<p>Please click here to verify your email address: </p>
<p><a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a></p>
<p>If you did not sign up to create a profile on {{ trans('app.name') }}, please inform us by replying to this email. Thank you!</p>
<p>The {{ trans('app.name') }} Team</p>

