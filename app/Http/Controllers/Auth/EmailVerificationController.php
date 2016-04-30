<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jrean\UserVerification\Facades\UserVerification;
use Auth;
use Exception;

/* user gets here when registered but email isn't verified
 */
class EmailVerificationController extends Controller
{
	public function __construct()
	{
        $this->middleware('auth.email_not_verified');

		//if verified - redirect to home
		if($user = Auth::user()) {
			if($user->verified) {
				redirect()->to('/home')->send();
			}
		}
	}

	public function emailNotVerified() 
	{
		return view('auth.email_not_verified');
	}

	public function resendVerificationEmail(Request $request)
	{
		if($user = $request->user()) {
			UserVerification::generate($user);
			UserVerification::send($user, trans('registration.user-verification_email_subject'));
			return $this->simpleSuccessAnswer(
				"Verification email is sent", 
				"Verification email is sent successfully. Please check your mail box"
			);

		} else {
			throw new Exception("User not found");
		}

	}
}
