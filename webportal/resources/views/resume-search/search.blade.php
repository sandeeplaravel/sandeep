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
<?php
use App\Models\Experience;
use \App\Http\Controllers\ResumeController;
?>
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3 page-content">
					<div class="inner-box default-inner-box">
						<div class="list-filter">
							<h5 class="list-title"><strong><a href="#"> {{ t('Education') }} </a></strong></h5>
							<div class="filter-date filter-content">
								<select class="education" multiple="multiple">
									@foreach($sidebar_degrees as $sidebar_degree)
							            <option value="{{$sidebar_degree->id}}">{{$sidebar_degree->name}}</option>
						            @endforeach
							    </select>
							</div>
						</div>

						<div class="list-filter">
							<h5 class="list-title"><strong><a href="#"> {{ t('Skill') }} </a></strong></h5>
							<div class="filter-date filter-content">
								<select class="skill" multiple="multiple">
						            @foreach($sidebar_skills as $sidebar_skill)
							            <option value="{{$sidebar_skill->skill}}">{{$sidebar_skill->skill}}</option>
						            @endforeach
							    </select>
							</div>
						</div>

						<div class="list-filter">
							<h5 class="list-title"><strong><a href="#"> {{ t('Experience') }} </a></strong></h5>
							<div class="filter-date filter-content">
								<select class="experience" multiple="multiple">
									@for($i=1;$i<=50;$i++)
							            <option value="{{$i}}">{{$i}}</option>
						            @endfor
							    </select>
							</div>
						</div>

						<div class="list-filter">
							<h5 class="list-title"><strong><a href="#"> {{ t('Prefered Location') }} </a></strong></h5>
							<div class="filter-date filter-content">
								<select class="location" multiple="multiple">
						            @foreach($sidebar_cities as $sidebar_city)
							            <option value="{{$sidebar_city->name}}">{{$sidebar_city->name}}</option>
						            @endforeach
							    </select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-9 page-content">

					<div class="inner-box default-inner-box search-filter">
						
						<div id="accordion" class="panel-group">
							<div class="spinner">
							<!-- USER -->
							<?php $i=0;$count = count($users);?>
							@if($count > 0)
							@foreach($users as $user)
							<div class="card card-default">
								@if($i==0)
								<div class="card-header">
									<h4 class="card-title"><a href="" data-toggle="collapse" data-parent="#accordion">{{ t('Candidate Search Results') }} <?php echo '('.$count.')' ?> </a></h4>
								</div>
								@endif
								<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'show' : '' }}" id="userPanel">
									<div class="card-body">
										<p>{{$user->name}}</p>

										<p>Last position: 
											<?php $position = Experience::where('user_id', $user->id)->latest()->get()->pluck('designation');
								            	if (count($position) > 0) {
								            		echo $position[0];
								            	}?>
						            	</p>
										<p>Skill: {{$user->skill}}</p>
										<p>Experience: {{ResumeController::countExp($user->id)}} years.</p>
										<p>Current CTC: {{$user->current_ctc}} LPA</p>
										 <select class="btn btn-default" style="border-radius:0;height: 38px;">
										     <option selected>Shortlist Candidate for</option>
										     @if (Auth::check())
										     <?php $employer_id = Auth::user()->id;?>
										     @else
										     	<?php $employer_id = 0;?>
										     @endif
										     <?php $jobs = ResumeController::getJobs($employer_id);
										     		$job_count = count($jobs);
										     ?>
										     @if($job_count > 0)
										     @foreach($jobs as $job)
										     	<option value="{{ $job->id }}">{{ $job->title }}</option>
										     @endforeach
										     @else
										     	<option value="0">{{ t('No jobs.') }}</option>
										     @endif
										   </select>
										  <button type="button" class="btn btn-default" style="border-radius:0">Mark As Favorite</button>
										  @if (Auth::check() && Auth::user()->user_type_id == 1)
										  <a href="{{ url('/storage/'.$user->resume) }}" type="button" class="btn btn-default" style="border-radius:0" download>Download Resume</a>
										  @else
										  <a href="javascript:void();" type="button" class="btn btn-default" style="border-radius:0">Download Resume</a>
										  @endif
									</div>
								</div>
							</div>
							<?php $i++;?>
							@endforeach
							@else
								<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title"><a href="" data-toggle="collapse" data-parent="#accordion">{{ t('Candidate Search Results') }} <?php echo '('.$count.')' ?> </a></h4>
								</div>
								<div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'show' : '' }}" id="userPanel">
									<div class="card-body">
										<p>{{ t('No result. Refine your search using other criteria.') }}</p>

									</div>
								</div>
							</div>
							@endif

						</div>
						<!--/.spinner End-->
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
	<!-- Added by Vimal -->
	<script src="{{ url('assets/js/fselectjs.js') }}" type="text/javascript"></script>
	<!-- Added by Vimal -->
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js'))
		<script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js') }}" type="text/javascript"></script>
	@endif
	<!-- Added by Vimal -->
	<script>

		jQuery('.education').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
	    });
	    jQuery('.skill').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
	    });
	    jQuery('.experience').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
	    });
	    jQuery('.location').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
	    });

	    jQuery('.education, .skill, .experience, .location').change(function(){
	    	var education = jQuery('.education').val();
	    	var skill = jQuery('.skill').val();
	    	var experience = jQuery('.experience').val();
	    	var location = jQuery('.location').val();

	    	searchFilter(education, skill, experience, location);
	    });

	    function searchFilter(education, skill, experience, location){
	    	
				data = {
					'_token': '<?php echo csrf_token(); ?>',
					'education': education,
					'skill': skill,
					'experience': experience,
					'location': location,
				},
				jQuery.ajax({
	               type:'POST',
	               url:'/search-filter',
	               data: data,
	               beforeSend: function() {
				        // setting a timeout
				        $('.spinner').css('text-align', 'center');
				        $('.spinner').html('<i class="fa fa-spinner"></i>');
			        },
	               success:function(data) {
	                  console.log(data);
	                  jQuery('.search-filter').html(data);
	               }
	            });
		}
	</script>
	<!-- Added by Vimal -->
@endsection
