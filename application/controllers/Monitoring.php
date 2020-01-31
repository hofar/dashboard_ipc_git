<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitoring extends CI_Controller {

    Public function index(){
        
    }
    public function masuk($kode)
    {
        if ($kode==1221) {
            $this->load->model('monitoring_m');
            $dat = $this->monitoring_m->monit();
            $jum = $this->monitoring_m->jumlah();
            $this->load->view('template/pages/monitoring_v',compact('dat','jum'));
        }
    }
}