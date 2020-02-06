<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();

        //untuk prod
        if ($this->session->userdata('SESS_IS_LOGIN') === TRUE) {
            $path = ($this->session->userdata('SESS_IS_LOGIN') === TRUE) ? 'home' : '';
            redirect($path);
        }

        //untuk dev
        //redirect(base_url('Welcome'));

        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        $this->load->model('login_model');
        $this->load->model('log_model');
    }

    public function index() {
        $this->form_validation->set_rules('user_name', 'Username', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        $json_encode = array();

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/login');
        } else {
            $user_name = array(
                'USER_NAME' => $this->input->post('user_name')
            );

            if ($this->login_model->cek_user($user_name) > 0) {
                $data = array(
                    'USER_NAME' => $this->input->post('user_name'),
                    'USER_PASSWORD' => md5($this->input->post('user_password'))
                );
                $user = $this->login_model->select_user($data);

                if (count($user) > 0) {
                    if ($user->USER_STATUS == 1) {

                        $hari_ini = date('Y-m-d');
                        $hari_ini_ = explode('-', date('d-M-y', strtotime($hari_ini)));
                        $hari_ini_v = $hari_ini_[0] . '-' . strtoupper($hari_ini_[1]) . '-' . $hari_ini_[2];
                        $hari_ini_v_i = date('Y-m-d', strtotime($hari_ini_v));
                        $start_date_o = $user->START_DATE;
                        $end_date_o = $user->END_DATE;
                        // explode start
                        $start_date_a = explode('-', $start_date_o);
                        $hari_start = $start_date_a[0];
                        $bulan_start = $start_date_a[1];
                        $tahun_start = $start_date_a[2];
                        $tahun_start_y = explode(' ', $tahun_start);
                        $tahun_start_y_i = $tahun_start_y[0];
                        $start_date_c = $hari_start . '-' . $bulan_start . '-' . $tahun_start_y_i;
                        $tahun_start_p = date('Y-m-d', strtotime($start_date_c));
                        // explode end
                        $end_date_a = explode('-', $end_date_o);
                        $hari_end = $end_date_a[0];
                        $bulan_end = $end_date_a[1];
                        $tahun_end = $end_date_a[2];
                        $tahun_end_y = explode(' ', $tahun_end);
                        $tahun_end_y_i = $tahun_end_y[0];
                        $end_date_c = $hari_end . '-' . $bulan_end . '-' . $tahun_end_y_i;
                        $tahun_end_p = date('Y-m-d', strtotime($end_date_c));

                        $v_login = (($tahun_start_p <= $hari_ini) && ($tahun_end_p >= $hari_ini)) ? true : false;
                        // jika start date lebih dari sama dengan hari ini dan end date kurang dari sama dengan hari ini
                        //var_dump($hari_ini);
                        //var_dump($user->START_DATE);
                        //var_dump($user->END_DATE);
                        $json_encode = array(
                            "hari_ini" => $hari_ini,
                            "hari_ini_v" => $hari_ini_v,
                            //"hari_ini_v_i" => $hari_ini_v_i,
                            "start_date_o" => $start_date_o,
                            "end_date_o" => $end_date_o,
                            "login_" => $v_login,
                            //"start_date_a" => $start_date_a,
                            //"tahun_start" => $tahun_start,
                            //"tahun_start_y" => $tahun_start_y,
                            "start_date_c" => $start_date_c,
                            "tahun_start_p" => $tahun_start_p,
                            "end_date_c" => $end_date_c,
                            "tahun_end_p" => $tahun_end_p,
                        );
                        //echo json_encode($json_encode);
                        //die();
                        if ($v_login) {
                            // boleh login

                            if ($user->USER_PRIV == 1 && $user->USER_POSITION == 1) {
                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 1,
                                    'SESS_USER_POSITION' => 1,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data4 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data4);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai super admin');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 1 && $user->USER_POSITION == 2) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 1,
                                    'SESS_USER_POSITION' => 2,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data5 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data5);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai user pusat');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 1 && $user->USER_POSITION == 3) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 1,
                                    'SESS_USER_POSITION' => 3,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data10 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data10);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai divisi teknik');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 1 && $user->USER_POSITION == 4) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 1,
                                    'SESS_USER_POSITION' => 4,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data21 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data21);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai manajerial pusat');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 2 && $user->USER_POSITION == 2) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 2,
                                    'SESS_USER_POSITION' => 2,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data6 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data6);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai user cabang');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 2 && $user->USER_POSITION == 4) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 2,
                                    'SESS_USER_POSITION' => 4,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data9 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data9);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai manajerial cabang');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 3 && $user->USER_POSITION == 2) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 3,
                                    'SESS_USER_POSITION' => 2,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data17 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data17);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai user anak perusahaan');

                                redirect(base_url('home'));
                            } elseif ($user->USER_PRIV == 3 && $user->USER_POSITION == 4) {

                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 3,
                                    'SESS_USER_POSITION' => 4,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data23 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data23);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME . ', anda login sebagai manajerial anak perusahaan');

                                redirect(base_url('home'));
                            } else {
                                $session = array(
                                    'SESS_USER_ID' => $user->USER_ID,
                                    'SESS_USER_NAME' => $user->USER_NAME,
                                    'SESS_USER_BRANCH' => $user->USER_BRANCH,
                                    'SESS_USER_PRIV' => 4,
                                    'SESS_USER_POSITION' => 4,
                                    'SESS_IS_LOGIN' => TRUE
                                );

                                $data7 = array(
                                    'USER_ID' => $user->USER_ID,
                                    'LOG_ACTION' => 'user login application',
                                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                                    'LOG_URL' => $_SERVER['REQUEST_URI']
                                );

                                $this->log_model->add($data7);

                                $this->session->set_userdata($session);

                                $this->session->set_flashdata('login', 'Selamat datang pegawai ' . $user->USER_NAME);

                                redirect(base_url('home'));
                            }
                        } else {
                            $this->session->set_flashdata('user_name', $this->input->post('user_name'));

                            $this->session->set_flashdata('message', 'Akun tidak aktif');

                            redirect('login');
                        }
                    } else {
                        $this->session->set_flashdata('user_name', $this->input->post('user_name'));

                        $this->session->set_flashdata('message', 'Akun tidak aktif');

                        redirect('login');
                    }
                } else {
                    $this->session->set_flashdata('user_name', $this->input->post('user_name'));

                    $this->session->set_flashdata('message', 'Username atau password salah');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('user_name', $this->input->post('user_name'));

                $this->session->set_flashdata('message', 'Username atau password tidak terdaftar');
                redirect('login');
            }
        }
    }

    Public function login_temp() {

        $this->load->view('template/login2');
    }

}
