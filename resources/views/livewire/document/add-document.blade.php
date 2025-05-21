<div> 
<div class="bg-gray-50">
  <div class="container mx-auto px-4 py-2 max-w-full">
    <!-- Page Header -->


    @if(auth()->user()->role_id==2)
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Company & Document Verification</h2>
      <p class="text-sm text-gray-600 mt-1">
        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs mr-2">Status: {{ ucfirst($company->verification_status) }}</span>
        Submit all required documents for verification.
      </p>
    </div>

    @if ($successMessage)
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-green-700">{{ $successMessage }}</p>
        </div>
      </div>
    </div>
    @endif

    @if ($errorMessage)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700">{{ $errorMessage }}</p>
        </div>
      </div>
    </div>
    @endif

    <!-- Document Status Overview -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Verification Status</h2>
        <div>
          <span class="text-sm font-medium {{ $company->verification_status == 'draft' ? 'text-yellow-600 bg-yellow-50' : ($company->verification_status == 'pending_review' ? 'text-blue-600 bg-blue-50' : 'text-green-600 bg-green-50') }} px-2 py-1 rounded-full mr-3">
            {{ ucfirst($company->verification_status) }}
          </span>
          <span class="text-sm font-medium text-gray-500">{{ $company->completed_documents_count }} of {{ $company->required_documents_count }} Documents Complete</span>
        </div>
      </div>
      
      <!-- Progress Bar -->
      <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
        <div class="bg-[#C40F12] h-2.5 rounded-full" style="width: {{ ($company->completed_documents_count / $company->required_documents_count) * 100 }}%"></div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap justify-end gap-3 mb-2">
        <button wire:click="saveDraft" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
          <i class="fas fa-save mr-2"></i> Save Draft
        </button>
        <button wire:click="submitAllDocuments" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors" {{ !$termsAccepted || !$company->allDocumentsUploaded() ? 'disabled' : '' }}>
          <i class="fas fa-paper-plane mr-2"></i> Submit All Documents
        </button>
      </div>
    </div>

    <!-- Document List -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <h3 class="text-lg font-bold text-gray-800 mb-6">Required Documents</h3>
      
      <!-- Documents -->
      <div class="space-y-6">
        @foreach($documents as $document)
        <div class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="{{ $document->icon }} text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">{{ $document->document_type_label }}</h4>
                <p class="text-sm text-gray-600 mt-1">
                  @if($document->document_type == \App\Models\Document::TYPE_TIN)
                    Enter your Tax Identification Number
                  @else
                    Upload your {{ strtolower($document->document_type_label) }}
                  @endif
                </p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="px-2 py-1 rounded-full {{ $document->status_color }} text-xs mr-3">{{ $document->status_label }}</span>
              @if($document->status == \App\Models\Document::STATUS_NOT_UPLOADED)
                <button wire:click="editDocument({{ $document->id }})" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                  <i class="fas {{ $document->document_type == \App\Models\Document::TYPE_TIN ? 'fa-pen' : 'fa-upload' }} mr-1"></i> 
                  {{ $document->document_type == \App\Models\Document::TYPE_TIN ? 'Fill Details' : 'Upload' }}
                </button>
              @elseif($document->status == \App\Models\Document::STATUS_UPLOADED)
                <div class="flex">
                  <button wire:click="editDocument({{ $document->id }})" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors mr-2">
                    <i class="fas fa-edit mr-1"></i> Edit
                  </button>
                  <button wire:click="removeDocument({{ $document->id }})" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 transition-colors">
                    <i class="fas fa-trash-alt mr-1"></i>
                  </button>
                </div>
              @elseif($document->status == \App\Models\Document::STATUS_CHANGES_REQUESTED)
                <button wire:click="editDocument({{ $document->id }})" class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-opacity-50 transition-colors">
                  <i class="fas fa-redo mr-1"></i> Update
                </button>
              @endif
            </div>
          </div>

          <!-- Document Info (if uploaded) -->
          @if($document->file_name && $document->status != \App\Models\Document::STATUS_NOT_UPLOADED)
          <div class="mt-4 bg-gray-50 p-3 rounded-lg">
            <div class="flex items-center">
              <i class="fas fa-file-pdf text-[#C40F12] text-xl mr-3"></i>
              <div>
                <p class="text-sm font-medium text-gray-700">{{ $document->file_name }}</p>
                <p class="text-xs text-gray-500">{{ number_format($document->file_size / 1024 / 1024, 2) }} MB</p>
              </div>
            </div>
          </div>
          @endif

          <!-- TIN Info (if filled) -->
          @if($document->document_type == \App\Models\Document::TYPE_TIN && $document->tin_number)
          <div class="mt-4 bg-gray-50 p-3 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              <div>
                <p class="text-xs text-gray-500">TIN Number:</p>
                <p class="text-sm font-medium text-gray-700">{{ $document->tin_number }}</p>
              </div>
              <div>
                <p class="text-xs text-gray-500">Issue Date:</p>
                <p class="text-sm font-medium text-gray-700">{{ $document->issue_date }}</p>
              </div>
            </div>
          </div>
          @endif

          <!-- Admin Notes (if any) -->
          @if($document->admin_notes)
          <div class="mt-4 bg-yellow-50 p-3 rounded-lg">
            <p class="text-xs text-yellow-700 font-medium">Admin Notes:</p>
            <p class="text-sm text-yellow-800">{{ $document->admin_notes }}</p>
          </div>
          @endif

          <!-- Upload/Edit Section -->
          @if($editingDocument == $document->id)
          <div class="mt-5 pt-5 border-t border-gray-200">
            @if($document->document_type == \App\Models\Document::TYPE_TIN)
            <!-- TIN Document Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
