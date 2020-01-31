<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

        $this->load->model('login_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
           $this->load->library('m_pdf');
    }

    public function index() {
        // $id_branch = $this->session->userdata('SESS_USER_BRANCH');
        // $status = 1;
        // $data = $this->main_model->list_prog_investasi_status($id_branch, $status);
        // print_r($data); die();
        $data['notif_announcement']= $this->announcement_model->cek_notif();
        $branch = $this->session->userdata('SESS_USER_BRANCH');
        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user view home',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                // echo json_encode($data4); exit();
        $this->log_model->add($data4);
        $this->data['get_cabang'] = $this->main_model->get_cabang();
        $this->data['get_gauge_value'] = $this->main_model->get_gauge_value();

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/home_index',$data);
        $this->load->view('template/global/footer');
    }


    Public function detail_all(){

        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');

        // $data = $this->main_model->detail();
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
        $data12 = $this->main_model->gauge_meter_all();

        // $datasend['data'] = $data;
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

        echo json_encode($datasend);
    }

   Public function detail($id_branch){

        // deklarasi tanggal
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
        $data12 = $this->main_model->gauge_meter($id_branch);

        $datasend['data'] = $data;
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

        echo json_encode($datasend);
    }

    Public function detail_awal($id_branch){

        // deklarasi tanggal
        // print_r($id_branch); die();
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
        $data12 = $this->main_model->gauge_meter($id_branch);

        $datasend['data'] = $data;
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

        echo json_encode($datasend);
    }

    Public function profil($id_branch){
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

     Public function profil_awal($id_branch){
        $data = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function list_investasi($id_branch){
        $data = $this->main_model->kontrak_kritis($id_branch);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function kontrak_kritis($id_branch){
        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;

        echo json_encode($datasend);
    }

     Public function kontrak_kritis_awal($id_branch){
        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;

        echo json_encode($datasend);
    }

    Public function print_kontrak_kritis($id_branch){
        $data = $this->main_model->kontrak_kritis($id_branch);
        $data2 = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        // $id = $id_branch;
        // print_r($id); die();
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

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        // $id = $id_branch;
        // print_r($id); die();
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
        $data = $this->main_model->list_prog_investasi_posisi($id_branch, $posisi, $get_bulan);
        $data2 = $this->main_model->detail($id_branch);
        $data3 = $this->main_model->d_posisi($id_branch);
        $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        $datasend['data3'] = $data3;
        $datasend['data4'] = $jenis;

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

         // print_r($datasend['data4']); die();

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
        $data12 = $this->main_model->gauge_meter_p($is_pusat);

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
        $data = $this->main_model->pusat_kontrak_kritis($is_pusat);
        // $data2 = $this->main_model->detail($id_branch);

        $datasend['data'] = $data;
        // $datasend['data2'] = $data2;

        echo json_encode($datasend);
    }

    Public function print_pusat_kontrak_kritis($is_pusat){
        $data = $this->main_model->pusat_kontrak_kritis($is_pusat);
        $data2 = $is_pusat;
        // $jenis = $data[0]->POSPROG_NAME;

        $datasend['data'] = $data;
        $datasend['data2'] = $data2;
        // $datasend['data4'] = $jenis;

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

        $datasend['data'] = $data;
        $datasend['data3'] = $data3;

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

         // print_r($datasend['data4']); die();

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


        $datasend['data'] = $data;
        $datasend['data3'] = $data3;

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
        // print_r($datasend);
    }


    Public function pusat_list_investasi_kendala($is_pusat, $kendala=""){
        $data = $this->main_model->pusat_list_prog_investasi_kendala($is_pusat, $kendala);
        $data3 = $this->main_model->d_kendala();

        $datasend['data'] = $data;
        $datasend['data3'] = $data3;

        echo json_encode($datasend);
        // print_r($datasend);
    }
    

    Public function detail_kendala($id_kendala, $kendala=""){
        $data = $this->main_model->detail_kendala($id_kendala, $kendala);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_kendala_awal($id_kendala, $kendala=""){
        $data = $this->main_model->detail_kendala($id_kendala, $kendala);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_status($id_status, $status=""){
        $data = $this->main_model->detail_status($id_status, $status);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

     Public function detail_status_awal($id_status, $status=""){
        $data = $this->main_model->detail_status($id_status, $status);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_posisi($id_posisi, $posisi=""){
        $data = $this->main_model->detail_posisi($id_posisi, $posisi);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

     Public function detail_posisi_awal($id_posisi, $posisi=""){
        $data = $this->main_model->detail_posisi($id_posisi, $posisi);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function detail_kontrak($id_kontrak){
        $data = $this->main_model->detail_kontrak($id_kontrak);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    // DETAIL GAUGE KRITIS

    Public function d_gauge_kritis_1_p($is_pusat){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;

        $data = $this->main_model->d_gauge_kritis_1_p($is_pusat, $get_bulan, $deviasi_till70);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_p($is_pusat){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;

        $data = $this->main_model->d_gauge_kritis_2_p($is_pusat, $get_bulan, $deviasi_till100);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_p($is_pusat){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3_p($is_pusat, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }
    
    Public function d_gauge_kritis_1_all(){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1_all($get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_all(){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2_all($get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_all(){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3_all($get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_1($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1($id_branch, $get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2($id_branch, $get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

     Public function d_gauge_kritis_1_awal($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_1($id_branch, $get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_2_awal($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');

        $data = $this->main_model->d_gauge_kritis_2($id_branch, $get_bulan);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }

    Public function d_gauge_kritis_3_awal($id_branch){
        // deklarasi tanggal
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_kontrak_end = $date->format('Y-m-d');

        $data = $this->main_model->d_gauge_kritis_3($id_branch, $get_bulan, $get_kontrak_end);

        $datasend['data'] = $data;

        echo json_encode($datasend);
    }
}
