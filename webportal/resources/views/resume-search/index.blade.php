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
				

				<div class="col-md-12 page-content">

					@include('flash::message')

					@if (isset($errors) and $errors->any())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<div class="inner-box default-inner-box">
						
						
						<div id="accordion" class="panel-group">
							<!-- USER -->
							<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title"><a href="" data-toggle="collapse" data-parent="#accordion">{{ t('Resume Search') }}</a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'show' : '' }}" id="userPanel">
									<div class="card-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="userPanel">
                                            
                                            
                                                
                                                
                                            

                                                
    
                                                <!-- Search by Keyword -->
												<?php $searchByKeywordError = (isset($errors) and $errors->has('search_by_keyword')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Search by Keyword') }}: </label>
                                                    <div class="col-md-9">
                                                        <input name="search_by_keyword" type="text" class="form-control{{ $searchByKeywordError }}" placeholder="" value="">
                                                    </div>
                                                </div>
	
												<!-- Skill -->
												<?php $skillError = (isset($errors) and $errors->has('skill')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Skill') }}: </label>
                                                    <div class="col-md-9">
                                                        <input name="skill" type="text" class="form-control{{ $skillError }}" placeholder="" value="">
                                                    </div>
                                                </div>

                                                <!-- Education -->
												<?php $educationError = (isset($errors) and $errors->has('education')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Education') }}: </label>
                                                    <div class="col-md-9">
                                                        <input name="education" type="text" class="form-control{{ $educationError }}" placeholder="" value="">
                                                    </div>
                                                </div>
    
    											<!-- Total experience -->
												<?php $totalExpError = (isset($errors) and $errors->has('total_experience_min')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Total Experience') }}: </label>
                                                    <div class="col-md-4">
                                                        <input name="total_experience_min" type="text" class="form-control {{ $totalExpError }}" placeholder="{{ t('Min') }}" value="">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="total_experience_max" type="text" class="form-control{{ $totalExpError }}" placeholder="{{ t('Max') }}" value="">
                                                    </div>
                                                </div>
                                                
    
                                               <!-- Total experience -->
												<?php $currentCtcError = (isset($errors) and $errors->has('current_ctc')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Current CTC') }}: </label>
                                                    <div class="col-md-4">
                                                        <input name="current_ctc_min" type="text" class="form-control {{ $currentCtcError }}" placeholder="{{ t('Min') }}" value="">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="current_ctc_max" type="text" class="form-control{{ $currentCtcError }}" placeholder="{{ t('Max') }}" value="">
                                                    </div>
                                                </div>
                                                
                                            
                                            	
                                           
                                            
                                            <?php $prefered_locationError = (isset($errors) and $errors->has('prefered_location')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group row required">
                                                    <label class="col-md-3 col-form-label">{{ t('Prefered Location') }}:</label>
													<div class="input-group col-md-9">
													
														<input id="prefered_location"
															   name="prefered_location"
															   type="text"
															   class="form-control{{ $prefered_locationError }}"
															   placeholder="{{ t('Prefered Location') }}"
															   value=""
														>
													</div>
                                                </div>
                                            
											<div class="form-group row">
												<div class="offset-md-3 col-md-9"></div>
											</div>
											
											<!-- Button -->
											<div class="form-group row">
												<div class="offset-md-3 col-md-9">
													<button style="" type="submit" class="btn btn-info">{{ t('Search For Candidate') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						

						</div>
						<!--/.row-box End-->

					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
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
@endsection
