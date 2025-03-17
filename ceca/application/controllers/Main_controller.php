<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','validate'));
		$this->load->library('email');
		$this->load->model('AdminModel');
		date_default_timezone_set("Europe/Madrid");
	}


	public function index()
	{
		    $this->load->view('error-404');//loading in custom error view

	}


	public function payment($inv_id)
	{
		$data['title'] = 'Make Payment'; 
		
		$data["invoice_details"]=$this->AdminModel->invoice_detail($inv_id);
		$this->load->view('Front/inc/header',$data);
		$this->load->view('Front/home',$data);
	}


	/******* If payment is successfully completed ********************/

	public function success($inv_id,$comp_id,$order_id,$user_id,$amount)
	{
		$data['title'] = 'success'; 

		$insertData = array(
			'inv_id' =>$inv_id , 
			'empresa_id' =>$comp_id , 
			'order_id' =>$order_id , 
			'user_id' =>$user_id , 
			'amount' =>$amount , 
			'status' =>1 , 
			'added_on' =>date("Y-m-d H:i:s") , 
		);

		// $updateData = array('borrado' =>1 , );
		
		$this->db->trans_begin();
			$res = $this->AdminModel->insertInto('ceca_gateway', $insertData);

			// $res2 =  $this->AdminModel->updateWhere("facturas", $updateData, array("id" => $inv_id));

			if ($res) {
				if ($this->db->trans_status() === false) {
					$this->db->trans_rollback();

					$this->load->view('error-404');

				} else {
					$this->db->trans_commit();

					$empresa=$this->AdminModel->selectAllFromWhere("empresa",  array('id' =>$comp_id , ));
					$user=$this->AdminModel->selectAllFromWhere("usuarios",  array('id' =>$user_id , ));

					$data['order_id']=$order_id;
					$data['amount']=$amount;
					$data['first_name']=$user[0]['nombre'];
					$data['last_name']=$user[0]['apellidos'];
					$data['email']=$user[0]['email'];
					$data['company']=$empresa[0]['nombre'];

					//print_r($user[0]['email']);

					$this->email->set_newline("\r\n");
		            //SMTP & mail configuration
		            $config = array(
		                'protocol' => PROTOCOL,
		                'smtp_crypto' => smtp_crypto,
		                'smtp_host' => SMTP_HOST,
		                'smtp_port' => SMTP_PORT,
		                'smtp_user' => SMTP_USER,
		                'smtp_pass' => SMTP_PASS,
			       		//'newline' = "\r\n",
		                'mailtype' => MAILTYPE,
		            );
		            $this->email->set_newline("\r\n");
		            $this->email->initialize($config);

		            $this->email->from(FROM_MAIL);
		            $this->email->to(ADMIN_MAIL);
		            $this->email->subject('Payment Notification: ORDER ID - '.$order_id.' ');
		            //  call confirmation Template
		            $message = $this->load->view('Front/inc/send-email' ,$data,true);
		            $this->email->message($message);            
		            $status = $this->email->send(); 

		   //          if(!empty($status)){
					// echo json_encode(array('status' => 1,'msg' => 'Mail sent successfully' ));
					// } else{

					// 	echo json_encode(array('status' => 0,'msg' => 'Mail error ' ));
					// 	 echo $this->email->print_debugger();

					// }	

					 redirect('/trasaction-success', 'refresh');


					
				}
				
			} else {
				 $this->load->view('error-404');
		}


		
	}

	/******* If payment is Failed , inserd record only ********************/

	public function failed($inv_id,$comp_id,$order_id,$user_id,$amount)
	{
		$insertData = array(
			'inv_id' =>$inv_id , 
			'empresa_id' =>$comp_id , 
			'order_id' =>$order_id , 
			'user_id' =>$user_id , 
			'amount' =>$amount , 
			'status' =>0, 
			'added_on' =>date("Y-m-d H:i:s") , 
		);
		
		$this->db->trans_begin();
			$res = $this->AdminModel->insertInto('ceca_gateway', $insertData);
			if ($res) {
				if ($this->db->trans_status() === false) {
					$this->db->trans_rollback();

					$this->load->view('error-404');

				} else {
					$this->db->trans_commit();
					redirect('/trasaction-failed/', 'refresh');
				}
				
			} else {
				$this->load->view('error-404');
		}


		
	}


	/*************** Success message page **************/
	public function trasaction_success()
	{
		$data['title']="Transaction Success";
		$this->load->view('Front/inc/header',$data);
		$this->load->view('Front/okay',$data);
	}

	/*************** falied message page **************/
	public function trasaction_failed()
	{
		$data['title']="Transaction Failed";
		$this->load->view('Front/inc/header',$data);
		$this->load->view('Front/nokay',$data);
	}




	

	public function generate_hash()
	{	
		$encryptin="1WPALZKM";
		$MerchantID=$_POST["MerchantID"];
	  	$AcquirerBIN=$_POST["AcquirerBIN"];
	  	$TerminalID=$_POST["TerminalID"];
	  	$order_id=$_POST["order_id"];
	  	$amount=$_POST["amount"];
	  	$currency_type=$_POST["currency_type"];
	  	$Exponent=$_POST["Exponent"];
	  	$Cifrado=$_POST["Cifrado"];
	  	$URL_OK=$_POST["URL_OK"];
	  	$URL_NOK=$_POST["URL_NOK"];

		$password = $encryptin.$MerchantID.$AcquirerBIN.$TerminalID.$order_id.$amount.$currency_type.$Exponent.$Cifrado.$URL_OK.$URL_NOK;

		$hash= hash('sha256', $password);

		echo json_encode(array('hash' =>$hash , ));
	}



}
