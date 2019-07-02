{{--
 * JobClass - Job Board Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (isset($errors) and $errors->any())
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (session('code'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p>{{ session('code') }}</p>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
					
				<!-- 
				<div class="col-xl-12">
					<div class="alert alert-info">
						{{ getTokenMessage() }}:
					</div>
				</div>
				-->

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="border-bottom: 2px solid #ddd; margin-bottom: 20px;">
					<!-- <h2 class="logo-title"><strong>{{ t('Code') }}</strong></h2> -->
					<h1 style="color: #555; font-size: 2.50rem; font-weight: 300; " class="alert alert-warning"> Thank you! You're just one step away... </h1>
					<h3 style="color: black; font-weight: 500;"> Please click on the verification link we just sent to your Email. </h2>

					<div style="font-size: 1rem; margin-bottom: 20px;"> 
						<!-- Haven't recived the email verification link? -->
						<div href="lurl('verify/user/'{{ app('request')->input('userId') }}'/resend/email')" class="btn btn-warning btn-link" style="color: #1877f2; vertical-align: baseline; padding: 0px;"> {{ t('Re-send verification link to email') }} </div>
						<!--
							<a href="/verify/user/{{ app('request')->input('userId') }}/resend/email" class="btn btn-warning"> t("Re-send") </a>
						 <a href="' . lurl('verify/' . $entityRef['slug'] . '/' . $entity->id . '/resend/email') . '" class="btn btn-warning">' . t("Re-send") . </a>; -->
						</div>
				</div>
			
				<div class="col-lg-5 col-md-8 col-sm-10 col-xs-12 login-box">
					<div class="card card-default">
						<div class="card-body">
							<form id="tokenForm" role="form" method="POST" action="{{ lurl(getRequestPath('verify/.*')) }}">
								{!! csrf_field() !!}
								<!-- <h3 style="color: black; font-size 1rem;"> We also sent you and verifcation code on your mobile, please enter the code in following box. </h2> -->
								<h3> Verify your phone number </h3>

								<!-- code -->
								<?php $codeError = (isset($errors) and $errors->has('code')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="code" class="col-form-label">{{ getTokenLabel() }}:</label>
									<div class="input-icon">
										<i class="fa icon-lock-2"></i>
										<input id="code"
											   name="code"
											   type="text"
											   placeholder="{{ t('Enter the OTP received by SMS') }}"
											   class="form-control{{ $codeError }}"
											   value="{{ old('code') }}"
										>
									</div>
								</div>
								
								<div class="form-group">
									<button id="tokenBtn" type="submit" class="btn btn-primary btn-lg btn-block">{{ t('Verify') }}</button>
								</div>
								<div style="font-size: 1rem; margin-bottom: 20px;"> 
									<!-- Haven't recived the OTP? -->
									<div href="/verify/user/{{ app('request')->input('userId') }}/resend/sms)" class="btn btn-warning btn-link" style="color: #1877f2; vertical-align: baseline; padding: 0px;"> {{ t('Re-send OTP by sms') }} </div>
								</div>
							</form>
						</div>
						
						<!--
						<div class="card-footer text-center">
							&nbsp;
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script>
		$(document).ready(function () {
			$("#tokenBtn").click(function () {
				$("#tokenForm").submit();
				return false;
			});
		});
	</script>
@endsection