<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function index()
	{
		$this->twig->render('welcome');
	}
	public function zakat()
	{
		$this->twig->render('welcome');
	}
}
