<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Announcement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('SESS_IS_LOGIN')) {

            redirect(base_url('login'));
        }
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        //$this->load->model('login_model');
        $this->load->model('log_model');
        $this->load->model('announcement_model');
        $this->load->model('main_model');

        if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 1) {
            
        } elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 2) {
            
        } elseif ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 3) {
            
        } else {
            if ($this->announcement_model->cek_notif() > 0) {

                $this->announcement_model->delete_notif();
            }
        }

        //$this->data['notif_count'] = $this->main_model->count_data();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count'] = $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi'] = $this->notifikasi_model->realisasi_no($cab)->result();
        $this->data['notif_integrasi'] = $this->notifikasi_model->notifintegrasi();
        //$this->load->library('m_pdf');
    }

    public function index() {
        ini_set('max_execution_time', 0); //0 seconds
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $month = $date->format('m');

        $this->data['get_cabang'] = $this->main_model->get_cabang();
        $this->data['get_gauge_value'] = $this->main_model->get_gauge_value($get_tahun);

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view announcement',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->data['list'] = $this->announcement_model->all();

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/viewannouncement');
        $this->load->view('template/global/footer');
    }

    public function sudahbaca($id) {
        $data = array(
            "ID_USER" => $this->session->userdata('SESS_USER_ID'),
            "ID_ANNOUNCEMENT" => $id,
            "BACA" => 1
        );
        $this->announcement_model->insertbaca($data);
        redirect(base_url('announcement'));
    }

    public function updatehorn($id, $data) {
        if ($data == 1) {
            $data = 0;
        } else {
            $data = 1;
        }
        $this->announcement_model->updatehorn($id, $data);
        redirect(base_url('announcement'));
    }

    public function upload() {

        $this->load->library('upload');

        $nmfile = $this->input->post('announcement_file');
        // $filename = date('Ymd_his');
        $config['upload_path'] = './uploads/announcement/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 10000;
        $config['overwrite'] = true;
        // $config['file_name'] = $filename;
        // print_r($nmfile); exit();
        $this->upload->initialize($config);

        if ($_FILES['announcement_file']['name']) {
            if ($this->upload->do_upload('announcement_file')) {

                $gbr = $this->upload->data();
                $data = array(
                    'ANNOUNCEMENT_NAME' => $gbr['file_name']
                );

                $this->announcement_model->insert_file($data);

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user upload announcement',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Upload file berhasil');

                redirect('announcement');
            } else {
                $this->session->set_flashdata('fail', 'Upload gagal');

                redirect('announcement');
            }
        } else {
            $this->session->set_flashdata('fail', 'Gagal Upload File');

            redirect('announcement');
        }
    }

    public function delete_modal($id) {

        $data['list'] = $this->announcement_model->find($id);
        $data = $data['list'];
        echo json_encode($data);

        // $this->load->view('template/pages/delete_announcement_modal', $data);
    }

    public function delete($id) {

        $delete_file = $this->announcement_model->find($id);

        $name_file = $this->announcement_model->find($id)->ANNOUNCEMENT_NAME;

        if ($delete_file) {

            if ($this->announcement_model->delete($id)) {

                unlink($_SERVER["DOCUMENT_ROOT"] . '/ipc.dashboard.realisasi/uploads/announcement/' . $name_file);

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete announcement',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('message', 'File berhasil dihapus');

                redirect(base_url('announcement'));
            } else {

                $this->session->set_flashdata('fail', 'File gagal dihapus');

                redirect(base_url('announcement'));
            }
        } else {

            redirect(base_url('announcement'));
        }
    }

}