<!-- Continuing from where the first snippet ended -->
<label class="block text-sm font-medium text-gray-700">TIN Number</label>
                <input type="text" wire:model="tinNumber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                @error('tinNumber') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                <input type="date" wire:model="issueDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                @error('issueDate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Document (Optional)</label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload-tin" class="relative cursor-pointer bg-white rounded-md font-medium text-[#C40F12] hover:text-red-700">
                      <span>Upload a file</span>
                      <input id="file-upload-tin" wire:model="documentFiles.tin" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">PDF, PNG, JPG up to 5MB</p>
                </div>
              </div>
              @error('documentFiles.tin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            @else
            <!-- Regular Document Upload Form -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Upload {{ $document->document_type_label }}</label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload-{{ $document->document_type }}" class="relative cursor-pointer bg-white rounded-md font-medium text-[#C40F12] hover:text-red-700">
                      <span>Upload a file</span>
                      <input id="file-upload-{{ $document->document_type }}" wire:model="documentFiles.{{ $document->document_type }}" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">PDF, PNG, JPG up to 5MB</p>
                </div>
              </div>
              @error('documentFiles.' . $document->document_type) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
              <button wire:click="cancelEdit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                Cancel
              </button>
              <button wire:click="uploadDocument({{ $document->id }})" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                Save Document
              </button>
            </div>
          </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">Terms and Conditions</h3>
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" wire:model="termsAccepted" class="rounded border-gray-300 text-[#C40F12] shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
            <span class="ml-2 text-sm text-gray-700">I accept the terms and conditions</span>
          </label>
        </div>
      </div>
      <p class="text-sm text-gray-600 mb-4">
        By submitting these documents, you confirm that all information provided is accurate and complete. 
        You understand that false information may result in rejection of your application.
      </p>
      <button wire:click="toggleTermsModal" class="text-sm text-[#C40F12] hover:text-red-700 font-medium">
        View Full Terms and Conditions
      </button>
    </div>

    @endif 


    <!-- Admin Review Panel (visible only to admins) -->
    @if(auth()->user()->role_id==1)
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">Admin Review Panel</h3>
        <button wire:click="toggleAdminPanel" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
          {{ $showAdminPanel ? 'Hide Panel' : 'Show Panel' }}
        </button>
      </div>

      @if($showAdminPanel)
      <div class="space-y-6">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Overall Admin Notes</label>
          <textarea wire:model="overallAdminNotes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @foreach($documents as $document)
          @if($document->status != \App\Models\Document::STATUS_NOT_UPLOADED)
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
              <h4 class="font-medium text-gray-800">{{ $document->document_type_label }}</h4>
              <span class="px-2 py-1 rounded-full {{ $document->status_color }} text-xs">{{ $document->status_label }}</span>
            </div>
            
            @if($document->file_name)
            <div class="mb-3 flex items-center">
              <i class="fas fa-file-pdf text-[#C40F12] text-xl mr-2"></i>
              <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $document->file_name }}</a>
            </div>
            @endif

            <div class="mb-3">
              <label class="block text-xs font-medium text-gray-700 mb-1">Admin Notes</label>
              <textarea wire:model="adminNotes.{{ $document->id }}" rows="2" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50"></textarea>
            </div>

            <div class="flex justify-end gap-2">


            @if($document->status_label!='Approved')

            
              <button wire:click="adminReviewDocument({{ $document->id }}, 'approved')" class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium hover:bg-green-200">
                Approve
              </button>

              @endif 

              @if($document->status_label=='Approved')

              @else
              <button wire:click="adminReviewDocument({{ $document->id }}, 'rejected')" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium hover:bg-red-200">
                Reject
              </button>

              @endif

              <button wire:click="adminReviewDocument({{ $document->id }}, 'changes_requested')" class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-medium hover:bg-yellow-200">
                Request Changes
              </button>
            </div>
          </div>
          @endif
          @endforeach
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">

        @if($company->completed_documents_count==6)


          <button wire:click="adminReviewAll('approved')" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-colors">
            Approve All
          </button>

        
       

          @if($company->approvedDocument() >=1 )

          @else

          <button wire:click="adminReviewAll('rejected')" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 transition-colors">
            Reject All
          </button>
          @endif 


          <button wire:click="adminReviewAll('changes_requested')" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-opacity-50 transition-colors">
            Request Changes for All
          </button>

          @endif
          
          
        </div>
      </div>
      @endif
    </div>
    @endif
  </div>
</div>

<!-- Terms and Conditions Modal -->
@if($showTermsModal)
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
    <div class="px-6 py-4 border-b border-gray-200">
      <h3 class="text-lg font-medium text-gray-900">Terms and Conditions</h3>
    </div>
    <div class="px-6 py-4">
      <div class="space-y-4 text-sm text-gray-700">
        <p><strong>1. Document Submission and Verification</strong></p>
        <p>By submitting documents for verification, you confirm that all information provided is accurate, current, and complete. You understand that submitting false information may result in immediate rejection of your application and possible legal consequences.</p>
        
        <p><strong>2. Data Privacy</strong></p>
        <p>You agree that the documents and information you provide may be reviewed by our verification team and relevant authorities as required by law. We will protect your information in accordance with our Privacy Policy and applicable data protection regulations.</p>
        
        <p><strong>3. Document Retention</strong></p>
        <p>Documents submitted for verification will be retained for the period required by applicable regulations. You may request deletion of your documents after this period, subject to legal requirements.</p>
        
        <p><strong>4. Changes to Submitted Information</strong></p>
        <p>You agree to promptly update any information that changes after submission. Failure to maintain accurate information may result in suspension or termination of services.</p>
        
        <p><strong>5. Verification Decision</strong></p>
        <p>You understand that submission of documents does not guarantee approval. Our verification team reserves the right to request additional information or clarification if needed.</p>
      </div>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
      <button wire:click="toggleTermsModal" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 mr-3">
        Close
      </button>
      <button wire:click="acceptTerms" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700">
        Accept Terms
      </button>
    </div>
  </div>
</div>
@endif
</div>
