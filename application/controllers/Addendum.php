<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addendum extends CI_Controller {

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
        $this->load->model('addendum_model');
        $this->load->model('subprogramrkap_model');
        $this->load->model('log_model');
        $this->load->model('rkap_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('risiko_model');
        $this->load->model('realisasi_model');
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function view($id) {
        //$data['groups'] = $this->addendum_model->all_jenis_subprogram();
        $data['list'] = $this->addendum_model->all_subprogram($id)[0];
        $data['list2'] = $this->addendum_model->all_addendum($id);
        $data['last_data'] = $this->addendum_model->last_data_nonhistory($id)->SUBPRO_ADD_ID;
        $data['row_subprogram'] = $this->addendum_model->find_subprogram($id);
        $data['find'] = $this->risiko_model->find_print($id);

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view addendum',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );
        $this->log_model->add($data4);
        //echo json_encode($data);
        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/viewaddendum', $data);
        $this->load->view('template/global/footer');
    }

    public function add($id) {
        // print_r($id);
        $this->form_validation->set_rules('no_kontrak', 'Nomor Kontrak', 'required');
        $this->form_validation->set_rules('tgl_kontrak', 'Tanggal Kontrak', 'required');
        $this->form_validation->set_rules('nilai_kontrak', 'Nilai Kontrak', 'required');
        $this->form_validation->set_rules('jangka_waktu', 'Jangka Waktu', 'required');
        $this->form_validation->set_rules('tgl_berakhir_jaminan', 'Tanggal Berakhir jaminan', 'required');

        if ($this->form_validation->run() === FALSE) {

            $data['groups'] = $this->addendum_model->all_jenis_subprogram();
            $data['groups2'] = $this->rkap_model->all_investasi();
            $data['find_history_max'] = $this->addendum_model->find_history_max($id);
            $data['list'] = $this->addendum_model->all_subprogram($id);
            $data['list2'] = $this->addendum_model->all_addendum($id);
            $data['row_subprogram'] = $this->addendum_model->find_subprogram($id);
            $id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;
            $data['kontrak_val'] = $this->addendum_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
            $data['kontrak_val_notselected'] = $this->subprogramrkap_model->nilai_rkap_notselected($id_rkap, $id)[0]['RKAP_VAL'];
            $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
            $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
            $max_subpro_years_set = $this->addendum_model->get_years_max_add($id);
            $years_the_last = $max_subpro_years_set[0]['SUBPRO_YEARS'];
            $last_years_set = strtotime($years_the_last);
            $last_years_a = date('d-m-Y', $last_years_set);
            $data['max_subpro_years'] = $last_years_a;
            $data['act'] = 'add';
            $data['find'] = $this->risiko_model->find_print($id);

            //realisasi
            $data['realisasi'] = $this->addendum_model->max_realisasi($id);
            // print_r($data['realisasi']); exit();
            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/entryaddendum', $data);
            $this->load->view('template/global/footer');
        } else {
            $data['find'] = $this->risiko_model->find_print($id);
            $versi = $this->addendum_model->find_history_max($id);
            

            $no_kontrak = $this->input->post('no_kontrak');
            $date_contr = $this->input->post('date_contr');
            $bulan_contr_set = strtotime($date_contr);
            $bulan_contr = date('m', $bulan_contr_set);
            $tot_contr = (int)$bulan_contr;

            $tgl_kontrak = $this->input->post('tgl_kontrak');
            $bulan_kontrak_set = strtotime($tgl_kontrak);

            // $tgl_kontrak_new = $this->input->post('tgl_kontrak_new');
            // $bulan_kontrak_set_new = strtotime($tgl_kontrak_new);
            
            $bulan_kontrak = date('m', $bulan_kontrak_set);
            $tahun_kontrak = date('d-M-y', $bulan_kontrak_set);
            $get_tahun = date('Y-m', $bulan_kontrak_set);
            $tot_month_contr = (int)$bulan_kontrak;
            $tgl_end_real = $this->input->post('tgl_end_real');
            // print_r($tgl_end_real); exit();
            $bulan_end_set = strtotime($tgl_end_real);
            $bulan_end = date('m', $bulan_end_set);
            $tot_month_end = (int)$bulan_end;
            $nilai_kontrak_set = $this->input->post('nilai_kontrak');
            $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
            $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
            $jangka_waktu = $this->input->post('jangka_waktu');
            $jangka_waktu_total = $this->input->post('jangka_new');
            $jangka_dua_bulan = $this->input->post('new_month_add');
             // print_r($jangka_dua_bulan); exit();
            $jangka_waktu_lama_set = $this->addendum_model->ambil_data($id);
            $jangka_waktu_lama = (int) $jangka_waktu_lama_set[0]["SUBPRO_MONTH"];
            $kurva_month = $this->input->post('kurva_month');
            $total_jangka = count($kurva_month);
            $subpromonth = $total_jangka + $tot_month_contr - 1;
            $cek_bulan_addendum = $this->addendum_model->cek_bulan_addendum($bulan_kontrak, $id);

            $is_addendum = $this->addendum_model->cek_addendum_yyn($id);
            
            $cek_bulan = $this->addendum_model->all_addmonth($get_tahun, $id, $is_addendum);
            $cek_duplikat_data = $this->addendum_model->cek_duplikat_max($id);

            // validasi addendum ke
                $is_addendum_update = $is_addendum + 1;
            
            // print_r(count($cek_bulan)); exit();
            // print_r($cek_bulan); exit(); 

                // foreach ($cek_bulan as $val) {
               
                //     $datamax['RKAP_SUBPRO_ID'] = $val->RKAP_SUBPRO_ID;
                //     $datamax['SUBPRO_MONTH'] = $val->SUBPRO_MONTH;
                //     $datamax['SUBPRO_YEARS'] = $val->SUBPRO_YEARS;
                //     $datamax['SUBPRO_VALUE'] = $val->SUBPRO_VALUE;
                //     $datamax['CREATED_AT'] = $val->CREATED_AT;
                //     $datamax['IS_ADDENDUM'] = $is_addendum_update;    

                //     $this->db->insert("TX_RKAP_SUB_PROGRAM_MONTHLY", $datamax);
                // }

            $max_subpro_month_set = $this->addendum_model->get_month_max($id);
            $max_subpro_month = (int) $max_subpro_month_set[0]["SUBPRO_MONTH"];
            $month = $max_subpro_month;
            $last_month_set = $this->addendum_model->last_month($id);
            $last_month = $last_month_set->SUBPRO_MONTH;

            if ($max_subpro_month == 12) {

                $get_subpro_month = $max_subpro_month + $last_month;
            }
            else{
                $get_subpro_month = $max_subpro_month;
            }

            $date1 = date_create($date_contr);;
            $date2 = date_create($tgl_end_real);;
            $diff = date_diff($date1,$date2);
            $month_last = $subpromonth - $get_subpro_month;

            $tgl_berakhir_jaminan = $this->input->post('tgl_berakhir_jaminan');
            
            $version = $this->input->post('version');
            // for ($i = 1; $i <= $jangka_dua_bulan; $i++) {

            //     $max_subpro_years_set = $this->addendum_model->get_years_max_add($id);
            //     $max_subpro_years = $max_subpro_years_set[0]["SUBPRO_YEARS"];
            //     $time = strtotime($max_subpro_years);
            //     $final = date("d-M-y", strtotime("+1 month", $time));
            //     $month = date("m", strtotime("+1 month", $time));
            //     // print_r($max_subpro_years_set); exit();
            //     $datamontly = array(
            //         'RKAP_SUBPRO_ID' => $id,
            //         'SUBPRO_MONTH' => $month,
            //         'SUBPRO_YEARS' => $final,
            //         'IS_ADDENDUM' => $is_addendum_update,
            //     );

            //     $this->addendum_model->addmontly($datamontly);
            // }
            // print_r($datamontly); exit();
            $this->tambahmont2($id,$jangka_waktu,$tgl_kontrak,$is_addendum_update);
            if ($versi == null) {

                $versi_update = 0;
            } else {
                $versi_update = $versi + 1;
            }

             $data['row_subprogram'] = $this->addendum_model->find_subprogram($id);
                $data3 = array(
                    'RKAP_SUBPRO_ID' => $id,
                    'SUBPRO_ADD_NUM' => $data['row_subprogram']->RKAP_SUBPRO_CONTRACT_NO,
                    'SUBPRO_ADD_DATE' => $data['row_subprogram']->RKAP_SUBPRO_START,
                    // 'SUBPRO_ADD_DATE_NEW' => $data['row_subprogram']->RKAP_SUBPRO_DATE_NEW,
                    'SUBPRO_ADD_END_REAL' => $data['row_subprogram']->RKAP_SUBPRO_END_REAL,
                    'SUBPRO_ADD_VALUE' => $data['row_subprogram']->RKAP_SUBPRO_CONTRACT_VALUE,
                    'SUBPRO_ADD_PERIODE' => $data['row_subprogram']->RKAP_SUBPRO_PERIODE,
                     'SUBPRO_ADD_PERIOD_TOT' => 0,
                     'SUBPRO_ADD_ENDREAL_LAST' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    'SUBPRO_ADD_ENDOF_GUARANTEE' => $data['row_subprogram']->RKAP_SUBPRO_ENDOF_GUARANTEE,
                    'VERSION' => $is_addendum_update
                );
                $this->addendum_model->add_history_addendumm($data3);

                //yayan
                if ($jangka_waktu > 0) {
                    $jt = $jangka_waktu -1;
                }else {
                    $jt = 0;
                }
                $time11 = new DateTime($tgl_kontrak);
                $time11->add($this->add_months($jt, $time11));
                $date11 = $time11->format('d-M-y');

            $data = array(
                'RKAP_SUBPRO_ID' => $id,
                'SUBPRO_ADD_NUM' => $no_kontrak,
                'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                // 'SUBPRO_ADD_DATE_NEW' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak_new)->format('d-M-y'),
                'SUBPRO_ADD_END_REAL' => $date11,
                'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y')
            );

            if ($this->addendum_model->add($data)) {
                if ($id != null) {
                    // $id_real = $this->realisasi_model->get_id_real($id);
                    // $real_value = $this->realisasi_model->get_real_value($id);
                    
                    // $count_real = count($id_real);
                    // for ($i=0; $i < $count_real; $i++) { 

                    //     $id_realisasi = $id_real[$i]->REAL_SUBPRO_ID;
                    //     $percent_update = $real_value[$i]->REAL_SUBPRO_VAL / $nilai_kontrak * 100;

                    //     $this->realisasi_model->update_percent($percent_update, $id, $id_realisasi);

                    // }
                }
                
                $abs = $this->addendum_model->ambiljangkawaktu2($id);
                //echo var_dump($data->num_rows());
                //echo var_dump($data->result()[0]->SUBPRO_YEARS);
                $data2 = array(
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_SUBPRO_END_REAL' => $abs->result()[0]->TGL,
                    'RKAP_SUBPRO_PERIODE' => $abs->num_rows()
                );

                $this->subprogramrkap_model->update($id, $data2);

                //$id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;
                $this->subprogramrkap_model->generates3($id);
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user add addendum and update sub program period and contract value',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data addendum berhasil ditambahkan');

                redirect(base_url('addendum/view/' . $id));
            } else {

                $this->session->set_flashdata('message', 'Data addendum gagal ditambahkan');

                redirect(base_url('addendum/add/' . $id));
            }
        }
    }

    public function coba22($jangka,$tgl)
    {
        //$data = $this->addendum_model->data_history_before($id_subprogram, $id_history)->VERSION;;
        // echo var_dump($data->num_rows());
        // echo var_dump($data->result()[0]->TGL);
        $data = $this->subprogramrkap_model->kurvarealisasi(4069);
        $arrayName = ["01-2018","02-2018","03-2018","04-2018"];
        $timestamp = date('Y-m-d G:i:s');
        for ($i=0; $i < $jangka ; $i++) { 
            $time = new DateTime($tgl);
            $time->add($this->add_months($i, $time));
            $date[$i] = $time->format('m-y');
        }
        $daten = array();
        $daten2 = array();
        foreach ($data->result() as $key => $value) {
            $daten[$key] = $value->TGL;
            $daten2[$key]= $value->VAL;
        }

        //$daten3 = array();
        for ($j=0; $j < 4 ; $j++) { 
            for ($k=0; $k < 3; $k++) { 
                if ($date[$j] == $daten[$k])  {
                    $daten3[$j] = $date[$j];
                }
                else{
                    
                }
            }
        }
        
    }

    public function tambahmont2($id,$jangka,$tgl,$v)
    {
        $timestamp = date('Y-m-d G:i:s');
        for ($i=0; $i < $jangka ; $i++) { 
            $time = new DateTime($tgl);
            $time->add($this->add_months($i, $time));
            $date[$i] = $time->format('d-M-y');
            $date2[$i] = $time->format('m');
             $data2[$i] = array(
                'RKAP_SUBPRO_ID' => $id,
                'SUBPRO_MONTH' => $date2[$i],
                'SUBPRO_VALUE' => 0,
                'SUBPRO_YEARS' => $date[$i],
                'IS_ADDENDUM' => $v
            );
            $this->subprogramrkap_model->add2($data2[$i]);   
        }
        //echo json_encode($data2);
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

    public function detail($id) {

        $data['groups'] = $this->addendum_model->all_jenis_subprogram();
        $data['list'] = $this->addendum_model->find_addendum($id)[0];
        $data['row_subprogram'] = $this->addendum_model->find_subprogram($id);
        $data['list2'] = $this->addendum_model->detail($id)[0];
        $id_subpro = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
        $id_rkap = $this->subprogramrkap_model->find($id_subpro)->RKAP_SUBPRO_INVS_ID;
        $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
        $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
        $data['kontrak_val_notselected_addendum'] = $this->addendum_model->nilai_rkap_notselected_addendum($id_rkap, $id_subpro)[0]['RKAP_VAL'];
         $max_subpro_years_set = $this->addendum_model->get_years_max_add($id_subpro);
            $years_the_last = $max_subpro_years_set[0]['SUBPRO_YEARS'];
            $last_years_set = strtotime($years_the_last);
            $last_years_a = date('d-m-Y', $last_years_set);
            $data['max_subpro_years'] = $last_years_a;
        $data['act'] = 'detail';

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view detail addendum',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/entryaddendum', $data);
        $this->load->view('template/global/footer');
    }

    public function update($id) {

        $data_addendum = $this->addendum_model->find($id);
        $id_subprogram = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
        $data['find'] = $this->risiko_model->find_print($id);

        if ($data_addendum) {

            $this->form_validation->set_rules('no_kontrak', 'Nomor Kontrak', 'required');
            $this->form_validation->set_rules('tgl_kontrak', 'Tanggal Kontrak', 'required');
            $this->form_validation->set_rules('nilai_kontrak', 'Nilai Kontrak', 'required');
            $this->form_validation->set_rules('jangka_waktu', 'Jangka Waktu', 'required');
            $this->form_validation->set_rules('tgl_berakhir_jaminan', 'Tanggal Berakhir jaminan', 'required');

            if ($this->form_validation->run() === FALSE) {

                $data['groups'] = $this->addendum_model->all_jenis_subprogram();
                $data['groups2'] = $this->rkap_model->all_investasi();
                $data['find_history_max'] = $this->addendum_model->find_history_max($id_subprogram);
                $data['list'] = $this->addendum_model->find_addendum($id)[0];
                $data['row_subprogram'] = $this->addendum_model->find_subprogram($id_subprogram);
                $data['list2'] = $this->addendum_model->detail($id)[0];
                $id_rkap = $this->subprogramrkap_model->find($id_subprogram)->RKAP_SUBPRO_INVS_ID;
                // print_r($data['row_subprogram'] ); exit();
                $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
                $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
                $data['kontrak_val_notselected_addendum'] = $this->addendum_model->nilai_rkap_notselected_addendum($id_rkap, $id_subprogram)[0]['RKAP_VAL'];
                $max_is_addendum_set = $this->addendum_model->get_is_addendum_max($id_subprogram)[0]['IS_ADDENDUM'];
                $max_subpro_years_set = $this->addendum_model->get_years_max($id_subprogram , $max_is_addendum_set);
                // print_r($max_is_addendum_set); 
                // print_r($max_subpro_years_set); exit();
                $years_the_last = $max_subpro_years_set[0]['SUBPRO_YEARS'];
                $last_years_set = strtotime($years_the_last);
                $last_years_a = date('d-m-Y', $last_years_set);
                // print_r($last_years_a); exit();
                $data['max_subpro_years'] = $last_years_a;
                $data['act'] = 'edit';

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/entryaddendum', $data);
                $this->load->view('template/global/footer');
            } else {

                $versi = $this->addendum_model->find_history_max($id_subprogram);
                $no_kontrak = $this->input->post('no_kontrak');
                $date_contr = $this->input->post('date_contr');
                $bulan_contr_set = strtotime($date_contr);
                $bulan_contr = date('m', $bulan_contr_set);
                $tot_contr = (int)$bulan_contr;
                $tgl_kontrak = $this->input->post('tgl_kontrak');
                $bulan_kontrak_set = strtotime($tgl_kontrak);
                // $tgl_kontrak_new = $this->input->post('tgl_kontrak_new');
                // $bulan_kontrak_set_new = strtotime($tgl_kontrak_new);

                $bulan_kontrak = date('m', $bulan_kontrak_set);
                $tot_month_contr = (int)$bulan_kontrak;
                $tgl_end_real = $this->input->post('tgl_end_real');
                
                $bulan_end_set = strtotime($tgl_end_real);
                $bulan_end = date('m', $bulan_end_set);
                $tot_month_end = (int)$bulan_end;
                $nilai_kontrak_set = $this->input->post('nilai_kontrak');
                $nilai_kontrak1 = str_replace('.', '', $nilai_kontrak_set);
                $nilai_kontrak = str_replace(',', '.', $nilai_kontrak1);
                $jangka_waktu = $this->input->post('jangka_waktu');
                $jangka_waktu_total = $this->input->post('jangka_new');
                $jangka_dua_bulan = $this->input->post('new_month_add');
                // print_r($tgl_kontrak);
                // print_r($jangka_waktu); 
                $jangka_waktu_lama_set = $this->addendum_model->ambil_data($id_subprogram);
                $jangka_waktu_lama = (int) $jangka_waktu_lama_set[0]["SUBPRO_MONTH"];
                // print_r($nilai_kontrak); exit();
                $kurva_month = $this->input->post('kurva_month');
                $total_jangka = count($kurva_month);
                $subpromonth = $total_jangka + $tot_month_contr - 1;
                
                
                $cek_bulan_addendum = $this->addendum_model->cek_bulan_addendum($bulan_kontrak, $id_subprogram);
                
                $cek_duplikat_data = $this->addendum_model->cek_duplikat_max($id_subprogram);
             
                $tgl_berakhir_jaminan = $this->input->post('tgl_berakhir_jaminan');
                
                $version = $this->input->post('version');
                $id_history = $this->addendum_model->last_data($id_subprogram)->HISTORY_SUBPRO_ADD_ID;
                $last_addendum = $this->addendum_model->last_data($id_subprogram)->VERSION;
                // print_r($last_addendum); exit();
                $this->addendum_model->delete_monthly($id_subprogram, $last_addendum);

                $get_tahun = date('Y-m', $bulan_kontrak_set);
                $is_addendum = $this->addendum_model->cek_addendum_yyn($id_subprogram);
                $cek_bulan = $this->addendum_model->all_addmonth($get_tahun, $id_subprogram, $is_addendum);
                // print_r($cek_bulan); exit();
            //    foreach ($cek_bulan as $val) {
               
            //         $datamax['RKAP_SUBPRO_ID'] = $val->RKAP_SUBPRO_ID;
            //         $datamax['SUBPRO_MONTH'] = $val->SUBPRO_MONTH;
            //         $datamax['SUBPRO_YEARS'] = $val->SUBPRO_YEARS;
            //         $datamax['SUBPRO_VALUE'] = $val->SUBPRO_VALUE;
            //         $datamax['CREATED_AT'] = $val->CREATED_AT;
            //         $datamax['IS_ADDENDUM'] = $last_addendum;    

            //         $this->db->insert("TX_RKAP_SUB_PROGRAM_MONTHLY", $datamax);
            //     }

                $max_subpro_month_set = $this->addendum_model->get_month_max($id_subprogram);
                $max_subpro_month = (int) $max_subpro_month_set[0]["SUBPRO_MONTH"];
                $month = $max_subpro_month;
                $last_month_set = $this->addendum_model->last_month($id_subprogram);
                $last_month = $last_month_set->SUBPRO_MONTH;

                if ($max_subpro_month == 12) {

                    $get_subpro_month = $max_subpro_month + $last_month;
                }
                else{
                    $get_subpro_month = $max_subpro_month;
                }

                $date1 = date_create($date_contr);;
                $date2 = date_create($tgl_end_real);;
                $diff = date_diff($date1,$date2);
                $month_last = $subpromonth - $get_subpro_month;

                $tgl_berakhir_jaminan = $this->input->post('tgl_berakhir_jaminan');
                    // if ($jangka_dua_bulan >=1) {

                      $max_is_addendum_set = $this->addendum_model->get_is_addendum_max($id_subprogram)[0]['IS_ADDENDUM'];
                    //   for ($i = 1; $i < $jangka_dua_bulan; $i++) {
                          
                    //         $max_subpro_years_set = $this->addendum_model->get_years_max_edit($id_subprogram , $max_is_addendum_set);
                    //         $max_subpro_years = $max_subpro_years_set[0]["SUBPRO_YEARS"];
                    //         $time = strtotime($max_subpro_years);
                    //         $final = date("d-M-y", strtotime("+1 month", $time));
                    //         $month = date("m", strtotime("+1 month", $time));
                    //         // print_r($month); exit();
                    //         $datamontly = array(
                    //             'RKAP_SUBPRO_ID' => $id_subprogram,
                    //             'SUBPRO_MONTH' => $month,
                    //             'SUBPRO_YEARS' => $final,
                    //             'IS_ADDENDUM' => $last_addendum,
                    //         );
                            
                    //         $this->addendum_model->addmontly($datamontly);
                    //     }
                            // print_r($datamontly); exit();
                    // }else{
                         // exit();

                    // }
                // print_r($versi); exit();
                $id_subprogram = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
                $this->tambahmont2($id_subprogram,$jangka_waktu,$tgl_kontrak,$last_addendum);
                
                //$this->addendum_model->delete_monthly($id_subprogram, $last_addendum);
                $abs = $this->addendum_model->ambiljangkawaktu2($id_subprogram);
                $abs_val = $this->addendum_model->ambilnilai($id_subprogram);
                
                //echo var_dump($data->num_rows());
                //echo var_dump($data->result()[0]->SUBPRO_YEARS);
                
                $data2 = array(
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_SUBPRO_END_REAL' => $abs->result()[0]->TGL,
                    'RKAP_SUBPRO_PERIODE' => $abs->num_rows()
                );

                //$this->subprogramrkap_model->update($id, $data2);

                $this->subprogramrkap_model->update($id_subprogram, $data2);

                if ($versi == null) {

                    $versi_update = 0;
                } else {
                    $versi_update = $versi;
                }

                $data = array(
                    'SUBPRO_ADD_NUM' => $no_kontrak,
                    'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                    // 'SUBPRO_ADD_DATE_NEW' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak_new)->format('d-M-y'),
                    'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                    'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                    'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y')
                );


                if ($this->addendum_model->update($id, $data)) {
                    $subpro_id = $this->addendum_model->detail($id)[0]->RKAP_SUBPRO_ID;
                    if ($id != null) {
                        // $id_real = $this->realisasi_model->get_id_real($subpro_id);
                        // $real_value = $this->realisasi_model->get_real_value($subpro_id);
                        //     // print_r($id_real);exit();
                        
                        // $count_real = count($id_real);
                        // for ($i=0; $i < $count_real; $i++) { 

                        //     $id_realisasi = $id_real[$i]->REAL_SUBPRO_ID;
                        //     $percent_update = $real_value[$i]->REAL_SUBPRO_VAL / $nilai_kontrak * 100;
                        //     $this->realisasi_model->update_percent_adendum($percent_update, $subpro_id, $id_realisasi);

                        // }
                        $this->subprogramrkap_model->generates3($id);
                    }
                    // $add112 = $this->addendum_model->ambiladendumakhir($id);
                    // if ($add112->num_rows() <= 1) {
                    //         $data3 = array(
                    //         'SUBPRO_ADD_NUM' => $no_kontrak,
                    //         'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                    //         // 'SUBPRO_ADD_DATE_NEW' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak_new)->format('d-M-y'),
                    //         'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    //         'SUBPRO_ADD_ENDREAL_LAST' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    //         'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                    //         'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                    //         'SUBPRO_ADD_PERIOD_TOT' => $jangka_waktu_total,
                    //         'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y'),
                    //         );
                    //     $this->addendum_model->update_history($id_history, $data3);
                        
                    // }
                    // $data3 = array(
                    //     'SUBPRO_ADD_NUM' => $no_kontrak,
                    //     'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                    //     // 'SUBPRO_ADD_DATE_NEW' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak_new)->format('d-M-y'),
                    //     'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    //     'SUBPRO_ADD_ENDREAL_LAST' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    //     'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                    //     'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                    //     'SUBPRO_ADD_PERIOD_TOT' => $jangka_waktu_total,
                    //     'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y'),
                    // );
                    // $this->addendum_model->update_history($id_history, $data3);

                    // $data2 = array(
                    //     'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    //     'RKAP_SUBPRO_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    //     'RKAP_SUBPRO_PERIODE' => $jangka_waktu_total
                    // );
                    // $this->subprogramrkap_model->update($id_subprogram, $data2);

                    // $id_rkap = $this->subprogramrkap_model->find($id_subprogram)->RKAP_SUBPRO_INVS_ID;


                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update addendum and update sub program period and contract value',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data addendum berhasil diubah');

                    redirect(base_url('addendum/view/' . $id_subprogram));
                } else {

                    $this->session->set_flashdata('message', 'Data addendum gagal diubah');

                    redirect(base_url('addendum/update' . $id));
                }
            }
        } else {

            redirect(base_url('addendum/view/' . $id_subprogram));
        }
    }

    public function delete_modal($id) {

        $data['list'] = $this->addendum_model->find($id);
           $data = $data['list'];
        echo json_encode($data);
        
        // $this->load->view('template/pages/delete_addendum_modal', $data);
    }

    public function delete($id) {

        $delete_addendum = $this->addendum_model->find($id);
        
        $id_subprogram = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
        //echo var_dump($id_subprogram);
        $rkap_periode = $this->addendum_model->find_subprogram($id_subprogram)->RKAP_SUBPRO_PERIODE;
        //echo var_dump($rkap_periode);
        $rkap_contract_history = $this->addendum_model->find_subprogram($id_subprogram)->RKAP_CONTRACT_VALUE_HISTORY;
        //echo var_dump($rkap_contract_history);
        $last_data = $this->addendum_model->last_data_nonhistory($id_subprogram)->SUBPRO_ADD_ID;
        //echo var_dump($last_data);
        $id_history = $this->addendum_model->last_data($id_subprogram)->HISTORY_SUBPRO_ADD_ID;
        //echo var_dump($id_history);
        $id_history_notselect = $this->addendum_model->last_data_notselect($id_subprogram, $id_history)->HISTORY_SUBPRO_ADD_ID;
        //echo var_dump();
         // print_r($id_history_notselect); exit();
        $data_sebelumnya = $this->addendum_model->data_history_before($id_subprogram, $id_history_notselect);
        $jangka_waktu_before = $this->addendum_model->data_history_before($id_subprogram, $id_history_notselect)->SUBPRO_ADD_PERIOD_TOT;
        $value_before = $this->addendum_model->data_history_before($id_subprogram, $id_history_notselect)->SUBPRO_ADD_VALUE;
        $end_real_before = $this->addendum_model->data_history_before($id_subprogram, $id_history_notselect)->SUBPRO_ADD_ENDREAL_LAST;
        $last_addendum = $this->addendum_model->data_history_before($id_subprogram, $id_history)->VERSION;

        $subpro_by_monthly = $this->addendum_model->data_history_by_monthly($id_subprogram)->RKAP_SUBPRO_ID;
        $jangka_waktu_by_monthly = $rkap_periode - $subpro_by_monthly;
        $subpro_by_years = $this->addendum_model->data_history_by_years($id_subprogram)->SUBPRO_YEARS;

        $subpro_periode = $this->addendum_model->all_subprogram($id_subprogram)[0]->RKAP_SUBPRO_PERIODE;
        $last_periode   = $subpro_periode - $jangka_waktu_by_monthly;   

        // print_r($subpro_periode); exit();
        
        if ($delete_addendum) {
            $data = array(
                'IS_DELETED' => 1
            );
            
            
            // if ($id != null) {
            //     $id_real = $this->realisasi_model->get_id_real($subpro_id);
            //     $real_value = $this->realisasi_model->get_real_value($subpro_id);
            //         // print_r($id_real);exit();
                
            //     $count_real = count($id_real);
            //     for ($i=0; $i < $count_real; $i++) { 

            //         $id_realisasi = $id_real[$i]->REAL_SUBPRO_ID;
            //         $percent_update = $real_value[$i]->REAL_SUBPRO_VAL / $rkap_contract_history * 100;
            //         $this->realisasi_model->update_percent_adendum($percent_update, $subpro_id, $id_realisasi);

            //     }
            // }

            if ($this->addendum_model->delete($id, $data)) {
                
                //if ($id == $last_data) {
                    
                    // if ($id_history_notselect == '') {
                    //     $data2 = array(
                    //         'RKAP_SUBPRO_CONTRACT_VALUE' => $rkap_contract_history,
                    //         'RKAP_SUBPRO_END_REAL' => $subpro_by_years,
                    //         'RKAP_SUBPRO_PERIODE' => $last_periode
                    //     );
                    // }else{
                    //     $data2 = array(
                    //         'RKAP_SUBPRO_CONTRACT_VALUE' => $value_before,
                    //         'RKAP_SUBPRO_END_REAL' => $end_real_before,
                    //         'RKAP_SUBPRO_PERIODE' => $jangka_waktu_before
                    //     );
                    // }

                    //echo json_encode($data2);
                    $this->addendum_model->delete_monthly($id_subprogram, $last_addendum);
                    $abs = $this->addendum_model->ambiljangkawaktu2($id_subprogram);
                    $abs_val = $this->addendum_model->ambilnilai($id_subprogram);
                    
                    //echo var_dump($data->num_rows());
                    //echo var_dump($data->result()[0]->SUBPRO_YEARS);
                    
                    $data2 = array(
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $abs_val->result()[0]->NIL,
                        'RKAP_SUBPRO_END_REAL' => $abs->result()[0]->TGL,
                        'RKAP_SUBPRO_PERIODE' => $abs->num_rows()
                    );

                    //$this->subprogramrkap_model->update($id, $data2);

                    $this->subprogramrkap_model->update($id_subprogram, $data2);
                    $this->addendum_model->delete_history($id_history, $data);
                   
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete addendum',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                $subpro_id = $this->addendum_model->ambilidrkap($id);
                $this->log_model->add($data4);
                $this->subprogramrkap_model->generates3($subpro_id);
                $this->session->set_flashdata('success', 'Data berhasil di hapus');

                redirect(base_url('addendum/view/' . $id_subprogram));
            
            } else {

                $this->session->set_flashdata('fail', 'data gagal di hapus');

                redirect(base_url('addendum/view/' . $id));
            }
        } else {
            redirect(base_url('addendum/view/' . $id_subprogram));
        }
    }

}