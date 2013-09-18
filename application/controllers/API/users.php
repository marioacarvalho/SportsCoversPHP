<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Users extends CI_Controller {
			
			function __construct()
    {
        parent::__construct();
        $this->load->model('crud');
        $this->load->library('email');
		$this->load->library('form_validation');
        $this->form_validation->CI =& $this; #important
		$this->api_errors = $this->config->item("api_errors");
        $this->load->library('bcrypt');
    }
	
	public function index()
	{
		
	}
	
	public function registerWithEmail()
	{
	/*
		$_POST['Email'] = 'marioacarvalho@gmail.com';
		$_POST['Password'] = 'pimenta89';
	
	*/
		
		$this-> _ValidateCreateUserEmail();	
		$email = $_POST['Email'];
		$password = $_POST['Password'];
		//$pass = $this->encrypt->encode($password);	
		
		$data = array( "password" => $this->bcrypt->hash_password($password), 
                       "email" => $email,
                       "register_date" => date("Y-m-d H:i:s"));
		
		$created =  $this->crud->create("accounts", $data);
		if($created === FALSE) {
                send_error(500,$this->api_errors["unknown_error"]);
            }
        $userid = $this->crud->insert_id();
        $data['id'] = $userid;
		//$this->SendRegistrationEmail($userid);
		$this->output->set_header($this->config->item('json_header'));
        $this->output->set_output(json_encode($data)); 
	}
	
	public function logInUser()
	{
	/*
		$_POST['Email'] = 'marioascarvalho@gmail.com';
		$_POST['Password'] = 'pimenta89';
	*/	
		if($this->input->post("Email", true) === false || $this->input->post("Password", true) === false)
        {
        	send_error(500,$this->api_errors["login_error_empty"]); 
            die;
        }
		
		$user = $this->crud->retrieve("accounts",
									  "*", 
									  array("email" => $this->input->post("Email", true)), 
									  CRUD::RESULT_ROW );
		if (!empty($user)) {
			if ($this->bcrypt->check_password($_POST['Password'], $user['password'])) {
				$this->output->set_header($this->config->item('json_header'));
        		$this->output->set_output(json_encode($user));
				return; 
			} else {
				send_error(500,$this->api_errors["login_error_password"]);
				return; 
			}
		} else {
				send_error(500,$this->api_errors["login_error_email"]); 
				return;
		}
	}
	
	private function _ValidateCreateUserEmail(){
        $this->form_validation->set_message('is_unique', 'This email already exists.');
        $config = array(
            array(
                 'field'   => 'Email', 
                 'label'   => 'Email', 
                 'rules'   => 'xss_clean|required|valid_email|max_length[100]|is_unique[accounts.Email]'
            ),
            array(
                 'field'   => 'Password', 
                 'label'   => 'Password', 
                 'rules'   => 'strip_tags|xss_clean|required|min_length[6]|max_length[20]'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === FALSE){
            $error = $this->api_errors["create_error"];
            $error["Validation"] = $this->form_validation->get_errors();
            send_error(400, $error);
        }    
    }
    
    /**
     * Send an email for a new user confirm is registration
     */
    
    public function SendRegistrationEmail($user_index)
    {
        $this->load->library("mailing");

        $user = $this->crud->retrieve("accounts", "*", array("id" => $user_index));
        $email_data = array("to" => $user["email"],
                            "subject" => "Welcome to SportsCovers",
                            "user" => $user["id"]);
        
        $email_result = $this->mailing->register_validation($email_data);
		
    }
		
}


	