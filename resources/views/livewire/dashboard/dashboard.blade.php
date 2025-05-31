<div>
    <!-- Page Header -->
    <div class="flex justify-between">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back, {{ auth()->user()->name }}!</h2>
        <p class="text-sm text-gray-600 mt-1">Here's what's happening with your system today.</p>
    </div>




<label class="inline-flex items-center cursor-pointer">
  <input wire:click="changeView" type="checkbox" value="" class="sr-only peer">
  <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600 dark:peer-checked:bg-red-600"></div>
  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"> Change View  </span>
</label>



    
    </div>



    @if($tab_id==1)
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Active Users -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
                <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-user-check"></i>
                </span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($stats['active_users']['count']) }}</span>
                <span class="ml-2 text-xs font-medium {{ $stats['active_users']['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center">
                    <i class="fas fa-arrow-{{ $stats['active_users']['trend'] === 'up' ? 'up' : 'down' }} mr-1"></i> 
                    {{ abs($stats['active_users']['change']) }}%
                </span>
            </div>
            <div class="text-xs text-gray-500 mt-2">Compared to last month</div>
        </div>
        
        <!-- New Companies -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">New Companies</h3>
                <span class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-building"></i>
                </span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($stats['new_companies']['count']) }}</span>
                <span class="ml-2 text-xs font-medium {{ $stats['new_companies']['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center">
                    <i class="fas fa-arrow-{{ $stats['new_companies']['trend'] === 'up' ? 'up' : 'down' }} mr-1"></i> 
                    {{ abs($stats['new_companies']['change']) }}%
                </span>
            </div>
            <div class="text-xs text-gray-500 mt-2">New companies this week</div>
        </div>
        
        <!-- Reports Generated -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Reports Generated</h3>
                <span class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <i class="fas fa-file-alt"></i>
                </span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($stats['reports_generated']['count']) }}</span>
                <span class="ml-2 text-xs font-medium {{ $stats['reports_generated']['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center">
                    <i class="fas fa-arrow-{{ $stats['reports_generated']['trend'] === 'up' ? 'up' : 'down' }} mr-1"></i> 
                    {{ abs($stats['reports_generated']['change']) }}%
                </span>
            </div>
            <div class="text-xs text-gray-500 mt-2">Reports from last 30 days</div>
        </div>
        
        <!-- Active Accounts -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Active Accounts</h3>
                <span class="p-2 bg-red-100 text-[#C40F12] rounded-lg">
                    <i class="fas fa-credit-card"></i>
                </span>
            </div>
            <div class="flex items-center">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($stats['active_accounts']['count']) }}</span>
                <span class="ml-2 text-xs font-medium text-green-500 flex items-center">
                    <span class="h-2 w-2 bg-green-500 rounded-full mr-1"></span>
                    Active
                </span>
            </div>
            <div class="text-xs text-gray-500 mt-2">Valid accounts</div>
        </div>
    </div>
    
    <!-- Dashboard Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Dashboard Content -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-800">CreditInfo Admin Panel</h2>
                <div>
                    <button class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                        <i class="fas fa-plus mr-2"></i> New Report
                    </button>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Use the sidebar to navigate through different modules. This admin panel allows you to manage users, view statements, generate reports, and configure system settings.</p>
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 text-sm text-blue-800">
                <div class="flex items-start">
                    <span class="mr-3 text-blue-500">
                        <i class="fas fa-info-circle text-lg"></i>
                    </span>
                    <div>
                        <p class="font-medium">Getting Started</p>
                        <p class="mt-1">Check the documentation for more information on how to use the CreditInfo admin panel. If you need help, contact our support team.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activities</h3>
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-400">
                                <i class="{{ $activity['icon'] }} text-sm"></i>
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['user'] }}</p>
                            <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-400">{{ $activity['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        <i class="fas fa-history text-2xl mb-2"></i>
                        <p class="text-sm">No recent activities</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Payment Statistics -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Payment Statistics (Last 30 Days)</h3>
            <div class="space-y-4">
                @foreach($paymentStats as $status => $stats)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                                {{ $status === 'completed' ? 'bg-green-100 text-green-600' : 
                                   ($status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 
                                   ($status === 'failed' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600')) }}">
                                <i class="fas fa-{{ $status === 'completed' ? 'check' : ($status === 'pending' ? 'clock' : 'times') }}"></i>
                            </span>
                            <span class="ml-3 text-sm font-medium text-gray-900 capitalize">{{ $status }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900">{{ $stats['count'] }} payments</div>
                            <div class="text-xs text-gray-500">TZS {{ $stats['total_amount'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Monthly Reports Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Reports Generated by Month</h3>
            <div class="space-y-3">
                @foreach($monthlyReports->take(6) as $report)
                    <div class="flex items-center">
                        <div class="w-20 text-sm text-gray-600">{{ $report['month'] }}</div>
                        <div class="flex-1 px-3">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-[#C40F12] h-2 rounded-full" 
                                     style="width: {{ $report['count'] > 0 ? min(($report['count'] / $monthlyReports->max('count')) * 100, 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="w-16 text-sm font-medium text-gray-900 text-right">{{ $report['count'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- System Status Footer -->
    <div class="mt-8 bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">System Status:</span>
                @foreach($systemStatus as $service => $status)
                    @if($service !== 'last_checked')
                        <div class="flex items-center space-x-2">
                            <span class="h-2 w-2 rounded-full {{ $status === 'operational' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                            <span class="text-xs text-gray-600 capitalize">{{ $service }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="text-xs text-gray-500">
                Last checked: {{ $systemStatus['last_checked']->diffForHumans() }}
            </div>
        </div>
    </div>

    @else




    <livewire:admin.dashboard />


    @endif 




</div>