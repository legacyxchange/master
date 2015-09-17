<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Layout {
	private $ci;
	
	public function __construct(){
		$this->ci = &get_instance();
	}
	public function load($view, $data = null, $layout = 'layout'){
		switch($layout){
			case 'layout':
				$this->ci->load->view('template/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('template/footer', $data);
				break;
			case 'admin':
				$this->ci->load->view('admin/template/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('admin/template/footer', $data);
				break;
			case 'administrator':
				$this->ci->load->view('administrator/template/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('administrator/template/footer', $data);
				break;
			case 'new_admin':
				$this->ci->load->view('admin/new_admin/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('admin/new_admin/footer', $data);
				break;
			case 'ecommerce':
				$this->ci->load->view('admin/ecommerce/template/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('admin/ecommerce/template/footer', $data);
				break;
			default:
				$this->ci->load->view('template/header', $data);
				$this->ci->load->view($view, $data);
				$this->ci->load->view('template/footer', $data);
				break;
		}
		return;
	}
}
