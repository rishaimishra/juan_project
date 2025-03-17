<script type="text/javascript">

	//******************** */delete State *********************************************
	function deleteCeca(ele) {
		var key = $(ele).attr('data-key');
		if (confirm('Do you want to delete?')) {
			var formData = new FormData();
			formData.append('key', key);
			var url = "<?php echo base_url('admin/Dashboard/deleteCeca'); ?>";
			AjaxPost(formData, url, deleteSuccess, AjaxError);
		}
	}

	function deleteSuccess(content) {
		//console.log(content);

		var result = JSON.parse(content);
		if (result.success) {
			showAlert(result.success);
			setTimeout(() => {
				window.location = "<?php echo base_url('admin/Dashboard/transactions'); ?>";
			}, 1000);
		} else {
			showAlert(result.error, 'error');
		}
	}

</script>