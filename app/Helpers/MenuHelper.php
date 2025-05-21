<?php

namespace App\Helpers;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MenuHelper
{
    /**
     * Check if user has access to a specific menu based on company verification status
     *
     * @param string $menuName The name of the menu to check access for
     * @return bool Returns true if user's company is approved, false otherwise
     */
    public static function canAccessMenu(string $menuName): bool
    {
        // If user is not logged in, they don't have access
        if (!Auth::check()) {
            return false;
        }

        $userId = auth()->user()->company_id;
        
        // Cache the result for 5 minutes to improve performance
        $cacheKey = "menu_access_{$userId}_{$menuName}";
        
        return Cache::remember($cacheKey, 300, function () use ($userId) {
            // Get user's company
            $company = Company::where('id', $userId)->first();
            
            // If user doesn't have a company, they don't have access
            if (!$company) {
                return false;
            }
            
            // Return true if company's verification status is approved
            return $company->verification_status === 'approved';
        });
    }
    
    /**
     * Check if user has access to a specific menu and get the reason if they don't
     *
     * @param string $menuName The name of the menu to check access for
     * @return array Returns ['access' => bool, 'reason' => string]
     */
    public static function getMenuAccessDetails(string $menuName): array
    {
        // If user is not logged in, they don't have access
        if (!Auth::check()) {
            return [
                'access' => false,
                'reason' => 'You must be logged in to access this feature.'
            ];
        }

        $userId = Auth::id();
        
        // Get user's company
        $company = Company::where('user_id', $userId)->first();
        
        // If user doesn't have a company, they don't have access
        if (!$company) {
            return [
                'access' => false,
                'reason' => 'You need to register a company to access this feature.'
            ];
        }
        
        // Check company verification status
        if ($company->verification_status !== 'approved') {
            return [
                'access' => false,
                'reason' => 'Your company verification is pending. Current status: ' . 
                            ucfirst(str_replace('_', ' ', $company->verification_status)) . '.'
            ];
        }
        
        return [
            'access' => true,
            'reason' => ''
        ];
    }
}