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
<div id="skillsFields">
	<!-- name -->
	<?php $skillError = (isset($errors) and $errors->has('skills.skill')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="skills.skill">{{ t('skill') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
		    
		    
			<input name="skill"
				   placeholder="{{ t('Skill') }}"
				   class="form-control input-md{{ $skillError }}"
				   type="text"
				   value="{{ old('skills.skill', (isset($skills->skill) ? $skills->skill : '')) }}">
		</div>
	</div>
	
	<?php $proficiencyError = (isset($errors) and $errors->has('skills.proficiency')) ? ' is-invalid' : ''; ?>
		<div class="form-group row required">
			<label class="{{ $classLeftCol }} control-label{{ $proficiencyError }}" for="proficiency">{{ t('Proficiency') }}</label>
			<div class="{{ $classRightCol }}">
				<select id="proficiency" name="proficiency" class="form-control sselecter{{ $proficiencyError }}">
					<option value="0" {{ (!old('skills.proficiency') or old('skills.proficiency')==0) ? 'selected="selected"' : '' }}> {{ t('Select a proficiency') }} </option>
					@foreach ($proficiency as $item)
						<option value="{{ $item }}"
								{{ (!old('skills.proficiency') or old('skills.proficiency')==$item) ? 'selected="selected"' : '' }}>
							{{ $item }}
						</option>
					@endforeach
				</select>
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