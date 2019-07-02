<?php
// From Company's Form
$classLeftCol = 'col-md-3';
$classRightCol = 'col-md-9';

if (isset($originForm)) {
	// From User's Form
	if ($originForm == 'user') {
		$classLeftCol = 'col-md-3';
		$classRightCol = 'col-md-7';
	}
	
	// From Post's Form
	if ($originForm == 'post') {
		$classLeftCol = 'col-md-3';
		$classRightCol = 'col-md-8';
	}
}

?>
<div id="experienceFields">
	<!-- name -->
	<?php $employerError = (isset($errors) and $errors->has('experience.employer')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="experience.employer">{{ t('employer') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
		    
		    
			<input name="employer"
				   placeholder="{{ t('Employer') }}"
				   class="form-control input-md{{ $employerError }}"
				   type="text"
				   value="{{ old('experience.employer', (isset($experience->employer) ? $experience->employer : '')) }}">
		</div>
	</div>
	
		<?php $designationError = (isset($errors) and $errors->has('experience.designation')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="experience.designation">{{ t('designation') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
			<input name="designation"
				   placeholder="{{ t('Designation') }}"
				   class="form-control input-md{{ $designationError }}"
				   type="text"
				   value="{{ old('experience.designation', (isset($experience->designation) ? $experience->designation : '')) }}">
		</div>
	</div>
	
		<?php $startError = (isset($errors) and $errors->has('experience.start')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="experience.start">{{ t('Start') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
			<input name="start"
				   placeholder="{{ t('Start') }}"
				   class="form-control input-md{{ $startError }}"
				   type="text"
				   value="{{ old('experience.start', (isset($experience->start) ? $experience->start : '')) }}">
		</div>
	</div>
	
	
		<?php $endError = (isset($errors) and $errors->has('experience.end')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="experience.end">{{ t('End') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
			<input name="end"
				   placeholder="{{ t('End') }}"
				   class="form-control input-md{{ $endError }}"
				   type="text"
				   value="{{ old('experience.end', (isset($experience->end) ? $experience->end : '')) }}">
		</div>
	</div>
	
		<?php $currentError = (isset($errors) and $errors->has('experience.current')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="experience.current">{{ t('Current') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
		    <input type="checkbox" name="is_current" class="custom-control-input input-md{{ $currentError }}" value="0" {{ (!old('experience.is_current') or old('experience.is_current')==1) ? 'checked="checked"' : '' }} id="currentCompany">
		    <label class="custom-control-label" for="currentCompany"><small id="current" class="form-text text-muted">Current</small></label>
			
		</div>
	</div>
	
		
		
	
</div>

@section('after_styles')
	@parent
	<style>
		#companyFields .select2-container {
			width: 100% !important;
		}
		.file-loading:before {
			content: " {{ t('Loading') }}...";
		}
	</style>
@endsection

@section('after_scripts')
	@parent
	<script>
		/* Initialize with defaults (logo) */
		$('#logo').fileinput(
		{
			theme: "fa",
			language: '{{ config('app.locale') }}',
			@if (config('lang.direction') == 'rtl')
				rtl: true,
			@endif
			showPreview: true,
			allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
			showUpload: false,
			showRemove: false,
			maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
			@if (isset($company) and !empty($company->logo) and \Storage::exists($company->logo))
			initialPreview: [
				'{{ resize($company->logo, 'medium') }}'
			],
			initialPreviewAsData: true,
			initialPreviewFileType: 'image',
			/* Initial preview configuration */
			initialPreviewConfig: [
				{
					width: '120px'
				}
			],
			initialPreviewShowDelete: false
			@endif
		});
	</script>
	@if (isset($company) and !empty($company))
	<script>
		/* Translation */
		var lang = {
			'select': {
				'country': "{{ t('Select a country') }}",
				'admin': "{{ t('Select a location') }}",
				'city': "{{ t('Select a city') }}"
			}
		};

		/* Locations */
		var countryCode = '{{ old('company.country_code', (isset($company) ? $company->country_code : 0)) }}';
		var adminType = 0;
		var selectedAdminCode = 0;
		var cityId = '{{ old('company.city_id', (isset($company) ? $company->city_id : 0)) }}';
	</script>
	<script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
	@endif
@endsection