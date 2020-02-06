<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Usermanagement extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('SESS_IS_LOGIN') || ($this->session->userdata('SESS_IS_LOGIN') && $this->session->userdata('SESS_USER_POSITION') !== 1)) {
            
            redirect(base_url('login'));
        }
        
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('log_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
    }
    
    public function index() {
        
        $this->form_validation->set_rules('username', 'search username', 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            
            $data['list'] = $this->user_model->all();
            $this->session->unset_userdata('username');
            $data4 = array(
                'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                'LOG_ACTION' => 'view user',
                'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                'LOG_URL' => $_SERVER['REQUEST_URI']
            );
            
            $this->log_model->add($data4);
            
            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewusermanagement', $data);
            $this->load->view('template/global/footer');
        } else {
            
            $key = $this->user_model->search_username();
            $data['list'] = $key;
            $this->session->set_flashdata('username', $this->input->post('username'));
            $data4 = array(
                'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                'LOG_ACTION' => 'search user',
                'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                'LOG_URL' => $_SERVER['REQUEST_URI']
            );
            
            $this->log_model->add($data4);
            
            $this->load->view('template/global/header',$this->data);
            $this->load->view('template/pages/viewusermanagement', $data);
            $this->load->view('template/global/footer');
        }
    }
    
    public function register() {
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nipp', 'NIPP', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', ' Email', 'required');
        $this->form_validation->set_rules('privilage', ' Privilage', 'required');
        $this->form_validation->set_rules('branch', ' Branch', 'required');
        $this->form_validation->set_rules('posisi', ' Posisi', 'required');
        
        
        $data['groups'] = $this->user_model->all_privilage();
        $data['groups1'] = $this->user_model->all_branch();
        $data['groups2'] = $this->user_model->all_posisi();
        $data['groupsPusat1'] = $this->user_model->branch_pusat();
        $data['groupsPusat2'] = $this->user_model->posisi_pusat();
        $data['groupsAnak1'] = $this->user_model->branch_anak();
        $data['groupsAnak2'] = $this->user_model->posisi_anak();
        
        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/adduser', $data);
        $this->load->view('template/global/footer');
    }
    
    public function added() {
        
        $username = $this->input->post('username');
        $nipp = $this->input->post('nipp');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $privilage = $this->input->post('privilage');
        $branch = $this->input->post('branch');
        $posisi = $this->input->post('posisi');
        
        $polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $polapassword = "/^.{5,}$/";
        
        
        if ($this->user_model->member_konflik($username) > 0 || !preg_match($polapassword, $this->input->post('password')) || !preg_match($polaemail, $this->input->post('email'))) {
            
            if (!preg_match($polapassword, $this->input->post('password'))) {
                $this->session->set_flashdata('password', 'Password minimal terdiri dari 5 karakter');
            }
            
            if (!preg_match($polaemail, $this->input->post('email'))) {
                $this->session->set_flashdata('valid_email', 'Email Tidak Valid');
            }
            
            if ($this->user_model->member_konflik($username) > 0) {
                $this->session->set_flashdata('username', 'Username telah terdaftar sebelumnya');
            }
            
            
            $this->session->set_flashdata('USERNAM', $this->input->post('username'));
            $this->session->set_flashdata('NIP', $this->input->post('nipp'));
            $this->session->set_flashdata('PASSWOR', $this->input->post('password'));
            $this->session->set_flashdata('MAIL', $this->input->post('email'));
            
            redirect(base_url('usermanagement/register'));
        } else {
            
            $data = array(
                'USER_NAME' => $username,
                'USER_NIPP' => $nipp,
                'USER_PASSWORD' => md5($password),
                'USER_EMAIL' => $email,
                'USER_PRIV' => $privilage,
                'USER_BRANCH' => $branch,
                'USER_POSITION' => $posisi,
                'USER_STATUS' => 1,
            );
            
            // print_r($data); exit()
            
            $this->session->set_userdata($data);
            
            if ($this->user_model->add($data)) {
                
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'add user',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);
                
                $this->session->set_flashdata('message', 'Registrasi user berhasil');
                
                redirect(base_url('usermanagement'));
            } else {
                
                $this->session->set_flashdata('warning', 'Maaf, Anda Belum Bisa Regristrasi Mohon Isi Data Dengan Benar');
                
                redirect(base_url('usermanagement/register'));
            }
        }
    }
    
    public function update($id) {
        $this->form_validation->set_rules('username', 'Username', 'trim');
        $this->form_validation->set_rules('nipp', 'NIPP', 'trim');
        $this->form_validation->set_rules('email', ' Email', 'trim');
        $this->form_validation->set_rules('privilage', ' Privilage', 'trim');
        $this->form_validation->set_rules('branch', ' Branch', 'trim');
        $this->form_validation->set_rules('posisi', ' Posisi', 'trim');
        
        $user = $this->user_model->finduser($id);
        
        if (count($user) > 0) {
            
            if ($this->form_validation->run() === FALSE) {
                
                $data['groups'] = $this->user_model->all_privilage();
                $data['groups1'] = $this->user_model->all_branch();
                $data['groups2'] = $this->user_model->all_posisi();
                $data['groupsPusat1'] = $this->user_model->branch_pusat();
                $data['groupsPusat2'] = $this->user_model->posisi_pusat();
                $data['groupsAnak1'] = $this->user_model->branch_anak();
                $data['groupsAnak2'] = $this->user_model->posisi_anak();
                
                $data['list'] = $this->user_model->finduser($id);
                
                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/edit_user', $data);
                $this->load->view('template/global/footer');
            } else {
                
                $data = array(
                    'USER_NAME' => $this->input->post('username'),
                    'USER_NIPP' => $this->input->post('nipp'),
                    'USER_EMAIL' => $this->input->post('email'),
                    'USER_PRIV' => $this->input->post('privilage'),
                    'USER_BRANCH' => $this->input->post('branch'),
                    'USER_POSITION' => $this->input->post('posisi')
                );
                
                if ($this->user_model->update($id, $data)) {
                    
                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'update akun user',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );
                    
                    $this->log_model->add($data4);
                    
                    $this->session->set_flashdata('message', 'Data berhasil diubah');
                    
                    redirect(base_url('usermanagement'));
                } else {
                    
                    $this->session->set_flashdata('error', 'Data gagal diubah');
                    
                    redirect(base_url('usermanagement/update/' . $id));
                }
            }
        } else {
            redirect(base_url('usermanagement'));
        }
    }
    
    public function update_pass_user($id) {
        
        
        if ($this->input->post('password_new') == $this->input->post('password_konfirm')) {
            $data1 = array(
                'USER_PASSWORD' => md5($this->input->post('password_new'))
            );
            
            if ($this->user_model->update_pass_user($id, $data1)) {
                
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'update password akun user',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);
                
                $this->session->set_flashdata('success', 'Password berhasil diubah');
                
                redirect(base_url('usermanagement'));
            } else {
                
                $this->session->set_flashdata('message', 'Password gagal diubah');
                
                redirect(base_url('usermanagement/update/' . $id));
            }
        } else {
            
            $this->session->set_flashdata('warning', 'Password baru dan konfirmasi password tidak sama');
            
            redirect(base_url('usermanagement/update/' . $id));
        }
    }
    
    public function edit_modalstatus($id) {
        
        $data['list'] = $this->user_model->finduser($id);
        $data = $data['list'];
        echo json_encode($data);
        
        // $this->load->view('template/pages/edit_modalstatus', $data);
    }
    
    public function update_status($id) {
        $this->form_validation->set_rules('status', 'Konfirmasi', 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            
            redirect(base_url('usermanagement'));
        } else {
            $status = $this->input->post('status');
            
            $data = array(
                'USER_STATUS' => $status
            );
            
            if ($this->user_model->update($id, $data)) {
                
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'update status user',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);
                
                $this->session->set_flashdata('success', 'Data berhasil diubah');
                
                redirect(base_url('usermanagement'));
            } else {
                
                $this->session->set_flashdata('warning', 'data gagal diubah');
                
                redirect(base_url('usermanagement'));
            }
        }
    }
    
    public function delete_modal($id) {
        
        $data['list'] = $this->user_model->finduser($id);
        $data = $data['list'];
        echo json_encode($data);
        
        // $this->load->view('template/pages/delete_user_modal', $data);
    }
    
    
    
    //delete by checked cread by johan & hofar tanggal 37/01/2020
    
    public function delete_all(){
        
        $list_id = $this->input->post('USER_ID');
        // var_dump($list_id);
        $del_ok = 0;
        $del_fail=0;
        foreach ($list_id as $id) {
            //$this->User_model->delete_by_id($id);
            
            if ($this->user_model->update_user($id)) {
                // $data6 = array(
                    //     'USER_STATUS' => 2
                    // );
                    
                    //$this->user_model->update_is_active($id, $data6);
                    
                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'delete user',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );
                    
                    $this->log_model->add($data4);
                    
                    //$this->session->set_flashdata('success', 'Data berhasil dihapus');
                    $del_fail++;
                    
                    //redirect(base_url('usermanagement'));
                } else {
                    
                    //$this->session->set_flashdata('fail', 'Data gagal dihapus');
                    
                    //redirect(base_url('usermanagement'));
                    
                    $del_ok++;
                }
            }
            echo json_encode(array("status" => true,"input"=>$list_id,"del_ok"=>$del_ok,"del_fail"=>$del_fail));
        }  
        
        
        
        public function desain_user(){
            $this->form_validation->set_rules('username', 'search username', 'trim');
            
            if ($this->form_validation->run() === FALSE) {
                
                $data['list'] = $this->user_model->all();
                $this->session->unset_userdata('username');
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'view user',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);
                
                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/v_desain_user', $data);
                $this->load->view('template/global/footer');
            } else {
                
                $key = $this->user_model->search_username();
                $data['list'] = $key;
                $this->session->set_flashdata('username', $this->input->post('username'));
                $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'search user',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                
                $this->log_model->add($data4);
                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/v_desain_user',$data);
                $this->load->view('template/global/footer');
                
            }
        }
        
        
        
        public function delete($id) {
            if ($this->user_model->update_user($id)) {
                // $data6 = array(
                    //     'USER_STATUS' => 2
                    // );
                    
                    //$this->user_model->update_is_active($id, $data6);
                    
                    $data4 = array(
                        'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                        'LOG_ACTION' => 'delete user',
                        'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                        'LOG_URL' => $_SERVER['REQUEST_URI']
                    );
                    
                    $this->log_model->add($data4);
                    
                    $this->session->set_flashdata('success', 'Data berhasil dihapus');
                    
                    redirect(base_url('usermanagement'));
                } else {
                    
                    $this->session->set_flashdata('fail', 'Data gagal dihapus');
                    
                    redirect(base_url('usermanagement'));
                }
            }
            
        }
        