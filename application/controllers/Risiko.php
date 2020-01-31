<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Risiko extends CI_Controller {

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
        $this->load->model('risiko_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('subprogramrkap_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $this->load->library('m_pdf');
    }

    function cek($id) {

        $versi = $this->input->post('versi');

        $query = $this->risiko_model->get_versi($id, $versi);
        $data = array();
        $no = 0;
        foreach ($query as $val) {
            $data['tipe'][$no] = $val->RISK_TYPE;
            $data['deskripsi'][$no] = $val->RISK_DESC;
            $data['name_tipe'][$no] = $val->tipe;
            $data['name_impact'][$no] = $val->dampak;
            $data['impact'][$no] = $val->RISK_IMPACT;
            $data['ik'][$no] = $val->RISK_IK;
            $data['id'][$no] = $val->RISK_ID;
            $data['solving'][$no] = $val->RISK_SOLVING;
            $data['id_subpro'][$no] = $val->SUBPRO_RISK_ID;
            $data['serial'][$no] = $val->SERIAL;
            $no++;
        }
        $data['jml'] = count($data['id']);

        echo json_encode($data);
    }

    public function added($id) {
        $versi = $this->risiko_model->find_history_max($id);
        $data['version_history'] = $this->risiko_model->find_history($id, $versi);
        $data['row_subprogram_risiko_history'] = $this->risiko_model->find_subprogram_risiko_history($id);
        $data['find_history_max'] = $this->risiko_model->find_history_max($id);

        $id_history = $this->input->post('id_history');
        $risiko_tipe = $this->input->post('risiko_tipe');
        $risiko_deskripsi = $this->input->post('risiko_deskripsi');
        $dampak_risiko = $this->input->post('dampak_risiko');
        $risiko_ik = $this->input->post('risiko_ik');
        $risiko_id = $this->input->post('risiko_id');
        $risiko_penanganan = $this->input->post('risiko_penanganan');
        $version = $this->input->post('risiko_version');
        $serial = $this->input->post('serial');
        $realisasi_penanganan = $this->input->post('realisasi_penanganan');

        $find_risiko = $this->risiko_model->find_risiko($id);

        for ($i = 0; $i < count($risiko_tipe); $i++) {

            $idhistory = $id_history[$i];
            $tipe = $risiko_tipe[$i];
            $deskripsi = $risiko_deskripsi[$i];
            $dampak = $dampak_risiko[$i];
            $ik_risiko = $risiko_ik[$i];
            $id_risiko = $risiko_id[$i];
            $penanganan = $risiko_penanganan[$i];
            $realisasi = $realisasi_penanganan[$i];
            $serial_risiko = $serial[$i];

            if ($versi == null) {

                $versi_update = 0;
            } else {
                $versi_update = $versi + 1;
            }

            $data = array(
                'RKAP_SUBPRO_ID' => $id,
                'RISK_TYPE' => $tipe,
                'RISK_DESC' => $deskripsi,
                'RISK_IMPACT' => $dampak,
                'RISK_IK' => $ik_risiko,
                'RISK_ID' => $id_risiko,
                'RISK_SOLVING' => $penanganan,
                'RISK_REALISASI' => $realisasi,
                'RISK_VERSION' => $versi_update,
                'SERIAL' => $serial_risiko
            );

            $this->risiko_model->add_history($data);
        }

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user add history monitoring risiko',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->session->set_flashdata('success', 'Data monitoring risiko berhasil di tambah');

        redirect(base_url('risiko/view/' . $id));
    }

    public function added_risiko($id) {

        $cek_risiko = $this->risiko_model->find_risiko($id);

        if ($cek_risiko != null) {
            $this->risiko_model->delete_risiko($id);
        }

        $versi = $this->risiko_model->find_history_max($id);
        $serial = $this->risiko_model->find_serial_max($id);
        $list_real = $this->risiko_model->all_risiko_history($id, $versi);
        $risiko_tipe = $this->input->post('risiko_tipe');
        $risiko_deskripsi = $this->input->post('risiko_deskripsi');
        $dampak_risiko = $this->input->post('dampak_risiko');
        $risiko_ik = $this->input->post('risiko_ik');
        $risiko_id = $this->input->post('risiko_id');
        $risiko_penanganan = $this->input->post('risiko_penanganan');
        $version = $this->input->post('risiko_version');
        $realisasi_penanganan = $this->input->post('realisasi_penanganan');
        $serial = $this->input->post('serial');

        for ($i = 0; $i < count($risiko_tipe); $i++) {

            $tipe = $risiko_tipe[$i];
            $deskripsi = $risiko_deskripsi[$i];
            $dampak = $dampak_risiko[$i];
            $ik_risiko = $risiko_ik[$i];
            $id_risiko = $risiko_id[$i];
            $penanganan = $risiko_penanganan[$i];
            $realisasi = $realisasi_penanganan[$i];
            $serial_risiko = $serial[$i];

            if ($versi == null) {

                $versi_update = 0;
            } else {
                $versi_update = $versi + 1;
            }

            $data1 = array(
                'RKAP_SUBPRO_ID' => $id,
                'RISK_TYPE' => $tipe,
                'RISK_DESC' => $deskripsi,
                'RISK_IMPACT' => $dampak,
                'RISK_IK' => $ik_risiko,
                'RISK_ID' => $id_risiko,
                'RISK_SOLVING' => $penanganan,
                'RISK_REALISASI' => $realisasi,
                'RISK_VERSION' => $versi_update,
                'SERIAL' => $serial_risiko
            );

            $this->risiko_model->add_history($data1);
        }

        for ($i = 0; $i < count($risiko_tipe); $i++) {

            $tipe = $risiko_tipe[$i];
            $deskripsi = $risiko_deskripsi[$i];
            $dampak = $dampak_risiko[$i];
            $ik_risiko = $risiko_ik[$i];
            $id_risiko = $risiko_id[$i];
            $penanganan = $risiko_penanganan[$i];
            $realisasi = $realisasi_penanganan[$i];
            $serial_risiko = $serial[$i];

            $data = array(
                'RKAP_SUBPRO_ID' => $id,
                'RISK_TYPE' => $tipe,
                'RISK_DESC' => $deskripsi,
                'RISK_IMPACT' => $dampak,
                'RISK_IK' => $ik_risiko,
                'RISK_ID' => $id_risiko,
                'RISK_SOLVING' => $penanganan,
                'RISK_REALISASI' => $realisasi,
                'SERIAL' => $serial_risiko
            );

            $this->risiko_model->add($data);
        }

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user add history monitoring risiko',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->session->set_flashdata('success', 'Data monitoring risiko berhasil di tambah');

        redirect(base_url('risiko/view_risiko/' . $id));
    }

    public function print_risiko($id) {

        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['find'] = $this->risiko_model->find_print($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);

        $data['act'] = 'view';
        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user print penanganan risiko',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/print_risiko', $data);
        $this->load->view('template/global/footer');
    }

    public function cetakpdf($id) {
        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['find'] = $this->risiko_model->find_print($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);

        $this->load->view('template/pages/print_fix', $data);
        $sumber = $this->load->view('template/pages/print_fix', $data, TRUE);
        $html = $sumber;


        $pdfFilePath = "penanganan_risiko.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');
        
        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    public function print_view_risiko($id) {
        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['find'] = $this->risiko_model->find_print($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);

        $this->load->view('template/pages/print_fix', $data);
        $sumber = $this->load->view('template/pages/print_view_risiko', $data, TRUE);
        $html = $sumber;


        $pdfFilePath = "penanganan_risiko.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');
        
        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    public function print_monitoring_risiko($id) {
        $versi = $this->risiko_model->find_history_max($id);
        
        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['list_real'] = $this->risiko_model->all_risiko_history($id, $versi);
        $data['find'] = $this->risiko_model->find_print($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);

        $this->load->view('template/pages/print_fix', $data);
        $sumber = $this->load->view('template/pages/print_monitoring_risiko', $data, TRUE);
        $html = $sumber;


        $pdfFilePath = "penanganan_risiko.pdf";

        $pdf = $this->m_pdf->load();
        $pdf->SetDefaultBodyCSS('color', '#fff');
        
        $pdf->AddPage('L');

        $pdf->WriteHTML($html);

        $pdf->Output();
        exit();
    }

    public function view($id) {

        $versi = $this->risiko_model->find_history_max($id);
        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['row_subprogram'] = $this->risiko_model->find_subprogram($id);
        $data['groups'] = $this->risiko_model->all_jenis_risiko($id);
        $data['groups2'] = $this->risiko_model->all_jenis_dampak($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
        $data['row_subprogram_risiko_history'] = $this->risiko_model->find_subprogram_risiko_history($id);
        $data['find_risiko'] = $this->risiko_model->find_risiko($id);
        $data['version_history'] = $this->risiko_model->find_history($id, $versi);
        $data['get_version'] = $this->risiko_model->get_version($id);
        $data['find_history_max'] = $this->risiko_model->find_history_max($id);
        $data['find_type_max'] = $this->risiko_model->find_type_max($id);
        $data['serial'] = $this->risiko_model->find_serial($id);
        $data['find'] = $this->risiko_model->find_print($id);
        $data['list_subpro'] = $this->subprogramrkap_model->detail($id)[0];

        $data['act'] = 'view';
        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view form monitoring risiko',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/new_viewrisiko', $data);
        $this->load->view('template/global/footer');
    }

    public function view_risiko($id) {

        $versi = $this->risiko_model->find_history_max($id);

        $data['list'] = $this->risiko_model->all_risiko($id);
        $data['list_real'] = $this->risiko_model->all_risiko_history($id, $versi);
        $data['row_subprogram'] = $this->risiko_model->find_subprogram($id);
        $data['groups'] = $this->risiko_model->all_jenis_risiko($id);
        $data['groups2'] = $this->risiko_model->all_jenis_dampak($id);
        $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
        $data['row_subprogram_risiko_history'] = $this->risiko_model->find_subprogram_risiko_history($id);
        $data['find_risiko'] = $this->risiko_model->find_risiko($id);
        $data['version_history'] = $this->risiko_model->find_history($id, $versi);
        $data['get_version'] = $this->risiko_model->get_version($id);
        $data['find_history_max'] = $this->risiko_model->find_history_max($id);
        $data['find_type_max'] = $this->risiko_model->find_type_max($id);
        $data['serial'] = $this->risiko_model->find_serial($id);
        $data['find'] = $this->risiko_model->find_print($id);

        $data['act'] = 'view';
        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view form monitoring risiko',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/viewrisiko', $data);
        $this->load->view('template/global/footer');
    }

    public function add($id) {

        $this->form_validation->set_rules('risiko_tipe', 'Risiko Tipe', 'required');
        $this->form_validation->set_rules('risiko_deskripsi', 'Risiko Deskripsi', 'required');
        $this->form_validation->set_rules('dampak_risiko', 'Risiko Dampak', 'required');
        $this->form_validation->set_rules('risiko_ik', 'Risiko IK', 'required');
        $this->form_validation->set_rules('risiko_id', 'Risiko ID', 'required');
        $this->form_validation->set_rules('risiko_penanganan', 'Risiko Penanganan', 'required');

        if ($this->form_validation->run() === FALSE) {

            $versi = $this->risiko_model->find_history_max($id);

            $data['list'] = $this->risiko_model->all_risiko($id);
            $data['row_subprogram'] = $this->risiko_model->find_subprogram($id);
            $data['groups'] = $this->risiko_model->all_jenis_risiko($id);
            $data['groups2'] = $this->risiko_model->all_jenis_dampak($id);
            $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
            $data['find_risiko'] = $this->risiko_model->find_risiko($id);
            $data['version_history'] = $this->risiko_model->find_history($id, $versi);
            $data['get_version'] = $this->risiko_model->get_version($id);
            $data['find_history_max'] = $this->risiko_model->find_history_max($id);

            $data['act'] = 'add';

            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/addrisiko', $data);
            $this->load->view('template/global/footer');
        } else {

            $versi = $this->risiko_model->find_history_max($id);

            $risiko_tipe = $this->input->post('risiko_tipe');
            $risiko_deskripsi = $this->input->post('risiko_deskripsi');
            $dampak_risiko = $this->input->post('dampak_risiko');
            $risiko_ik = $this->input->post('risiko_ik');
            $risiko_id = $this->input->post('risiko_id');
            $risiko_penanganan = $this->input->post('risiko_penanganan');
            $version = $this->input->post('risiko_version');
            $serial = $this->risiko_model->find_serial_max($id);

            if ($serial == null) {

                $serial_update = 1;
            } else {
                $serial_update = $serial + 1;
            }

            $find_risiko = $this->risiko_model->find_risiko($id);

            $data = array(
                'RKAP_SUBPRO_ID' => $id,
                'RISK_TYPE' => $risiko_tipe,
                'RISK_DESC' => $risiko_deskripsi,
                'RISK_IMPACT' => $dampak_risiko,
                'RISK_IK' => $risiko_ik,
                'RISK_ID' => $risiko_id,
                'RISK_SOLVING' => $risiko_penanganan,
                'SERIAL' => $serial_update
            );

            if ($this->risiko_model->add($data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user add monitoring risiko',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data monitoring risiko berhasil ditambahkan');

                redirect(base_url('risiko/view/' . $id));
            } else {

                $this->session->set_flashdata('message', 'Data monitoring risiko gagal ditambahkan');

                redirect(base_url('risiko/add/' . $id));
            }
        }
    }

    public function update($id) {

        $data_risiko = $this->risiko_model->find($id);
        $id_subprogram = $this->risiko_model->find($id)->RKAP_SUBPRO_ID;

        if ($data_risiko) {

            $this->form_validation->set_rules('risiko_tipe', 'Risiko Tipe', 'required');
            $this->form_validation->set_rules('risiko_deskripsi', 'Risiko Deskripsi', 'required');
            $this->form_validation->set_rules('dampak_risiko', 'Risiko Dampak', 'required');
            $this->form_validation->set_rules('risiko_ik', 'Risiko IK', 'required');
            $this->form_validation->set_rules('risiko_id', 'Risiko ID', 'required');
            $this->form_validation->set_rules('risiko_penanganan', 'Risiko Penanganan', 'required');

            if ($this->form_validation->run() === FALSE) {

                $versi = $this->risiko_model->find_history_max($id);

                $data['row_subprogram'] = $this->risiko_model->find_subprogram($id);
                $data['groups'] = $this->risiko_model->all_jenis_risiko($id);
                $data['groups2'] = $this->risiko_model->all_jenis_dampak($id);
                $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
                $data['find_risiko'] = $this->risiko_model->find_risiko($id);
                $data['version_history'] = $this->risiko_model->find_history($id, $versi);
                $data['get_version'] = $this->risiko_model->get_version($id);
                $data['find_history_max'] = $this->risiko_model->find_history_max($id);

                $data['list'] = $this->risiko_model->find_data_risiko($id)[0];

                $data['act'] = 'edit';

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/addrisiko', $data);
                $this->load->view('template/global/footer');
            } else {

                $versi = $this->risiko_model->find_history_max($id);

                $risiko_tipe = $this->input->post('risiko_tipe');
                $risiko_deskripsi = $this->input->post('risiko_deskripsi');
                $dampak_risiko = $this->input->post('dampak_risiko');
                $risiko_ik = $this->input->post('risiko_ik');
                $risiko_id = $this->input->post('risiko_id');
                $risiko_penanganan = $this->input->post('risiko_penanganan');
                $version = $this->input->post('risiko_version');

                $find_risiko = $this->risiko_model->find_risiko($id);


                $data = array(
                    'RKAP_SUBPRO_ID' => $id_subprogram,
                    'RISK_TYPE' => $risiko_tipe,
                    'RISK_DESC' => $risiko_deskripsi,
                    'RISK_IMPACT' => $dampak_risiko,
                    'RISK_IK' => $risiko_ik,
                    'RISK_ID' => $risiko_id,
                    'RISK_SOLVING' => $risiko_penanganan
                );


                if ($this->risiko_model->update($id, $data)) {

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update monitroing risiko',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data monitoring risiko berhasil diubah');

                    redirect(base_url('risiko/view/' . $id_subprogram));
                } else {

                    $this->session->set_flashdata('message', 'Data monitoring risiko gagal diubah');

                    redirect(base_url('risiko/update' . $id));
                }
            }
        } else {

            redirect(base_url('risiko/view/' . $id_subprogram));
        }
    }

    public function update_risiko($id) {

        $data_risiko = $this->risiko_model->find_risiko_real($id);
        $id_subprogram = $this->risiko_model->find_risiko_real($id)->RKAP_SUBPRO_ID;

        if ($data_risiko) {

            $this->form_validation->set_rules('risiko_ik', 'Risiko IK', 'required');
            $this->form_validation->set_rules('risiko_id', 'Risiko ID', 'required');
            $this->form_validation->set_rules('realisasi_penanganan', 'Realisasi Penanganan', 'required');

            if ($this->form_validation->run() === FALSE) {

                $versi = $this->risiko_model->find_history_max($id);

                $data['row_subprogram'] = $this->risiko_model->find_subprogram($id);
                $data['groups'] = $this->risiko_model->all_jenis_risiko($id);
                $data['groups2'] = $this->risiko_model->all_jenis_dampak($id);
                $data['row_subprogram_risiko'] = $this->risiko_model->find_subprogram_risiko($id);
                $data['find_risiko'] = $this->risiko_model->find_risiko($id);
                $data['version_history'] = $this->risiko_model->find_history($id, $versi);
                $data['get_version'] = $this->risiko_model->get_version($id);
                $data['find_history_max'] = $this->risiko_model->find_history_max($id);

                $data['list'] = $this->risiko_model->find_data_risiko_real($id)[0];

                $data['act'] = 'edit';

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/edit_realisasi_risiko', $data);
                $this->load->view('template/global/footer');
            } else {

                $versi = $this->risiko_model->find_history_max($id_subprogram);

                $risiko_tipe = $this->input->post('risiko_tipe');
                $risiko_deskripsi = $this->input->post('risiko_deskripsi');
                $dampak_risiko = $this->input->post('dampak_risiko');
                $risiko_ik = $this->input->post('risiko_ik');
                $risiko_id = $this->input->post('risiko_id');
                $risiko_penanganan = $this->input->post('risiko_penanganan');
                $version = $this->input->post('risiko_version');
                $realisasi_penanganan = $this->input->post('realisasi_penanganan');

                $find_risiko = $this->risiko_model->find_risiko($id);

                if ($versi == null) {

                    $versi_update = 0;
                } else {
                    $versi_update = $versi + 1;
                }

                $data = array(
                    'RKAP_SUBPRO_ID' => $id_subprogram,
                    'RISK_TYPE' => $risiko_tipe,
                    'RISK_DESC' => $risiko_deskripsi,
                    'RISK_IMPACT' => $dampak_risiko,
                    'RISK_IK' => $risiko_ik,
                    'RISK_ID' => $risiko_id,
                    'RISK_SOLVING' => $risiko_penanganan,
                    'RISK_REALISASI' => $realisasi_penanganan,
                    'RISK_VERSION' => $versi_update
                );

                if ($this->risiko_model->add_history($id, $data)) {

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update monitroing risiko',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data monitoring risiko berhasil diubah');

                    redirect(base_url('risiko/view_risiko/' . $id_subprogram));
                } else {

                    $this->session->set_flashdata('message', 'Data monitoring risiko gagal diubah');

                    redirect(base_url('risiko/update_risiko' . $id));
                }
            }
        } else {

            redirect(base_url('risiko/view_risiko/' . $id_subprogram));
        }
    }

    public function delete_modal($id) {

        $data['list'] = $this->risiko_model->find($id);
           $data = $data['list'];
            echo json_encode($data);

        // $this->load->view('template/pages/delete_risiko_modal', $data);
    }

    public function delete($id) {
        $data_risiko = $this->risiko_model->find($id);
        $id_subprogram = $this->risiko_model->find($id)->RKAP_SUBPRO_ID;

        if ($data_risiko) {
            $data = array(
                'IS_DELETED' => 1
            );

            if ($this->risiko_model->delete($id, $data)) {
                
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete monitoring risiko',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data berhasil di hapus');

                redirect(base_url('risiko/view/' . $id_subprogram));
            } else {

                $this->session->set_flashdata('fail', 'data gagal di hapus');

                redirect(base_url('risiko/view/' . $id_subprogram));
            }
        } else {
            redirect(base_url('risiko/view/' . $id_subprogram));
        }
    }

}
