@extends('layouts.master')
@section('content')
@include('common.spacer')

	<div class="main-container">
		<div class="container">
			<div class="row">
				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-md-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('My Education') }} </h2>
						<div class="mb30">
							<a href="{{ lurl('account/education/create') }}" class="btn btn-default"><i class="icon-plus"></i> {{ t('Create a new education') }}</a>
						</div>
						<br>
						
						<div class="table-responsive">
							<form name="listForm" method="POST" action="{{ lurl('account/education/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										{{ t('Select') }}: {{ t('All') }} |
										<button type="submit" class="btn btn-sm btn-default delete-action">
											<i class="fa fa-trash"></i> {{ t('Delete') }}
                                        </button>
									</label>
									<div class="table-search pull-right col-sm-7">
										<div class="form-group">
											<div class="row">
												<label class="col-sm-5 control-label text-right">{{ t('Search') }} <br>
													<a title="clear filter" class="clear-filter" href="#clear">[{{ t('clear') }}]</a>
												</label>
												<div class="col-sm-7 searchpan">
													<input type="text" class="form-control" id="filter">
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter" data-filter-text-only="true">
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th> {{ t('Qualification') }}</th>
										<th> {{ t('Course') }}</th>
										<th data-sort-ignore="true"> {{ t('University') }} </th>
										<th data-type="numeric">{{ t('Passing Year') }}</th>
										<th> {{ t('Option') }}</th>
									</tr>
									</thead>
									<tbody>

									<?php
                                    if (isset($education) && $education->count() > 0):
									foreach($education as $key => $edu):
									?>
									<tr>
										<td style="width:2%" class="add-img-selector">
											<div class="checkbox">
												<label><input type="checkbox" name="entries[]" value="{{ $edu->id }}"></label>
											</div>
										</td>
										
										    	<td style="width:16%" class="price-td">
										{{$edu->qualification}}
										</td>
									
										    <td style="width:14%" class="price-td">{{$edu->degree}}</td>
        									<td style="width:16%" class="price-td">
        										{{$edu->university}}
        										</td>
									
										<td style="width:16%" class="price-td">
										{{$edu->passing_year}}
										</td>
										<td style="width:10%" class="action-td">
											<div>
												@if ($edu->user_id==$user->id)
													<p>
                                                        <a class="btn btn-primary btn-sm" href="{{ lurl('account/education/' . $edu->id . '/edit') }}">
                                                            <i class="fa fa-edit"></i> {{ t('Edit') }}
                                                        </a>
                                                    </p>
													<p>
														<a class="btn btn-danger btn-sm delete-action" href="{{ lurl('account/education/' . $edu->id . '/delete') }}">
															<i class="fa fa-trash"></i> {{ t('Delete') }}
														</a>
													</p>
												@endif
											</div>
										</td>
									</tr>
									<?php endforeach; ?>
                                    <?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
							
                        <div class="pagination-bar text-center">
                            {{ (isset($education)) ? $education->links() : '' }}
                        </div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

			$('#checkAll').click(function () {
				checkAll(this);
			});
			
			$('a.delete-action, button.delete-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
				
				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}
					
				}
				
				return false;
			});
		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
