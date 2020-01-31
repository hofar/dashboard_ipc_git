<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_print extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        $this->load->model('login_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        $this->load->model('Report_model');
        $this->load->model('ews_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $this->load->library('m_pdf');
        $this->load->library('excel');
    }

    Public function print_kontrak_kritis($id_branch){
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

    Public function print_kontrak_kritis_awal($id_branch){
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

    Public function list_investasi_posisi($id_branch, $posisi=""){
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

    Public function list_investasi_posisi_awal($id_branch, $posisi=""){
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

    Public function print_investasi_posisi($id_branch, $posisi=""){
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

    Public function print_investasi_posisi_awal($id_branch, $posisi=""){
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $data = $this->main_model->detail_posisi($id_branch, $posisi);
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

    /*status, kendala belum*/
    Public function list_investasi_status($id_branch, $status=""){
        // $cek_status = $this->main_model->cek_status($id_branch);
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function list_investasi_status_awal($id_branch, $status=""){

        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);


        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

     Public function print_investasi_status($id_branch, $status=""){
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);
       
       if ($status == 1) {
            $jenis = 'Berjalan';
        }else{
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

     Public function print_investasi_status_awal($id_branch, $status=""){
        $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_status($id_branch);
        if ($status == 1) {
            $jenis = 'Berjalan';
        }else{
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


    Public function list_investasi_kendala($id_branch, $kendala=""){
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

    Public function list_investasi_kendala_awal($id_branch, $kendala=""){
        $data = $this->main_model->list_prog_investasi_kendala($id_branch, $kendala);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_kendala($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
    }

      Public function print_investasi_kendala($id_branch, $kendala=""){
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

    Public function print_investasi_kendala_awal($id_branch, $kendala=""){
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

    /*USER PUSAT*/

    Public function pusat_detail($is_pusat){

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

    Public function pusat_profil($id_branch){
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function pusat_list_investasi($id_branch){
        $data = $this->main_model->kontrak_kritis($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function pusat_kontrak_kritis($is_pusat){
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

    Public function print_pusat_kontrak_kritis($is_pusat){
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

    Public function print_pusat_list_investasi_posisi($is_pusat, $posisi=""){
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

    Public function pusat_list_investasi_posisi($is_pusat, $posisi=""){
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

    Public function print_pusat_list_investasi_status($is_pusat, $status=""){
        $data = $this->main_model->pusat_list_prog_investasi_status($is_pusat, $status);
        $data3 = $this->main_model->d_status();
        $data2 = $is_pusat;
        if ($status == 1) {
            $jenis = 'Berjalan';
        }else{
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

    /*status, kendala belum*/
    Public function pusat_list_investasi_status($is_pusat, $status=""){
        $data = $this->main_model->pusat_list_prog_investasi_status($is_pusat, $status);
        $data3 = $this->main_model->d_status();
        $data4 = $this->main_model->pusat_list_prog_investasi_status_f($is_pusat, $status);


        $datasend['data'] = $data;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $data4;

        echo json_encode($datasend);
        // print_r($datasend);
    }


    Public function print_pusat_list_investasi_kendala($is_pusat, $kendala=""){
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


    
}
