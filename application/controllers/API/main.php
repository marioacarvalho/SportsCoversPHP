<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function updateAllLinks() {
		$this -> load -> library('simple_html_dom');
		$this -> load -> model('crud');
		$this -> _updateABola();
		$this -> _updateRecord();
		$this -> _updateOJogo();
		$this -> _updateMarca();
		$this -> _updateAS();
		$this -> _updatePrzegladSportowy();
		$this -> _updateDailyStar();
		$this -> _updateLeEquip();
		$this -> _updateLanceDigital();
		$this -> _updateLaGazzettaDelloSport();
		$this -> _updateOleArgentina();
		$localip = $_SERVER['REMOTE_ADDR'];
		$geo_data = json_decode($this -> _get_geolocation($localip));
		$this -> crud -> create('localhostUpdates', array('ip' => $localip, 'country' => $geo_data->countryName, 'timeJob' => date("Y-m-d H:i:s")));
	}

	public function getLinks() {
		$this -> load -> model('crud');
		$data = array();
		$data['links'] = $this -> _getAllData();
		$localip = $_SERVER['REMOTE_ADDR'];
		$this -> crud -> create('users', array('ip' => $localip));
		$geo_data = json_decode($this -> _get_geolocation($localip));
		$data['user_info'] = $geo_data;
	//	$countriesArray = $this -> crud -> retrieve('base_country', '*', FALSE, '_ARRAY');
	//	$data['countries_info'] = $countriesArray;
		$this->output->set_content_type('application/json');
    	$this->output->set_output(json_encode($data));
	}

	private function _get_geolocation($ip) {
		$d = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=46d2a9de7141f047fa49ba6db85c203f61f7d00d15c8ea4a2b52f0b981011eae&ip=$ip&format=json");
		//Use backup server if cannot make a connection
		return $d;
	}
	
	
	/*
	 * 
	 * 
	 * ARGENTINA
	 * 
	 */
	 
	 private function _updateOleArgentina() 
	 {
	 	
	 	$url = 'http://www.ole.com.ar';
		$html = file_get_html($url);
		$coverURL = '';
		foreach ($html->find('img' ) as $element) {
			if (strpos($element -> src, 'la-tapa') !== false) {
				$coverURL = $url.$element->src;
				$urlFinal = str_replace('_20.jpg', '_21.jpg', $coverURL);	
				$this -> crud -> update('newspapers', array('coverURL' => $urlFinal, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => OLE_ARGENTINA));
			}
		}
	}
	/*
	 * 
	 * 
	 * BRASIL
	 * 
	 * 
	 */
	 
	private function _updateLanceDigital() {
		$url = 'http://www.lancedigital.com.br/';
		$html = file_get_html($url);

		foreach ($html->find('div') as $element) {
			if (strpos($element -> id, 'container') !== false) {
				foreach ($element->find('section') as $element2) {
					if (strpos($element2 -> class, 'home') !== false) {
						foreach ($element2->find('div') as $element3) {
							if (strpos($element3 -> id, 'carousel') !== false) {
								foreach ($element3->find('div a img') as $element4) {
									$edition = $element4->alt;
									if (strpos($edition, 'Rio') !== false) {
										$this->_changeEndAndUpdateLanceDigital(LANCE_DIGITAL_RJ, $element4->src);
									}
									if (strpos($edition, 'Paulo') !== false) {
										$this->_changeEndAndUpdateLanceDigital(LANCE_DIGITAL_SP, $element4->src);
											
										
									}

								}
								
							}
						}
					}
				}
					
			}
		}
		
	}
	
	private function _changeEndAndUpdateLanceDigital($newspaperID, $url) {
		$urlFinal = str_replace('baja', 'alta', $url);	
		$this -> crud -> update('newspapers', array('coverURL' => $urlFinal, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => $newspaperID));
			
	}
	/*
	 * 
	 * 
	 * ENGLAND
	 * 
	 */
	 private function _updateDailyStar() {
		$url = 'http://images.dailystar-uk.co.uk/dynamic/pixfeed/covers/257x330back/';
		$dateToday = date("Y-m-d");
		$extension = '.jpg';
		$finalURL = ''.$url.$dateToday.$extension;
		$this -> crud -> update('newspapers', array('coverURL' => $finalURL, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => DAILY_STAR));
	}
	 
	 /*
	  * 
	  * 
	  * FRANCE
	  * 
	  */
	  private function _updateLeEquip()
	  {
	  	$url = 'http://www.lequipe.fr/Quotidien/une/une';
		$month = date('m');
		$year = date('y');
		$bigYear = date('Y');
		$day = date('d');
		$extension = '_hd.jpg';
		$urlFinal = ''.$url.$day.$month.$bigYear.$extension;
		$this -> crud -> update('newspapers', array('coverURL' => $urlFinal, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => LE_EQUIPE));
		
	  }
	/*
	*
	*
	* ITALY
	*
	*/
	private function _updateLaGazzettaDelloSport()
	{
		$url = 'http://images2.gazzettaobjects.it/primapagina/images/prima_pagina_grande.jpg?'.date('Y/m/d');
		$this -> crud -> update('newspapers', array('coverURL' => $url, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => LA_GAZZETTA_DELLO_SPORT));

	}
	/*
	 *
	 * PORTUGAL
	 *
	 *
	 */
	private function _updateABola() {
		$dow_numeric = date('w');

		$abolaURL = '';

		switch ($dow_numeric) {
			case 0 :
				$abolaURL = 'http://www.abola.pt/wdom/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 1 :
				$abolaURL = 'http://www.abola.pt/wseg/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 2 :
				$abolaURL = 'http://www.abola.pt/wter/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 3 :
				$abolaURL = 'http://www.abola.pt/wqua/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 4 :
				$abolaURL = 'http://www.abola.pt/wqui/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 5 :
				$abolaURL = 'http://www.abola.pt/wset/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			case 6 :
				$abolaURL = 'http://www.abola.pt/wsab/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
			default :
				$abolaURL = 'http://www.abola.pt/wseg/wfotosdia/wdiag.jpg?' . date('Y/m/d');
				break;
		}
		$this -> crud -> update('newspapers', array('coverURL' => $abolaURL, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => ABOLA));
	}

	private function _updateRecord() {

		$html = file_get_html('http://www.record.xl.pt/capas/default.aspx');
		// Find all images
		$record = '';

		foreach ($html->find('div') as $element) {
			if (strpos($element -> class, 'capa-grande-container') !== false) {
				foreach ($element->find('img') as $element2) {
					if (strpos($element2 -> src, 'big') !== false) {
						$record = $element2 -> src;
					}
				}

			}

		}
		$this -> crud -> update('newspapers', array('coverURL' => $record, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => RECORD));
	}

	private function _updateOJogo() {

		$ojogo = "";
		$htmlOjogo = file_get_html('http://www.ojogo.pt/jornaldodia');
		foreach ($htmlOjogo->find('a') as $element2) {
			if (strpos($element2 -> id, 'jdCapaLink') !== false) {
				foreach ($element2->find('img') as $element3) {
					if (strpos($element3 -> src, 'highlight') !== false) {
						$ojogo = 'http://cdn.controlinveste.pt' . $element3 -> src;
					}

				}
			}

		}
		$this -> crud -> update('newspapers', array('coverURL' => $ojogo, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => OJOGO));
	}

	/*
	 *
	 * SPAIN
	 *
	 *
	 */
	private function _updateMarca() {
		$month = date('m');
		$year = date('y');
		$bigYear = date('Y');
		$day = date('d');
		$separator = '/';
		$url = "http://www.marca.com/multimedia/primeras/$year$separator$month$separator$month$day.html";

		$html = file_get_html($url);
		// Find all images

		$amarca = "";
		foreach ($html->find('div') as $element) {
			if (strpos($element -> id, 'contenido-noticia') !== false) {
				foreach ($element->find('img') as $element2) {
					if (strpos($element2 -> src, 'http://estaticos02.marca.com/imagenes/' . $bigYear . '/' . $month . '/' . $day . '/') !== false) {
						$amarca = $element2 -> src;
					}
				}

			}

		}
		$this -> crud -> update('newspapers', array('coverURL' => $amarca, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => MARCA));
	}

	private function _updateAS() {

		$url = "http://as.com";

		$html = file_get_html($url);
		// Find all images
		$as = '';

		foreach ($html->find('header.portada section.periodico a img') as $a) {
			$property = 'data-src';
			$normalURL = $a -> $property;
			$as = str_replace('normal', 'grande', $normalURL);
		}

		$this -> crud -> update('newspapers', array('coverURL' => $as, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => ASJ));
	}
	
	/*
	 * 
	 * 
	 * POLAND
	 * 
	 */
	 public function test()
	 {
	 	$this -> load -> library('simple_html_dom');
		$this -> load -> model('crud');
		$urlgrab = $this->_updateMarca();
		$this->output->set_content_type('application/json');
    	$this->output->set_output(json_encode($urlgrab));
		
		

	 }
	 private function _updatePrzegladSportowy()
	 {
	 	
	 	$url = "http://www.e-kiosk.pl/redir.php?t=przeglad_sportowy&prc=sports";
		$urlImage = "http://www.e-kiosk.pl/images/";
		$html = file_get_html($url);
		$imageName = '';
		// Find all images
		foreach ($html->find('div.step-issue div#issue div#image a img') as $a) {
			$elementSrc = $a->src;
			$clean = str_replace('phpThumb.php?src=images/', '', $elementSrc);
			$imageName = str_replace('&w=175&h=235', '', $clean);
		 
			
		}
		$varSQL = "".$urlImage.$imageName;
		$this -> crud -> update('newspapers', array('coverURL' => $varSQL, 'lastUpdate' => date("Y-m-d H:i:s")), array('id' => PRZEGLAD_SPORTOW));
	 }

	private function _getAllData() {
		$alldata = $this -> crud -> retrieve('newspapers', '*', FALSE, '_ARRAY', 'country', array( array('base_country', 'newspapers.country = base_country.id', 'left')));
		return $alldata;

	}

	private function _objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}

		if (is_array($d)) {
			/*
			 * Return array converted to object
			 * Using __FUNCTION__ (Magic constant)
			 * for recursive call
			 */
			return array_map(__FUNCTION__, $d);
		} else {
			// Return array
			return $d;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
