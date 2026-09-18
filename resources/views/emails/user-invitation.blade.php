@component('mail::message')
{{ __(':inviter has invited you to join :app.', ['inviter' => $invitation->inviter->name, 'app' => config('app.name')]) }}

{{ __('Follow the link below to create your account. The invitation expires on :date.', ['date' => $invitation->expires_at->toFormattedDateString()]) }}

@component('mail::button', ['url' => $acceptUrl])
{{ __('Accept Invitation') }}
@endcomponent

{{ __('If you were not expecting this invitation, you may discard this email.') }}
@endcomponent
