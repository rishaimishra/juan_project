<?php


class AdminLogin extends ci_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','validate'));
		$this->load->model('AdminModel');
		date_default_timezone_set("Asia/Kolkata");
		if (isset($_SESSION['admin_data'])&&!empty($_SESSION['admin_data'])) {
			// redirect('admin/Dashboard/transactions');
		}
	}

	public function index()
	{
		$this->load->view('adminpanel/login');
	}

	public function verifyUser()
	{		
		if(isset($_POST['email']) && isset($_POST['password']))
		{
			$email =validateInput($_POST['email']);
			$pwd =validateInput($_POST['password']);
			$password=MD5($pwd);
            $result = $this->AdminModel->selectAllFromWhere("usuarios",Array("email"=>$email,"pass"=>$password,"fk_tipo_usuario" => 1 ,"activo" => 1));
			if($result)
			{
					$this->session->set_userdata("admin_data", $result[0]);

					if($result[0]['fk_tipo_usuario'] == 1 ){

						redirect("admin/Dashboard/transactions");
					} else{
						$this->load->view('error-404');
					}
					
					
			}
			else
			{
				$this->session->set_flashdata("error","Please enter valid credentials");
				redirect(__class__);
			}			
		}
		else
		{
			$this->session->set_flashdata("error","System error found, Please contact service provider");
		}		
	}
}

?>