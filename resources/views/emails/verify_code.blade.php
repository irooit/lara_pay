@component('mail::message')

您的验证码是：{{ $verifyCode }}，请尽快进行验证！

Your verification code is: {{ $verifyCode }}, please verify as soon as possible!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
