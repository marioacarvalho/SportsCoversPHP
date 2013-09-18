<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Email Configuration settings.
*/

// mail sending protocol (mail, sendmail, smtp)
//$config['protocol'] = "smtp";

$config['mailpath'] = "/usr/sbin/sendmail";
$config['priority'] = 1;

// html or text
$config['mailtype'] = "html";



$config['charset'] = "UTF-8";
$config['wordwrap'] = FALSE;
$config['wrapchars'] = 80;
// new_line chars
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";



/* SMTP Settings */
$config['protocol'] = "smtp";     
$config['smtp_host'] = "ssl://smtp.gmail.com";
$config['smtp_user'] = "mail@sportscovers.co";
$config['smtp_pass'] = "pimenta89_";
$config['smtp_port'] = 465;
$config['smtp_timeout'] = 30;



// validate email adress (TRUE or FALSE)
//$config['validate'] = FALSE;
//$config['bcc_batch_mode'] = FALSE;
//$config['bcc_batch_size'] = 200;