@component('mail::message')
{{-- # Reset password --}}
# استرجاع كلمة السر

{{-- This message from {{ config('app.name') }} to change your password. --}}
هذه الرسالة من  {{ config('app.name') }} لاسترجاع كلمة السر الخاصة بك.

@component('mail::button', ['url' => $data['url']])
{{-- Click here to create a new password --}}
اضغط هنا لإسترجاع كلمة السر
@endcomponent

<br>
<div style="text-align: center;">
{{-- ---------------OR--------------- --}}
---------------أو---------------
</div>
<br>
<br>
{{-- Go to this link: <a href="{{ $data['url'] }}" _blank="target">{{ $data['url'] }}</a> --}}
اضغط على هذا الرابط: <a href="{{ $data['url'] }}" _blank="target">{{ $data['url'] }}</a>

{{-- Thanks,<br> --}}
شكرا لتسجيلك فى موقعنا <a href="{{ url('/') }}" _blank="target">{{ config('app.name') }}</a>
@endcomponent
