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
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-md-8 page-content">
					<div class="inner-box">
						<h2 class="title-2">
							<strong><i class="icon-user-add"></i> {{ t('Create your account, Its free') }}</strong>
						</h2>
						
						@if (config('settings.social_auth.social_login_activation'))
							<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
										<a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i class="icon-facebook"></i> {!! t('Connect with Facebook') !!}</a>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
										<a href="{{ lurl('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i> {!! t('Connect with Google') !!}</a>
									</div>
								</div>
							</div>
							
							<div class="row d-flex justify-content-center loginOr">
								<div class="col-xl-12 mb-1">
									<hr class="hrOr">
									<span class="spanOr rounded">{{ t('or') }}</span>
								</div>
							</div>
						@endif
						
						<div class="row mt-5">
							<div class="col-xl-12">
								<form id="signupForm" class="form-horizontal" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>
										<?php
										/*
										<!-- gender_id -->
										<?php $genderIdError = (isset($errors) and $errors->has('gender_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label{{ $genderIdError }}">{{ t('Gender') }} <sup>*</sup></label>
											<div class="col-md-7">
												<select name="gender_id" id="genderId" class="form-control selecter{{ $genderIdError }}">
													<option value="0"
															@if (old('gender_id')=='' or old('gender_id')==0)
																selected="selected"
															@endif
													> {{ t('Select') }} </option>
													@foreach ($genders as $gender)
														<option value="{{ $gender->tid }}"
																@if (old('gender_id')==$gender->tid)
																	selected="selected"
																@endif
														>
															{{ $gender->name }}
														</option>
													@endforeach
												</select>
											</div>
										</div>
										*/
										?>

										<!-- passing user type to registration page, if not passed, the page will show employee and jobseeker radio selection -->
										<?php $user_type_id = app('request')->input('userType') ?>

										<!-- user_type_id -->
										<?php $userTypeIdError = (isset($errors) and $errors->has('user_type_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required" style="display: {{ (empty($user_type_id)) ? '' : 'none' }} ">
											<label class="col-md-4 col-form-label">{{ t('You are a') }} <sup>*</sup></label>
											<div class="col-md-6">
												@foreach ($userTypes as $type)
													<div class="form-check form-check-inline pt-2" >
														<input type="radio"
															   name="user_type_id"
															   id="userTypeId-{{ $type->id }}"
															   class="form-check-input user-type{{ $userTypeIdError }}"
															   value="{{ $type->id }}" 
															   {{ (request()->get('userType') == $type->id) || (old('user_type_id', request()->get('type')) == $type->id)  ? 'checked="checked"' : '' }}
															   onchange="showHideResumeField()"
														>
														<label class="form-check-label" for="user_type_id-{{ $type->id }}">
															{{ t('' . $type->name) }}
														</label>
													</div>
												@endforeach
											</div>
										</div>
										
										<!-- name -->
										<?php $nameError = (isset($errors) and $errors->has('name')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label">{{ t('Name') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input name="name" placeholder="{{ t('Name') }}" class="form-control input-md{{ $nameError }}" type="text" value="{{ old('name') }}">
											</div>
										</div>

										<!-- country_code -->
										@if (empty(config('country.code')))
											<?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label{{ $countryCodeError }}" for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-6">
													<select id="countryCode" name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>{{ t('Select') }}</option>
														@foreach ($countries as $code => $item)
															<option value="{{ $code }}" {{ (old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$code) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
										@endif
										
										@if (isEnabledField('phone'))
											<!-- phone -->
											<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label">{{ t('Phone') }}
													@if (!isEnabledField('email'))
														<sup>*</sup>
													@endif
												</label>
												<div class="col-md-6">
													<div class="input-group">
														<!--
														<div class="input-group-prepend">
															<span id="phoneCountry" class="input-group-text">{!! getPhoneIcon(old('country', config('country.code'))) !!}</span>
														</div>
														-->
														<input name="phone"
															   placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('Phone Number') }}"
															   class="form-control input-md{{ $phoneError }}"
															   type="text"
															   onfocusout="if(this.value.length >= 10)checkPhoneExist(this.value);" 
															   value="{{ phoneFormat(old('phone'), old('country', config('country.code'))) }}"
														>

														@if ( $user_type_id == 1 ) 
														<div class="input-group-append tooltipHere" data-placement="top"
															 data-toggle="tooltip"
															 data-original-title="{{ t('Hide the phone number on the job posts.') }}">
															<span class="input-group-text">
																<input name="phone_hidden" id="phoneHidden" type="checkbox"
																	   value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }}>&nbsp;<small>{{ t('Hide') }}</small>
															</span>
														</div>
														@endif
													</div>
												</div>
											</div>
										@endif
										
										@if (isEnabledField('email'))
											<!-- email -->
											<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email">{{ t('Email') }}
													@if (!isEnabledField('phone'))
														<sup>*</sup>
													@endif
												</label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="icon-mail"></i></span>
														</div>
														<input id="email"
															   name="email"
															   type="email"
															   onfocusout="checkEmailExist(this.value);"
															   class="form-control{{ $emailError }}"
															   placeholder="{{ t('Email') }}"
															   value="{{ old('email') }}"
														>
													</div>
												</div>
											</div>
										@endif
										
										@if (isEnabledField('username'))
											<!-- username -->
											<?php $usernameError = (isset($errors) and $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email">{{ t('Username') }}</label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="icon-user"></i></span>
														</div>
														<input id="username"
															   name="username"
															   type="text"
															   class="form-control{{ $usernameError }}"
															   placeholder="{{ t('Username') }}"
															   value="{{ old('username') }}"
														>
													</div>
												</div>
											</div>
										@endif
										
										<!-- password -->
										<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label" for="password">{{ t('Password') }} <sup>*</sup></label>
											<div class="col-md-6">
												<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('Password') }}">
												<br>
												<input id="password_confirmation" name="password_confirmation" type="password" class="form-control{{ $passwordError }}"
													   placeholder="{{ t('Password Confirmation') }}">
												<small id="" class="form-text text-muted">{{ t('At least 5 characters') }}</small>
											</div>
										</div>

										<!-- filename -->
										<?php $resumeFilenameError = (isset($errors) and $errors->has('filename') and (request()->get('userType') == 2)) ? ' is-invalid' : ''; ?>
										<div class="form-group row {{ (request()->get('userType') == 2) ? 'required': '' }}" id="resumeField" style="display: {{ (request()->get('type') == $type->id) ? '': 'none' }}">
											<label class="col-md-4 col-form-label {{ $resumeFilenameError }} " for="resume"> {{ t('Resume') }}
												<sup>*</sup>
											</label>

											<div class="col-md-8">
												<div class="mb10">
													<input id="filename" name="resume" type="file" class="form-control file {{ $resumeFilenameError }} btn btn-sm btn-add-listing">
												</div>
												<small id="" class="form-text text-muted">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')]) }}</small>
											</div>
										</div>
										
										@if (config('larapen.core.register.showCompanyFields'))
											<div id="companyBloc">
												<div class="content-subheading">
													<i class="icon-town-hall fa"></i>
													<strong>{{ t('Company Information') }}</strong>
												</div>
												
												@include('account.company._form', ['originForm' => 'user'])
											</div>
										@endif
										
										@if (config('larapen.core.register.showResumeFields'))
											<div id="resumeBloc">
												<div class="content-subheading">
													<i class="icon-attach fa"></i>
													<strong>{{ t('Resume') }}</strong>
												</div>
												
												@include('account.resume._form', ['originForm' => 'user'])
											</div>
										@endif

										@if (config('settings.security.recaptcha_activation'))
											<!-- recaptcha -->
											<?php $recaptchaError = (isset($errors) and $errors->has('g-recaptcha-response')) ? 'is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label{{ $recaptchaError }}" for="g-recaptcha-response"></label>
												<div class="col-md-6">
													{!! Recaptcha::render(['lang' => config('app.locale')]) !!}
												</div>
											</div>
										@endif
										
										<!-- term -->
										<?php $termError = (isset($errors) and $errors->has('term')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required"
											 style="margin-top: -10px;">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-6">
												<div class="form-check">
													<input name="term" id="term"
														   class="form-check-input{{ $termError }}"
														   value="1"
														   type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }}
													>
													<div class="" for="customCheck1" style="display: inline;">I have read, understood and accept the
														<a href="http://foxijobs.com/page/terms"> Terms & Conditions </a> and
														<a href="http://foxijobs.com/page/privacy">Privacy Policy</a> of FoxiJobs.com
													</div>
													<!-- 
													<label class="form-check-label" for="invalidCheck3">
														{!! t('I read, understood and accept the Terms & Conditions and <a :attributes>Privacy Policy FoxiJobs.com</a>', ['attributes' => getUrlPageByType('terms')]) !!}
													</label>
													-->
												</div>
												<div style="clear:both"></div>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-8">
												<button id="signupBtn" class="btn btn-success btn-lg"> {{ t('Register') }} </button>
											</div>
										</div>

										<div style="margin-bottom: 30px;"></div>

									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post a Job') }}</strong></h3>
							<p>
								{{ t('Do you have a post to be filled within your company? Find the right candidate in a few clicks at :app_name',
								['app_name' => config('app.name')]) }}
							</p>
						</div>
						<div class="promo-text-box"><i class="icon-pencil-circled fa fa-4x icon-color-2"></i>
							<h3><strong>{{ t('Create and Manage Jobs') }}</strong></h3>
							<p>{{ t('Become a best company. Create and Manage your jobs. Repost your old jobs, etc.') }}</p>
						</div>
						<div class="promo-text-box"><i class="icon-heart-2 fa fa-4x icon-color-3"></i>
							<h3><strong>{{ t('Create your Favorite jobs list.') }}</strong></h3>
							<p>{{ t('Create your Favorite jobs list, and save your searches. Don\'t forget any opportunity!') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js') }}" type="text/javascript"></script>
	@endif
	
	<script>

		$(document).ready(function ()
		{
    		var userTypeId = "<?php echo old('user_type_id', request()->get('userType')); ?>";
			var userTypeId = parseInt("{{ (request()->get('userType')) }}");
    				
			/** Show hide the resume filed on based on the request parameter passed */
			if (userTypeId == 1) {
				$("#resumeField").hide();
			} else {
				$("#resumeField").show();
			}
    
			/* Set user type */
			setUserType(userTypeId);
			$('.user-type').click(function () {
				userTypeId = $(this).val();
				setUserType(userTypeId);
			});

			/* Submit Form */
			$("#signupBtn").click(function () {
				$("#signupForm").submit();
				return false;
			});

			/** Show hide the resume filed on selection of employee of jobseeker radio */
			$('input[type="radio"]').click(function(){
				var selectedOption = $(this).val(); 
				if (selectedOption == 1) {
					$("#resumeField").hide();
				} else {
					$("#resumeField").show();
				}
			});

			

		});
	</script>
	{{--Added by Vimal (Check phone number already exist or not.)--}} 
	<script src="{{url('/assets/js/phone-email-check.js')}}"></script>

@endsection
