<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller {

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
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        //$this->load->model('Report_model');
        $this->load->model('ews_model');
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_announcement'] = $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count'] = $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi'] = $this->notifikasi_model->realisasi_no($cab)->result();
        $this->data['notif_integrasi'] = $this->notifikasi_model->notifintegrasi();
        //$this->load->library('m_pdf');
        //$this->load->library('excel');
    }

    public function index() {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $month = $date->format('m');
        // $month = '5';
        $data['value'] = $this->main_model->get_value_realisasi();
        $data['notif'] = $this->main_model->count_data();

        // print_r($data['notif']); exit();
        // $test = $this->ews_model->target_tes($month);
        // print_r($test); exit();

        $id_branch = $this->session->userdata('SESS_USER_BRANCH');
        $reminderKontrakKritis = $this->setting_model->get_data_reminder_kon_krit()->DATA_REMINDER;
        $reminderKontrakKritis = $reminderKontrakKritis == null ? 0 : $reminderKontrakKritis;

        $reminderKontrakBA = $this->setting_model->get_data_reminder_kontrak_b_a()->DATA_REMINDER;
        $reminderKontrakBA = $reminderKontrakBA == null ? 0 : $reminderKontrakBA;

        $data['notif_announcement'] = $this->announcement_model->cek_notif();
        $branch = $this->session->userdata('SESS_USER_BRANCH');

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view home',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->data['get_cabang'] = $this->main_model->get_cabang();
        $this->data['get_cabang_2'] = $this->main_model->get_cabang_2();
        $this->data['get_gauge_value'] = $this->main_model->get_gauge_value($get_tahun);

        $this->data['total_kontrak_kritis'] = $this->ews_model->total_kontrak_kritis($id_branch, $get_bulan, $reminderKontrakKritis);
        $this->data['detail_kontrak_kritis'] = $this->ews_model->detail_kontrak_kritis($id_branch, $get_bulan, $reminderKontrakKritis);

        // Merubah bentuk data dari array ke objek
        if (is_array($this->data['total_kontrak_kritis'])) {
            $object = new stdClass();
            foreach ($this->data['total_kontrak_kritis'] as $key) {
                $object->KETERLAMBATAN = 0;
            }

            $this->data['total_kontrak_kritis'] = $object;
        }

        $this->data['total_start_sub_program'] = $this->ews_model->total_start_sub_program_fix($id_branch, $reminderKontrakBA);
        $this->data['detail_start_sub_program'] = $this->ews_model->detail_start_sub_program_fix($id_branch, $reminderKontrakBA);

        // REMINDER REALISASI PELAPORAN
        $tempData = $this->ews_model->get_rkap_id_not_current_date_realisasi_pelaporan($id_branch);
        $tempId = '';

        for ($i = 0; $i < count($tempData); $i++) {
            $tempId = $tempId . $tempData[$i]->RKAP_SUBPRO_ID . ', ';
        }

        $id_rkap_not_current_date = $tempId != '' ? rtrim($tempId, ', ') : 'null';

        $id_rkap_duplicate = $this->ews_model->get_id_rkap_duplicate_realisasi_pelaporan($id_branch, $id_rkap_not_current_date);
        $id_real = '';

        for ($i = 0; $i < count($id_rkap_duplicate); $i++) {
            if ($id_rkap_duplicate[$i]->RKAP_SUBPRO_ID == $id_rkap_duplicate[$i - 1]->RKAP_SUBPRO_ID) {
                $id_real = $id_real . $id_rkap_duplicate[$i]->REAL_SUBPRO_ID . ', ';
            }
        }

        $id_real = $id_real != '' ? rtrim($id_real, ', ') : 'null';

        $this->data['total_realisasi_pelaporan'] = $this->ews_model->total_realisasi_pelaporan($id_branch, $id_real);
        $this->data['detail_realisasi_pelaporan'] = $this->ews_model->detail_realisasi_pelaporan($id_branch, $id_real);

        // END REMINDER REALISASI PELAPORAN

        $this->data['total_kontrak_b_a'] = $this->ews_model->total_kontrak_b_a($id_branch, $reminderKontrakBA);
        $this->data['detail_kontrak_b_a'] = $this->ews_model->detail_kontrak_b_a($id_branch, $reminderKontrakBA);
        // $data['posisi_prog_investasi'] = $this->main_model->posisi_prog_investasi($id_branch);
        // print_r($data['posisi_prog_investasi']);
        $data['popupindikator'] = $this->popupindikator2($id_branch);
        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/home_index', $data);
        $this->load->view('template/global/footer');
    }

    Public function detail_all() {

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $data2 = $this->main_model->all_realisasi_fisik($get_bulan, $get_tahun);
        $data3 = $this->main_model->all_kpi_realisasi_program();
        $data4 = $this->main_model->all_kpi_realisasi_fisik($get_bulan, $get_tahun);
        $data5 = $this->main_model->all_status_prog_investasi_berjalan();
        $data6 = $this->main_model->all_status_prog_investasi_belum_berjalan();
        $data7 = $this->main_model->all_posisi_prog_investasi();
        $data8 = $this->main_model->all_kendala_prog_investasi();
        $data9 = $this->main_model->gauge_kritis_1_all($get_bulan, $deviasi_till70);
        $data10 = $this->main_model->gauge_kritis_2_all($get_bulan, $deviasi_till100);
        $data11 = $this->main_model->gauge_kritis_3_all($get_bulan, $get_kontrak_end);
        $data12 = $this->main_model->gauge_meter_all($get_bulan);
        $data13 = $this->main_model->value_fisik_all($get_bulan);
        $data14 = $this->main_model->value_program_all();
        $data15 = $this->main_model->value_realisasi_all($get_bulan, $get_tahun);

        $data2->RE = $this->bilangan($data2->RE);
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;
        $datasend['data5'] = $data5;
        $datasend['data6'] = $data6;
        $datasend['data7'] = $data7;
        $datasend['data8'] = $data8;
        $datasend['data9'] = $data9;
        $datasend['data10'] = $data10;
        $datasend['data11'] = $data11;
        $datasend['data12'] = $data12;
        $datasend['data13'] = $data13;
        $datasend['data14'] = $data14;
        $datasend['data15'] = $data15;

        echo json_encode($datasend);
    }

    Public function detail($id_branch) {

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');
        // print_r($tahun); exit();

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $data = $this->main_model->detail($id_branch);
        $data2 = $this->main_model->realisasi_fisik($id_branch, $get_bulan, $get_tahun);
        $data3 = $this->main_model->kpi_realisasi_program($id_branch);
        $data4 = $this->main_model->kpi_realisasi_fisik($id_branch, $get_bulan, $get_tahun);
        $data5 = $this->main_model->status_prog_investasi_berjalan($id_branch);
        $data6 = $this->main_model->status_prog_investasi_belum_berjalan($id_branch);
        $data7 = $this->main_model->posisi_prog_investasi($id_branch);
        $data8 = $this->main_model->kendala_prog_investasi($id_branch);
        $data9 = $this->main_model->gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70);
        $data10 = $this->main_model->gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100);
        $data11 = $this->main_model->gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);
        $data12 = $this->main_model->gauge_meter($id_branch, $get_bulan);
        $data13 = $this->main_model->value_fisik($get_bulan, $id_branch);
        $data14 = $this->main_model->value_program($id_branch);
        $data15 = $this->main_model->value_realisasi($get_bulan, $id_branch, $get_tahun);

        $datasend['data'] = $data;
        $data2->RE = $this->bilangan($data2->RE);
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;
        $datasend['data5'] = $data5;
        $datasend['data6'] = $data6;
        $datasend['data7'] = $data7;
        $datasend['data8'] = $data8;
        $datasend['data9'] = $data9;
        $datasend['data10'] = $data10;
        $datasend['data11'] = $data11;
        $datasend['data12'] = $data12;
        $datasend['data13'] = $data13;
        $datasend['data14'] = $data14;
        $datasend['data15'] = $data15;

        echo json_encode($datasend);
    }

    Public function detail_awal($id_branch) {

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $data = $this->main_model->detail($id_branch);
        $data2 = $this->main_model->realisasi_fisik($id_branch, $get_bulan, $get_tahun);
        $data3 = $this->main_model->kpi_realisasi_program($id_branch);
        $data4 = $this->main_model->kpi_realisasi_fisik($id_branch, $get_bulan, $get_tahun);
        $data5 = $this->main_model->status_prog_investasi_berjalan($id_branch);
        $data6 = $this->main_model->status_prog_investasi_belum_berjalan($id_branch);
        $data7 = $this->main_model->posisi_prog_investasi($id_branch);
        $data8 = $this->main_model->kendala_prog_investasi($id_branch);
        $data9 = $this->main_model->gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70);
        $data10 = $this->main_model->gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100);
        $data11 = $this->main_model->gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);
        $data12 = $this->main_model->gauge_meter($id_branch, $get_bulan);
        $data14 = $this->main_model->value_program($id_branch);
        $data15 = $this->main_model->value_realisasi($get_bulan, $id_branch, $get_tahun);

        $datasend['data'] = $data;
        $data2->RE = $this->bilangan($data2->RE);
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $data4->RE = $this->bilangan($data4->RE);
        $datasend['data4'] = $data4;
        $datasend['data5'] = $data5;
        $datasend['data6'] = $data6;
        $datasend['data7'] = $data7;
        $datasend['data8'] = $data8;
        $datasend['data9'] = $data9;
        $datasend['data10'] = $data10;
        $datasend['data11'] = $data11;
        $datasend['data12'] = $data12;
        $datasend['data14'] = $data14;
        $datasend['data15'] = $data15;

        echo json_encode($datasend);
    }

    public function bilangan($id) {
        $bulat = round($id, 0);
        $jml = strlen($bulat);
        if ($jml == 0) {
            $nh = "0";
        } else if ($jml >= 1 && $jml <= 6) {
            $n = $bulat / 1000;
            $n = round($n, 0);
            $h = " RB";
            $nh = $n . $h;
        } else if ($jml >= 7 && $jml <= 9) {
            $n = $id / 1000000;
            $n = round($n, 0);
            $h = " JT";
            $nh = $n . $h;
        } else if ($jml >= 10 && $jml <= 12) {
            $n = $id / 1000000000;
            $n = round($n, 0);
            $h = " M";
            $nh = $n . $h;
        } else if ($jml >= 13 && $jml <= 15) {
            $n = $id / 1000000000000;
            $n = round($n, 0);
            $h = " T";
            $nh = $n . $h;
        } else if ($jml >= 16 && $jml <= 18) {
            $n = $id / 1000000000000000;
            $n = round($n, 0);
            $h = " KD";
            $nh = $n . $h;
        } else if ($jml >= 19) {
            $n = $id / 1000000000000000000;
            $n = round($n, 0);
            $h = " -";
            $nh = $n . $h;
        }

        return $nh;
    }

    Public function profil($id_branch) {
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function profil_awal($id_branch) {
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function list_investasi($id_branch) {
        $data = $this->main_model->kontrak_kritis($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function kontrak_kritis($id_branch) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');

        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->kontrak_kritis_f($id_branch, $get_tahun, $get_bulan);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function kontrak_kritis_awal($id_branch) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');

        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->kontrak_kritis_f($id_branch, $get_tahun, $get_bulan);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function print_kontrak_kritis($id_branch) {
        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print kontrak kritis',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_kontrak', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kontrak', $datasend, TRUE);
        $html = $sumber;

        $pdfFilePath = "print_dashboard_posisi.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function print_kontrak_kritis_awal($id_branch) {
        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->realisasi_program();

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        // print_r($datasend['data3']); exit();

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print kontrak kritis',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_kontrak', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kontrak', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_posisi.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function list_investasi_posisi($id_branch, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $data = $this->main_model->list_prog_investasi_posisi($id_branch, $posisi, $get_bulan);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_posisi($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function list_investasi_posisi_awal($id_branch, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $data = $this->main_model->list_prog_investasi_posisi($id_branch, $posisi, $get_bulan);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_posisi($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function print_investasi_posisi($id_branch, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $data = $this->main_model->list_prog_investasi_posisi($id_branch, $posisi, $get_bulan);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_posisi($id_branch);
        $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi posisi',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_posisi', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_posisi', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_posisi.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function print_investasi_posisi_awal($id_branch, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $data = $this->main_model->list_prog_investasi_posisi($id_branch, $posisi, $get_bulan);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_posisi($id_branch);
        $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi posisi awal',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_posisi', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_posisi', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_posisi.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    /* status, kendala belum */

    Public function list_investasi_status($id_branch, $status = "") {
        // $cek_status = $this->main_model->cek_status($id_branch);
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function list_investasi_status_awal($id_branch, $status = "") {

        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);


        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function print_investasi_status($id_branch, $status = "") {
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);

        if ($status == 1) {
            $jenis = 'Berjalan';
        } else {
            $jenis = 'Belum Berjalan';
        }

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi status',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_status', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_status', $datasend, TRUE);
        $html = $sumber;

        $pdfFilePath = "print_dashboard_status.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function print_investasi_status_awal($id_branch, $status = "") {
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);
        if ($status == 1) {
            $jenis = 'Berjalan';
        } else {
            $jenis = 'Belum Berjalan';
        }

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi status awal',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_status', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_status', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_status.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function list_investasi_kendala($id_branch, $kendala = "") {
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function list_investasi_kendala_awal($id_branch, $kendala = "") {
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function print_investasi_kendala($id_branch, $kendala = "") {
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);
        $jenis = $data[0]->CONTRAINTS_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi kendala',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_kendala', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kendala', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_kendala.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function print_investasi_kendala_awal($id_branch, $kendala = "") {
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);
        $jenis = $data[0]->CONTRAINTS_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $this->load->view('template/pages/print_dashboard_kendala', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kendala', $datasend, TRUE);
        $html = $sumber;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print investasi kendala awal',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $pdfFilePath = "print_dashboard_kendala.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    /* USER PUSAT */

    Public function pusat_detail($is_pusat) {

        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $data2 = $this->main_model->pusat_realisasi_fisik($is_pusat, $get_bulan, $get_tahun);
        $data3 = $this->main_model->pusat_kpi_realisasi_program($is_pusat);
        $data4 = $this->main_model->pusat_kpi_realisasi_fisik($is_pusat, $get_bulan, $get_tahun);
        $data5 = $this->main_model->pusat_status_prog_investasi_berjalan($is_pusat);
        $data6 = $this->main_model->pusat_status_prog_investasi_belum_berjalan($is_pusat);
        $data7 = $this->main_model->pusat_posisi_prog_investasi($is_pusat);
        $data8 = $this->main_model->pusat_kendala_prog_investasi($is_pusat);
        $data9 = $this->main_model->gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70);
        $data10 = $this->main_model->gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100);
        $data11 = $this->main_model->gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end);
        $data12 = $this->main_model->gauge_meter_p($is_pusat, $get_bulan);
        $data13 = $this->main_model->value_fisik_p($get_bulan, $is_pusat);
        $data14 = $this->main_model->value_program_p($is_pusat);
        $data15 = $this->main_model->value_realisasi_p($get_bulan, $is_pusat, $get_tahun);

        $data2->RE = $this->bilangan($data2->RE);
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;
        $datasend['data5'] = $data5;
        $datasend['data6'] = $data6;
        $datasend['data7'] = $data7;
        $datasend['data8'] = $data8;
        $datasend['data9'] = $data9;
        $datasend['data10'] = $data10;
        $datasend['data11'] = $data11;
        $datasend['data12'] = $data12;
        $datasend['data13'] = $data13;
        $datasend['data14'] = $data14;
        $datasend['data15'] = $data15;

        echo json_encode($datasend);
    }

    Public function pusat_profil($id_branch) {
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function pusat_list_investasi($id_branch) {
        $data = $this->main_model->kontrak_kritis($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function pusat_kontrak_kritis($is_pusat) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');

        $data = $this->main_model->pusat_kontrak_kritis($is_pusat);
        $data2 = $this->main_model->pusat_kontrak_kritis_f($is_pusat, $get_tahun, $get_bulan);
        $data3 = $this->main_model->total_realisasi_program_pusat($is_pusat);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function print_pusat_kontrak_kritis($is_pusat) {
        $data = $this->main_model->pusat_kontrak_kritis($is_pusat);
        $data2 = $is_pusat;
        // $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        // $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print pusat kontrak kritis',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_kontrak_pusat', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kontrak_pusat', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_kontrak_pusat.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function print_pusat_list_investasi_posisi($is_pusat, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->pusat_list_prog_investasi_posisi($is_pusat, $posisi, $get_bulan);
        $data3 = $this->main_model->d_posisi();
        $data2 = $is_pusat;
        $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print pusat list investasi posisi',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_posisi_pusat', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_posisi_pusat', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_posisi_pusat.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function pusat_list_investasi_posisi($is_pusat, $posisi = "") {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->pusat_list_prog_investasi_posisi($is_pusat, $posisi, $get_bulan);
        $data3 = $this->main_model->d_posisi();
        $data4 = $this->main_model->pusat_list_prog_investasi_posisi_f($is_pusat, $posisi, $get_bulan);

        $datasend['data'] = $data;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;

        echo json_encode($datasend);
    }

    Public function print_pusat_list_investasi_status($is_pusat, $status = "") {
        $data = $this->main_model->pusat_list_prog_investasi_status($is_pusat, $status);
        $data3 = $this->main_model->d_status();
        $data2 = $is_pusat;
        if ($status == 1) {
            $jenis = 'Berjalan';
        } else {
            $jenis = 'Belum Berjalan';
        }

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print pusat list investasi status',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_status_pusat', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_status_pusat', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_status_pusat.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
        // print_r($datasend);
    }

    /* status, kendala belum */

    Public function pusat_list_investasi_status($is_pusat, $status = "") {
        $data = $this->main_model->pusat_list_prog_investasi_status($is_pusat, $status);
        $data3 = $this->main_model->d_status();
        $data4 = $this->main_model->pusat_list_prog_investasi_status_f($is_pusat, $status);


        $datasend['data'] = $data;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;

        echo json_encode($datasend);
        // print_r($datasend);
    }

    Public function print_pusat_list_investasi_kendala($is_pusat, $kendala = "") {
        $data = $this->main_model->pusat_list_prog_investasi_kendala($is_pusat, $kendala);
        $data3 = $this->main_model->d_kendala();
        $data2 = $is_pusat;
        $jenis = $data[0]->CONTRAINTS_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print pusat list investasi kendala',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_dashboard_kendala_pusat', $datasend);
        $sumber = $this->load->view('template/pages/print_dashboard_kendala_pusat', $datasend, TRUE);
        $html = $sumber;


        $pdfFilePath = "print_dashboard_kendala_pusat.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    Public function pusat_list_investasi_kendala($is_pusat, $kendala = "") {
        $data = $this->main_model->pusat_list_prog_investasi_kendala($is_pusat, $kendala);
        $data3 = $this->main_model->d_kendala();
        $data4 = $this->main_model->pusat_list_prog_investasi_kendala_f($is_pusat, $kendala);

        $datasend['data'] = $data;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;

        echo json_encode($datasend);
    }

    Public function detail_kendala($id_kendala, $kendala = "") {
        $data = $this->main_model->detail_kendala($id_kendala, $kendala);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_kendala_awal($id_kendala, $kendala = "") {
        $data = $this->main_model->detail_kendala($id_kendala, $kendala);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_status($id_status, $status = "") {
        $data = $this->main_model->detail_status($id_status, $status);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_status_awal($id_status, $status = "") {
        $data = $this->main_model->detail_status($id_status, $status);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_posisi($id_posisi, $posisi = "") {
        $data = $this->main_model->detail_posisi($id_posisi, $posisi);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_posisi_awal($id_posisi, $posisi = "") {
        $data = $this->main_model->detail_posisi($id_posisi, $posisi);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_kontrak($id_kontrak) {
        $data = $this->main_model->kontrak_kritis($id_kontrak);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    // DETAIL GAUGE KRITIS

    Public function d_gauge_kritis_1_p($is_pusat) {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;

        $data = $this->main_model->d_gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_p($is_pusat) {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;

        $data = $this->main_model->d_gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_p($is_pusat) {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_1_all() {
        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1_all($get_bulan, $deviasi_till70);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_all() {
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2_all($get_bulan, $deviasi_till100);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_all() {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3_all($get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_1($id_branch) {
        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2($id_branch) {
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3($id_branch) {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_1_awal($id_branch) {
        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1($id_branch, $get_bulan, $deviasi_till70);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_awal($id_branch) {
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2($id_branch, $get_bulan, $deviasi_till100);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_awal($id_branch) {
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    public function cetakpdf($id) {

        $data['get_cabang_2'] = $this->main_model->get_cabang_2();
        $data['get_gauge_value'] = $this->main_model->get_gauge_value();

        $data['sipil_rkap'] = $this->main_model->sipil_rkap();
        $data['peralatan_rkap'] = $this->main_model->peralatan_rkap();
        $data['non_fisik_rkap'] = $this->main_model->non_fisik_rkap();
        $data['total_report_rkap'] = $this->main_model->total_report_rkap();
        $data['jumlah_sipil_rkap'] = $this->main_model->jumlah_sipil_rkap();
        $data['jumlah_peralatan_rkap'] = $this->main_model->jumlah_peralatan_rkap();
        $data['jumlah_non_sipil_rkap'] = $this->main_model->jumlah_non_sipil_rkap();
        $data['jumlah_total_rkap'] = $this->main_model->jumlah_total_rkap();

        $data['sipil_berjalan'] = $this->main_model->sipil_berjalan();
        $data['peralatan_berjalan'] = $this->main_model->peralatan_berjalan();
        $data['non_fisik_berjalan'] = $this->main_model->non_fisik_berjalan();
        $data['total_report_berjalan'] = $this->main_model->total_report_berjalan();
        $data['jumlah_sipil_berjalan'] = $this->main_model->jumlah_sipil_berjalan();
        $data['jumlah_peralatan_berjalan'] = $this->main_model->jumlah_peralatan_berjalan();
        $data['jumlah_non_sipil_berjalan'] = $this->main_model->jumlah_non_sipil_berjalan();
        $data['jumlah_total_berjalan'] = $this->main_model->jumlah_total_berjalan();

        $data['persentase_berjalan'] = $this->main_model->persentase_berjalan();
        $data['persentase_berjalan_footer'] = $this->main_model->persentase_berjalan_footer();

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user cetak pdf',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/pages/print_fix', $data);
        $sumber = $this->load->view('template/pages/print_kpi_program', $data, TRUE);
        $html = $sumber;


        $pdfFilePath = "report.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');

        $pdf->AddPage('P', 'A4');

        $pdf->WriteHTML($html);

        $pdf->Output();


        exit();
    }

    public function popupindikator1($cabang) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_bulan22 = (int) $date->format('m');
        $data = $this->rkap_model->indikator_yyn2($cabang, $get_bulan22);

        $id = '';
        $stat = '';

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->RKAP_INVS_ID <> $id && $data[$i]->REAL_SUBPRO_STATUS == '1') {

                $datar[] = array('RKAP_INVS_ID' => $data[$i]->RKAP_INVS_ID,
                    'TARGETZ' => $data[$i]->TARGETZ,
                    'RKAP_SUBPRO_TITTLE' => $data[$i]->RKAP_SUBPRO_TITTLE,
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $data[$i]->RKAP_SUBPRO_CONTRACT_VALUE,
                    'REAL_SUBPRO_ID' => $data[$i]->REAL_SUBPRO_ID);

                $id = $data[$i]->RKAP_INVS_ID;
            }
        }

        return $datar;
    }

    public function popupindikator2($cabang) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('m-Y');
        $my = DateTime::createFromFormat('m-Y', $get_bulan)->format('Y-m-d h:i:s');
        $date = new DateTime($my);
        $date->modify('-1 month');
        $mb = $date->format('m-Y');
        $data = $this->rkap_model->indikator_yyn3($cabang, $mb);

        return $data;
    }

    public function cobaget() {
        echo json_encode($_GET);
    }

    public function cobaquery($cabang) {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('m-Y');
        $my = DateTime::createFromFormat('m-Y', $get_bulan)->format('Y-m-d h:i:s');
        $date = new DateTime($my);
        $date->modify('-1 month');
        $mb = $date->format('m-Y');
        $data = $this->rkap_model->indikator_yyn3($cabang, $mb);

        echo json_encode($data);
    }

}
