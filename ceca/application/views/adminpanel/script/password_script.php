<script type="text/javascript">
	$(function() {

		$("#form1").submit(function(e) {
			e.preventDefault();

			var from_date = $("[name= password]");
			var error = "";

			if ($.trim(from_date.val()) == "") {
				error = "Please type password";
				from_date.focus();
			}


			var from_date2 = $("[name= cpassword]");
			var error = "";
			if ($.trim(from_date2.val()) == "") {
				error = "Please type confirm password";
				from_date2.focus();
			}


			if(from_date == from_date2){
				error = "Password Mismatched";
				$("#msg").html("<p style='color:red;fonr-size:14px;'>Password Mismatched.</p>");
			}

			if (error != "") {
				showAlert(error, 'error');
				return;
			}

			var formData = new FormData(this);
			var url = "<?php echo base_url('admin/Dashboard/update_password'); ?>";


			var btnSubmit = $('#btnSubmit');
			btnSubmit.html('Please Wait...');
	 		btnSubmit.attr('disabled', true);

			AjaxPost(formData, url, SaveSuccess, AjaxError);

		});

		function SaveSuccess(content) {
			console.log(content);

			var result = JSON.parse(content);

			if (result.success) {
				showAlert(result.success);
				$("#msg").html("<p style='color:green;fonr-size:14px;'>Your password has been updated.</p>");
				var btnSubmit = $('#btnSubmit');
				btnSubmit.html('Save');
				btnSubmit.attr('disabled', false);
				setTimeout(() => {
					window.location = "<?php echo base_url('admin/Dashboard/logout'); ?>";
				}, 2000);

			} else {
				showAlert(result.error, 'error');
				var btnSubmit = $('#btnSubmit');
				btnSubmit.html('Save');
				btnSubmit.attr('disabled', false);
			}
		}	

});


</script>