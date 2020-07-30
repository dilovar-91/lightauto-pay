@component('mail::message')
Hello **{{$fio}}**,  {{-- use double space for line break --}}
Thank you for choosing Mailtrap!

Click below to start working right now
@component('mail::button', ['url' => $link])
{{$phone}}
@endcomponent
Sincerely,  
Mailtrap team.
@endcomponent