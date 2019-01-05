@component('mail::message')

您的注册账号为 {{ $user->username }}。感谢您选择，在您后续使用服务的过程中，我们将竭诚为您服务。

Regards,<br>
{{ config('app.name') }}
@endcomponent


