@component('mail::message')
# New Message
Hi a new message have been just posted
@component('mail::button', ['url' => ''])
Button Text
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponen
