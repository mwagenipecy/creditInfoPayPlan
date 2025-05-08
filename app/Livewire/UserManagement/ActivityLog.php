<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog as ActivityLogModel;
use App\Models\User;
use App\Models\Company;

class ActivityLog extends Component
{
    use WithPagination;
    
    public $perPage = 20;
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'user' => '',
        'action' => '',
        'date_range' => '',
        'model_type' => '',
    ];
    
    // Listen for events from other components
    protected function getListeners()
    {
        return [
            'userCreated' => '$refresh',
            'userUpdated' => '$refresh',
            'userDeleted' => '$refresh',
            'userBlocked' => '$refresh',
            'userUnblocked' => '$refresh',
            'userVerified' => '$refresh',
            'filtersReset' => 'resetFilters',
        ];
    }
    
    public function resetFilters()
    {
        $this->filters = [
            'user' => '',
            'action' => '',
            'date_range' => '',
            'model_type' => '',
        ];
        $this->searchTerm = '';
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    protected function buildActivityQuery()
    {
        // Base query
        $query = ActivityLogModel::with(['user']);
        
        // Apply search
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('action', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('user', function ($sq) {
                      $sq->where('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        // Apply user filter
        if (!empty($this->filters['user'])) {
            $query->where('user_id', $this->filters['user']);
        }
        
        // Apply action filter
        if (!empty($this->filters['action'])) {
            $query->where('action', $this->filters['action']);
        }
        
        // Apply model type filter
        if (!empty($this->filters['model_type'])) {
            $query->where('model_type', $this->filters['model_type']);
        }
        
        // Apply date range filter
        if (!empty($this->filters['date_range'])) {
            list($startDate, $endDate) = explode(' to ', $this->filters['date_range']);
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        
        // If company admin, only show activities related to their company
        if (auth()->user()->hasRole('company_admin')) {
            $companyId = auth()->user()->company_id;
            
            $query->where(function ($q) use ($companyId) {
                // Get all users in the company
                $userIds = User::where('company_id', $companyId)->pluck('id')->toArray();
                
                // Activities performed by users in the company
                $q->whereIn('user_id', $userIds)
                  // Or activities about users in the company
                  ->orWhere(function ($sq) use ($userIds) {
                      $sq->where('model_type', User::class)
                        ->whereIn('model_id', $userIds);
                  })
                  // Or activities about the company itself
                  ->orWhere(function ($sq) use ($companyId) {
                      $sq->where('model_type', Company::class)
                        ->where('model_id', $companyId);
                  });
            });
        }
        
        return $query;
    }
    
    public function render()
    {
        $query = $this->buildActivityQuery();
        
        $activities = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        // Get users for filter
        $users = User::orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Get unique action types from the activities
        $actions = ActivityLogModel::distinct('action')->pluck('action');
        
        // Get unique model types from the activities
        $modelTypes = ActivityLogModel::distinct('model_type')->pluck('model_type');
        $formattedModelTypes = $modelTypes->mapWithKeys(function ($type) {
            $className = class_basename($type);
            return [$type => $className];
        });
        
        return view('livewire.user-management.activity-log', [
            'activities' => $activities,
            'users' => $users,
            'actions' => $actions,
            'modelTypes' => $formattedModelTypes,
        ]);
    }
}