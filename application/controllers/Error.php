<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('SESS_IS_LOGIN')) {

            redirect(base_url('login'));
        }
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
    }

    public function index(){ 
	    $this->output->set_status_header('404'); 
	    $this->load->view('template/error/error-404');//loading in custom error view
	 } 

}
