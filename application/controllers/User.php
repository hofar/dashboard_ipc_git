<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('SESS_IS_LOGIN')) {

            redirect(base_url('login'));
        }
		
		$this->output->set_header('Last-Modified:'.gmdate('D,d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control:post-check=0,pre-check=0',false);
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

	public function index()
	{
		
	}

	public function update_pass($id)
        {
            $this->form_validation->set_rules('password', 'Password Baru', 'required');
            $this->form_validation->set_rules('password_new', 'Password', 'required');
            $this->form_validation->set_rules('password_konfirm', 'Konfirmasi Password', 'required');

            if ( $this->form_validation->run() === FALSE ) {

                $data['list'] = $this->user_model->finduser($id);

                $this->load->view('template/global/header',$this->data);
                $this->load->view('template/pages/edit_user_pass', $data);
                $this->load->view('template/global/footer');

            } else {

                $data = array(
                    'USER_PASSWORD' => md5($this->input->post('password'))
                        );

                        $user = $this->user_model->select_user($data);

                        if (count($user) > 0) {

                            if ($this->input->post('password_new') == $this->input->post('password_konfirm')) {
                                $data1 = array(
                                    'USER_PASSWORD' => md5($this->input->post('password_new'))
                                );

                                if ($this->user_model->update_pass($id, $data1)) {

                                    $this->session->set_flashdata('success', 'Data berhasil di update');

                                    redirect(base_url('user/update_pass/' . $id));
                                } else {

                                    $this->session->set_flashdata('message', 'Data gagal di update');
                                    
                                }
                            } else {
                                $this->session->set_flashdata('warning', 'Password baru dan konfirmasi password tidak sama');
                            }
                        } else {

                            $this->session->set_flashdata('warning', 'Password lama salah');
                        }

                        redirect(base_url('user/update_pass/' . $id));
                    }
                }

		

	  

}
