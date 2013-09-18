<?php
/**
* Email Module
* 
* @author EAE
* @link
*/

class Mailing
{
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('email');

	}	

	public function register_validation($data = array(), $deactivated = FALSE)
	{

		$this->CI->email->from(EMAIL_NO_REPLY, EMAIL_NO_REPLY_NAME);
		$this->CI->email->to($data['to']); 
		$this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to("",""); 

		$email_message = $this->CI->load->view('emails/email_register_welcome', 
                                array('user' => $data["user"]),
			                    TRUE);
		$this->CI->email->message($email_message);

		$email_send_result = $this->CI->email->send();
        
		$this->CI->email->clear();


		return $email_send_result;

	}
        
    public function mail_outsider($data = array())
	{	
		$this->CI->email->from($data['from'], $data['from_name']);
		$this->CI->email->to($data['to']); 
		$this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to($data['from'], $data['from_name']);

		$email_message = $this->CI->load->view('website/emails/email_send_outsider', 
                                array('data'=>$data,),
			                    TRUE);
		$this->CI->email->message($email_message);

		$email_send_result = $this->CI->email->send();
        
		$this->CI->email->clear();


		return $email_send_result;
	}
        
    public function mail_invitation($data = array())
	{

		$this->CI->email->from($data['from'], $data['from_name']);
		$this->CI->email->to($data['to']); 
		$this->CI->email->subject($data['subject']);
                $this->CI->email->reply_to($data['from'], $data['from_name']);

		$email_message = $this->CI->load->view('website/emails/email_invitation', 
                                array('data'=>$data,),
			                    TRUE);
		$this->CI->email->message($email_message);

		$email_send_result = $this->CI->email->send();
        
		$this->CI->email->clear();


		return $email_send_result;

	}
        
    public function send_thanks_email($data = array())
	{

		$this->CI->email->from($data['from'], $data['from_name']);
		$this->CI->email->to($data['to']); 
		$this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to($data['from'], $data['from_name']);

		$email_message = $this->CI->load->view('website/emails/send_thanks_email', 
                                array('data'=>$data,),
			                    TRUE);
		$this->CI->email->message($email_message);

		$email_send_result = $this->CI->email->send();
        
		$this->CI->email->clear();


		return $email_send_result;
	}
    
    public function recover_password($data = array())
    {
        $this->CI->email->from(EMAIL_NO_REPLY, EMAIL_NO_REPLY_NAME);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to("",""); 
        
        $email_message = $this->CI->load->view('website/emails/email_recover', 
                                                array( 'data' => $data,
                                                'recover_code'=>$data['recover_code'],
                                                'subject' => $data['subject']),
                                                TRUE);
        $this->CI->email->message($email_message);
        $email_send_result = $this->CI->email->send();
        $this->CI->email->clear();
        
        return $email_send_result;
    }
    
    public function send_commit_email($data = array()){
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
                $this->CI->email->reply_to($data['from'], $data['from_name']);
        
        $email_message = $this->CI->load->view('website/emails/send_commit_email', 
                                               array('data'=>$data,),
                                               TRUE);
        $this->CI->email->message($email_message);        
        $email_send_result = $this->CI->email->send();        
        $this->CI->email->clear();        
                
        return $email_send_result; 
    }
    
    public function send_email($data = array(), $reply = TRUE){
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
        if($reply){
            $this->CI->email->reply_to($data['from'], $data['from_name']);
        }
        $email_message = $this->CI->load->view('website/emails/send_email', 
                                       array('data'=>$data,),
                                       TRUE);
        
        $this->CI->email->message($email_message);        
        $email_send_result = $this->CI->email->send();        
        $this->CI->email->clear();        
                
        return $email_send_result; 
    }
    
    public function send_register_emails($data = array()){
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
        $email_message = $this->CI->load->view('website/emails/send_register_emails', 
                                       array('data'=>$data,),
                                       TRUE);
        
        $this->CI->email->message($email_message);        
        $email_send_result = $this->CI->email->send();        
        $this->CI->email->clear();        
                
        return $email_send_result; 
    }
    
    public function send_thanks_of_rewish_email($data = array())
    {
        
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to($data['from'], $data['from_name']);
        
        $email_message = $this->CI->load->view('website/emails/send_thanks_of_rewish_email', 
                                               array('data'=>$data,),
                                               TRUE);
        $this->CI->email->message($email_message);        
        $email_send_result = $this->CI->email->send();        
        $this->CI->email->clear();
        
        return $email_send_result;
    }
    
    public function send_wish_deleted_email($data = array())
    {
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->bcc($data['bcc']); 
        $this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to($data['from'], $data['from_name']);
        
        $email_message = $this->CI->load->view('website/emails/send_wish_deleted_email', 
                                               array('data'=>$data,),
                                               TRUE);
        $this->CI->email->message($email_message);
        
        $email_send_result = $this->CI->email->send();
        
        $this->CI->email->clear();
        
                
        return $email_send_result;
    }
    
    public function send_reply($data = array()){
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->to($data['to']); 
        $this->CI->email->subject($data['subject']);
        $email_message = $this->CI->load->view('website/emails/email_reply', 
                                               array('data'=>$data,),
                                               TRUE);
        
        $this->CI->email->message($email_message);        
        $email_send_result = $this->CI->email->send();        
        $this->CI->email->clear();        
                
        return $email_send_result; 
    }
    
    public function send_reported($data = array())
    {
        $this->CI->email->from($data['from'], $data['from_name']);
        $this->CI->email->bcc($data['bcc']); 
        $this->CI->email->subject($data['subject']);
        $this->CI->email->reply_to("",""); 
        
        $email_message = $this->CI->load->view('website/emails/send_reported', 
                                               array('data'=>$data,),
                                               TRUE);
        $this->CI->email->message($email_message);
        
        $email_send_result = $this->CI->email->send();
        
        $this->CI->email->clear();
        
                
        return $email_send_result;
    }
    
    

}

/* End of file email.php */
/* Location: ./system/application/modules/geographic/controllers/email.php  */