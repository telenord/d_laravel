<p>Please click here to reset your password: </p>
<p><a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a></p>
<p>If you did not ask to reset password at {{ trans('app.name') }}, please ignore this email. Thank you!</p>
<p>The {{ trans('app.name') }} Team</p>

