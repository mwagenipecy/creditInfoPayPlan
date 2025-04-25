<div>



<div class="bg-gray-50 min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-full">
    <!-- Page Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Company Verification Management</h2>
        <p class="text-sm text-gray-600 mt-1">Manage and review company verifications</p>
      </div>
      <a href="{{ route('add.company') }}" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
        <i class="fas fa-plus mr-2"></i> Register New Company
      </a>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
            <option value="">All Status</option>
            <option value="draft">Draft</option>
            <option value="pending_review">Submitted</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="changes_requested">Changes Requested</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
          <select wire:model="dateRange" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
            <option value="">All Time</option>
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="quarter">Last 3 Months</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <div class="relative">
            <input wire:model.debounce.300ms="search" type="text" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Search by company name, TIN, registration number...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-end mt-4 gap-2">
        <button wire:click="resetFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
          <i class="fas fa-times mr-2"></i> Reset
        </button>
        <button wire:click="applyFilters" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
          <i class="fas fa-filter mr-2"></i> Apply Filters
        </button>
      </div>
    </div>

    <!-- Company Listing Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration No.</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($companies as $company)
            <tr class="hover:bg-gray-50 cursor-pointer">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 {{ $this->getCompanyColor($company) }} text-white rounded-full flex items-center justify-center">
                    <span class="text-lg font-medium">{{ substr($company->company_name, 0, 1) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $company->company_name }}</div>
                    <div class="text-sm text-gray-500">{{ $company->primary_email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ $company->registration_number }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $this->getStatusColor($company->verification_status) }}">
                  {{ $this->getStatusLabel($company->verification_status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $company->completedDocumentsCount }} of {{ $company->requiredDocumentsCount }} Uploaded
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $company->updated_at->format('F d, Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('add.document', $company->id) }}" class="text-[#C40F12] hover:text-red-800">
                  <i class="fas fa-eye mr-1"></i> View
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                No companies found matching your criteria.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing 
                <span class="font-medium">{{ $companies->firstItem() ?? 0 }}</span> 
                to 
                <span class="font-medium">{{ $companies->lastItem() ?? 0 }}</span> 
                of 
                <span class="font-medium">{{ $companies->total() }}</span> results
              </p>
            </div>
            <div>
              {{ $companies->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


            
            </div>
