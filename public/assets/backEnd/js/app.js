// starting the ajax request start
$(document).ajaxStart(function(event, jqxhr, ajaxOptions, errorThrown){
	$('.loading').show();
});
// end of ajax start
// starting the ajax request stop
$(document).ajaxStop(function(event, jqxhr, ajaxOptions, errorThrown){
	$('.loading').hide();
});
// end of ajax stop
// global ajax success function
$(document).ajaxSuccess(function(event, jqxhr, ajaxOptions, errorThrown){
	var contentType   = jqxhr.getResponseHeader("Content-Type");
	var responseBody  = jqxhr.responseText;
	$('.bb-alert').removeClass('alert-danger').addClass('alert-info');
});
// end of of ajax success function
// global ajax error function
$(document).ajaxError(function(event, jqxhr, ajaxOptions, errorThrown) {
	var contentType   = jqxhr.getResponseHeader("Content-Type");
	var responseBody  = jqxhr.responseText;
	if(jqxhr.status == 404) {
		$('.bb-alert').removeClass('alert-info').addClass('alert-danger').find('span').html("oppss! not found");
		$('.bb-alert').show().delay(3000).fadeOut();
	}
	else if(jqxhr.status == 500) {
		$('.bb-alert').removeClass('alert-info').addClass('alert-danger').find('span').html("Internal Error occured.");
		$('.bb-alert').show().delay(3000).fadeOut();
	}
	else if(jqxhr.status == 403) {
		$('.bb-alert').removeClass('alert-info').addClass('alert-danger').find('span').html("You are not authorized.");
		$('.bb-alert').show().delay(3000).fadeOut();
	}
	else if(jqxhr.status == 405) {
		$('.bb-alert').removeClass('alert-info').addClass('alert-danger').find('span').html("opss!Method not allowed");
		$('.bb-alert').show().delay(3000).fadeOut();
	}
});
// end of global ajax error function

