{{--
This file is part of laravel-bootstrap-adminlte-starter-kit.

Copyright (c) 2016 Oleksii Prudkyi
--}}

@extends('pages.box.simple_box')

@section('simple_box_title', 'Your email isn\'t verified.')
@section('simple_box_style', 'danger')

@section('simple_box_body')
<p>The system stores sensitive information and it's important to ensure
if you have used correct email so no one will be allowed to access your private info.</p>
<p>Please check your mail box and click the link sent to you in verification email.</p>
<p>If you have not received your verification email you might need to check Spam or Bulk Mail folders as well.</p>
<p>Also, you may request new verification email by clicking
<a id="anchorResendVerificationEmail" href="{{ URL::route('verification.resend_verification_email') }}"
 onclick="$.TSPApp.User.resendVerificationEmail('{{ URL::route('verification.resend_verification_email') }}');return false;"
>here</a>
@endsection

