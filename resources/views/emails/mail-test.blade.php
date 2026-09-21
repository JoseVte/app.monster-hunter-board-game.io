@component('mail::message')
{{ __('This is a test message. If it reached you, :app can send mail.', ['app' => config('app.name')]) }}

{{ __('Sent through the :mailer mailer at :time.', ['mailer' => $sentThrough, 'time' => now()->toDateTimeString()]) }}
@endcomponent
