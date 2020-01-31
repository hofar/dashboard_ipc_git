<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rkapinvestasi extends CI_Controller {

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
        $this->load->model('rkap_model');
        $this->load->model('log_model');
        $this->load->model('notifikasi_model');
        $this->load->model('realisasi_model');
        $this->load->model('ganttchart_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        $this->load->library('pagination');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $this->data['notif_integrasi'] = $this->notifikasi_model->notifintegrasi();
    }

    public function coba2()
    { 
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = (int)$date->format('m');
        $get_tahun = $date->format('Y');
        $month = $date->format('m');
        //$title,$posisi,$kode,$cabang,$num, $offset
        $data['hasil_persentase'] = $this->rkap_model->sortcustom('','','Banten','',1, 10,1)->result();
        echo json_encode($_SESSION);
        //echo var_dump($this->session->userdata('search1'));
    }

    public function index($page = 0) {
 
        $branch = $this->session->userdata('SESS_USER_BRANCH');
        $this->session->unset_userdata('search1');
        $this->session->unset_userdata('search2');
        $data['groups'] = $this->rkap_model->all_cabang();
        $data['groups3'] = $this->realisasi_model->all_posisi();

        if ( $this->session->userdata('SESS_USER_PRIV') == 1) {

            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
            //pagination
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';

            $config['base_url'] = base_url() . 'rkapinvestasi/index/';
            $config['total_rows'] = count($this->rkap_model->all());
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->all_limit($config['per_page'],$page);

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
        else{

            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B; 
            //paginatioN
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            // print_r($config['total_rows']); exit();
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';

            $config['base_url'] = base_url() . 'rkapinvestasi/index/';
            $config['total_rows'] = count($this->rkap_model->all_percabang($branch));
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->branch_limit($branch,$config['per_page'],$page);
            
            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
    }

    public function search1($page = 1)
    {
        $this->session->unset_userdata('search2');
        if ($this->uri->segment(3) != 'page') {
            $_SESSION['search1'] = array('title' => $this->input->post('title'),
                                     'kode'=> $this->input->post('kode'),
                                     'cabang' => $this->input->post('cabang'),
                                     'posisi' => $this->input->post('posisi'));
        }

        $var1 = isset($_SESSION['search1']['title']) ? $_SESSION['search1']['title'] : '';
        $var2 = isset($_SESSION['search1']['kode']) ? $_SESSION['search1']['kode'] : '';
        
        $var4 = isset($_SESSION['search1']['posisi']) ? $_SESSION['search1']['posisi'] : '';
        $branch = $this->session->userdata('SESS_USER_BRANCH');
        $data['groups'] = $this->rkap_model->all_cabang();
        $data['groups3'] = $this->realisasi_model->all_posisi();
        if ( $this->session->userdata('SESS_USER_PRIV') == 1) {
            $var3 = isset($_SESSION['search1']['cabang']) ? $_SESSION['search1']['cabang'] : '';
            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
            //pagination
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            
             
            if ($this->uri->segment(4) == NULL) {
                $num1 = 1;
                $num2 = 10;
            }else{
                $num1 = $this->uri->segment(4) + 1;
                $num2 = $this->uri->segment(4) + 10;
            }
            $config['base_url'] = base_url() . 'rkapinvestasi/search1/page/';
            $config['total_rows'] = $this->rkap_model->searchcustom2_count($var1,$var2,$var3,$var4);
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->searchcustom2($var1,$var2,$var3,$var4,$num1,$num2);

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
        else{

            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B; 
            //paginatioN
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            // print_r($config['total_rows']); exit();
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            if ($this->uri->segment(4) == NULL) {
                $num1 = 1;
                $num2 = 10;
            }else{
                $num1 = $this->uri->segment(4) + 1;
                $num2 = $this->uri->segment(4) + 10;
            }
            $var3 = $this->session->userdata('SESS_USER_NAME');
            $config['base_url'] = base_url() . 'rkapinvestasi/search1/page/';
            $config['total_rows'] = $this->rkap_model->searchcustom2_count($var1,$var2,$var3,$var4);
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->searchcustom2($var1,$var2,$var3,$var4,$num1,$num2);

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
        
    }
    public function search2()
    {
        if ($this->uri->segment(3) != 'page') {

            $_SESSION['search1'] = array('title' => $this->input->post('title'),
                                     'kode'=> $this->input->post('kode'),
                                     'cabang' => $this->input->post('cabang'),
                                     'posisi' => $this->input->post('posisi'));

            $_SESSION['search2'] = array('sort_cabang' => $this->input->post('sort_cabang'),
                                     'kebutuhan'=> $this->input->post('kebutuhan'),
                                     'rkap' => $this->input->post('rkap'));
        }

        //$var1 = isset($_SESSION['search1']['title']) ? $_SESSION['search1']['title'] : ' ';
        if (isset($_SESSION['search1']['title'])) {
            $var1 = $_SESSION['search1']['title'];
        }else if($_SESSION['search2']['sort_cabang'] != "-"){
            $var1 = '';
        }else{
            $var1 = ' ';
        }
        $var2 = isset($_SESSION['search1']['kode']) ? $_SESSION['search1']['kode'] : '';
        $var4 = isset($_SESSION['search1']['posisi']) ? $_SESSION['search1']['posisi'] : '';

        if (isset($_SESSION['search2']['kebutuhan'])) {
            $var5 = $_SESSION['search2']['kebutuhan'];
        }else if(isset($_SESSION['search2']['rkap'])){
            $var5 = $_SESSION['search2']['rkap'];
        }else{
            $var5 = "";
        }
        $branch = $this->session->userdata('SESS_USER_BRANCH');
        $data['groups'] = $this->rkap_model->all_cabang();
        $data['groups3'] = $this->realisasi_model->all_posisi();
        if ( $this->session->userdata('SESS_USER_PRIV') == 1) {
            
            if (isset($_SESSION['search1']['cabang'])) {
                $var3 = $_SESSION['search1']['cabang'];
            }else if($_SESSION['search2']['sort_cabang'] != '-'){
                $var3 = $_SESSION['search2']['sort_cabang'];
            }else{
                $var3 = "";
            }

            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
            //pagination
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            
             
            if ($this->uri->segment(4) == NULL) {
                $num1 = 1;
                $num2 = 10;
            }else{
                $num1 = $this->uri->segment(4) + 1;
                $num2 = $this->uri->segment(4) + 10;
            }
            $config['base_url'] = base_url() . 'rkapinvestasi/search2/page/';

            $config['total_rows'] = $this->rkap_model->sortcustom($var1,$var2,$var3,$var4,$num1,$num2,$var5)->num_rows();
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->sortcustom($var1,$var2,$var3,$var4,$num1,$num2,$var5)->result();
            
            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
        else{

            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $get_bulan = $date->format('Y-m');
            $get_bulan22 = (int)$date->format('m');
            $get_tahun = $date->format('Y');
            $month = $date->format('m');

            $get_bulan2 = date("m", strtotime("-1 month", strtotime(date("F") . "1")) );
            $get_bulan_ini2 = $date->format('m');
            $data['list2'] = $this->rkap_model->bulan_sebelumnya($get_bulan);
            $data['list3'] = $this->rkap_model->bulan_ini($get_bulan);
            $data['list4'] = $this->rkap_model->sampai_bulan_ini($get_bulan);
            $data['hasil_sd_bulan_ini'] = $this->rkap_model->hasil_sd_bulan_ini($get_bulan);
            $data['hasil_rencana_sd_bulan_ini'] = $this->rkap_model->hasil_rencana_sd_bulan_ini($get_bulan);
            $data['hasil_persentase'] = $this->rkap_model->indikator_yyn('060',$get_bulan22);
            $data['get_previous_month'] = $this->rkap_model->get_previous_month($get_bulan2);
            $data['get_month'] = $this->rkap_model->get_month($get_bulan);
            $data['get_until_this_month'] = $this->rkap_model->get_month($get_bulan);
            $data['deviasi_till70'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
            $data['deviasi_till100'] = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
            //pagination
            $config['per_page'] = 10;
            $config['num_links'] = 4 ;
            // $config['uri_segment'] = 5;
            //Tambahan untuk styling
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tag_close']  = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            
             
            if ($this->uri->segment(4) == NULL) {
                $num1 = 1;
                $num2 = 10;
            }else{
                $num1 = $this->uri->segment(4) + 1;
                $num2 = $this->uri->segment(4) + 10;
            }
            $config['base_url'] = base_url() . 'rkapinvestasi/search2/page/';
            $var3 = $this->session->userdata('SESS_USER_NAME');
            $config['total_rows'] = $this->rkap_model->sortcustom($var1,$var2,$var3,$var4,$num1,$num2,$var5)->num_rows();
            $this->pagination->initialize($config);
            $data['halaman'] = $this->pagination->create_links();
            $data['list'] = $this->rkap_model->sortcustom($var1,$var2,$var3,$var4,$num1,$num2,$var5)->result();
            
            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewrkapinvestasi', $data);
            $this->load->view('template/global/footer');
        }
    }
    public function add() {

        $this->form_validation->set_rules('judul_investasi', 'Judul Investasi', 'required');
        $this->form_validation->set_rules('project_number', 'Project Number', 'required');
        $this->form_validation->set_rules('jenis_aktiva', 'Jenis Aktiva', 'required');
        $this->form_validation->set_rules('jenis_investasi', 'Jenis Investasi', 'required');
        $this->form_validation->set_rules('tahun_investasi', 'Tahun Investasi', 'required');
        $this->form_validation->set_rules('kebutuhan_dana', 'Kebutuhan Dana', 'required');
        $this->form_validation->set_rules('nilai_rkap', 'Nilai RKAP', 'required');
        $this->form_validation->set_rules('triwulan_satu', 'Triwulanan I', 'required');
        $this->form_validation->set_rules('triwulan_dua', 'Triwulanan II', 'required');
        $this->form_validation->set_rules('triwulan_tiga', 'Triwulanan III', 'required');
        $this->form_validation->set_rules('triwulan_empat', 'Triwulan IV', 'required');
        $this->form_validation->set_rules('realisasi_sebelum', 'Realisasi Sebelum', 'required');
        $this->form_validation->set_rules('taksasi', 'Taksasi', 'required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'required');


        if ($this->form_validation->run() === FALSE) {

            $data['groups1'] = $this->rkap_model->all_aktiva();
            $data['groups2'] = $this->rkap_model->all_investasi();
            $data['groups3'] = $this->realisasi_model->all_posisi();
            $data['act'] = 'add';

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/addrkapinvestasi', $data);
        } else {

            $judul_investasi = $this->input->post('judul_investasi');
            $project_number = $this->input->post('project_number');
            $jenis_aktiva = $this->input->post('jenis_aktiva');
            $jenis_investasi = $this->input->post('jenis_investasi');
            $tahun_investasi = $this->input->post('tahun_investasi');
            $posisi = $this->input->post('posisi');
            $user_id = $this->session->userdata('SESS_USER_ID');

            $kebutuhan_dana_set = $this->input->post('kebutuhan_dana');
            $kebutuhan_dana1 = str_replace('.','',$kebutuhan_dana_set);
            $kebutuhan_dana = str_replace(',','.',$kebutuhan_dana1);

            $nilai_rkap_set = $this->input->post('nilai_rkap');
            $nilai_rkap1 = str_replace('.','',$nilai_rkap_set);
            $nilai_rkap = str_replace(',','.',$nilai_rkap1);
            
            $triwulan_satu_set = $this->input->post('triwulan_satu');
            $triwulan_satu1 = str_replace('.','',$triwulan_satu_set);
            $triwulan_satu = str_replace(',','.',$triwulan_satu1);

            $triwulan_dua_set = $this->input->post('triwulan_dua');
            $triwulan_dua1 = str_replace('.','',$triwulan_dua_set);
            $triwulan_dua = str_replace(',','.',$triwulan_dua1);

            $triwulan_tiga_set = $this->input->post('triwulan_tiga');
            $triwulan_tiga1 = str_replace('.','',$triwulan_tiga_set);
            $triwulan_tiga = str_replace(',','.',$triwulan_tiga1);

            $triwulan_empat_set = $this->input->post('triwulan_empat');
            $triwulan_empat1 = str_replace('.','',$triwulan_empat_set);
            $triwulan_empat = str_replace(',','.',$triwulan_empat1);
            
            $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
            $realisasi_sebelum1 = str_replace('.','',$realisasi_sebelum_set);
            $realisasi_sebelum = str_replace(',','.',$realisasi_sebelum1);

            $taksasi_set = $this->input->post('taksasi');
            $taksasi1= str_replace('.','',$taksasi_set);
            $taksasi = str_replace(',','.',$taksasi1);

            $data = array(
                'RKAP_INVS_ID' => '1',
                'RKAP_INVS_TITLE' => $judul_investasi,
                'RKAP_INVS_PROJECT_NUMBER' => $project_number,
                'RKAP_INVS_ASSETS' => $jenis_aktiva,
                'RKAP_INVS_TYPE' => $jenis_investasi,
                'RKAP_INVS_YEAR' => $tahun_investasi,
                'RKAP_INVS_COST_REQ' => $kebutuhan_dana,
                'RKAP_INVS_VALUE' => $nilai_rkap,
                'RKAP_INVS_QUARTER_I' => $triwulan_satu,
                'RKAP_INVS_QUARTER_II' => $triwulan_dua,
                'RKAP_INVS_QUARTER_III' => $triwulan_tiga,
                'RKAP_INVS_QUARTER_IV' => $triwulan_empat,
                'RKAP_INVS_REAL_BEFORE' => $realisasi_sebelum,
                'RKAP_INVS_TAKSASI' => $taksasi,
                'RKAP_INVS_USER_ID' => $user_id,
                'RKAP_INVS_POS' => $posisi,
                'ON_USE' => 'Y'
            );
            $data2 = $data;
            unset($data2['RKAP_INVS_ID']);
            if ($this->rkap_model->add($data)) {

                $id_last = $this->rkap_model->select_id_user($data2)->RKAP_INVS_ID;
                $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

                $data7 = array(
                        'RKAP_INVS_ID' =>  $id_last,
                        'LAST_UPDATE' => $date->format('d-M-y')
                        
                    );

                $this->notifikasi_model->add($data7);

                $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user add rkap investasi',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data RKAP investasi berhasil ditambahkan');

                redirect(base_url('Rkapinvestasi'));
            } else {

                $this->session->set_flashdata('message', 'Data RKAP investasi gagal ditambahkan');

                redirect(base_url('Rkapinvestasi/add'));
            }
        }
    }

    public function detail($id) {
        $data['groups1'] = $this->rkap_model->all_aktiva();
        $data['groups2'] = $this->rkap_model->all_investasi();
        $data['groups3'] = $this->realisasi_model->all_posisi();
        $data['list'] = $this->rkap_model->detail($id)[0];
        $data['act'] = 'detail';

        $data['report'] = $this->ganttchart_model->tampilganttchartnew($id);
        
        $data['ganttaddendum'] = $this->ganttchart_model->ganttchartaddendum($id);
        
        $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user detail rkap investasi',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

        $this->log_model->add($data4);

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/addrkapinvestasi', $data);
    }

    public function update($id)
    {
        $data_rkap = $this->rkap_model->find($id);


        if ($data_rkap) {

            $this->form_validation->set_rules('judul_investasi', 'Judul Investasi', 'required');
            $this->form_validation->set_rules('project_number', 'Project Number', 'required');
            $this->form_validation->set_rules('jenis_aktiva', 'Jenis Aktiva', 'required');
            $this->form_validation->set_rules('jenis_investasi', 'Jenis Investasi', 'required');
            $this->form_validation->set_rules('tahun_investasi', 'Tahun Investasi', 'required');
            $this->form_validation->set_rules('kebutuhan_dana', 'Kebutuhan Dana', 'required');
            $this->form_validation->set_rules('nilai_rkap', 'Nilai RKAP', 'required');
            $this->form_validation->set_rules('triwulan_satu', 'Triwulanan I', 'required');
            $this->form_validation->set_rules('triwulan_dua', 'Triwulanan II', 'required');
            $this->form_validation->set_rules('triwulan_tiga', 'Triwulanan III', 'required');
            $this->form_validation->set_rules('triwulan_empat', 'Triwulan IV', 'required');
            $this->form_validation->set_rules('realisasi_sebelum', 'Realisasi Sebelum', 'required');
            $this->form_validation->set_rules('taksasi', 'Taksasi', 'required');
            $this->form_validation->set_rules('posisi', 'Posisi', 'required');

            if ($this->form_validation->run() === FALSE) {

                $data['groups1'] = $this->rkap_model->all_aktiva();
                $data['groups2'] = $this->rkap_model->all_investasi();
                $data['groups3'] = $this->realisasi_model->all_posisi();
                $data['list'] = $this->rkap_model->detail($id)[0];
                $data['act'] = 'edit';
                $data['report'] = $this->ganttchart_model->tampilganttchartnew($id);

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/addrkapinvestasi', $data);

            } else {

                $judul_investasi = $this->input->post('judul_investasi');
                $project_number = $this->input->post('project_number');
                $jenis_aktiva = $this->input->post('jenis_aktiva');
                $jenis_investasi = $this->input->post('jenis_investasi');
                $tahun_investasi = $this->input->post('tahun_investasi');
                $kebutuhan_dana_set = $this->input->post('kebutuhan_dana');
                $kebutuhan_dana1 = str_replace('.', '', $kebutuhan_dana_set);
                $kebutuhan_dana = str_replace(',', '.', $kebutuhan_dana1);

                $nilai_rkap_set = $this->input->post('nilai_rkap');
                $nilai_rkap1 = str_replace('.', '', $nilai_rkap_set);
                $nilai_rkap = str_replace(',', '.', $nilai_rkap1);

                $triwulan_satu_set = $this->input->post('triwulan_satu');
                $triwulan_satu1 = str_replace('.', '', $triwulan_satu_set);
                $triwulan_satu = str_replace(',', '.', $triwulan_satu1);

                $triwulan_dua_set = $this->input->post('triwulan_dua');
                $triwulan_dua1 = str_replace('.', '', $triwulan_dua_set);
                $triwulan_dua = str_replace(',', '.', $triwulan_dua1);

                $triwulan_tiga_set = $this->input->post('triwulan_tiga');
                $triwulan_tiga1 = str_replace('.', '', $triwulan_tiga_set);
                $triwulan_tiga = str_replace(',', '.', $triwulan_tiga1);

                $triwulan_empat_set = $this->input->post('triwulan_empat');
                $triwulan_empat1 = str_replace('.', '', $triwulan_empat_set);
                $triwulan_empat = str_replace(',', '.', $triwulan_empat1);

                $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                $realisasi_sebelum1 = str_replace('.', '', $realisasi_sebelum_set);
                $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum1);

                $taksasi_set = $this->input->post('taksasi');
                $taksasi1 = str_replace('.', '', $taksasi_set);
                $taksasi = str_replace(',', '.', $taksasi1);
                $user_id = $this->session->userdata('SESS_USER_ID');
                 $posisi = $this->input->post('posisi');

                $data = array(
                    'RKAP_INVS_TITLE' => $judul_investasi,
                    'RKAP_INVS_PROJECT_NUMBER' => $project_number,
                    'RKAP_INVS_ASSETS' => $jenis_aktiva,
                    'RKAP_INVS_TYPE' => $jenis_investasi,
                    'RKAP_INVS_YEAR' => $tahun_investasi,
                    'RKAP_INVS_COST_REQ' => $kebutuhan_dana,
                    'RKAP_INVS_VALUE' => $nilai_rkap,
                    'RKAP_INVS_QUARTER_I' => $triwulan_satu,
                    'RKAP_INVS_QUARTER_II' => $triwulan_dua,
                    'RKAP_INVS_QUARTER_III' => $triwulan_tiga,
                    'RKAP_INVS_QUARTER_IV' => $triwulan_empat,
                    'RKAP_INVS_REAL_BEFORE' => $realisasi_sebelum,
                    'RKAP_INVS_TAKSASI' => $taksasi,
                    'RKAP_INVS_USER_ID' => $user_id,
                    'RKAP_INVS_POS' => $posisi
                );

                if ($this->rkap_model->update($id, $data)) {


                $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

                $data7 = array(
                        'RKAP_INVS_ID' =>  $id,
                        'LAST_UPDATE' => $date->format('d-M-y')
                        
                    );

                    $this->notifikasi_model->add($data7);

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update rkap investasi',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data RKAP investasi berhasil diubah');

                    redirect(base_url('rkapinvestasi'));
                } else {

                    $this->session->set_flashdata('message', 'Data RKAP investasi berhasil diubah');

                    redirect(base_url('rkapinvestasi/update' . $id));
                }
            }
        } else {

           redirect(base_url('rkapinvestasi'));
        }
    }

    public function delete_modal($id)
    {
        
        $data['list']= $this->rkap_model->find($id);
        
        $this->load->view('template/pages/delete_rkap_modal', $data);
    }

    public function delete($id)
      {
        $delete_rkap = $this->rkap_model->find($id);

        if ($delete_rkap) {
            $data = array(
            'IS_DELETED' => 1
            );

          if ($this->rkap_model->delete($id, $data)) {

            $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user delete rkap investasi',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                $this->log_model->add($data4);

            $this->session->set_flashdata('success', 'Data ' . $delete_rkap->RKAP_INVS_TITLE . ' berhasil di hapus');

            redirect(base_url('rkapinvestasi'));
          } else {

            $this->session->set_flashdata('fail', 'data gagal di hapus');

            redirect(base_url('rkapinvestasi'));
          }

        } else {
          redirect(base_url('rkapinvestasi'));
        }
      }

     public function GetContractNumber(){

        $get_number = $this->input->post('nomor_kontrak');
        $check_number = $this->rkap_model->get_contract($get_number);

        if ($get_number == $check_number[0]->RKAP_INVS_PROJECT_NUMBER) {
            
            echo json_encode("ada");
        }
        else{
            echo json_encode("tidak");
        }
        
    }

    public function insert_before($id)
    {
        $this->load->library('upload');

        $nmfile = $this->input->post('filefoto_before'); 
        $filename = "picturebefore_".$id;
        $config['upload_path'] = './uploads/before/'; 
        $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
        $config['max_size'] = '5000';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;
 
        $this->upload->initialize($config);
         
        if($_FILES['filefoto_before']['name'])
        {
            if ($this->upload->do_upload('filefoto_before'))
            {   
                // $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                $gbr = $this->upload->data();
                $data = array(
                    // 'UPLOADED_BEFORE' => $date->format('Y-m-d H:i:s'),
                    'IS_UPLOADED_BEFORE' => 1,
                    'PICTURE_BEFORE' => $gbr['file_name']
                    
                );
                // print_r($this->session->userdata('SESS_USER_ID')); die();
                $this->rkap_model->get_insert_before($data,$id);
                
                // $this->session->set_userdata('SESS_PEGAWAI_PICTURE_USER',$gbr['file_name']);

                $this->session->set_flashdata('success', 'Upload foto berhasil');

                redirect('rkapinvestasi/update/' . $id); 
            }else{
                $this->session->set_flashdata('fail', 'Maaf, foto tidak dapat diunggah, silahkan ulangi kembali');

                redirect('rkapinvestasi/update/' . $id);
            }
        }
    } 

    public function insert_after($id)
    {   
        $img_link = $this->rkap_model->find($id)->PICTURE_AFTER;

        if ($img_link == 'no_image.jpg') {
               
               $this->load->library('upload');

                $nmfile = $this->input->post('filefoto_after'); 
                $filename = "pictureafter_".$id;
                $config['upload_path'] = './uploads/after/'; 
                $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
                $config['max_size'] = '5000';
                $config['overwrite'] = true;
                $config['file_name'] = $filename;
         
                $this->upload->initialize($config);
                 
                if($_FILES['filefoto_after']['name'])
                {
                    if ($this->upload->do_upload('filefoto_after'))
                    {   
                        // $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                        $gbr = $this->upload->data();
                        $data = array(
                            // 'UPLOADED_BEFORE' => $date->format('Y-m-d H:i:s'),
                            // 'IS_UPLOADED_BEFORE' => 1,
                            'PICTURE_AFTER' => $gbr['file_name']
                            
                        );
                        // print_r($this->session->userdata('SESS_USER_ID')); die();
                        $this->rkap_model->get_insert_after($data,$id);
                        
                        // $this->session->set_userdata('SESS_PEGAWAI_PICTURE_USER',$gbr['file_name']);

                        $this->session->set_flashdata('success', 'Upload foto berhasil');

                        redirect('rkapinvestasi/update/' . $id); 
                    }else{
                        $this->session->set_flashdata('fail', 'Maaf, foto tidak dapat diunggah, silahkan ulangi kembali');

                        redirect('rkapinvestasi/update/' . $id);
                    }
                }
        }else{

                if(unlink($_SERVER["DOCUMENT_ROOT"].'/ipc.dashboard.realisasi/uploads/after/'.$img_link)){

                    $this->load->library('upload');

                    $nmfile = $this->input->post('filefoto_after'); 
                    $filename = "pictureafter_".$id;
                    $config['upload_path'] = './uploads/after/'; 
                    $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
                    $config['max_size'] = '5000';
                    $config['overwrite'] = true;
                    $config['file_name'] = $filename;
             
                    $this->upload->initialize($config);
                     
                    if($_FILES['filefoto_after']['name'])
                    {
                        if ($this->upload->do_upload('filefoto_after'))
                        {   
                            // $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                            $gbr = $this->upload->data();
                            $data = array(
                                // 'UPLOADED_BEFORE' => $date->format('Y-m-d H:i:s'),
                                // 'IS_UPLOADED_BEFORE' => 1,
                                'PICTURE_AFTER' => $gbr['file_name']
                                
                            );
                            // print_r($this->session->userdata('SESS_USER_ID')); die();
                            $this->rkap_model->get_insert_after($data,$id);
                            
                            // $this->session->set_userdata('SESS_PEGAWAI_PICTURE_USER',$gbr['file_name']);

                            $this->session->set_flashdata('success', 'Upload foto berhasil');

                            redirect('rkapinvestasi/update/' . $id); 
                        }else{
                            $this->session->set_flashdata('fail', 'Maaf, foto tidak dapat diunggah, silahkan ulangi kembali');

                            redirect('rkapinvestasi/update/' . $id);
                        }
                    }
                } 
            }
    }
        

}
