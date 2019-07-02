
<link href="assets/plugins/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>

<style>
	.form-group {
		margin-bottom: .3rem;
	}

	.form-control {
		border-radius: 0rem !important;
	}

	input[type="file"] {
		display: block;
	}
</style>

<!--
		.form-control{
					border-bottom: 2px black solid!important;
					border-top: 0px!important;
					border-right: 0px!important;
					border-left: 0px!important;
					border-radius: 0px!important;
		}

		.form-control:focus{
			color: #000;
			background-color: #fff;
			border-color: #000;
			outline: 0;
			border-bottom: 2px #0000 solid!important;
			
			box-shadow: 0px 1px 5px -2px rgba(0,0,0,0.75)!important;
		}
		
	input.file {
	position: absolute;
	font-size: 50px;
	opacity: 0;
	right: 0;
	top: 0;
	}

	div.file {
	position: relative;
	overflow: hidden;
	}

	#overlay {
	position: fixed; /* Sit on top of the page content */

	width: 100%; /* Full width (cover the whole page) */
	height: 100%; /* Full height (cover the whole page) */
	top: 0; 
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0,0,0,0.5); /* Black background with opacity */
	z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
	cursor: pointer; /* Add a pointer on hover */
	}
		</style> 

	-->


<?php
	// Init.
	$sForm = [
		'enableFormAreaCustomization' => '0',
		'hideTitles'                  => '0',
		'title'                       => t('Millions of jobs, search the one you deserve.'),
		'subTitle'                    => t('Simple, fast and efficient'),
		'bigTitleColor'               => '', // 'color: #FFF;',
		'subTitleColor'               => '', // 'color: #FFF;',
		'backgroundColor'             => '', // 'background-color: #444;',
		'backgroundImage'             => '', // null,
		'height'                      => '', // '450px',
		'parallax'                    => '0',
		'hideForm'                    => '0',
		'formBorderColor'             => '', // 'background-color: #7324bc;',
		'formBorderSize'              => '', // '5px',
		'formBtnBackgroundColor'      => '', // 'background-color: #7324bc; border-color: #7324bc;',
		'formBtnTextColor'            => '', // 'color: #FFF;',
	];

	// Get Search Form Options
	if (isset($searchFormOptions)) {
		if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
			$sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
		}
		if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
			$sForm['hideTitles'] = $searchFormOptions['hide_titles'];
		}
		if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
			$sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
			$sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
			if (str_contains($sForm['title'], '{count_jobs}')) {
				try {
					$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
				} catch (\Exception $e) {
					$countPosts = 0;
				}
				$sForm['title'] = str_replace('{count_jobs}', $countPosts, $sForm['title']);
			}
			if (str_contains($sForm['title'], '{count_users}')) {
				try {
					$countUsers = \App\Models\User::count();
				} catch (\Exception $e) {
					$countUsers = 0;
				}
				$sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
			}
		}
		if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
			$sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
			$sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
			if (str_contains($sForm['subTitle'], '{count_jobs}')) {
				try {
					$countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
				} catch (\Exception $e) {
					$countPosts = 0;
				}
				$sForm['subTitle'] = str_replace('{count_jobs}', $countPosts, $sForm['subTitle']);
			}
			if (str_contains($sForm['subTitle'], '{count_users}')) {
				try {
					$countUsers = \App\Models\User::count();
				} catch (\Exception $e) {
					$countUsers = 0;
				}
				$sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
			}
		}
		if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
			$sForm['parallax'] = $searchFormOptions['parallax'];
		}
		if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
			$sForm['hideForm'] = $searchFormOptions['hide_form'];
		}
	}

	// Country Map status (shown/hidden)
	$showMap = false;
	if (file_exists(config('larapen.core.maps.path') . config('country.icode') . '.svg')) {
		if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
			$showMap = true;
		}
	}
	?>

	@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1') @if (isset($firstSection)
	and !$firstSection)
	<div class="h-spacer"></div>
	@endif @if (!auth()->check())


	<?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
	<!-- <div class="wide-intro {{ $parallax }}" style="padding:0px; background-image: url(http://foxijobs.com/storage/app/logo/header-5cde50fc2ab5c.jpeg);"> -->
	<div class="wide-intro {{ $parallax }}" style="padding: 0px; /* background-position-x: -200px; background-position-y: -10px; */">

		<!-- "https://www.youtube.com/watch?v=iia8HIsvqmw&list=PLKTlP51GPmJz_ej9d_4OUAh65PMS8jn2n&index=4" -->

		<div class="dtable hw100"> <!-- </div> style="background-color: rgba(0,0,0,0.5);"> -->

			<div class="dtable-cell hw100" style="background-color: rgba(0, 0, 0, 0.4); padding: 10px;">

				<div class="container">
					<div class="row" style="padding-top: 10px;">
						<!-- job search div -->
						<div class="col-sm-7" style=" padding: 5px 30px;">
							<div class="mt-sm-5 mb-sm-4">
								@if ($sForm['hideTitles'] != '1')
								<h1 class="intro-title animated fadeInLeft" style="text-align: left"> {{ $sForm['title'] }} </h1>
								<!--
									 <p class="sub animateme fittext3 animated fadeInLeft">
									{!! $sForm['subTitle'] !!}
								</p>
								-->
								<h1 style="color: white; font-family: Open Sans Condensed, Helvetica Neue, sans-serif">
									Search for
									<a href="" style="color: #fcde11;" class="typewrite" data-period="1000" data-type='[ "Developers", "Engineers", "UX designers", "Problem Solvers", "Project Managers", "Database Administrator", "IT Managers" ]'>
										<span class="wrap" style="color: #fcde11;"></span>
									</a>
								</h1>
							@endif
							</div>

							@if ($sForm['hideForm'] != '1')
							<div class="search-row animated fadeInUp">

								<!-- search form -->
								<?php $attr = ['countryCode' => config('country.icode')]; ?>
								<form id="search" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
									<div class="row m-0">
										<div class="col-sm-5 col-xs-12 search-col relative">
											<i class="icon-docs icon-append"></i>
											<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
										</div>

										<div class="col-sm-5 col-xs-12 search-col relative locationicon">
											<i class="icon-location-2 icon-append"></i>
											<input type="hidden" id="lSearch" name="l" value=""> @if ($showMap)
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
											 placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom" data-toggle="tooltip" type="button"
											 data-original-title="{{ t('Enter a city name OR a state name with the prefix " :prefix
											 " like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}"> @else
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon" placeholder="{{ t('Where?') }}"
											 value=""> @endif
										</div>

										<div class="col-sm-2 col-xs-12 search-col">
											<button class="btn btn-primary btn-search btn-block">
												<i class="icon-search"></i>
												<strong>{{ t('Find') }}</strong>
											</button>
										</div>
										{!! csrf_field() !!}
									</div>
								</form>
								<!-- /search form -->
							</div>

							@endif

						</div>
						<!-- job search div - ends -->


						<!-- Registration form div -->
						<div class="col-sm-5" style="padding: 10px 25px; background: rgba(255, 255, 255, 0.3) ;">

							<!-- 
						<h2 class="title-2">
							<strong>
								<i class="icon-user-add"></i> {{ t('Create your account, Its free') }}</strong>
						</h2>
						-->

							@if (config('settings.social_auth.social_login_activation'))
							<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
										<a href="{{ lurl('auth/facebook') }}" class="btn-fb">
											<i class="icon-facebook"></i> {!! t('Connect with Facebook') !!}</a>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
									<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
										<a href="{{ lurl('auth/google') }}" class="btn-danger">
											<i class="icon-googleplus-rect"></i> {!! t('Connect with Google') !!}</a>
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

							<!--// Just resume form close -->
							<div class="form-group row required" style="background:#fff; padding: 10px; ">
								<div class="col-md-12 text-center mb-2" style="color: black; font-size: 18px;">
									{{ t('Need a job in IT ?') }}
								</div>
								<div class="col-md-12 text-center">
									<button class="col-md-7 col-lg-7 col-sm-12 btn-lg btn-success" onclick="document.getElementById('resumeFile').click()">
											<i class="fa fa-upload"></i> 
											<span class=""> {{ t('Upload your Resume') }} </span>
									</button>
									<small id="" class="form-text text-muted">Max 5 MB, doc, docx, rtf, pdf</small>
									<!-- <small id="" class="form-text text-muted">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')]) }}</small> -->
								</div>
							</div>

							<div class="row d-flex justify-content-center loginOr">
								<div class="col-xl-12 mb-1">
									<hr class="hrOr">
									<span class="spanOr rounded">{{ t('or') }}</span>
								</div>
							</div>
								
							<!-- form div -->
							<div class="form-group row required" style="border: 1px solid #ddd; border-top: none;">
								<div style="">
									<form id="signupForm" class="form-horizontal" method="POST" action="{{ url('register') }}" enctype="multipart/form-data"
									 style="background:#fff; padding: 10px 30px;">

										@if (isset($errors) and $errors->any())
										<div class="col-xl-12">
											<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<h5>
													<strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong>
												</h5>
												<ul class="list list-check">
													@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										</div>
										@endif @if (Session::has('flash_notification'))
										<div class="col-xl-12">
											<div class="row">
												<div class="col-lg-12">
													@include('flash::message')
												</div>
											</div>
										</div>
										@endif

										<h3 class="" style=" margin-bottom: 10px; border-bottom: 2px solid #ddd; color: #333;">
											{{ t('Register As Candidate') }}
										</h3>

										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="name">{{ t('Name') }}
												<sup>*</sup>
											</label>
											<div class="col-md-9">
												<input type="text" class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }} " name="name" id="name" placeholder="Your Full Name" value={{ old('name') }}>
											</div>
										</div>

										@if (isEnabledField('phone'))
											<!-- phone -->
											<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label">{{ t('Phone') }}
													<sup>*</sup>
												</label>
												<div class="col-md-9">
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
																onkeyup="if(this.value.length >= 10)checkPhoneExist(this.value);"
																value="{{ phoneFormat(old('phone'), old('country', config('country.code'))) }}"
														>
														
														<!-- 
														<div class="input-group-append tooltipHere" data-placement="top"
															data-toggle="tooltip"
															data-original-title="{{ t('Hide the phone number on the job posts.') }}">
															<span class="input-group-text">
																<input name="phone_hidden" id="phoneHidden" type="checkbox"
																		value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }}>&nbsp;<small>{{ t('Hide') }}</small>
															</span>
														</div>
														-->
													</div>
												</div>
											</div>
										@endif
										
										<!--
										<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="password">{{ t('Email') }}
													<sup>*</sup>
												</label>
												<div class="col-md-9">
													<input type="email" class="form-control {{ $errors->has('email') ? 'border border-danger' : '' }} " name="email" id="email" placeholder="Email" aria-describedby="email" value={{ old('email') }}>
												</div>
										</div>
										-->

										@if (isEnabledField('email'))
											<!-- email -->
											<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="email">{{ t('Email') }}
													<sup>*</sup>
												</label>
												<div class="col-md-9">
													<div class="input-group">
														<input id="email"
																name="email"
																type="email"
																onkeyup="checkEmailExist(this.value);"
																class="form-control{{ $emailError }}"
																placeholder="{{ t('Email') }}"
																value="{{ old('email') }}"
														>
													</div>
												</div>
											</div>
										@endif

										<!--
										@if (isEnabledField('username'))
											<!-- username ->
											<?php $usernameError = (isset($errors) and $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="email">{{ t('Username') }}</label>
												<div class="col-md-9">
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
										-->

										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="password">{{ t('Password') }}
												<sup>*</sup>
											</label>
											<div class="col-md-9">
												<input id="password" name="password" type="password" class="form-control {{ $errors->has('password') ? 'border border-danger' : '' }} " placeholder="{{ t('Password') }}" style="margin-bottom: .5rem;">
												<input id="Confirm" name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'border border-danger' : '' }} " placeholder="{{ t('Password Confirmation') }}">
												<small id="" class="form-text text-muted">{{ t('At least 5 characters') }}</small>
											</div>
										</div>

                                        <input type="hidden" name="user_type_id" id="user_type_id" value="2" />

										<!--
										<div class="form-group row required">
										<div class="input-group file-caption-main">
											<div class="file-caption form-control  kv-fileinput-caption" tabindex="500">
											<span class="file-caption-icon"></span>
											<input class="file-caption-name" onkeydown="return false;" onpaste="return false;" placeholder="Select file...">
										</div>
										<div class="input-group-btn input-group-append">
													<button type="button" tabindex="500" title="Clear selected files" class="btn btn-default btn-secondary fileinput-remove fileinput-remove-button"><i class="glyphicon glyphicon-trash"></i>  <span class="hidden-xs">Remove</span></button>
													<button type="button" tabindex="500" title="Abort ongoing upload" class="btn btn-default btn-secondary kv-hidden fileinput-cancel fileinput-cancel-button"><i class="glyphicon glyphicon-ban-circle"></i>  <span class="hidden-xs">Cancel</span></button>
													<button type="submit" tabindex="500" title="Upload selected files" class="btn btn-default btn-secondary fileinput-upload fileinput-upload-button"><i class="glyphicon glyphicon-upload"></i>  <span class="hidden-xs">Upload</span></button>
													<div tabindex="500" class="btn btn-primary btn-file"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;  <span class="hidden-xs">Browse …</span><input id="filename" name="resume" type="file" class="form-control file btn btn-sm btn-add-listing"></div>
												</div>
											</div>
										</div>
										-->

										<!-- filename -->
										<?php $resumeFilenameError = (isset($errors) and $errors->has('filename')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label {{ $resumeFilenameError }} " for="resume"> {{ t('Resume') }}
												<sup>*</sup>
											</label>

											<div class="col-md-9">
												<div class="mb10">
													<input id="filename" name="resume" type="file"  class="form-control file{{ $resumeFilenameError }} btn btn-sm" data-show-preview="false" value={{ old('resume') }}>
												</div>
												<small id="" class="form-text text-muted">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')]) }}</small>
											</div>
										</div>

										<div class="form-group row required">
											<div class="col-md-3">
											</div>
											<div class="col-md-9">
												<div class="custom-checkbox">
													<input type="checkbox" name="term" class="form-check-input" id="customCheck1">
													<div class="" for="customCheck1" style="display: inline;">I have read, understood and accept the
														<a href="http://foxijobs.com/page/terms"> Terms & Conditions </a> and
														<a href="http://foxijobs.com/page/privacy">Privacy Policy</a> of FoxiJobs.com
													</div>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-3"></div>
											<div class="col-md-9">
												<button type="submit" class="btn btn-lg btn-primary col-md-5" onclick="$('#progressDiv').show();" > Register </button>
											</div>
										</div>

										<!-- 
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


                                <form id="signupForm" class="form-horizontal" method="POST" action="{{ url('register') }}" enctype="multipart/form-data">
                                    
                                    <div  class="form-group">
                                      <label for="confirmpass">Upload Resume<sup style="color:red;">  *</sup></label>
                                    <div class="file btn btn btn-sm btn-add-listing pl-4 pr-4">
                        							Upload
                        							<input class="file" type="file" name="filename"/>
                        						</div>
                                    
                                    </div>
                                    
                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <div class="form-row"> 
                                            <div class="col-md-2">
                                            <label class="d-none d-sm-block" for="name" style="margin-top: 9px;">Name<sup style="color:red;">  *</sup></label>
                                            </div>
                                            <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Full Name">
                                            </div>
                                         </div>
                                      </div>
                                     
                                  </div>
                                  <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <div class="form-row"> 
                                            <div class="col-md-2">
                                            <label class="d-none d-sm-block" for="name" style="margin-top: 9px;">Email<sup style="color:red;">  *</sup></label>
                                            </div>
                                            <div class="col-md-9">
                                            <input type="email" class="form-control" name="email" id="name" placeholder="Email">
                                            </div>
                                         </div>
                                      </div>
                                     
                                   </div>
                                   
                                    <div class="form-row">
                                       <div class="form-group col-md-12">
                                          <div class="form-row"> 
                                            <div class="col-md-2" style="padding:0px;">
                                            <label class="d-none d-sm-block" for="password" style="margin-top: 9px;">Password<sup style="color:red;">  *</sup></label>
                                            </div>
                                            <div class="col-md-9">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            </div>
                                         </div>
                                      </div>
                                     
                                   </div>
                                   
                                   <input type="hidden" name="user_type_id" value="2">
                                   
                                   <div class="form-row">
                                         <div class="form-group col-md-12">
                                            <div class="form-row"> 
                                              <div class="col-md-2" style="padding:0px;">
                                              <label class="d-none d-sm-block" for="Confirm">Confirm Password<sup style="color:red;">  *</sup></label>
                                              </div>
                                              <div class="col-md-9">
                                              <input type="password"  class="form-control" name="password_confirmation" id="Confirm" placeholder="Confirm Password">
                                              </div>
                                           </div>
                                        </div>
                                       
                                     </div>
                                  
                                  
                               
                                  
                                   <div class="form-row">
                                       <div class="form-group col-md-12 text-center">
                                          <div class="form-row"> 
                                            <div class="col-md-12" style="padding:0px;">
                                             <div class="custom-control custom-checkbox" style="margin: 10px 0px;">
                                              <input type="checkbox" name="term" class="custom-control-input" id="customCheck1">
                                              <label class="custom-control-label" for="customCheck1">I read,
understood and accept the Terms & Conditions and <a href="http://foxijobs.com/page/terms">Privacy Policy of FoxiJobs.com</a>.</label>
                                             </div>
                                            </div>
                                            <div class="col-md-12">
                                             <button type="submit" class="btn btn-lg btn-add-listing pl-4 pr-4">Submit</button>
                                            </div>
                                         </div>
                                      </div>
                                     
                                   </div>
                            
                                </form>
								-->
									</form>

								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@else
	<!-- @include('home.inc.spacer') -->

	<div style="margin-top: 30px;">
		<div class="container">
			<div class="intro">
				<div class="dtable hw100">
					<div class="dtable-cell hw100">
						<div class="container text-center">

							<div class="search-row fadeInUp">
								<?php $attr = ['countryCode' => config('country.icode')]; ?>
								<form id="search" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET" data-toggle="validator">
									<div class="row m-0">
										<div class="col-sm-5 col-xs-12 search-col relative">
											<i class="icon-docs icon-append"></i>
											<input type="text" name="q" class="form-control keyword has-icon" placeholder="{{ t('What?') }}" value="">
										</div>

										<div class="col-sm-5 col-xs-12 search-col relative locationicon">
											<i class="icon-location-2 icon-append"></i>
											<input type="hidden" id="lSearch" name="l" value=""> @if ($showMap)
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
											 placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom" data-toggle="tooltip" type="button"
											 data-original-title="{{ t('Enter a city name OR a state name with the prefix " :prefix
											 " like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}"> @else
											<input type="text" id="locSearch" name="location" class="form-control locinput input-rel searchtag-input has-icon" placeholder="{{ t('Where?') }}"
											 value=""> @endif
										</div>

										<div class="col-sm-2 col-xs-12 search-col">
											<button class="btn btn-primary btn-search btn-block">
												<i class="icon-search"></i>
												<strong>{{ t('Find') }}</strong>
											</button>
										</div>
										{!! csrf_field() !!}
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@endif 
@endif

<script>

		function _(el) {
			return document.getElementById(el);
		}

		function uploadFile() {

			var file = document.getElementById("resumeFile").files[0];

			/* Check if file size is more than 5MB, then abort upload */
			/* alert(file.name+" | "+file.size+" | "+file.type); */
			if (file.size > 5000000) {
				alert ("The resume file size must be under 5MB. Please reduce the size of the resume and try uploading again.");
				return false;
		    }

			var formdata = new FormData();
			formdata.append("resumeFile", file);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", "{{ url('tempResume/store') }}"); /* http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP */
			/* use file_upload_parser.php from above url */
			ajax.send(formdata);

			$("#progressDiv").show();
		}

		function progressHandler(event) {
			_("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
			var percent = (event.loaded / event.total) * 100;
			_("progressBar").value = Math.round(percent);
			_("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
		}

		function completeHandler(event) {
			_("status").innerHTML = event.target.responseText;
			_("progressBar").value = 0; /* will clear progress bar after successful upload */

			$("#progressDiv").hide();

			// alert(event.target.responseText);
			
			/* Rediect as upload is successfull */
		  window.location.replace("{{ url('register' . '?userType=2') }}")
			
			/* alert("Upload completed."); */
		}

		function errorHandler(event) {
			_("status").innerHTML = "Upload Failed";
			$("#progressDiv").hide();
		}

		function abortHandler(event) {
			_("status").innerHTML = "Upload Aborted";
			$("#progressDiv").hide();
		}
</script>


@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js') }}" type="text/javascript"></script>
	@endif

	{{--Added by Vimal (Check phone number already exist or not.)--}} 
	<script src="{{url('/assets/js/phone-email-check.js')}}"></script>

<div class="col-md-12" style="position: absolute; z-index: -100; top:100; left: 100;">
	<form id="upload_form" enctype="multipart/form-data" method="post">
		<input type="file" name="resumeFile" id="resumeFile" onchange="uploadFile()" hidden>
		<!-- 
			<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
			<h3 id="status"></h3>
			<p id="loaded_n_total"></p>
		-->
	</form>
</div>

@include('common.progress')

@endsection

	