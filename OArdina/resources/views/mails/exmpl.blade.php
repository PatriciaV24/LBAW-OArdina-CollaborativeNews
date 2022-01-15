@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}

Click below to recover your password
@component('mail::button', ['url' => $link])
Recover password
@endcomponent
Sincerely,
O Ardina team.
@endcomponent