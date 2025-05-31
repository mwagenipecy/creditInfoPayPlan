<x-app-layout>
  
 @section('main-section')

  @if(auth()->user()->role_id==1)
 <livewire:dashboard.dashboard />

 @endif 


 @if(auth()->user()->role_id==2 || auth()->user()->role_id==3 )
<livewire:dashboard.company />

@endif 
 

 @endsection


</x-app-layout>

