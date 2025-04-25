<?php

namespace App\Livewire\Document;

use App\Models\Company;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class AddDocument extends Component
{
    use WithFileUploads;

    public Company $company;
    
    // Document file uploads
    public $documentFiles = [];
    
    // TIN document specific fields
    public $tinNumber;
    public $issueDate;
    
    // Admin review fields
    public $adminNotes = [];
    
    // Editing state tracking
    public $editingDocument = null;
    
    // Modal state
    public $showTermsModal = false;
    public $showAdminPanel = false;
    public $overallAdminNotes = '';
    
    // Terms acceptance
    public $termsAccepted = false;
    
    // Success and error messages
    public $successMessage = '';
    public $errorMessage = '';

    public function mount(Company $company)
    {

        $this->company = $company;
        $this->termsAccepted = $company->terms_accepted;
        
        // Initialize the company with all required document types if they don't exist yet
        $this->initializeCompanyDocuments();
    }


    protected function initializeCompanyDocuments()
{
    $documentTypes = [
        Document::TYPE_BUSINESS_LICENSE,
        Document::TYPE_BOT_LICENSE,
        Document::TYPE_BRELA_CERTIFICATE,
        Document::TYPE_MEMORANDUM,
        Document::TYPE_TIN,
        Document::TYPE_TAX_CLEARANCE,
    ];

    foreach ($documentTypes as $type) {
        if (!$this->company->documents()->where('document_type', $type)->exists()) {
            $this->company->documents()->create([
                'document_type' => $type,
                'status' => Document::STATUS_NOT_UPLOADED,
                'company_id' => $this->company->id  // Explicitly set the company_id
            ]);
        }
    }

    // Pre-fill TIN fields if they exist
    $tinDocument = $this->company->documents()->where('document_type', Document::TYPE_TIN)->first();
    if ($tinDocument) {
        $this->tinNumber = $tinDocument->tin_number;
        $this->issueDate = $tinDocument->issue_date;
    }
}

  
    public function editDocument($documentId)
    {
        $this->editingDocument = $documentId;
        $this->resetErrorMessages();
    }

    public function cancelEdit()
    {
        $this->editingDocument = null;
        $this->resetErrorMessages();
        $this->resetDocumentFiles();
    }

    public function toggleAdminPanel()
    {
        $this->showAdminPanel = !$this->showAdminPanel;
    }

    public function toggleTermsModal()
    {
        $this->showTermsModal = !$this->showTermsModal;
    }

    public function acceptTerms()
    {
        $this->termsAccepted = true;
        $this->company->terms_accepted = true;
        $this->company->save();
        $this->showTermsModal = false;
    }

    public function uploadDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        
        // Special case for TIN document type
        if ($document->document_type === Document::TYPE_TIN) {
            $this->validate([
                'tinNumber' => 'required|string|max:50',
                'issueDate' => 'required|date',
                'documentFiles.tin' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png',
            ], [
                'tinNumber.required' => 'TIN Number is required',
                'issueDate.required' => 'Issue date is required',
                'documentFiles.tin.max' => 'File size must not exceed 5MB',
                'documentFiles.tin.mimes' => 'Only PDF, JPG and PNG files are allowed',
            ]);
            
            $document->tin_number = $this->tinNumber;
            $document->issue_date = $this->issueDate;
            
            // Upload file if provided
            if (isset($this->documentFiles['tin'])) {
                $path = $this->documentFiles['tin']->store('documents', 'public');
                $document->file_path = $path;
                $document->file_name = $this->documentFiles['tin']->getClientOriginalName();
                $document->file_size = $this->documentFiles['tin']->getSize();
            }
            
            $document->status = Document::STATUS_UPLOADED;
            $document->save();
            
            $this->resetDocumentFile('tin');
        } else {
            // Regular document upload
            $documentType = $document->document_type;
            
            $this->validate([
                "documentFiles.$documentType" => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            ], [
                "documentFiles.$documentType.required" => 'Please select a file to upload',
                "documentFiles.$documentType.max" => 'File size must not exceed 5MB',
                "documentFiles.$documentType.mimes" => 'Only PDF, JPG and PNG files are allowed',
            ]);
            
            try {
                $path = $this->documentFiles[$documentType]->store('documents', 'public');
                
                $document->file_path = $path;
                $document->file_name = $this->documentFiles[$documentType]->getClientOriginalName();
                $document->file_size = $this->documentFiles[$documentType]->getSize();
                $document->status = Document::STATUS_UPLOADED;
                $document->save();
                
                $this->resetDocumentFile($documentType);
                
            } catch (\Exception $e) {
                Log::error('Error uploading document: ' . $e->getMessage());
                $this->errorMessage = 'Error uploading document. Please try again.';
            }
        }
        
        $this->editingDocument = null;
        $this->successMessage = 'Document uploaded successfully!';
        
        // Check if all documents are completed and update company status if needed
        $this->updateCompanyStatus();
    }

    public function removeDocument($documentId)
    {
        $document = Document::findOrFail($documentId);
        
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->file_path = null;
        $document->file_name = null;
        $document->file_size = null;
        $document->status = Document::STATUS_NOT_UPLOADED;
        $document->save();
        
        $this->successMessage = 'Document removed successfully!';
        $this->updateCompanyStatus();
    }

    public function adminReviewDocument($documentId, $status)
    {
        $document = Document::findOrFail($documentId);
        $document->status = $status;
        
        if (isset($this->adminNotes[$documentId])) {
            $document->admin_notes = $this->adminNotes[$documentId];
        }
        
        $document->save();
        $this->successMessage = 'Document status updated successfully!';
    }

    public function adminReviewAll($status)
    {
        foreach ($this->company->documents as $document) {
            if ($document->status != Document::STATUS_NOT_UPLOADED) {
                $document->status = $status;
                if ($this->overallAdminNotes) {
                    $document->admin_notes = $this->overallAdminNotes;
                }
                $document->save();
            }
        }
        
        $this->company->verification_status = $status;
        $this->company->save();
        
        $this->successMessage = 'All documents have been reviewed!';
    }

    public function submitAllDocuments()
    {
        if (!$this->termsAccepted) {
            $this->errorMessage = 'You must accept the terms and conditions before submitting.';
            return;
        }
        
        if (!$this->company->allDocumentsUploaded()) {
            $this->errorMessage = 'All required documents must be uploaded before submitting.';
            return;
        }
        
        $this->company->verification_status = 'pending_review';
        $this->company->save();
        
        $this->successMessage = 'All documents have been submitted for verification!';
    }

    public function saveDraft()
    {
        $this->company->verification_status = 'draft';
        $this->company->save();
        $this->successMessage = 'Draft saved successfully!';
    }

    private function updateCompanyStatus()
    {
        if ($this->company->allDocumentsUploaded()) {
            $this->company->verification_status = 'ready_to_submit';
        } else {
            $this->company->verification_status = 'draft';
        }
        $this->company->save();
    }

    private function resetErrorMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    private function resetDocumentFiles()
    {
        $this->documentFiles = [];
    }

    private function resetDocumentFile($type)
    {
        unset($this->documentFiles[$type]);
    }

    public function render()
    {
        return view('livewire.document.add-document', [
            'documents' => $this->company->documents,
        ]);
    }




}
