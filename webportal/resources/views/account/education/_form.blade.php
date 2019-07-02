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
<div id="educationFields">
	<!-- name -->
	<?php $universityError = (isset($errors) and $errors->has('education.university')) ? ' is-invalid' : ''; ?>
	<div class="form-group row required">
		<label class="{{ $classLeftCol }} control-label" for="education.university">{{ t('University') }} <sup>*</sup></label>
		<div class="{{ $classRightCol }}">
			<input name="university"
				   placeholder="{{ t('University') }}"
				   class="form-control input-md{{ $universityError }}"
				   type="text"
				   value="{{ old('education.university', (isset($education->university) ? $education->university : '')) }}">
		</div>
	</div>
	
		
		
		<?php $degreeError = (isset($errors) and $errors->has('education.degree')) ? ' is-invalid' : ''; ?>
		<div class="form-group row required">
			<label class="{{ $classLeftCol }} control-label{{ $degreeError }}" for="degree">{{ t('Degree') }}</label>
			<div class="{{ $classRightCol }}">
				<select id="degree" name="degree" class="form-control sselecter{{ $degreeError }}">
					<option value="0" {{ (!old('education.degree') or old('education.degree')==0) ? 'selected="selected"' : '' }}> {{ t('Select a degree') }} </option>
					@foreach ($degree as $item)
						<option value="{{ $item->id }}"
								{{ (!old('education.degree') or old('education.degree')==$item.id) ? 'selected="selected"' : '' }}>
							{{ $item->name }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
		
		
		
		<?php $qualificationError = (isset($errors) and $errors->has('education.qualification')) ? ' is-invalid' : ''; ?>
		<div class="form-group row required">
			<label class="{{ $classLeftCol }} control-label{{ $qualificationError }}" for="qualification">{{ t('Qualification') }}</label>
			<div class="{{ $classRightCol }}">
				<select id="qualification" name="qualification" class="form-control sselecter{{ $qualificationError }}">
					<option value="0" {{ (!old('education.qualification') or old('education.qualification')==0) ? 'selected="selected"' : '' }}> {{ t('Select a Qualification') }} </option>
					@foreach ($qualification as $item)
						<option value="{{ $item->id }}"
								{{ (!old('education.qualification') or old('education.qualification')==$tem.id ) ? 'selected="selected"' : '' }}>
							{{ $item->name }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
		

		
		
		<?php $passing_yearError = (isset($errors) and $errors->has('education.passing_year')) ? ' is-invalid' : ''; ?>
		<div class="form-group row required">
			<label class="{{ $classLeftCol }} control-label{{ $passing_yearError }}" for="passing_year">{{ t('Passing Year') }}</label>
			<div class="{{ $classRightCol }}">
				<input name="passing_year" value="{{ old('education.passing_year', (isset($education->passing_year) ? $education->passing_year : '')) }}" class="form-control input-md{{ $passing_yearError }}">
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