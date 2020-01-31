<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Realisasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('SESS_IS_LOGIN')) {

            redirect(base_url('login'));
        }
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        $this->load->model('login_model');
        $this->load->model('realisasi_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('subprogramrkap_model');
        $this->load->model('announcement_model');
        $this->load->model('risiko_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function view($id) {


        $data['groups'] = $this->realisasi_model->all_jenis_subprogram();
        $data['groups2'] = $this->realisasi_model->all_status();
        $data['groups4'] = $this->realisasi_model->all_kendala();
        $data['groups5'] = $this->realisasi_model->all_month();
        $data['groups6'] = $this->realisasi_model->all_years();
        $data['list'] = $this->realisasi_model->all_realisasi_program($id);
        $data['find'] = $this->risiko_model->find_print($id);

        $data['count_real'] = $this->realisasi_model->hitung_realisasi($id);
        $data['count_waktu'] = $this->realisasi_model->jumlah_jangka_waktu($id)->RKAP_SUBPRO_PERIODE;

        $data['row_subprogram'] = $this->realisasi_model->find_subprogram($id);

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view realisasi',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->form_validation->set_rules('title', 'search title', 'trim');

        if ($this->form_validation->run() === FALSE) {

            $this->session->unset_userdata('title');
            $this->session->unset_userdata('type');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('kendala');
            $this->session->unset_userdata('month');
            $this->session->unset_userdata('years');

            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/viewrealisasi', $data);
            $this->load->view('template/global/footer');
        } else {
            $title = $this->input->POST('title');
            $type = $this->input->POST('type');
            $status = $this->input->POST('status');
            $kendala = $this->input->POST('kendala');
            $month = $this->input->POST('month');
            $years = $this->input->POST('years');
            // print_r($years); exit();
            $this->session->set_flashdata('title', $this->input->post('title'));
            $this->session->set_flashdata('type', $this->input->post('type'));
            $this->session->set_flashdata('status', $this->input->post('status'));
            $this->session->set_flashdata('kendala', $this->input->post('kendala'));
            $this->session->set_flashdata('month', $this->input->post('month'));
            $this->session->set_flashdata('years', $this->input->post('years'));

            if ($title != null && $type == null && $status == null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_null($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_jenis($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_status($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_status($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_jenis_status($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala == null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_status($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_jenis_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_status_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_status_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_jenis_status_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala != null && $month == null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_status_kendala($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_jenis_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_status_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_status_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_jenis_status_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_jenis_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_status_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala == null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_status_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_status_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_jenis_status_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala != null && $month != null && $years == null) {
                $key = $this->realisasi_model->search_title_jenis_status_kendala_month($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_jenis_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_status_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_status_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_jenis_status_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_jenis_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_jenis_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_status_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_status_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status == null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala == null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_status_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_status_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_status_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status == null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_jenis_status_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_jenis_status_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status == null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_jenis_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type == null && $status != null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_status_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala != null && $month == null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_status_kendala_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala == null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_status_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status == null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type == null && $status != null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_status_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $type != null && $status != null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_jenis_status_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $type != null && $status != null && $kendala != null && $month != null && $years != null) {
                $key = $this->realisasi_model->search_title_jenis_status_kendala_month_years($id);
                $data['list'] = $key;

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewrealisasi', $data);
                $this->load->view('template/global/footer');
            }
        }
    }

    public function generate($id)
    {
       $this->subprogramrkap_model->generates($id);
    }

    public function generate2($id)
    {
       $this->subprogramrkap_model->generates2($id);
    }

    public function add($id) {
        $data['cek'] = $this->realisasi_model->find_add($id);
        if ($data['cek'] == null) {
        } else {
            $id_subpro = $this->realisasi_model->find_id_subpro($id)->REAL_SUBPRO_ID;
            $data['list3'] = $this->realisasi_model->data_sebelumnya_add($id, $id_subpro);
        }

        $data['list4'] = $this->realisasi_model->find_add_sebelum($id);

        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('kendala', 'Kendala', 'required');
        $this->form_validation->set_rules('catatan', 'Catatan', 'required');
        $this->form_validation->set_rules('realisasi_biaya_pelaporan', 'Realisasi Biaya Pelaporan', 'required');
        $this->form_validation->set_rules('realisasi_persen_pelaporan', 'Realisasi Persen Pelaporan', 'required');
        $this->form_validation->set_rules('realisasi_value_pelaporan', 'Realisasi Value Pelaporan', 'required');


        if ($this->form_validation->run() === FALSE) {

            $data['groups'] = $this->realisasi_model->all_jenis_subprogram();
            $data['groups2'] = $this->realisasi_model->all_status();
            $data['groups4'] = $this->realisasi_model->all_kendala();
            $data['list'] = $this->realisasi_model->all_realisasi_program($id);
            // print_r($data['list']); exit();
            $data['listrkap'] = $this->ganttchart_model->find($id);
            $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id)[0]['PERSEN_TOT'];

            if ($this->realisasi_model->persen_notselected($id)[0]['PERSEN_TOT'] == null) {

                $data['persen_tot_val'] = 0;
            } else {
                $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id)[0]['PERSEN_TOT'];
            }

            $data['row_subprogram'] = $this->realisasi_model->find_subprogram($id);

            $data['act'] = 'add';

            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/addrealisasi', $data);
            $this->load->view('template/global/footer');
        } else {

            if ($this->input->post('tgl_deadline') == null) {

                $bln_pelaporan_set = $this->input->post('bln_pelaporan');
                $bln_explode = explode('-', $bln_pelaporan_set);

                $count_real = $this->realisasi_model->hitung_realisasi($id);

                if ($count_real == 0) {
                    $bln_pelaporan_new = 1;
                } else {
                    $bln_pelaporan_new = $count_real + 1;
                }

                $bln_pelaporan = $bln_explode[0];
                $thn_pelaporan = $bln_explode[1];
                $hari_pelaporan = $this->strotimedev($thn_pelaporan,$bln_pelaporan);
                $deadline_set = strtotime($this->input->post('tgl_deadline'));
                $deadline = date('d-M-y', $deadline_set);

                $status = $this->input->post('status');
                $kendala = $this->input->post('kendala');
                $tgl_deadline = $this->input->post('tgl_deadline');
                $catatan = $this->input->post('catatan');
                $realisasi_biaya_pelaporan_set = $this->input->post('realisasi_biaya_pelaporan');
                $realisasi_biaya_pelaporan1 = str_replace('.', '', $realisasi_biaya_pelaporan_set);
                $realisasi_biaya_pelaporan = str_replace(',', '.', $realisasi_biaya_pelaporan1);

                $realisasi_persen_pelaporan_set = $this->input->post('realisasi_persen_pelaporan');
                $realisasi_persen_pelaporan = str_replace(',', '.', $realisasi_persen_pelaporan_set);

                $realisasi_value_pelaporan_set = $this->input->post('realisasi_value_pelaporan');
                $realisasi_value_pelaporan = str_replace(',', '.', $realisasi_value_pelaporan_set);

                $realisasi_persen_tot_set = $this->input->post('realisasi_persen_tot');
                $realisasi_persen_tot = str_replace(',', '.', $realisasi_persen_tot_set);
                // print_r($realisasi_persen_tot); exit();

                $data = array(
                    'REAL_SUBPRO_MONTH_NEW' => $bln_pelaporan_new,
                    'REAL_SUBPRO_MONTH' => $bln_pelaporan,
                    'REAL_SUBPRO_YEAR' => $thn_pelaporan,
                    'REAL_SUBPRO_DATE' => $hari_pelaporan,
                    'RKAP_SUBPRO_ID' => $id,
                    'REAL_SUBPRO_STATUS' => $status,
                    'REAL_SUBPRO_CONSTRAINTS' => $kendala,
                    'REAL_SUBPRO_DEADLINE' => null,
                    'REAL_SUBPRO_COMMENT' => $catatan,
                    'REAL_SUBPRO_COST' => $realisasi_biaya_pelaporan,
                    'REAL_SUBPRO_PERCENT' => $realisasi_persen_pelaporan,
                    'REAL_SUBPRO_VAL' => $realisasi_value_pelaporan,
                    'REAL_SUBPRO_PERCENT_TOT' => $realisasi_persen_tot
                );
            } else {

                $bln_pelaporan_set = $this->input->post('bln_pelaporan');
                $bln_explode = explode('-', $bln_pelaporan_set);

                $count_real = $this->realisasi_model->hitung_realisasi($id);

                if ($count_real == 0) {
                    $bln_pelaporan_new = 1;
                } else {
                    $bln_pelaporan_new = $count_real + 1;
                }

                $bln_pelaporan = $bln_explode[0];
                $thn_pelaporan = $bln_explode[1];
                $hari_pelaporan = $this->strotimedev($thn_pelaporan,$bln_pelaporan);
                $deadline_set = strtotime($this->input->post('tgl_deadline'));
                $deadline = date('d-M-y', $deadline_set);


                $status = $this->input->post('status');
                $kendala = $this->input->post('kendala');
                $tgl_deadline = $this->input->post('tgl_deadline');
                $catatan = $this->input->post('catatan');
                $realisasi_biaya_pelaporan_set = $this->input->post('realisasi_biaya_pelaporan');
                $realisasi_biaya_pelaporan1 = str_replace('.', '', $realisasi_biaya_pelaporan_set);
                $realisasi_biaya_pelaporan = str_replace(',', '.', $realisasi_biaya_pelaporan1);

                $realisasi_persen_pelaporan_set = $this->input->post('realisasi_persen_pelaporan');
                $realisasi_persen_pelaporan = str_replace(',', '.', $realisasi_persen_pelaporan_set);

                $realisasi_value_pelaporan_set = $this->input->post('realisasi_value_pelaporan');
                $realisasi_value_pelaporan = str_replace(',', '.', $realisasi_value_pelaporan_set);

                $realisasi_persen_tot_set = $this->input->post('realisasi_persen_tot');
                $realisasi_persen_tot = str_replace(',', '.', $realisasi_persen_tot_set);

                $data = array(
                    'REAL_SUBPRO_MONTH_NEW' => $bln_pelaporan_new,
                    'REAL_SUBPRO_MONTH' => $bln_pelaporan,
                    'REAL_SUBPRO_YEAR' => $thn_pelaporan,
                    'REAL_SUBPRO_DATE' => $hari_pelaporan,
                    'RKAP_SUBPRO_ID' => $id,
                    'REAL_SUBPRO_STATUS' => $status,
                    'REAL_SUBPRO_CONSTRAINTS' => $kendala,
                    'REAL_SUBPRO_DEADLINE' => $deadline,
                    'REAL_SUBPRO_COMMENT' => $catatan,
                    'REAL_SUBPRO_COST' => $realisasi_biaya_pelaporan,
                    'REAL_SUBPRO_PERCENT' => $realisasi_persen_pelaporan,
                    'REAL_SUBPRO_VAL' => $realisasi_value_pelaporan,
                    'REAL_SUBPRO_PERCENT_TOT' => $realisasi_persen_tot
                );

            }


            if ($this->realisasi_model->add($data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user add realisasi',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                $this->subprogramrkap_model->generates2($id);
                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data realisasi sub program berhasil ditambahkan');

                redirect(base_url('realisasi/view/' . $id));
            } else {

                $this->session->set_flashdata('message', 'Data realisasi sub program gagal ditambahkan');

                redirect(base_url('realisasi/add/' . $id));
            }
        }
    }

    public function detail($id) {

        $data['groups'] = $this->realisasi_model->all_jenis_subprogram();
        $data['groups2'] = $this->realisasi_model->all_status();
        $data['groups4'] = $this->realisasi_model->all_kendala();
        $data['list'] = $this->realisasi_model->find_realisasi($id)[0];

        $id_subpro = $this->realisasi_model->find($id)->RKAP_SUBPRO_ID;

        $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'];

        if ($this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'] == null) {

            $data['persen_tot_val'] = 0;
        } else {
            $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'];
        }

        $data['persen_select'] = $this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'];
                 if ($this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'] == null) {

                    $data['persen_select'] = 0;
                } else {
                    $data['persen_select'] = $this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'];
                }

        $data['listrkap'] = $this->ganttchart_model->find($id_subpro);
        $data['cek'] = $this->realisasi_model->find_add($id_subpro);
        $data['list3'] = $this->realisasi_model->data_sebelumnya($id, $id_subpro);

        $data['act'] = 'detail';

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view detail realisasi',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/addrealisasi', $data);
        $this->load->view('template/global/footer');
    }

    public function update($id) {

        $data_realisasi = $this->realisasi_model->find($id);
        $id_subprogram = $this->realisasi_model->find($id)->RKAP_SUBPRO_ID;

        if ($data_realisasi) {

            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('kendala', 'Kendala', 'required');
            $this->form_validation->set_rules('catatan', 'Catatan', 'required');
            $this->form_validation->set_rules('realisasi_biaya_pelaporan', 'Realisasi Biaya Pelaporan', 'required');


            if ($this->form_validation->run() === FALSE) {

                $data['groups'] = $this->realisasi_model->all_jenis_subprogram();
                $data['groups2'] = $this->realisasi_model->all_status();
                $data['groups4'] = $this->realisasi_model->all_kendala();
                $data['list'] = $this->realisasi_model->find_realisasi($id)[0];
                $data['row_subprogram'] = $this->realisasi_model->find_subprogram($id);
                $data['list2'] = $this->realisasi_model->detail($id)[0];

                $id_subpro = $this->realisasi_model->find($id)->RKAP_SUBPRO_ID;
                $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'];

                if ($this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'] == null) {

                    $data['persen_tot_val'] = 0;
                } else {
                    $data['persen_tot_val'] = $this->realisasi_model->persen_notselected($id_subpro)[0]['PERSEN_TOT'];
                }
                
                $data['persen_select'] = $this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'];
                 if ($this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'] == null) {

                    $data['persen_select'] = 0;
                } else {
                    $data['persen_select'] = $this->realisasi_model->persen_selected($id, $id_subpro)[0]['PERSEN_TOT'];
                }

                $data['listrkap'] = $this->ganttchart_model->find($id_subpro);
                $data['cek'] = $this->realisasi_model->find_add($id_subpro);
                $data['list3'] = $this->realisasi_model->data_sebelumnya($id, $id_subpro);

                $data['act'] = 'edit';

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/addrealisasi', $data);
                $this->load->view('template/global/footer');
            } else {

                if ($this->input->post('tgl_deadline') == '') {

                    // print_r($this->input->post('realisasi_persen_pelaporan')); exit();
                    $bln_pelaporan_set = $this->input->post('bln_pelaporan');
                    $bln_explode = explode('-', $bln_pelaporan_set);

                    $count_real = $this->realisasi_model->hitung_realisasi($id);

                    if ($count_real == 0) {
                        $bln_pelaporan_new = 1;
                    } else {
                        $bln_pelaporan_new = $count_real + 1;
                    }

                    $bln_pelaporan = $bln_explode[0];
                    $thn_pelaporan = $bln_explode[1];

                    $hari_pelaporan = $this->strotimedev($thn_pelaporan,$bln_pelaporan);

                    $deadline_set = strtotime($this->input->post('tgl_deadline'));
                    $deadline = date('d-M-y', $deadline_set);

                    $status = $this->input->post('status');
                    $kendala = $this->input->post('kendala');
                    $tgl_deadline = $this->input->post('tgl_deadline');
                    $catatan = $this->input->post('catatan');
                    $realisasi_biaya_pelaporan_set = $this->input->post('realisasi_biaya_pelaporan');
                    $realisasi_biaya_pelaporan_set1 = str_replace('.', '', $realisasi_biaya_pelaporan_set);
                    $realisasi_biaya_pelaporan = str_replace(',', '.', $realisasi_biaya_pelaporan_set1);

                    $realisasi_persen_pelaporan_set = $this->input->post('realisasi_persen_pelaporan');
                    $realisasi_persen_pelaporan = str_replace(',', '.', $realisasi_persen_pelaporan_set);
                    // print_r($realisasi_persen_pelaporan); exit();

                    $realisasi_value_pelaporan_set = $this->input->post('realisasi_value_pelaporan');
                    // $realisasi_value_pelaporan_set1 = str_replace('.', '', $realisasi_value_pelaporan_set);
                    // $realisasi_value_pelaporan = str_replace(',', '.', $realisasi_value_pelaporan_set1);
                    
                    $realisasi_persen_tot_set = $this->input->post('realisasi_persen_tot');
                    $realisasi_persen_tot = str_replace(',', '.', $realisasi_persen_tot_set);
                    // print_r($realisasi_value_pelaporan_set); exit();

                    $data = array(
                        'REAL_SUBPRO_MONTH_NEW' => $bln_pelaporan_new,
                        'REAL_SUBPRO_MONTH' => $bln_pelaporan,
                        'REAL_SUBPRO_YEAR' => $thn_pelaporan,
                        'REAL_SUBPRO_DATE' => $hari_pelaporan,
                        'REAL_SUBPRO_STATUS' => $status,
                        'REAL_SUBPRO_CONSTRAINTS' => $kendala,
                        'REAL_SUBPRO_DEADLINE' => null,
                        'REAL_SUBPRO_COMMENT' => $catatan,
                        'REAL_SUBPRO_COST' => $realisasi_biaya_pelaporan,
                        'REAL_SUBPRO_PERCENT' => $realisasi_persen_pelaporan,
                        // 'REAL_SUBPRO_PERCENT' => str_replace('.', '', $realisasi_persen_pelaporan),
                        'REAL_SUBPRO_VAL' => $realisasi_value_pelaporan_set,
                        'REAL_SUBPRO_PERCENT_TOT' => $realisasi_persen_tot
                    );
                    // print_r($data); exit();
                } else {
                    $bln_pelaporan_set = $this->input->post('bln_pelaporan');
                    $bln_explode = explode('-', $bln_pelaporan_set);

                    $count_real = $this->realisasi_model->hitung_realisasi($id);

                    if ($count_real == 0) {
                        $bln_pelaporan_new = 1;
                    } else {
                        $bln_pelaporan_new = $count_real + 1;
                    }

                    $bln_pelaporan = $bln_explode[0];
                    $thn_pelaporan = $bln_explode[1];

                    $hari_pelaporan = $this->strotimedev($thn_pelaporan,$bln_pelaporan);
                    $deadline_set = strtotime($this->input->post('tgl_deadline'));
                    $deadline = date('d-M-y', $deadline_set);

                    $status = $this->input->post('status');
                    $kendala = $this->input->post('kendala');
                    $tgl_deadline = $this->input->post('tgl_deadline');
                    $catatan = $this->input->post('catatan');
                    $realisasi_biaya_pelaporan_set = $this->input->post('realisasi_biaya_pelaporan');
                    $realisasi_biaya_pelaporan_set1 = str_replace('.', '', $realisasi_biaya_pelaporan_set);
                    $realisasi_biaya_pelaporan = str_replace(',', '.', $realisasi_biaya_pelaporan_set1);

                    $realisasi_persen_pelaporan_set = $this->input->post('realisasi_persen_pelaporan');
                    $realisasi_persen_pelaporan = str_replace(',', '.', $realisasi_persen_pelaporan_set);

                    $realisasi_value_pelaporan_set = $this->input->post('realisasi_value_pelaporan');
                    // $realisasi_value_pelaporan_set1 = str_replace('.', '', $realisasi_value_pelaporan_set);
                    // $realisasi_value_pelaporan = str_replace(',', '.', $realisasi_value_pelaporan_set1);
                    
                    $realisasi_persen_tot_set = $this->input->post('realisasi_persen_tot');
                    $realisasi_persen_tot = str_replace(',', '.', $realisasi_persen_tot_set);
                    
                    $data = array(
                        'REAL_SUBPRO_MONTH_NEW' => $bln_pelaporan_new,
                        'REAL_SUBPRO_MONTH' => $bln_pelaporan,
                        'REAL_SUBPRO_YEAR' => $thn_pelaporan,
                        'REAL_SUBPRO_DATE' => $hari_pelaporan,
                        'REAL_SUBPRO_STATUS' => $status,
                        'REAL_SUBPRO_CONSTRAINTS' => $kendala,
                        'REAL_SUBPRO_DEADLINE' => $deadline,
                        'REAL_SUBPRO_COMMENT' => $catatan,
                        'REAL_SUBPRO_COST' => $realisasi_biaya_pelaporan,
                        'REAL_SUBPRO_PERCENT' => $realisasi_persen_pelaporan,
                        // 'REAL_SUBPRO_PERCENT' => str_replace('.', '', $realisasi_persen_pelaporan),
                        'REAL_SUBPRO_VAL' => $realisasi_value_pelaporan_set,
                        'REAL_SUBPRO_PERCENT_TOT' => $realisasi_persen_tot
                        // 'REAL_SUBPRO_PERCENT_TOT' => str_replace('.', '', $realisasi_persen_tot)
                    );
                }
                if ($this->realisasi_model->update($id, $data)) {
                    $all_count_real_subpro = $this->realisasi_model->get_count_all_row($id_subprogram);
                    $this->realisasi_model->update_last_row($all_count_real_subpro);

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update realisasi',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);
                    $this->subprogramrkap_model->generates2($id_subprogram);
                    $this->session->set_flashdata('success', 'Data realisasi sub program berhasil diubah');

                    redirect(base_url('realisasi/view/' . $id_subprogram));
                } else {

                    $this->session->set_flashdata('message', 'Data realisasi sub program gagal diubah');

                    redirect(base_url('realisasi/update' . $id));
                }
            }
        } else {

            redirect(base_url('realisasi/view/' . $id_subprogram));
        }
    }

    public function strotimedev($a,$b)
    {
        $h1 = date('d-M-y', strtotime($a."-".$b."-".date('d')));
        $h2 = date('t-M-y', strtotime($a."-".$b."-01"));
        $exc = explode("-",$h2);
                    
        if(date('d') >= $exc[0]){
            $h3 = $h2;
        }else {
            $h3 = $h1;
        }
        return $h3;
    }

    public function delete_modal($id) {

        $data['list'] = $this->realisasi_model->find($id);

        $this->load->view('template/pages/delete_realisasi_modal', $data);
    }

    public function delete($id) {
        $delete_realisasi = $this->realisasi_model->find($id);
        $id_subprogram = $this->realisasi_model->find($id)->RKAP_SUBPRO_ID;

        if ($delete_realisasi) {
            $data = array(
                'IS_DELETED' => 1
            );

            if ($this->realisasi_model->delete($id, $data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete realisasi',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data berhasil di hapus');

                redirect(base_url('realisasi/view/' . $id_subprogram));
            } else {

                $this->session->set_flashdata('fail', 'data gagal di hapus');

                redirect(base_url('realisasi/view/' . $id_subprogram));
            }
        } else {
            redirect(base_url('realisasi/view/' . $id_subprogram));
        }
    }

}
