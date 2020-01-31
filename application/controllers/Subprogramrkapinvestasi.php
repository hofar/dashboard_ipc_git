<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subprogramrkapinvestasi extends CI_Controller {

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
        $this->load->model('subprogramrkap_model');
        $this->load->model('log_model');
        $this->load->model('risiko_model');
        $this->load->model('rkap_model');
        $this->load->model('main_model');
        $this->load->model('kurva_model');
        $this->load->model('realisasi_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function view($id) {

        $data['groups'] = $this->subprogramrkap_model->all_cabang();
        $data['list'] = $this->subprogramrkap_model->all($id);
        $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id);
        $data['list_rkap'] = $this->rkap_model->detail($id)[0];

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view sub program rkap',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );
        $this->log_model->add($data4);

        $this->form_validation->set_rules('title', 'search title', 'trim');
        $this->form_validation->set_rules('kode', 'search kode', 'trim');

        if ($this->form_validation->run() === FALSE) {

            $this->session->unset_userdata('title');
            $this->session->unset_userdata('kode');
            $this->session->unset_userdata('cabang');

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewsubprogramrkap', $data);
            $this->load->view('template/global/footer');
        } else {
            $title = $this->input->POST('title');
            $kode = $this->input->POST('kode');
            $cabang = $this->input->POST('cabang');

            $this->session->set_flashdata('title', $this->input->post('title'));
            $this->session->set_flashdata('kode', $this->input->post('kode'));
            $this->session->set_flashdata('cabang', $this->input->post('cabang'));

            if ($title != null && $kode == null && $cabang == null) {
                $key = $this->subprogramrkap_model->search_title($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $kode != null && $cabang == null) {
                $key = $this->subprogramrkap_model->search_kode($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $kode == null && $cabang != null) {
                $key = $this->subprogramrkap_model->search_cabang($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $kode != null && $cabang == null) {
                $key = $this->subprogramrkap_model->search_title_kode($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $kode == null && $cabang != null) {
                $key = $this->subprogramrkap_model->search_title_cabang($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title == null && $kode != null && $cabang != null) {
                $key = $this->subprogramrkap_model->search_kode_cabang($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } elseif ($title != null && $kode != null && $cabang != null) {
                $key = $this->subprogramrkap_model->search_title_kode_cabang($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            } else {
                $key = $this->subprogramrkap_model->search_title_kode_cabang($id);
                $data['list'] = $key;

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/viewsubprogramrkap', $data);
                $this->load->view('template/global/footer');
            }
        }
    }

    public function add($id) {

        $this->form_validation->set_rules('judul_sub_program', 'Judul Sub program', 'required');

        if ($this->form_validation->run() === FALSE) {

            $data['list_rkap'] = $this->rkap_model->detail($id)[0];
            $data['groups'] = $this->subprogramrkap_model->all_jenis_subprogram();
            $data['list'] = $this->subprogramrkap_model->all($id);
            $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id)[0]['RKAP_VAL'];
            $data['get_auto'] = $this->subprogramrkap_model->GetRow();
            $data['groups2'] = $this->rkap_model->all_investasi();
            $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id);
            $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
            $data['serial'] = $this->risiko_model->find_serial($id);
            
            $data['resutl_all_month_adden'] = $this->kurva_model->find_all_month_adden($id);
            $data['resutl_all_month_non_adden'] = $this->kurva_model->find_all_month_non_adden($id);
            // $data['cek_addendum'] = $this->kurva_model->cek_addendum($id);
            // $data['cek_addendum2'] = $this->kurva_model->cek_addendum2($id);
            // $data['cek_addendum3'] = $this->kurva_model->cek_addendum3($id);
            // $data['cek_addendum4'] = $this->kurva_model->cek_addendum4($id);
            // $data['cek_addendum5'] = $this->kurva_model->cek_addendum5($id);
            // $data['value'] = $this->subprogramrkap_model->tampilvalue($id);
            $data['cek_urutan'] = $this->kurva_model->find_all_month_adden($id);
            $data['realisasi'] = $this->realisasi_model->all_realisasi_program($id);
            $data['act'] = 'add';
            $data['find'] = $this->risiko_model->find_print($id);

            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/addsubprogramrkap', $data);
        } else {

            if ($this->input->post('tgl_kontrak') == null) {

                $judul_sub_program = $this->input->post('judul_sub_program');
                $jenis_sub_program = $this->input->post('jenis_sub_program');
                $no_kontrak = $this->input->post('no_kontrak');
                $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                $jangka_waktu = $this->input->post('jangka_waktu');
                $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');

                $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);

                $data = array(
                    'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                    'RKAP_SUBPRO_INVS_ID' => $id,
                    'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                    'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                    'RKAP_SUBPRO_CONTRACT_DATE' => null,
                    'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                    'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                    'RKAP_SUBPRO_ENDOF_GUARANTEE' => $tgl_berakhir_jaminan,
                    'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                    'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                );

            }
            elseif ($this->input->post('tgl_berakhir_jaminan') == null) {

                $judul_sub_program = $this->input->post('judul_sub_program');
                $jenis_sub_program = $this->input->post('jenis_sub_program');
                $no_kontrak = $this->input->post('no_kontrak');
                $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                $jangka_waktu = $this->input->post('jangka_waktu');
                $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');

                $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                    $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);

                $data = array(
                    'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                    'RKAP_SUBPRO_INVS_ID' => $id,
                    'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                    'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                    'RKAP_SUBPRO_CONTRACT_DATE' => $tgl_kontrak,
                    'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                    'RKAP_SUBPRO_END_REAL' => $tgl_end_real,
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                    'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                    'RKAP_SUBPRO_ENDOF_GUARANTEE' => null,
                    'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                    'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                );

            }
            else{
                $judul_sub_program = $this->input->post('judul_sub_program');
                $jenis_sub_program = $this->input->post('jenis_sub_program');
                $no_kontrak = $this->input->post('no_kontrak');
                $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                $jangka_waktu = $this->input->post('jangka_waktu');
                $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');

                $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                    $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);

                $data = array(
                    'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                    'RKAP_SUBPRO_INVS_ID' => $id,
                    'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                    'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                    'RKAP_SUBPRO_CONTRACT_DATE' => $tgl_kontrak,
                    'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                    'RKAP_SUBPRO_END_REAL' => $tgl_end_real,
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                    'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                    'RKAP_SUBPRO_ENDOF_GUARANTEE' => $tgl_berakhir_jaminan,
                    'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                    'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                );

            }

            //echo json_encode($data2);
            if ($this->subprogramrkap_model->add($data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user add sub program rkap',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);
                //tambah month
                $this->tambahmont1($id,$jangka_waktu);

                $this->session->set_flashdata('success', 'Data sub program rkap investasi berhasil ditambahkan');

                redirect(base_url('subprogramrkapinvestasi/view/' . $id));
            } else {

                $this->session->set_flashdata('message', 'Data sub program rkap investasi gagal ditambahkan');

                redirect(base_url('subprogramrkapinvestasi/add/' . $id));
            }
        }
    }

    public function tambahmont1($id,$jangka)
    {
        $idrkap1 = $this->subprogramrkap_model->ambilid($id);
        $timestamp = date('Y-m-d G:i:s');
        for ($i=0; $i < $jangka ; $i++) { 
            $time = new DateTime($this->input->post('tgl_kontrak'));
            $time->add($this->add_months($i, $time));
            $date[$i] = $time->format('d-M-y');
            $date2[$i] = $time->format('m');
             $data2[$i] = array(
                'RKAP_SUBPRO_ID' => $idrkap1,
                'SUBPRO_MONTH' => $date2[$i],
                'SUBPRO_VALUE' => 0,
                'SUBPRO_YEARS' => $date[$i],
                'IS_ADDENDUM' => 0
            );
            $this->subprogramrkap_model->add2($data2[$i]);   
        }
    }

    public function cobacoba($id)
    {   
        //$this->subprogramrkap_model->generates3($id);
       //$idrkap1 = $this->subprogramrkap_model->ambiladdendum($id);
       //echo $idrkap1;
       echo var_dump($this->addendum_model->find($id));
    }

    public function tambahmont2($id,$jangka)
    {
        $timestamp = date('Y-m-d G:i:s');
        for ($i=0; $i < $jangka ; $i++) { 
            $time = new DateTime($this->input->post('tgl_kontrak'));
            $time->add($this->add_months($i, $time));
            $date[$i] = $time->format('d-M-y');
            $date2[$i] = $time->format('m');
             $data2[$i] = array(
                'RKAP_SUBPRO_ID' => $id,
                'SUBPRO_MONTH' => $date2[$i],
                'SUBPRO_VALUE' => 0,
                'SUBPRO_YEARS' => $date[$i],
                'IS_ADDENDUM' => 0
            );
            $this->subprogramrkap_model->add2($data2[$i]);   
        }
    }

    public function add_months( $months, \DateTime $object ) {
        $next = new DateTime($object->format('d-m-Y H:i:s'));
        $next->modify('last day of +'.$months.' month');
    
        if( $object->format('d') > $next->format('d') ) {
            return $object->diff($next);
        } else {
            return new DateInterval('P'.$months.'M');
        }
    }

   public function GetContractorName(){
    
        $get_data     = $this->db->query("SELECT RKAP_SUBPRO_CONTRACTOR FROM TX_RKAP_SUB_PROGRAM WHERE TX_RKAP_SUB_PROGRAM.IS_DELETED = 0 AND RKAP_SUBPRO_CONTRACTOR  is not null GROUP BY RKAP_SUBPRO_CONTRACTOR");
        
        foreach($get_data->result() as $row){
            $data[]    = array("name"=>$row->RKAP_SUBPRO_CONTRACTOR);    
        }

        echo json_encode($data);
        
    } 

    public function GetContractNumber(){
        $get_number = $this->input->post('nomor_kontrak');
        $check_number = $this->subprogramrkap_model->get_contract($get_number);
        if ($get_number == $check_number[0]->RKAP_SUBPRO_CONTRACT_NO) {
            
            echo json_encode("ada");
        }
        else{
            echo json_encode("tidak");
        }
        
    } 

    public function detail($id) {

        $data['groups'] = $this->subprogramrkap_model->all_jenis_subprogram();
        $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id);
        $data['groups2'] = $this->rkap_model->all_investasi();
        $data['list'] = $this->subprogramrkap_model->detail($id)[0];
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
        $data['find'] = $this->risiko_model->find_print($id);

        $data['resutl_all_month_adden'] = $this->kurva_model->find_all_month_adden($id);

        $id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;

        $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
        $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
         $data['kontrak_val_notselected'] = $this->subprogramrkap_model->nilai_rkap_notselected($id_rkap,$id)[0]['RKAP_VAL'];
        $data['act'] = 'detail';
        $data['serial'] = $this->risiko_model->find_serial($id);
        $data['realisasi'] = $this->realisasi_model->all_realisasi_program($id);
        
        $realisasi_month  = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_MONTH; 
        $data['realisasi'] = $realisasi_month;


        $rencana_month  = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_MONTH; ;
        $data['rencana'] = $rencana_month;


        $deviasi_kurva_realisasi = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_PERCENT_TOT; 

        if ($deviasi_kurva_realisasi == null) {
           $data['deviasi_realisasi'] = 0;
        }else {
             $data['deviasi_realisasi'] = $deviasi_kurva_realisasi;
        }

        $deviasi_kurva_rencana = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_VALUE; ;

        if ($deviasi_kurva_rencana == null) {
           $data['deviasi_rencana'] = 0;
        }else {
            $data['deviasi_rencana'] = $deviasi_kurva_rencana;
        }
        
        //$awal = $this->subprogramrkap_model->detail($id)[0];
        $awal2 = $this->subprogramrkap_model->ifjangka($id);

        if ($awal2->num_rows() > 0) {
            $data['jangkashow'] = $awal2->result()[0]->PER;
        }else{
            $data['jangkashow'] = $data['list']->RKAP_SUBPRO_PERIODE;
        }
        
        $deviasi_kurva_total = $data['deviasi_realisasi'] - $data['deviasi_rencana'];
        $data['deviasi_total'] = $deviasi_kurva_total;

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;     

        // print_r($deviasi_till70); die();


        //yayan---------------------
        $data['kurvarealisasi'] = $this->subprogramrkap_model->kurvarealisasi($id);
        $data['jmladdn'] = $this->subprogramrkap_model->jmladendum($id);
        $data['jmlhdata'] = $this->subprogramrkap_model->jumlhdata($id);
        //echo json_encode($data);
        for ($i=0; $i < $data['jmladdn']; $i++) {

            $data["Adden"][$i] = $this->subprogramrkap_model->kurvaaddendum($id,$i);
            $data["Adden2"][$i] = "Add$i";  
        
        }
        //----------------------------
        if ($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total >= $deviasi_till70 ) {

            $data['warna'] = 1;
        } 
        elseif($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total == $deviasi_till70 ){
            $data['warna'] =2;
        } 
        elseif($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total <= $deviasi_till70 ){
            $data['warna'] = 3;
        }
        elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total >= $deviasi_till100){
            $data['warna'] = 4;
        }
        elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total == $deviasi_till100){
            $data['warna'] = 5;
        }
        elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total <= $deviasi_till100){
            $data['warna'] = 6;
        }

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user detail sub program rkap',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $data['resutl_all_month_non_adden'] = $this->kurva_model->find_all_month_non_adden($id);
            //   $data['cek_addendum'] = $this->kurva_model->cek_addendum($id);
            // $data['cek_addendum2'] = $this->kurva_model->cek_addendum2($id);
            // $data['cek_addendum3'] = $this->kurva_model->cek_addendum3($id);
            // $data['cek_addendum4'] = $this->kurva_model->cek_addendum4($id);
            // $data['cek_addendum5'] = $this->kurva_model->cek_addendum5($id);
            // //$data['value'] = $this->subprogramrkap_model->tampilvalue($id);
            $data['cek_urutan'] = $this->kurva_model->find_all_month_adden($id);

        
        //echo json_encode($data);

        $this->log_model->add($data4);

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/addsubprogramrkap', $data);
    }

    public function update($id) {

        $data_subprogramrkap = $this->subprogramrkap_model->find($id);
        $id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);

        if ($data_subprogramrkap) {

            $this->form_validation->set_rules('judul_sub_program', 'Judul Sub program', 'required');
           

            if ($this->form_validation->run() === FALSE) {

                $data['groups'] = $this->subprogramrkap_model->all_jenis_subprogram();
                $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id);
                $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
                $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
                $data['kontrak_val_notselected'] = $this->subprogramrkap_model->nilai_rkap_notselected($id_rkap,$id)[0]['RKAP_VAL'];
                $data['list'] = $this->subprogramrkap_model->detail($id)[0];
                $data['act'] = 'edit';
                $data['serial'] = $this->risiko_model->find_serial($id);
                $data['groups2'] = $this->rkap_model->all_investasi();
                $data['realisasi'] = $this->realisasi_model->all_realisasi_program($id);
                $data['find'] = $this->risiko_model->find_print($id);
                
                $data['resutl_all_month_adden'] = $this->kurva_model->find_all_month_adden($id);

                $realisasi_month  = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_MONTH; 
                $data['realisasi'] = $realisasi_month;
                $rencana_month  = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_MONTH; 
                $data['rencana'] = $rencana_month; 
                $deviasi_kurva_realisasi = $this->subprogramrkap_model->deviasi_realisasi_month($id)->REAL_SUBPRO_PERCENT_TOT; 
                $data['deviasi_realisasi'] = $deviasi_kurva_realisasi;
                $deviasi_kurva_rencana = $this->subprogramrkap_model->deviasi_rencana_month($id, $realisasi_month)->SUBPRO_VALUE; ;
                $data['deviasi_rencana'] = $deviasi_kurva_rencana;
                
                
                $deviasi_kurva_total = $deviasi_kurva_realisasi - $deviasi_kurva_rencana;
                $data['deviasi_total'] = $deviasi_kurva_total;

                $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
                $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;     

                
                //yayan---------------------
                $data['kurvarealisasi'] = $this->subprogramrkap_model->kurvarealisasi($id);
                $data['jmladdn'] = $this->subprogramrkap_model->jmladendum($id);
                $data['jmlhdata'] = $this->subprogramrkap_model->jumlhdata($id);
                //echo json_encode($data);
                for ($i=0; $i < $data['jmladdn']; $i++) {

                    $data["Adden"][$i] = $this->subprogramrkap_model->kurvaaddendum($id,$i);
                    $data["Adden2"][$i] = "Add$i";  
                
                }
                //----------------------------
                if ($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total >= $deviasi_till70 ) {

                    $data['warna'] = 1;
                } 
                elseif($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total == $deviasi_till70 ){
                    $data['warna'] =2;
                } 
                elseif($deviasi_kurva_realisasi <= 70 && $deviasi_kurva_total <= $deviasi_till70 ){
                    $data['warna'] = 3;
                }
                elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total >= $deviasi_till100){
                    $data['warna'] = 4;
                }
                elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total == $deviasi_till100){
                    $data['warna'] = 5;
                }
                elseif($deviasi_kurva_realisasi <= 100 && $deviasi_kurva_total <= $deviasi_till100){
                    $data['warna'] = 6;
                }

                $data['resutl_all_month_non_adden'] = $this->kurva_model->find_all_month_non_adden($id);
                // $data['cek_addendum'] = $this->kurva_model->cek_addendum($id);
                // $data['cek_addendum2'] = $this->kurva_model->cek_addendum2($id);
                // $data['cek_addendum3'] = $this->kurva_model->cek_addendum3($id);
                // $data['cek_addendum4'] = $this->kurva_model->cek_addendum4($id);
                // $data['cek_addendum5'] = $this->kurva_model->cek_addendum5($id);
                // $data['value'] = $this->subprogramrkap_model->tampilvalue($id);
                $data['cek_urutan'] = $this->kurva_model->find_all_month_adden($id);

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/addsubprogramrkap', $data);
            } else {
                if ($this->input->post('tgl_berakhir_jaminan') == null){
                    $judul_sub_program = $this->input->post('judul_sub_program');
                    $jenis_sub_program = $this->input->post('jenis_sub_program');
                    $no_kontrak = $this->input->post('no_kontrak');
                    $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                    $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                    $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                    $jangka_waktu = $this->input->post('jangka_waktu');
                    $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                    $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                    $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                    $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');
                    $data['find'] = $this->risiko_model->find_print($id);

                    $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                    $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                    $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                    $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                    $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                    $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                    $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                    $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);

                    $data = array(
                        'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                        'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                        'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                        'RKAP_SUBPRO_CONTRACT_DATE' => $tgl_kontrak,
                         'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                        'RKAP_SUBPRO_END_REAL' => $tgl_end_real,
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                        'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                        'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                        'RKAP_SUBPRO_ENDOF_GUARANTEE' => null,
                        'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                        'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                    );
                }elseif ($this->input->post('tgl_kontrak') == null){
                    $judul_sub_program = $this->input->post('judul_sub_program');
                    $jenis_sub_program = $this->input->post('jenis_sub_program');
                    $no_kontrak = $this->input->post('no_kontrak');
                    $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                    $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                    $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                    $jangka_waktu = $this->input->post('jangka_waktu');
                    $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                    $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                    $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                    $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');

                    $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                    $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                    $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                    $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                    $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                    $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                    $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                    $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);
                    $data['find'] = $this->risiko_model->find_print($id);

                    $data = array(
                        'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                        'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                        'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                        'RKAP_SUBPRO_CONTRACT_DATE' => null,
                        'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                        'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                        'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                        'RKAP_SUBPRO_ENDOF_GUARANTEE' => $tgl_berakhir_jaminan,
                        'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                        'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                    );
                }
                else{
                    $judul_sub_program = $this->input->post('judul_sub_program');
                    $jenis_sub_program = $this->input->post('jenis_sub_program');
                    $no_kontrak = $this->input->post('no_kontrak');
                    $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                    $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                    $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                    $jangka_waktu = $this->input->post('jangka_waktu');
                    $realisasi_sebelum_set = $this->input->post('realisasi_sebelum');
                    $realisasi_sebelum_set1 = str_replace('.', '', $realisasi_sebelum_set);
                    $realisasi_sebelum = str_replace(',', '.', $realisasi_sebelum_set1);
                    $kontraktor_pelaksana = $this->input->post('kontraktor_pelaksana');
                    $data['find'] = $this->risiko_model->find_print($id);

                    $tgl_kontrak_set = strtotime($this->input->post('tgl_kontrak'));
                    $tgl_kontrak = date('d-M-y', $tgl_kontrak_set);

                    $tgl_kontrak_set_new = strtotime($this->input->post('tgl_kontrak_new'));
                    $tgl_kontrak_new = date('d-M-y', $tgl_kontrak_set_new);

                    $tgl_end_real_set = strtotime($this->input->post('tgl_end_real'));
                    $tgl_end_real = date('d-M-y', $tgl_end_real_set);

                    $tgl_berakhir_jaminan_set = strtotime($this->input->post('tgl_berakhir_jaminan'));
                    $tgl_berakhir_jaminan = date('d-M-y', $tgl_berakhir_jaminan_set);

                    $data = array(
                        'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                        'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program,
                        'RKAP_SUBPRO_CONTRACT_NO' => $no_kontrak,
                        'RKAP_SUBPRO_CONTRACT_DATE' => $tgl_kontrak,
                        'RKAP_SUBPRO_CONTRACT_DATE_NEW' => $tgl_kontrak_new,
                        'RKAP_SUBPRO_END_REAL' => $tgl_end_real,
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                        'RKAP_CONTRACT_VALUE_HISTORY' => $nilai_kontrak,
                        'RKAP_SUBPRO_PERIODE' => $jangka_waktu,
                        'RKAP_SUBPRO_ENDOF_GUARANTEE' => $tgl_berakhir_jaminan,
                        'RKAP_SUBPRO_REAL_BEFORE' => $realisasi_sebelum,
                        'RKAP_SUBPRO_CONTRACTOR' => $kontraktor_pelaksana
                    );
                }
                $addendum_cek = $this->subprogramrkap_model->ambiladdendum($id);
                // print_r($data); exit();
                if ($addendum_cek == 0) {
                    if ($this->subprogramrkap_model->update($id, $data)) {

                        $this->subprogramrkap_model->delete_monthly_sub($id);
                        //$jml = $this->subprogramrkap_model->ambiljangka($id);
    
                        $this->tambahmont2($id,$jangka_waktu);
                        
                        $this->subprogramrkap_model->generates2($id);
    
                        $data4 = array(
                            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                            'LOG_ACTION' => 'user update sub program rkap',
                            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                            'LOG_URL' => $_SERVER['REQUEST_URI']
                        );
    
                        $this->log_model->add($data4);
    
                        $this->session->set_flashdata('success', 'Data sub program rkap investasi berhasil diubah');
    
                        redirect(base_url('subprogramrkapinvestasi/view/' . $id_rkap));
                    } else {
    
                        $this->session->set_flashdata('message', 'Data sub program rkap investasi gagal diubah');
    
                        redirect(base_url('subprogramrkapinvestasi/update/' . $id));
                    }
                }else {
                        $this->session->set_flashdata('message', 'WARNING !!! Sub program ini sudah ada addendum, Silahkan hapus dahulu semua addendum untuk edit sub program');
                        redirect(base_url('subprogramrkapinvestasi/detail/' . $id));
                    }
            }
        } else {

            redirect(base_url('subprogramrkapinvestasi/view/' . $id_rkap));
        }
    }

    public function delete_modal($id) {

        $data['list'] = $this->subprogramrkap_model->find($id);
           $data = $data['list'];
        echo json_encode($data);

        // $this->load->view('template/pages/delete_subprogram_modal', $data);
    }

    public function delete($id) {
        $delete_subprogram = $this->subprogramrkap_model->find($id);
        $id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;

        if ($delete_subprogram) {
            $data = array(
                'IS_DELETED' => 1
            );
            if ($this->subprogramrkap_model->delete($id, $data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete sub program rkap',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data ' . $delete_subprogram->RKAP_SUBPRO_TITTLE . ' berhasil di hapus');

                redirect(base_url('subprogramrkapinvestasi/view/' . $id_rkap));
            } else {

                $this->session->set_flashdata('fail', 'data gagal di hapus');

                redirect(base_url('subprogramrkapinvestasi/view/' . $id));
            }
        } else {
            redirect(base_url('subprogramrkapinvestasi/view/' . $id));
        }
    }

}