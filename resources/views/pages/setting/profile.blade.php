<x-app-layout>
  
 @section('main-section')




 <div class="bg-gray-50 p-2 rounded-xl mb-4">
                        <div class="bg-white p-4 rounded-xl">
                            @livewire('profile.update-password-form')
                        </div>
                    </div>


                    <div class="bg-gray-50 p-2 rounded-xl mb-4">
                        <div class="bg-white p-4 rounded-xl">
                            @livewire('profile.update-profile-information-form')
                        </div>
                    </div>





 @endsection


</x-app-layout>