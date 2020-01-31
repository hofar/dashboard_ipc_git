<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Kurva extends CI_Controller {

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
        $this->load->model('kurva_model');
        $this->load->model('log_model');
        $this->load->model('subprogramrkap_model');
        $this->load->model('main_model');
        $this->load->model('realisasi_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');

        $this->data['notif_announcement'] = $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count'] = $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi'] = $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function add($id) {

        $tgl_memulai = $this->kurva_model->find_subprogram($id)->RKAP_SUBPRO_CONTRACT_DATE;
        $blnstart = strtotime($tgl_memulai);
        $newstart = date('Y-m-d', $blnstart);

        $tgl_berakhir = $this->kurva_model->find_subprogram($id)->RKAP_SUBPRO_END_REAL;
        $blnend = strtotime($tgl_berakhir);
        $newend = date('Y-m-d', $blnend);

        $start = (new DateTime($newstart))->modify('first day of this month');
        $end = (new DateTime($newend))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $datakurva = array();
        $arrdata = $this->kurva_model->find_all_month($id);

        foreach ($period as $dt) {
            $datakurva_month[] = $dt->format("m");
            $datakurva_year[] = $dt->format("d-M-y");
        }

        $data['kurvas_month'] = $datakurva_month;
        $data['kurvas_year'] = $datakurva_year;
        $data['list'] = $this->kurva_model->all_subprogram($id);
        $data['row_subprogram'] = $this->kurva_model->find_subprogram($id);
        $data['list2'] = $this->kurva_model->all_subprogram_monthly($id);
        $data['row_subprogram_monthly'] = $this->kurva_model->find_subprogram_monthly($id);
        $data['resutl_all_month'] = $this->kurva_model->find_all_month($id);
        $data['resutl_all_month_non_adden_group'] = $this->subprogramrkap_model->jmladendum($id);
        $data['resutl_all_month_non_adden'] = $this->kurva_model->find_all_month_non_adden($id);
        $data['resutl_all_month_adden'] = $this->kurva_model->find_all_month_adden($id);
        $data['resutl_all_month_adden1'] = $this->kurva_model->find_all_month_adden1($id);
        $data['cek_urutan'] = $this->kurva_model->find_all_month_adden($id);
        // $data['cek_addendum'] = $this->kurva_model->cek_addendum($id);
        // $data['cek_addendum2'] = $this->kurva_model->cek_addendum2($id);
        // $data['cek_addendum3'] = $this->kurva_model->cek_addendum3($id);
        // $data['cek_addendum4'] = $this->kurva_model->cek_addendum4($id);
        // $data['cek_addendum5'] = $this->kurva_model->cek_addendum5($id);
        //yayan
        $data['kurvarealisasi'] = $this->subprogramrkap_model->kurvarealisasi($id);
        $data['jmladdn'] = $this->subprogramrkap_model->jmladendum($id);
        $data['jmlhdata'] = $this->subprogramrkap_model->jumlhdata($id);
        //echo json_encode($data);
        for ($i = 0; $i < $data['jmladdn']; $i++) {

            $data["Adden"][$i] = $this->subprogramrkap_model->kurvaaddendum($id, $i);
            $data["Adden2"][$i] = "Add$i";
        }
        //------------
        $data['list_subpro'] = $this->subprogramrkap_model->detail($id)[0];

        $data['result_month'] = $this->kurva_model->find_month($id);
        //$nilai = $this->subprogramrkap_model->tampilvalue($id);
        //$data['value'] = $nilai;

        $realisasi_month = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_MONTH;
        $data['realisasi'] = $realisasi_month;
        $rencana_month = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_MONTH;
        $data['rencana'] = $rencana_month;

        $deviasi_kurva_realisasi = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_PERCENT_TOT;
        $data['deviasi_realisasi'] = $deviasi_kurva_realisasi;
        $deviasi_kurva_rencana = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_VALUE;
        $data['deviasi_rencana'] = $deviasi_kurva_rencana;


        $deviasi_kurva_total = $deviasi_kurva_realisasi - $deviasi_kurva_rencana;
        $data['deviasi_total'] = $deviasi_kurva_total;

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;

        if ($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total >= $deviasi_till70) {

            $data['warna'] = 1;
        } elseif ($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total == $deviasi_till70) {
            $data['warna'] = 2;
        } elseif ($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total <= $deviasi_till70) {
            $data['warna'] = 3;
        } elseif ($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total >= $deviasi_till100) {
            $data['warna'] = 4;
        } elseif ($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total == $deviasi_till100) {
            $data['warna'] = 5;
        } elseif ($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total <= $deviasi_till100) {
            $data['warna'] = 6;
        }

        $data['act'] = 'add';

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view form kurva s',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );
        //echo json_encode($data);
        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/addkurva', $data);
    }

    public function coba22($id) {

        $data['jmladdn'] = $this->subprogramrkap_model->jmladendum($id);
        //echo json_encode($data);
        for ($i = 0; $i < $data['jmladdn']; $i++) {

            $data["Adden"][$i] = $this->subprogramrkap_model->kurvaaddendum($id, $i);
            $data["Adden2"][$i] = "Add$i";
        }

        echo json_encode($data);
    }

    public function added($id) {

        $cek_data = $this->kurva_model->find_subprogram_monthly($id);

        $kurva_month = $this->input->post('kurva_month');
        $kurva_mon = $this->input->post('SUBPRO_MON');
        $kurva_years = $this->input->post('kurva_years');
        $kurva_value_set = $this->input->post('kurva_value');
        $kurva_value1 = str_replace('.', '', $kurva_value_set);
        $kurva_value = str_replace(',', '.', $kurva_value1);
        if ($cek_data == null) {

            $total_cek = count($kurva_month) - 1;

            for ($i = 0; $i <= $total_cek; $i++) {

                $month = $kurva_month[$i];
                $value = $kurva_value[$i];
                $mon = $kurva_mon[$i];
                $years = $kurva_years[$i];

                $data['RKAP_SUBPRO_ID'] = $id;
                $data['SUBPRO_MON'] = $mon;
                $data['SUBPRO_VALUE'] = $value;
                $data['SUBPRO_MONTH'] = $month;
                $data['SUBPRO_YEARS'] = $years;

                $this->kurva_model->add($data);
            }
        } else {

            $cek_id = $this->kurva_model->cek_id($id);
            $total = count($cek_id) - 1;

            for ($i = 0; $i <= $total; $i++) {

                $month = $kurva_month[$i];
                $value = $kurva_value[$i];
                $mon = $cek_id[$i];
                $years = $kurva_years[$i];
                // print_r($years); exit();
                $data['RKAP_SUBPRO_ID'] = $id;
                $data['SUBPRO_MON'] = $mon;
                $data['SUBPRO_VALUE'] = $value;
                $data['SUBPRO_MONTH'] = $month;
                $data['SUBPRO_YEARS'] = $years;

                $this->kurva_model->add($data);
            }
        }

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user add or update kurva s',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->session->set_flashdata('success', 'Data kurva berhasil ditambahkan');

        redirect(base_url('kurva/add/' . $id));
    }

}
