<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('crud');
		$this -> load -> library('email');
		$this -> load -> library('form_validation');
		$this -> form_validation -> CI = &$this;
		#important
		$this -> api_errors = $this -> config -> item("api_errors");
		$this -> load -> library('bcrypt');
	}

	function index() {

	}

	function appNeedsUpdate() {

		if ($this -> input -> post("TheKey", true) === false) {
			send_error(500, $this -> api_errors["no_auth"]);
		}
		$theKey = '' . $_POST['TheKey'];
		$secret = sha1(MSECRET);

		if ($secret == $theKey) {
			$update = $this -> crud -> retrieve('app_versions', '*', FALSE, '_ARRAY');
			$this -> output -> set_content_type('application/json');
			$this -> output -> set_output(json_encode($update));
		} else {

			send_error(500, $this -> api_errors["no_auth"]);
		}

	}

	function allCountries() {
		$countriesArray = $this -> crud -> retrieve('base_country', '*', FALSE, '_ARRAY');
		$this -> output -> set_content_type('application/json');
  	 	header("Content-Disposition: attachment; filename=savethis.json");

		$this -> output -> set_output(json_encode($countriesArray));
	}

}
