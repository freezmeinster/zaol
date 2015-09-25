<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index(){
		$this->personal->is_login();
		$uid = $this->session->userdata('id');
		$year = date("Y");
		$data['active_user_id'] = $uid;
		$data['total_zakat_maal'] = $this->personal->get_total_zakat(1,$uid,$year);
		$data['total_zakat_fitrah'] = $this->personal->get_total_zakat(2,$uid,$year);
		$data['total_zakat_profesi'] = $this->personal->get_total_zakat(3,$uid,$year);
		$this->twig->render('dashboard/welcome', $data);
	}
	
	public function personal_info($jenis,$id,$year=NULL){
		$this->personal->is_login();
		if ( $year == NULL ){
			$year = date("Y");
		}
		if ( in_array($jenis, array("maal","fitrah","profesi"))){
			$template = 'dashboard/personal_info_'.$jenis;
			$data['year'] = $year;
			if ( $jenis == 'maal'){	
				$data['zakat'] = $this->personal->get_zakat(1,$id, $year);	
			} else if ( $jenis == 'fitrah'){	
				$data['zakat'] = $this->personal->get_zakat(2,$id, $year);	
			} else if ( $jenis == 'profesi'){	
				$data['zakat'] = $this->personal->get_zakat(3,$id, $year);	
			}
			$this->twig->render($template, $data);
		 } else {
			redirect("/dashboard/");
		 }
	}
	
	public function login(){
		if ($this->input->method() == 'post'){
			$email = $this->input->post("email");
			$pwd = $this->input->post("password");
			if ($this->personal->login($email,$pwd)){
				redirect("/dashboard");
			} else {
				redirect("/dashboard/login");
			}
			
		}
		$this->twig->render('dashboard/login');
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect("/dashboard/login");
	}
	
	public function register(){
		if ($this->input->method() == 'post'){
			$email = $this->input->post("email");
			$pass1 = $this->input->post("password1");
			$pass2 = $this->input->post("password2");
			$phone = $this->input->post("phone");
			$name = $this->input->post("name");
			
			if ($this->personal->user_exist($email)) {
				redirect("/dashboard/register");
			} else {
				if ($pass1 == $pass2 ){
					$data = array(
					"name" => $name,
					"password" => sha1($pass1),
					"phone" => $phone,
					"email" => $email,
					);
					$this->personal->register($data);
					redirect("/");
				} else {
					redirect("/dashboard/register");
				}
				
			}
		}
		$this->twig->render("dashboard/register");
	}
	
	public function personal_pay_maal($id){
		$data['list_bank'] = $this->internal->get_all_bank();
		$this->twig->render("dashboard/personal_pay_maal",$data);
	}
	
	public function personal_pay_fitrah($id){
		$this->twig->render("dashboard/personal_pay_maal");
	}
	
	public function personal_pay_profesi($id){
		$this->twig->render("dashboard/personal_pay_maal");
	}
}
