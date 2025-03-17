<?php

class Dashboard extends ci_controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'validate'));
		$this->load->library('form_validation');
		    $this->load->library('session');

		$this->load->model(array('AdminModel'));
		date_default_timezone_set("Europe/Madrid"); 
		if (!isset($_SESSION['admin_data'])) {
			redirect('AdminLogin');
		}
	}

//dashboard page
	public function transactions() {
		$data['title'] = 'Transactions'; 
		$data['rows'] = $this->AdminModel->all_transactions();
		$this->load->view('adminpanel/includes/header',$data); 
		$this->load->view('adminpanel/dashboard',$data);
		$this->load->view('adminpanel/includes/footer');	
		$this->load->view('adminpanel/script/ceca_script');	
		
	}




//delete 

public function deleteCeca() {

		if (isset($_POST['key'])) {
			$cid = base64_decode($_POST['key']);
			$result =  $this->AdminModel->deleteFromTable("ceca_gateway", array("id" => $cid));
			if ($result) {
				echo json_encode(array('success' => ' deleted successfully'));
			} else {
				echo json_encode(array('error' => ' could not delete'));
			}
		} else {
			echo json_encode(array('success' => 'Insufficient details sent,Please Contact Admin.'));
		}
		exit();
	}





	//logout from admin
	public function logout()
	{
		$this->session->sess_destroy('admin_data');
		redirect("AdminLogin");
	}


}