// starting the module pattern of appManager
(function($){
	var appManager = {
		// init function
		init: function(){
			var form,url,method,data,message,formData,clickedElement;
			$('.add_news').on('submit', '.addNewsForm form[data-remote]', this.addNews);
			$('.edit_news').on('submit', '.editNewsForm form[data-remote]', this.saveEditedNews);
			$('.news_list').on('click', '.news_table .delete_news', this.deleteNews);

			// analysis section
			$('.add_analysis').on('submit', '.addAnalysisForm form[data-remote]', this.addAnalysis);
			$('.edit_analysis').on('submit', '.editAnalysisForm form[data-remote]', this.saveEditedAnalysis);
			$('.analysis_list').on('click', '.analysis_table .delete_analysis', this.deleteAnalysis);
		},
		// end of init function

		// adding news
		addNews : function(event){
			event.preventDefault();
			form = $(this);
			formData = appManager.getFormCredentials(form);

			// sending ajax request
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(message);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},
		// end of adding news

		// adding news
		saveEditedNews : function(event){
			event.preventDefault();
			form = $(this);
			formData = appManager.getFormCredentials(form);

			// sending ajax request
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(message);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},
		// end of adding news

		// delete news
		deleteNews : function(event){
			event.preventDefault();
			clickedElement = $(this);
			clickedElementId = clickedElement.data('id');
			// alert(clickedElementId);
			// sending ajax request
			$.ajax({
				method : "POST",
				url : "/admin/delete-news",
				data : {news_id : clickedElementId},
				headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
			})
			.success(function(msg){
				clickedElement.closest('tr').remove();
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(msg);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},

		// adding Analysis
		addAnalysis : function(event){
			event.preventDefault();
			form = $(this);
			formData = appManager.getFormCredentials(form);

			// sending ajax request
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(message);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},
		// end of adding analysis

		// adding analysis
		saveEditedAnalysis : function(event){
			event.preventDefault();
			form = $(this);
			formData = appManager.getFormCredentials(form);

			// sending ajax request
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(message);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},
		// end of adding analysis

		// delete analysis
		deleteAnalysis : function(event){
			event.preventDefault();
			clickedElement = $(this);
			clickedElementId = clickedElement.data('id');
			// alert(clickedElementId);
			// sending ajax request
			$.ajax({
				method : "POST",
				url : "/admin/delete-analysis",
				data : {analysis_id : clickedElementId},
				headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
			})
			.success(function(msg){
				clickedElement.closest('tr').remove();
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(msg);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.fail(function(){

			});
		},

		// global getFormCredentials
		getFormCredentials: function(processedForm){
			url = processedForm.prop('action');

			method = processedForm.find('input[name="_method"]').val() || 'POST';

			data = processedForm.serialize();

			return {'form':processedForm,'method':method,'url':url,'data':data};
		},
		// end of global getFormCredentials

	};
	// calling the init function
	$(function(){
		appManager.init();
	});
})(jQuery);
// end of the module pattern of appManager


// starting of authManager
(function($){

	var authManager = {

		init : function(){
			var form,url,method,data,message,formData,errors,clickedElement;
			// member login
			// $('.member_login').on('submit','.loginForm form[data-remote]',this.memberLogin);
			// sending email
			$('.password_reset_email').on('submit','.sendEmailForm form[data-remote]',this.sendPasswordResetEmail);
			// resetting new password
			$('.member_password_reset').on('submit','.passwordResetForm form[data-remote]',this.setNewPassword);
		},

		// logging of a client
		memberLogin: function(event){
			event.preventDefault();
			form = $(this);
			formData = authManager.getFormCredentials(form);
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				if (msg == 1) {
					$('.flash_message').removeClass('alert-danger').addClass('alert-success');
					$('.flash_message').find('strong').html(message);
					$('.flash_message').show().on('click', function(){
						$(this).fadeOut(1000);
					});	
					document.location.href = "/member/dashboard"; 
				} else {
					$('.flash_message').removeClass('alert-danger').addClass('alert-success');
					$('.flash_message').find('strong').html('Credentials don\'t match.');
					$('.flash_message').show().on('click', function(){
						$(this).fadeOut(1000);
					});			
				}  
			})
			.error(function(jqXHR){
				errors = jqXHR.responseJSON;
				if(jqXHR.status == 422){
					if(errors.email){
						$(".req_email").html(errors.email).parent("div").addClass('has-error');
					}
					if(errors.password){
						$(".req_password").html(errors.password).parent("div").addClass('has-error');
					}
				}
			});
		},

		// sending password reset email
		sendPasswordResetEmail: function(event){
			event.preventDefault();
			// alert('sakil');
			form = $(this);
			formData = authManager.getFormCredentials(form);
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				message = form.data('remote-success');
				// showing the successful div with message
				$('.flash_message').removeClass('alert-danger').addClass('alert-success');
				$('.flash_message').find('strong').html(message);
				$('.flash_message').show().on('click', function(){
					$(this).fadeOut(1000);
				});	
			})
			.error(function(jqXHR){
				errors = jqXHR.responseJSON;
				if(jqXHR.status == 422){
					if(errors.email){
						$(".req_email").html(errors.email).parent("div").addClass('has-error');
					}
				}

			});
		},

		// setting new password
		setNewPassword: function(event){
			event.preventDefault();
			form = $(this);
			formData = authManager.getFormCredentials(form);
			$.ajax({
				method : formData.method,
				url : formData.url,
				data : formData.data,
			})
			.success(function(msg){
				
				if (!msg) {
					message = form.data('remote-success');
					$('.flash_message').removeClass('alert-danger').addClass('alert-success');
					$('.flash_message').find('strong').html(message);
					$('.flash_message').show().on('click', function(){
						$(this).fadeOut(1000);
					});	
					document.location.href = "/member/login";
				}
				else
				{
					$('.flash_message').removeClass('alert-success').addClass('alert-danger');
					$('.flash_message').find('strong').html("Sorry the email is not known to ROIFX.");
					$('.flash_message').show().on('click', function(){
						$(this).fadeOut(1000);
					});	
				}
			})
			.error(function(jqXHR){
				errors = jqXHR.responseJSON;
				if(jqXHR.status == 422){
					if(errors.email){
						$(".req_email").html(errors.email).parent("div").addClass('has-error');
					}
					if(errors.password){
						$(".req_password").html(errors.password).parent("div").addClass('has-error');
					}
					if(errors.confirm_password){
						$(".req_confirm_password").html(errors.confirm_password).parent("div").addClass('has-error');
					}
				}
			});
		},

		// global getFormCredentials
		getFormCredentials: function(processedForm){
			url = processedForm.prop('action');

			method = processedForm.find('input[name="_method"]').val() || 'POST';

			data = processedForm.serialize();

			return {'form':processedForm,'method':method,'url':url,'data':data};
		},
		// end of global getFormCredentials

	};

	$(function(){
		authManager.init();
	});
})(jQuery);