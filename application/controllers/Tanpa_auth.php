<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tanpa_auth extends CI_Controller {

    public function delete_modal($id) {
        $this->load->model('user_model');
        $data['list'] = $this->user_model->finduser($id);
        $data = $data['list'];
        echo json_encode($data);
    }

    public function edit_modalstatus($id) {
        $this->load->model('user_model');
        $data['list'] = $this->user_model->finduser($id);
        $data = $data['list'];
        echo json_encode($data);
    }

    public function delete_modal2($id)
    {
        $this->load->model('setting_model');
        $data['list']= $this->setting_model->find($id);
        $data = $data['list'];
        echo json_encode($data);
    }

    public function edit_modalstatus2($id) {
        $this->load->model('setting_model');
        $data['list'] = $this->setting_model->find($id);
        $data = $data['list'];
        echo json_encode($data);
    }

}