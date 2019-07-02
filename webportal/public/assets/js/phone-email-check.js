/** Added by Vimal (Check phone number already exist or not.) */
		function checkPhoneExist(val){
				data = {
					'_token': '<?php echo csrf_token(); ?>',
					'phone': val,
				},
				$.ajax({
	               type:'POST',
	               url:'/check-phone-exist',
	               async:false,
    			   dataType: "json",
	               data: data,
	               success:function(data) {
	                  console.log(data.error_mess);
	                  $( "input[name='phone']" ).addClass('is-invalid');
	                  var dialog = bootbox.dialog({
						    message: '<p class="text-center mb-0">' + data.error_mess + '</p>',
						    closeButton: true
						});
	                  $('.modal-content').css('background-color', '#f8d7da');
						            
						// Hide alert
						dialog.modal('hide');
	               }
	            });
		}

		/** Added by Vimal (Check email already exist or not.) */
		function checkEmailExist(val){
				data = {
					'_token': '<?php echo csrf_token(); ?>',
					'email': val,
				},
				$.ajax({
	               type:'POST',
	               url:'/check-email-exist',
	               async:false,
    			   dataType: "json",
	               data: data,
	               success:function(data) {
	                  console.log(data.error_mess);
	                  $( "input[name='email']" ).addClass('is-invalid');
	                  var dialog = bootbox.dialog({
						    message: '<p class="text-center mb-0">' + data.error_mess + '</p>',
						    closeButton: true
						});
	                  $('.modal-content').css('background-color', '#f8d7da');
						            
						// Hide alert
						dialog.modal('hide');
	               }
	            });
		}