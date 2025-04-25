<div>

<div class="bg-gray-50 ">
  <div class="container mx-auto px-4 py-2 max-w-full">
    <!-- Page Header -->
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Company & Document Verification</h2>
      <p class="text-sm text-gray-600 mt-1">
        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs mr-2">Status: Draft</span>
        Submit all required documents for verification.
      </p>
    </div>

    <!-- Document Status Overview -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Verification Status</h2>
        <div>
          <span id="doc-status" class="text-sm font-medium text-yellow-600 px-2 py-1 bg-yellow-50 rounded-full mr-3">Draft</span>
          <span class="text-sm font-medium text-gray-500"><span id="docs-complete">0</span> of 6 Documents Complete</span>
        </div>
      </div>
      
      <!-- Progress Bar -->
      <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
        <div id="progress-bar" class="bg-[#C40F12] h-2.5 rounded-full" style="width: 0%"></div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap justify-end gap-3 mb-2">
        <button id="btn-save-draft" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
          <i class="fas fa-save mr-2"></i> Save Draft
        </button>
        <button id="btn-submit-all" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors" disabled>
          <i class="fas fa-paper-plane mr-2"></i> Submit All Documents
        </button>
      </div>
    </div>

    <!-- Document List -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <h3 class="text-lg font-bold text-gray-800 mb-6">Required Documents</h3>
      
      <!-- Documents -->
      <div class="space-y-6">
        <!-- Business License -->
        <div id="doc-1" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-building text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Business License</h4>
                <p class="text-sm text-gray-600 mt-1">Upload your valid business license document</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Uploaded</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-upload mr-1"></i> Upload
              </button>
            </div>
          </div>

          <!-- Upload Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <div class="file-input-wrapper relative">
              <input type="file" class="doc-file opacity-0 absolute inset-0 w-full cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
              <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <div>
                  <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                  <p class="text-sm text-gray-600">Drag and drop files here or click to browse</p>
                  <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                </div>
              </div>
            </div>

            <div class="preview-section hidden mt-4">
              <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center">
                  <i class="fas fa-file-pdf text-[#C40F12] text-xl mr-3"></i>
                  <div>
                    <p class="text-sm font-medium text-gray-700 file-name">document.pdf</p>
                    <p class="text-xs text-gray-500 file-size">2.5 MB</p>
                  </div>
                </div>
                <div class="flex items-center">
                  <button class="btn-remove p-1 text-gray-500 hover:text-red-500">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="flex justify-end mt-4 gap-2">
              <button class="btn-cancel px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                Cancel
              </button>
              <button class="btn-save px-3 py-1.5 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                Save Document
              </button>
            </div>
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <h5 class="text-md font-medium text-gray-700 mb-3">Admin Review</h5>
            <div class="flex flex-wrap gap-3 mb-3">
              <button class="btn-approve px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-check mr-1"></i> Approve
              </button>
              <button class="btn-reject px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-times mr-1"></i> Reject
              </button>
              <button class="btn-request-changes px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-exclamation-circle mr-1"></i> Request Changes
              </button>
            </div>
            <textarea class="admin-notes w-full p-3 border border-gray-300 rounded-lg text-sm" rows="2" placeholder="Add notes or feedback (optional)"></textarea>
          </div>
        </div>

        <!-- BOT License -->
        <div id="doc-2" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-certificate text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">BOT License</h4>
                <p class="text-sm text-gray-600 mt-1">Upload your Board of Trade license</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Uploaded</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-upload mr-1"></i> Upload
              </button>
            </div>
          </div>

          <!-- Upload Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
            <div class="file-input-wrapper relative">
              <input type="file" class="doc-file opacity-0 absolute inset-0 w-full cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
              <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <div>
                  <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                  <p class="text-sm text-gray-600">Drag and drop files here or click to browse</p>
                  <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                </div>
              </div>
            </div>

            <div class="preview-section hidden mt-4">
              <!-- Same structure as Business License -->
            </div>

            <div class="flex justify-end mt-4 gap-2">
              <button class="btn-cancel px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                Cancel
              </button>
              <button class="btn-save px-3 py-1.5 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                Save Document
              </button>
            </div>
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>
        </div>

        <!-- BRELA Certification -->
        <div id="doc-3" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-file-contract text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">BRELA Certification</h4>
                <p class="text-sm text-gray-600 mt-1">Upload your Business Registration and Licensing Agency certificate</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Uploaded</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-upload mr-1"></i> Upload
              </button>
            </div>
          </div>

          <!-- Upload Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>
        </div>

        <!-- Memorandum of Association -->
        <div id="doc-4" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-file-signature text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Memorandum of Association</h4>
                <p class="text-sm text-gray-600 mt-1">Upload your company's memorandum of association</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Uploaded</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-upload mr-1"></i> Upload
              </button>
            </div>
          </div>

          <!-- Upload Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>
        </div>

        <!-- TIN Number -->
        <div id="doc-5" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-id-card text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">TIN Number</h4>
                <p class="text-sm text-gray-600 mt-1">Enter your Tax Identification Number</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Completed</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-pen mr-1"></i> Fill Details
              </button>
            </div>
          </div>

          <!-- TIN Form Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">TIN Number</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter TIN Number">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">TIN Certificate (Optional)</label>
              <div class="file-input-wrapper relative">
                <input type="file" class="doc-file opacity-0 absolute inset-0 w-full cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
                <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                  <div>
                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                    <p class="text-sm text-gray-600">Drag and drop files here or click to browse</p>
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max 5MB)</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex justify-end mt-4 gap-2">
              <button class="btn-cancel px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                Cancel
              </button>
              <button class="btn-save px-3 py-1.5 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                Save Details
              </button>
            </div>
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>
        </div>

        <!-- Tax Clearance -->
        <div id="doc-6" class="border border-gray-200 rounded-lg p-5">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-500 mr-4">
                <i class="fas fa-receipt text-xl"></i>
              </span>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Tax Clearance</h4>
                <p class="text-sm text-gray-600 mt-1">Upload your tax clearance certificate</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="doc-status px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs mr-3">Not Uploaded</span>
              <button class="btn-upload px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-upload mr-1"></i> Upload
              </button>
            </div>
          </div>

          <!-- Upload Section (Hidden initially) -->
          <div class="upload-section hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>

          <!-- Admin Review Section (Hidden initially) -->
          <div class="admin-review hidden mt-5 pt-5 border-t border-gray-200">
            <!-- Same structure as Business License -->
          </div>
        </div>
      </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-start">
        <div class="flex items-center h-5 mt-1">
          <input id="terms-checkbox" type="checkbox" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
        </div>
        <div class="ml-3 text-sm">
          <label for="terms-checkbox" class="font-medium text-gray-700">I agree to the Terms and Conditions</label>
          <p class="text-gray-500">By checking this box, you confirm that all provided documents are accurate and valid.</p>
        </div>
      </div>
      <div class="mt-3">
        <button id="view-terms" class="text-[#C40F12] text-sm hover:underline">View Terms and Conditions</button>
      </div>
    </div>

    <!-- Admin Review Panel (For Admins Only) -->
    <div id="admin-panel" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800">Admin Review Panel</h2>
        <span id="submission-status" class="text-sm font-medium text-yellow-600 px-2 py-1 bg-yellow-50 rounded-full">Pending Review</span>
      </div>
      
      <div class="space-y-4">
        <div class="p-4 bg-gray-50 rounded-lg">
          <h3 class="text-md font-medium text-gray-700 mb-2">Company Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
              <p class="text-gray-500">Company Name:</p>
              <p class="font-medium">Sample Company Ltd</p>
            </div>
            <div>
              <p class="text-gray-500">Registration Number:</p>
              <p class="font-medium">REG123456789</p>
            </div>
            <div>
              <p class="text-gray-500">Submission Date:</p>
              <p class="font-medium">April 24, 2025</p>
            </div>
            <div>
              <p class="text-gray-500">Contact Email:</p>
              <p class="font-medium">contact@samplecompany.com</p>
            </div>
          </div>
        </div>
        
        <div class="p-4 bg-gray-50 rounded-lg">
          <h3 class="text-md font-medium text-gray-700 mb-2">Review Decision</h3>
          <textarea class="w-full p-3 border border-gray-300 rounded-lg text-sm mb-4" rows="3" placeholder="Add overall feedback or notes..."></textarea>
          
          <div class="flex flex-wrap gap-3">
            <button id="btn-approve-all" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transition-colors">
              <i class="fas fa-check-circle mr-2"></i> Approve All
            </button>
            <button id="btn-reject-all" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 transition-colors">
              <i class="fas fa-times-circle mr-2"></i> Reject All
            </button>
            <button id="btn-request-changes-all" class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-opacity-50 transition-colors">
              <i class="fas fa-exclamation-circle mr-2"></i> Request Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Terms and Conditions Modal -->
  <div id="terms-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto p-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-800">Terms and Conditions</h3>
        <button id="close-terms" class="text-gray-400 hover:text-gray-500">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
      <div class="prose prose-sm max-w-none">
        <h4>1. Document Submission</h4>
        <p>By submitting documents through this platform, you certify that all information provided is accurate, complete, and valid. False or misleading information may result in rejection of your application and possible legal consequences.</p>
        
        <h4>2. Document Verification</h4>
        <p>All submitted documents will be subject to verification by our team. The verification process may take up to 5 business days. We reserve the right to request additional documentation if necessary.</p>
        
        <h4>3. Data Protection</h4>
        <p>Your documents and information will be stored securely and used only for verification purposes. We comply with applicable data protection regulations and will not share your information with third parties without your consent, except as required by law.</p>
        
        <h4>4. Document Requirements</h4>
        <p>All documents must be:</p>
        <ul>
          <li>Clear, legible, and complete</li>
          <li>In PDF, JPG, or PNG format</li>
          <li>No larger than 5MB per file</li>
          <li>Valid and not expired</li>
        </ul>
        
        <h4>5. Rejection and Resubmission</h4>
        <p>If your documents are rejected, you will be notified with specific reasons. You may resubmit documents after addressing the issues identified.</p>
      </div>
      <div class="mt-6 text-right">
        <button id="accept-terms" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
          I Accept
        </button>
      </div>
    </div>
  </div>

  <script>
    // Show/hide upload sections
    document.querySelectorAll('.btn-upload').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const uploadSection = parent.querySelector('.upload-section');
        uploadSection.classList.toggle('hidden');
      });
    });

    // Cancel button functionality
    document.querySelectorAll('.btn-cancel').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const uploadSection = parent.querySelector('.upload-section');
        uploadSection.classList.add('hidden');
      });
    });

    // File upload preview
    document.querySelectorAll('.doc-file').forEach(input => {
      input.addEventListener('change', function(e) {
        if (this.files.length > 0) {
          const parent = this.closest('[id^="doc-"]');
          const previewSection = parent.querySelector('.preview-section');
          const fileName = parent.querySelector('.file-name');
          const fileSize = parent.querySelector('.file-size');
          
          if (fileName && fileSize) {
            fileName.textContent = this.files[0].name;
            fileSize.textContent = (this.files[0].size / (1024 * 1024)).toFixed(2) + " MB";
          }
          
          if (previewSection) {
            previewSection.classList.remove('hidden');
          }
        }
      });
    });

    // Mock functionality for saving documents
    document.quer
    
    // Mock functionality for saving documents
    document.querySelectorAll('.btn-save').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const docStatus = parent.querySelector('.doc-status');
        const uploadSection = parent.querySelector('.upload-section');
        const previewSection = parent.querySelector('.preview-section');

        if (docStatus && previewSection && !previewSection.classList.contains('hidden')) {
          docStatus.textContent = 'Uploaded';
          docStatus.classList.remove('bg-gray-100', 'text-gray-600');
          docStatus.classList.add('bg-green-100', 'text-green-700');
          uploadSection.classList.add('hidden');
        }
      });
    });

    // Terms and Conditions modal functionality
    const termsModal = document.getElementById('terms-modal');
    const viewTermsButton = document.getElementById('view-terms');
    const closeTermsButton = document.getElementById('close-terms');
    const acceptTermsButton = document.getElementById('accept-terms');
    const termsCheckbox = document.getElementById('terms-checkbox');
    const submitAllButton = document.getElementById('btn-submit-all');

    viewTermsButton.addEventListener('click', () => {
      termsModal.classList.remove('hidden');
    });

    closeTermsButton.addEventListener('click', () => {
      termsModal.classList.add('hidden');
    });

    acceptTermsButton.addEventListener('click', () => {
      termsCheckbox.checked = true;
      termsModal.classList.add('hidden');
      submitAllButton.disabled = false;
    });

    // Enable submit button when terms are checked
    termsCheckbox.addEventListener('change', () => {
      submitAllButton.disabled = !termsCheckbox.checked;
    });

    // Mock functionality for submitting all documents
    submitAllButton.addEventListener('click', () => {
      alert('All documents have been submitted for verification!');
    });
    
    // Update progress bar and document completion status
    function updateProgress() {
      const totalDocs = document.querySelectorAll('[id^="doc-"]').length;
      const completedDocs = document.querySelectorAll('.doc-status.bg-green-100').length;
      const progressBar = document.getElementById('progress-bar');
      const docsComplete = document.getElementById('docs-complete');
      const docStatus = document.getElementById('doc-status');

      const progressPercentage = (completedDocs / totalDocs) * 100;
      progressBar.style.width = `${progressPercentage}%`;
      docsComplete.textContent = completedDocs;

      if (completedDocs === totalDocs) {
        docStatus.textContent = 'Complete';
        docStatus.classList.remove('text-yellow-600', 'bg-yellow-50');
        docStatus.classList.add('text-green-700', 'bg-green-50');
      } else {
        docStatus.textContent = 'Draft';
        docStatus.classList.remove('text-green-700', 'bg-green-50');
        docStatus.classList.add('text-yellow-600', 'bg-yellow-50');
      }
    }

    // Attach progress update to save buttons
    document.querySelectorAll('.btn-save').forEach(button => {
      button.addEventListener('click', updateProgress);
    });

    // Attach progress update to terms checkbox
    termsCheckbox.addEventListener('change', updateProgress);


    // Mock functionality for removing uploaded files
    document.querySelectorAll('.btn-remove').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const previewSection = parent.querySelector('.preview-section');
        const docStatus = parent.querySelector('.doc-status');

        if (previewSection && docStatus) {
          previewSection.classList.add('hidden');
          docStatus.textContent = 'Not Uploaded';
          docStatus.classList.remove('bg-green-100', 'text-green-700');
          docStatus.classList.add('bg-gray-100', 'text-gray-600');
          updateProgress();
        }
      });
    });

    // Mock functionality for admin review buttons
    document.querySelectorAll('.btn-approve, .btn-reject, .btn-request-changes').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const adminReviewSection = parent.querySelector('.admin-review');
        const docStatus = parent.querySelector('.doc-status');

        if (adminReviewSection && docStatus) {
          if (this.classList.contains('btn-approve')) {
            docStatus.textContent = 'Approved';
            docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700');
            docStatus.classList.add('bg-green-100', 'text-green-700');
          } else if (this.classList.contains('btn-reject')) {
            docStatus.textContent = 'Rejected';
            docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-100', 'text-green-700', 'bg-yellow-100', 'text-yellow-700');
            docStatus.classList.add('bg-red-100', 'text-red-700');
          } else if (this.classList.contains('btn-request-changes')) {
            docStatus.textContent = 'Changes Requested';
            docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
            docStatus.classList.add('bg-yellow-100', 'text-yellow-700');
          }
          adminReviewSection.classList.add('hidden');
          updateProgress();
        }
      });
    });

    // Show/hide admin review section
    document.querySelectorAll('.btn-upload').forEach(button => {
      button.addEventListener('click', function() {
        const parent = this.closest('[id^="doc-"]');
        const adminReviewSection = parent.querySelector('.admin-review');
        if (adminReviewSection) {
          adminReviewSection.classList.toggle('hidden');
        }
      });
    });
    

    // Mock functionality for admin panel buttons
    document.querySelectorAll('#btn-approve-all, #btn-reject-all, #btn-request-changes-all').forEach(button => {
      button.addEventListener('click', function() {
        const allDocs = document.querySelectorAll('[id^="doc-"]');
        const submissionStatus = document.getElementById('submission-status');

        allDocs.forEach(doc => {
          const docStatus = doc.querySelector('.doc-status');
          if (docStatus) {
            if (this.id === 'btn-approve-all') {
              docStatus.textContent = 'Approved';
              docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-red-100', 'text-red-700', 'bg-yellow-100', 'text-yellow-700');
              docStatus.classList.add('bg-green-100', 'text-green-700');
            } else if (this.id === 'btn-reject-all') {
              docStatus.textContent = 'Rejected';
              docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-100', 'text-green-700', 'bg-yellow-100', 'text-yellow-700');
              docStatus.classList.add('bg-red-100', 'text-red-700');
            } else if (this.id === 'btn-request-changes-all') {
              docStatus.textContent = 'Changes Requested';
              docStatus.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
              docStatus.classList.add('bg-yellow-100', 'text-yellow-700');
            }
          }
        });

        if (submissionStatus) {
          if (this.id === 'btn-approve-all') {
            submissionStatus.textContent = 'Approved';
            submissionStatus.classList.remove('text-yellow-600', 'bg-yellow-50', 'text-red-700', 'bg-red-50');
            submissionStatus.classList.add('text-green-700', 'bg-green-50');
          } else if (this.id === 'btn-reject-all') {
            submissionStatus.textContent = 'Rejected';
            submissionStatus.classList.remove('text-yellow-600', 'bg-yellow-50', 'text-green-700', 'bg-green-50');
            submissionStatus.classList.add('text-red-700', 'bg-red-50');
          } else if (this.id === 'btn-request-changes-all') {
            submissionStatus.textContent = 'Changes Requested';
            submissionStatus.classList.remove('text-yellow-600', 'bg-yellow-50', 'text-green-700', 'bg-green-50', 'text-red-700', 'bg-red-50');
            submissionStatus.classList.add('text-yellow-700', 'bg-yellow-50');
          }
        }
      });
    });

    // Mock functionality for toggling admin review panel visibility
    const adminPanel = document.getElementById('admin-panel');
    const toggleAdminPanelButton = document.createElement('button');
    toggleAdminPanelButton.textContent = 'Toggle Admin Panel';
    toggleAdminPanelButton.classList.add('px-4', 'py-2', 'bg-gray-100', 'text-gray-700', 'rounded-lg', 'text-sm', 'font-medium', 'hover:bg-gray-200', 'focus:outline-none', 'focus:ring-2', 'focus:ring-gray-300', 'focus:ring-opacity-50', 'transition-colors');
    document.body.insertBefore(toggleAdminPanelButton, adminPanel);

    toggleAdminPanelButton.addEventListener('click', () => {
      adminPanel.classList.toggle('hidden');
    });

    // Mock functionality for toggling document sections visibility
    document.querySelectorAll('.btn-upload').forEach(button => {
      button.addEventListener('click', function () {
        const parent = this.closest('[id^="doc-"]');
        const uploadSection = parent.querySelector('.upload-section');
        if (uploadSection) {
          uploadSection.classList.toggle('hidden');
        }
      });
    });

    // Mock functionality for toggling admin review sections
    document.querySelectorAll('.btn-approve, .btn-reject, .btn-request-changes').forEach(button => {
      button.addEventListener('click', function () {
        const parent = this.closest('[id^="doc-"]');
        const adminReviewSection = parent.querySelector('.admin-review');
        if (adminReviewSection) {
          adminReviewSection.classList.toggle('hidden');
        }
      });
    });
  </script>
</div>



    {{-- The best athlete wants his opponent at his best. --}}
</div>
