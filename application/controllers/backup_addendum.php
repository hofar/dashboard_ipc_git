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
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function view($id) {
        $data['groups'] = $this->addendum_model->all_jenis_subprogram();
        $data['list'] = $this->addendum_model->all_subprogram($id)[0];
        $data['list2'] = $this->addendum_model->all_addendum($id);
        $data['last_data'] = $this->addendum_model->last_data_nonhistory($id)->SUBPRO_ADD_ID;
        $data['row_subprogram'] = $this->addendum_model->find_subprogram($id);

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view addendum',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );
        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/viewaddendum', $data);
        $this->load->view('template/global/footer');
    }

    public function add($id) {
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
            $max_subpro_years_set = $this->addendum_model->get_years_max($id);
            $years_the_last = $max_subpro_years_set[0]['SUBPRO_YEARS'];
            $last_years_set = strtotime($years_the_last);
            $last_years_a = date('d-m-Y', $last_years_set);
            $data['max_subpro_years'] = $last_years_a;
            $data['act'] = 'add';
            // print_r($data['row_subprogram']); exit();
            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/entryaddendum', $data);
            $this->load->view('template/global/footer');
        } else {

            $versi = $this->addendum_model->find_history_max($id);

            $no_kontrak = $this->input->post('no_kontrak');
            $date_contr = $this->input->post('date_contr');
            $bulan_contr_set = strtotime($date_contr);
            $bulan_contr = date('m', $bulan_contr_set);
            $tot_contr = (int)$bulan_contr;

            $tgl_kontrak = $this->input->post('tgl_kontrak');
            $bulan_kontrak_set = strtotime($tgl_kontrak);
            
            $bulan_kontrak = date('m', $bulan_kontrak_set);
            $tahun_kontrak = date('d-M-y', $bulan_kontrak_set);
            $get_tahun = date('Y-m', $bulan_kontrak_set);
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
            $jangka_waktu_lama_set = $this->addendum_model->ambil_data($id);
            $jangka_waktu_lama = (int) $jangka_waktu_lama_set[0]["SUBPRO_MONTH"];
            $kurva_month = $this->input->post('kurva_month');
            $total_jangka = count($kurva_month);
            $subpromonth = $total_jangka + $tot_month_contr - 1;
            $cek_bulan_addendum = $this->addendum_model->cek_bulan_addendum($bulan_kontrak, $id);

            $is_addendum = $this->addendum_model->cek_is_addendum($id);
            
            $cek_bulan = $this->addendum_model->all_addmonth($get_tahun, $id, $is_addendum);
            
            $cek_duplikat_data = $this->addendum_model->cek_duplikat_max($id);

            if ($is_addendum == 0) {

                $is_addendum_update = $is_addendum + 1;
            } else{
                $is_addendum_update = $is_addendum + 1;
            }

                foreach ($cek_bulan as $val) {
               
                    $datamax['RKAP_SUBPRO_ID'] = $val->RKAP_SUBPRO_ID;
                    $datamax['SUBPRO_MONTH'] = $val->SUBPRO_MONTH;
                    $datamax['SUBPRO_YEARS'] = $val->SUBPRO_YEARS;
                    $datamax['SUBPRO_VALUE'] = $val->SUBPRO_VALUE;
                    $datamax['CREATED_AT'] = $val->CREATED_AT;
                    $datamax['IS_ADDENDUM'] = $is_addendum_update;    

                    $this->db->insert("TX_RKAP_SUB_PROGRAM_MONTHLY", $datamax);
                }

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

            for ($i = 1; $i <= $jangka_dua_bulan; $i++) {

                $max_subpro_years_set = $this->addendum_model->get_years_max($id);
                $max_subpro_years = $max_subpro_years_set[0]["SUBPRO_YEARS"];
                $time = strtotime($max_subpro_years);
                $final = date("d-M-y", strtotime("+1 month", $time));
                $month = date("m", strtotime("+1 month", $time));
                $datamontly = array(
                    'RKAP_SUBPRO_ID' => $id,
                    'SUBPRO_MONTH' => $month,
                    'SUBPRO_YEARS' => $final,
                    'IS_ADDENDUM' => $is_addendum_update,
                );

                $this->addendum_model->addmontly($datamontly);
            }

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
                    'SUBPRO_ADD_END_REAL' => $data['row_subprogram']->RKAP_SUBPRO_END_REAL,
                    'SUBPRO_ADD_VALUE' => $data['row_subprogram']->RKAP_SUBPRO_CONTRACT_VALUE,
                    'SUBPRO_ADD_PERIODE' => $data['row_subprogram']->RKAP_SUBPRO_PERIODE,
                    'SUBPRO_ADD_ENDOF_GUARANTEE' => $data['row_subprogram']->RKAP_SUBPRO_ENDOF_GUARANTEE,
                    'VERSION' => $is_addendum_update
                );
                $this->addendum_model->add_history_addendumm($data3);

            $data = array(
                'RKAP_SUBPRO_ID' => $id,
                'SUBPRO_ADD_NUM' => $no_kontrak,
                'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y')
            );

            if ($this->addendum_model->add($data)) {

                $data2 = array(
                    'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                    'RKAP_SUBPRO_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    'RKAP_SUBPRO_PERIODE' => $jangka_waktu_total
                );

                $this->subprogramrkap_model->update($id, $data2);

                $id_rkap = $this->subprogramrkap_model->find($id)->RKAP_SUBPRO_INVS_ID;

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
         $max_subpro_years_set = $this->addendum_model->get_years_max($id_subpro);
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

        if ($data_addendum) {

            $this->form_validation->set_rules('no_kontrak', 'Nomor Kontrak', 'required');
            $this->form_validation->set_rules('tgl_kontrak', 'Tanggal Kontrak', 'required');
            $this->form_validation->set_rules('nilai_kontrak', 'Nilai Kontrak', 'required');
            $this->form_validation->set_rules('jangka_waktu', 'Jangka Waktu', 'required');
            $this->form_validation->set_rules('tgl_berakhir_jaminan', 'Tanggal Berakhir jaminan', 'required');

            if ($this->form_validation->run() === FALSE) {

                $data['groups'] = $this->addendum_model->all_jenis_subprogram();
                $data['groups2'] = $this->rkap_model->all_investasi();
                $data['list'] = $this->addendum_model->find_addendum($id)[0];
                $data['row_subprogram'] = $this->addendum_model->find_subprogram($id_subprogram);

                $data['list2'] = $this->addendum_model->detail($id)[0];
                $id_subpro = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
                $id_rkap = $this->subprogramrkap_model->find($id_subpro)->RKAP_SUBPRO_INVS_ID;
                $data['get_rkap'] = $this->subprogramrkap_model->find_rkap($id_rkap);
                $data['kontrak_val'] = $this->subprogramrkap_model->nilai_rkap($id_rkap)[0]['RKAP_VAL'];
                $data['kontrak_val_notselected_addendum'] = $this->addendum_model->nilai_rkap_notselected_addendum($id_rkap, $id_subpro)[0]['RKAP_VAL'];
                $max_subpro_years_set = $this->addendum_model->get_years_max($id_subpro);
                $years_the_last = $max_subpro_years_set[0]['SUBPRO_YEARS'];
                $last_years_set = strtotime($years_the_last);
                $last_years_a = date('d-m-Y', $last_years_set);
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
                $jangka_waktu_lama_set = $this->addendum_model->ambil_data($id_subprogram);
                $jangka_waktu_lama = (int) $jangka_waktu_lama_set[0]["SUBPRO_MONTH"];
                $kurva_month = $this->input->post('kurva_month');
                $total_jangka = count($kurva_month);
                $subpromonth = $total_jangka + $tot_month_contr - 1;
                
                $cek_bulan_addendum = $this->addendum_model->cek_bulan_addendum($bulan_kontrak, $id_subprogram);

                $is_addendum = $this->addendum_model->cek_is_addendum($id_subprogram);

                $cek_bulan = $this->addendum_model->all_addmonth($bulan_kontrak, $id_subprogram, $is_addendum);
                
                $cek_duplikat_data = $this->addendum_model->cek_duplikat_max($id_subprogram);
              
                $max_subpro_month_set = $this->addendum_model->get_month_max($id_subprogram);
                
                $max_subpro_month = (int) $max_subpro_month_set[0]["SUBPRO_MONTH"];

                $month = $max_subpro_month;

                $month_last = $subpromonth - $max_subpro_month;
               
                $tgl_berakhir_jaminan = $this->input->post('tgl_berakhir_jaminan');
                
                $version = $this->input->post('version');
                
                for ($i = 1; $i <= $jangka_dua_bulan; $i++) {

                     $max_subpro_years_set = $this->addendum_model->get_years_max($id);
                $max_subpro_years = $max_subpro_years_set[0]["SUBPRO_YEARS"];
                $time = strtotime($max_subpro_years);
                $final = date("d-M-y", strtotime("+1 month", $time));
                $month = date("m", strtotime("+1 month", $time));
                $datamontly = array(
                    'RKAP_SUBPRO_ID' => $id,
                    'SUBPRO_MONTH' => $month,
                    'SUBPRO_YEARS' => $final,
                    'IS_ADDENDUM' => $is_addendum_update,
                );

                    $this->addendum_model->addmontly($datamontly);
                }

                if ($versi == null) {

                    $versi_update = 0;
                } else {
                    $versi_update = $versi + 1;
                }

                $data = array(
                    'SUBPRO_ADD_NUM' => $no_kontrak,
                    'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                    'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                    'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                    'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                    'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y')
                );


                if ($this->addendum_model->update($id, $data)) {

                    $data3 = array(
                        'RKAP_SUBPRO_ID' => $id_subprogram,
                        'SUBPRO_ADD_NUM' => $no_kontrak,
                        'SUBPRO_ADD_DATE' => Datetime::createFromFormat('d-m-Y', $tgl_kontrak)->format('d-M-y'),
                        'SUBPRO_ADD_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                        'SUBPRO_ADD_VALUE' => $nilai_kontrak,
                        'SUBPRO_ADD_PERIODE' => $jangka_waktu,
                        'SUBPRO_ADD_ENDOF_GUARANTEE' => Datetime::createFromFormat('d-m-Y', $tgl_berakhir_jaminan)->format('d-M-y'),
                        'VERSION' => $versi_update
                    );
                    $this->addendum_model->add_history_addendumm($data3);

                    $data2 = array(
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $nilai_kontrak,
                        'RKAP_SUBPRO_END_REAL' => Datetime::createFromFormat('d-m-Y', $tgl_end_real)->format('d-M-y'),
                        'RKAP_SUBPRO_PERIODE' => $jangka_waktu_total
                    );
                    $this->subprogramrkap_model->update($id_subprogram, $data2);

                    $id_rkap = $this->subprogramrkap_model->find($id_subprogram)->RKAP_SUBPRO_INVS_ID;


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

        $this->load->view('template/pages/delete_addendum_modal', $data);
    }

    public function delete($id) {

        $delete_addendum = $this->addendum_model->find($id);
        $id_subprogram = $this->addendum_model->find($id)->RKAP_SUBPRO_ID;
        $last_data = $this->addendum_model->last_data_nonhistory($id_subprogram)->SUBPRO_ADD_ID;
        $id_history = $this->addendum_model->last_data($id_subprogram)->HISTORY_SUBPRO_ADD_ID;
        $data_sebelumnya = $this->addendum_model->data_history_before($id_subprogram, $id_history);
        $jangka_waktu_before = $this->addendum_model->data_history_before($id_subprogram, $id_history)->SUBPRO_ADD_PERIODE;
        $value_before = $this->addendum_model->data_history_before($id_subprogram, $id_history)->SUBPRO_ADD_VALUE;
        $end_real_before = $this->addendum_model->data_history_before($id_subprogram, $id_history)->SUBPRO_ADD_END_REAL;
        $last_addendum = $this->addendum_model->data_history_before($id_subprogram, $id_history)->VERSION;
         // print_r($value_before); exit();
        
        if ($delete_addendum) {
            $data = array(
                'IS_DELETED' => 1
            );

            if ($this->addendum_model->delete($id, $data)) {
                if ($id == $last_data) {
                    $data2 = array(
                        'RKAP_SUBPRO_CONTRACT_VALUE' => $value_before,
                         'RKAP_SUBPRO_END_REAL' => $end_real_before,
                        'RKAP_SUBPRO_PERIODE' => $jangka_waktu_before
                    );

                    $this->subprogramrkap_model->update($id_subprogram, $data2);

                    $this->addendum_model->delete_monthly($id_subprogram, $last_addendum);
                }
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete addendum',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

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
