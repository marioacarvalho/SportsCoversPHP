<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Notifications extends CI_Controller {
			
	function __construct()
    {
        parent::__construct();
        $this->load->model('crud');
		$this->load->model('notificationmodel');
		$this->api_errors = $this->config->item("api_errors");
        $this->load->library('bcrypt');
    }
    
    public function test_notif(){
        $token = "23954de83dabe5f5911b71e6dcdce45f785203af54836274b06bd1d52db0f9de";
        $result = $this->notificationmodel->send_ios($token, 'Test Message', array('custom_var' => 'val'));
        $token2 = "ce0208f1d03b9ade9334a841f719398194d33ea68bc899ef0bea4543d6be3c2b";
        $result = $this->notificationmodel->send_ios($token2, 'See the last sports covers!', array('custom_var' => 'val'));
    }
}