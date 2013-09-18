<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Newspapers Database Indexes
|--------------------------------------------------------------------------
|
| 
|
*/

define('MSECRET',						'10U@R3fUK1nG1D30T@SSH0L3');
define('ABOLA',							1);
define('RECORD',						2);
define('OJOGO',							3); 
define('MARCA',							4);
define('ASJ',							5); 
define('PRZEGLAD_SPORTOW',				6);
define('DAILY_STAR',					7); 
define('LE_EQUIPE',						8); 
define('LANCE_DIGITAL_RJ',				9); 
define('LANCE_DIGITAL_SP',				10); 
define('LA_GAZZETTA_DELLO_SPORT',		11); 
define('OLE_ARGENTINA',					12); 


define('EMAIL_NO_REPLY','mail@sportscovers.co');
define('EMAIL_NO_REPLY_NAME','SportsCover.co'); 
define('MODERATOR_EMAILS','mariocarvalho_@hotmail.pt');


/* End of file constants.php */
/* Location: ./application/config/constants.php */