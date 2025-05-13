<?php

namespace App\Livewire\Document;

use App\Models\User;
use Livewire\Component;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
class RegisterCompany extends Component
{


      // Company Information
      public $company_name = '';
      public $trading_name = '';
      public $registration_number = '';
      public $date_of_incorporation = '';
      public $business_type = '';
      public $industry = '';
      
      // Contact Information
      public $primary_email = '';
      public $phone_number = '';
      public $website = '';
      public $physical_address = '';
      public $city = '';
      public $region = '';
      public $postal_address = '';
      
      // Primary Contact Person
      public $contact_name = '';
      public $contact_position = '';
      public $contact_email = '';
      public $contact_phone = '';
      
      // Status messages
      public $successMessage = '';
      public $errorMessage = '';
  
      protected function rules()
      {
          return [
              'company_name' => 'required|string|max:255',
              'trading_name' => 'nullable|string|max:255',
              'registration_number' => 'required|string|max:50|unique:companies',
              'date_of_incorporation' => 'required|date',
              'business_type' => 'required|string|max:50',
              'industry' => 'required|string|max:50',
              
              'primary_email' => 'required|email|max:255',
              'phone_number' => 'required|string|max:20',
              'website' => 'nullable|url|max:255',
              'physical_address' => 'required|string|max:255',
              'city' => 'required|string|max:100',
              'region' => 'required|string|max:100',
              'postal_address' => 'nullable|string|max:100',
              
              'contact_name' => 'required|string|max:255',
              'contact_position' => 'required|string|max:100',
              'contact_email' => 'required|email|max:255',
              'contact_phone' => 'required|string|max:20',
          ];
      }
  
      protected function messages()
      {
          return [
              'company_name.required' => 'Company name is required',
              'registration_number.required' => 'Registration number is required',
              'registration_number.unique' => 'This registration number is already registered',
              'date_of_incorporation.required' => 'Date of incorporation is required',
              'business_type.required' => 'Business type is required',
              'industry.required' => 'Industry is required',
              
              'primary_email.required' => 'Primary email is required',
              'primary_email.email' => 'Please enter a valid email address',
              'phone_number.required' => 'Phone number is required',
              'physical_address.required' => 'Physical address is required',
              'city.required' => 'City/Town is required',
              'region.required' => 'Region is required',
              
              'contact_name.required' => 'Contact person name is required',
              'contact_position.required' => 'Contact person position is required',
              'contact_email.required' => 'Contact email is required',
              'contact_email.email' => 'Please enter a valid email address',
              'contact_phone.required' => 'Contact phone number is required',
          ];
      }
  
      public function updated($propertyName)
      {
          $this->validateOnly($propertyName);
      }
  
      public function saveCompany()
      {
          try {
              $validatedData = $this->validate();
              
              // Create new company record
            $company=  Company::create($validatedData);
              
              // Reset form and show success message


              // assign user the company id and be the admin of the company
              $user=User::find(auth()->user()->id);
              $user->update(['role_id'=>2]);



              $this->reset();
              $this->successMessage = 'Company registered successfully!';
              $this->errorMessage = '';
              
              // Optional: Redirect after 2 seconds
              return redirect()->route('add.document', $company->id);
              
          } catch (\Exception $e) {
              Log::error('Error registering company: ' . $e->getMessage());
              $this->errorMessage = 'An error occurred while registering the company. Please try again.';
              $this->successMessage = '';
          }
      }


    public function render()
    {
        return view('livewire.document.register-company');
    }
}
