<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index()
	{
		$this->twig->render('welcome');
	}
	public function about()
	{
		echo "About";
	}
	public function contact()
	{
		echo "Contact";
	}
	public function landing()
	{
		redirect("/dashboard/");
	}
}
