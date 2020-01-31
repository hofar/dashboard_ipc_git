<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ganttchart extends CI_Controller {

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
        $this->load->model('ganttchart_model');
        $this->load->model('subprogramrkap_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');

        $this->data['notif_announcement'] = $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count'] = $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi'] = $this->notifikasi_model->realisasi_no($cab)->result();
    }

    public function view($id) {

        $data['list'] = $this->ganttchart_model->all($id);
        $data['row_rkap'] = $this->ganttchart_model->find_rkap($id);
        $data['list_rkap'] = $this->rkap_model->detail($id)[0];

        $data['report'] = $this->ganttchart_model->tampilganttchartnew($id);

        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view ganttchart',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );

        $this->log_model->add($data4);

        $this->load->view('template/global/header', $this->data);
        $this->load->view('template/pages/viewganttchart', $data);
    }

    public function add_modal($id) {

        $data['list'] = $this->ganttchart_model->find($id);
        echo json_encode($data);

        // $this->load->view('template/pages/add_ganttchart_modal', $data);
    }

    public function addsubpro_modal($id) {
        $data['row_rkap'] = $this->subprogramrkap_model->find_rkap($id);
        $data['list'] = $this->subprogramrkap_model->all($id);
        // $data['groups'] = $this->subprogramrkap_model->all_jenis_subprogram();
        $data['act'] = 'add';

        echo json_encode($data);
        // $this->load->view('template/pages/add_subpro_in_gantt', $data);
    }

    public function list_subpro() {
        $data['subpro'] = $this->subprogramrkap_model->all_jenis_subprogram();
        echo json_encode($data);
    }

    public function add($id) {

        $data_ganttchart = $this->ganttchart_model->find($id);
        $id_rkap = $this->ganttchart_model->find($id)->RKAP_SUBPRO_INVS_ID;

        if ($data_ganttchart) {

            $this->form_validation->set_rules('tgl_start', 'Start Date', 'required');
            $this->form_validation->set_rules('tgl_end', 'End Date', 'required');

            if ($this->form_validation->run() === FALSE) {

                $data['list'] = $this->ganttchart_model->all($id);
                $data['row_rkap'] = $this->ganttchart_model->find_rkap($id);

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewganttchart', $data);
                $this->load->view('template/global/footer');
            } else {

                $tgl_start = $this->input->post('tgl_start');
                $tgl_end = $this->input->post('tgl_end');

                $data = array(
                    'RKAP_SUBPRO_START' => Datetime::createFromFormat('d-m-Y', $tgl_start)->format('d-M-y'),
                    'RKAP_SUBPRO_END' => Datetime::createFromFormat('d-m-Y', $tgl_end)->format('d-M-y'),
                    'IS_GANTTCHART' => 1
                );

                if ($this->ganttchart_model->update($id, $data)) {

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user add ganttchart',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data ganttchart berhasil diubah');

                    redirect(base_url('ganttchart/view/' . $id_rkap));
                } else {

                    $this->session->set_flashdata('message', 'Data ganttchart gagal diubah');

                    redirect(base_url('ganttchart/view/' . $id_rkap));
                }
            }
        } else {

            redirect(base_url('ganttchart/view/' . $id_rkap));
        }
    }

    public function add_subpro($id) {

        $data_ganttchart = $this->ganttchart_model->find($id);
        $id_rkap = $this->ganttchart_model->find($id)->RKAP_SUBPRO_INVS_ID;


        $this->form_validation->set_rules('judul_sub_program', 'Judul Sub Program', 'required');
        $this->form_validation->set_rules('jenis_sub_program', 'Jenis Sub Program', 'required');

        if ($this->form_validation->run() === FALSE) {

            $data['list'] = $this->ganttchart_model->all($id);
            $data['row_rkap'] = $this->ganttchart_model->find_rkap($id);


            $this->load->view('template/global/header', $this->data);
            $this->load->view('template/pages/viewganttchart', $data);
            $this->load->view('template/global/footer');
        } else {

            $judul_sub_program = $this->input->post('judul_sub_program');
            $jenis_sub_program = $this->input->post('jenis_sub_program');
            $id_rkap_subpro = $this->input->post('id_rkap');

            $data = array(
                'RKAP_SUBPRO_TITTLE' => $judul_sub_program,
                'RKAP_SUBPRO_INVS_ID' => $id_rkap_subpro,
                'RKAP_SUBPRO_TYPE_ID' => $jenis_sub_program
            );

            if ($this->subprogramrkap_model->add($data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user add subprogram in ganttchart',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data sub program berhasil diubah');

                redirect(base_url('ganttchart/view/' . $id_rkap_subpro));
            } else {

                $this->session->set_flashdata('message', 'Data sub program gagal diubah');

                redirect(base_url('ganttchart/view/' . $id_rkap_subpro));
            }
        }
    }

    public function update_modal($id) {

        $data['list'] = $this->ganttchart_model->find($id);
        echo json_encode($data);

        // $this->load->view('template/pages/update_ganttchart_modal', $data);
    }

    public function update($id) {


        $data_ganttchart = $this->ganttchart_model->find($id);
        $id_rkap = $this->ganttchart_model->find($id)->RKAP_SUBPRO_INVS_ID;

        if ($data_ganttchart) {

            $this->form_validation->set_rules('tgl_start', 'Start Date', 'required');
            $this->form_validation->set_rules('tgl_end', 'End Date', 'required');

            if ($this->form_validation->run() === FALSE) {

                $data['list'] = $this->ganttchart_model->all($id);
                $data['row_rkap'] = $this->ganttchart_model->find_rkap($id);

                $this->load->view('template/global/header', $this->data);
                $this->load->view('template/pages/viewganttchart', $data);
                $this->load->view('template/global/footer');
            } else {

                $tgl_start = $this->input->post('tgl_start');
                $tgl_end = $this->input->post('tgl_end');

                $data = array(
                    'RKAP_SUBPRO_START' => Datetime::createFromFormat('d-m-Y', $tgl_start)->format('d-M-y'),
                    'RKAP_SUBPRO_END' => Datetime::createFromFormat('d-m-Y', $tgl_end)->format('d-M-y'),
                    'IS_GANTTCHART' => 1
                );

                if ($this->ganttchart_model->update($id, $data)) {

                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'user update ganttchart',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );

                    $this->log_model->add($data4);

                    $this->session->set_flashdata('success', 'Data ganttchart berhasil diubah');

                    redirect(base_url('ganttchart/view/' . $id_rkap));
                } else {

                    $this->session->set_flashdata('message', 'Data ganttchart gagal diubah');

                    redirect(base_url('ganttchart/view' . $id_rkap));
                }
            }
        } else {

            redirect(base_url('ganttchart/view/' . $id_rkap));
        }
    }

    public function delete_modal($id) {

        $data['list'] = $this->ganttchart_model->find($id);
        echo json_encode($data);

        // $this->load->view('template/pages/delete_ganttchart_modal', $data);
    }

    public function delete($id) {
        $data_ganttchart = $this->ganttchart_model->find($id);
        $id_rkap = $this->ganttchart_model->find($id)->RKAP_SUBPRO_INVS_ID;

        if ($data_ganttchart) {
            $data = array(
                'IS_GANTTCHART' => 0,
                'RKAP_SUBPRO_START' => null,
                'RKAP_SUBPRO_END' => null
            );

            if ($this->ganttchart_model->delete($id, $data)) {

                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user delete ganttchart',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

                $this->log_model->add($data4);

                $this->session->set_flashdata('success', 'Data ' . $data_ganttchart->RKAP_SUBPRO_TITTLE . ' berhasil di hapus dari ganttchart');

                redirect(base_url('ganttchart/view/' . $id_rkap));
            } else {

                $this->session->set_flashdata('fail', 'data gagal di hapus');

                redirect(base_url('ganttchart/view/' . $id_rkap));
            }
        } else {
            redirect(base_url('ganttchart/view/' . $id_rkap));
        }
    }

}
