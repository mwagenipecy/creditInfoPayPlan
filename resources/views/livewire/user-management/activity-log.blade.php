<div>
    <div class="overflow-x-auto px-4 pb-4">
        <!-- Filters specific to activity log -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
            <div class="flex flex-wrap gap-2">
                <select wire:model.live="filters.user" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filters.action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}">{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filters.model_type" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Entity Types</option>
                    @foreach($modelTypes as $type => $display)
                    <option value="{{ $type }}">{{ $display }}</option>
                    @endforeach
                </select>
                
                <div class="relative">
                    <input type="text" wire:model.live="filters.date_range" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Date Range">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <select wire:model.live="perPage" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="20">20 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                    <option value="200">200 per page</option>
                </select>
            </div>
        </div>
        
        <!-- Activity Log table -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('created_at')">
                            Timestamp
                            @if($sortField === 'created_at')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('user_id')">
                            User
                            @if($sortField === 'user_id')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('action')">
                            Action
                            @if($sortField === 'action')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('model_type')">
                            Entity Type
                            @if($sortField === 'model_type')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        IP Address
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>{{ $activity->created_at->format('M d, Y H:i:s') }}</div>
                        <div class="text-xs">{{ $activity->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($activity->user)
                            <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                @if($activity->user->profile_photo_path)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url($activity->user->profile_photo_path) }}" alt="{{ $activity->user->name }}">
                                @else
                                <span class="text-gray-600 font-medium text-xs">{{ substr($activity->user->first_name, 0, 1) }}{{ substr($activity->user->last_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $activity->user->first_name }} {{ $activity->user->last_name }}</div>
                                <div class="text-xs text-gray-500">{{ $activity->user->email }}</div>
                            </div>
                            @else
                            <span class="text-sm text-gray-500">System</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $actionColor = 'gray';
                            switch ($activity->action) {
                                case 'created':
                                    $actionColor = 'green';
                                    break;
                                case 'updated':
                                case 'changed_role':
                                case 'changed_company':
                                    $actionColor = 'blue';
                                    break;
                                case 'deleted':
                                    $actionColor = 'red';
                                    break;
                                case 'blocked':
                                    $actionColor = 'red';
                                    break;
                                case 'unblocked':
                                    $actionColor = 'green';
                                    break;
                                case 'verified_email':
                                    $actionColor = 'amber';
                                    break;
                                case 'reset_password':
                                    $actionColor = 'indigo';
                                    break;
                                case 'impersonated':
                                    $actionColor = 'purple';
                                    break;
                            }
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $actionColor }}-100 text-{{ $actionColor }}-800">
                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ class_basename($activity->model_type) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $activity->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $activity->ip_address }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span class="mt-2 text-gray-500 text-base">No activity logs found.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    </div>
</div>