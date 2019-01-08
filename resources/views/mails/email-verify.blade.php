@component('mail::message')
verify your email
@component('mail::button', ['url' => $user->getActivationLink()])
verify
@endcomponent
Thanks
#endcomponent
