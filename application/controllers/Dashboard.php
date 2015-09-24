<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->twig->render('dashboard/welcome');
	}
	
	public function personal_info($jenis,$id,$year=NULL){
		if ( $year == NULL ){
			$year = date("Y");
		}
		if ( in_array($jenis, array("maal","fitrah","profesi"))){
			$template = 'dashboard/personal_info_'.$jenis;
			$data['year'] = $year;
			if ( $jenis == 'maal'){	
				$data['maal'] = $this->personal->get_zakat_maal($id, $year);	
			}
			$this->twig->render($template, $data);
		 } else {
			redirect("/dashboard/");
		 }
	}
}
