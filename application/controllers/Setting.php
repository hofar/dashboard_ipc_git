<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Controller {

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
        $this->load->model('announcement_model');
        $this->load->model('main_model');
        $this->load->model('setting_model');
        
        $this->data['notif_count']= $this->main_model->count_data();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $this->load->library('m_pdf');
    }

    public function index() {

        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user view announcement',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );
                // echo json_encode($data4); exit();
        $this->log_model->add($data4);

        $data['list'] = $this->setting_model->all();

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/viewsetting', $data);
        $this->load->view('template/global/footer');
    }

    public function add()
	{
		// bikin rule validation
		$this->form_validation->set_rules('deviasi_a', 'Deviasi a', 'required');
		$this->form_validation->set_rules('deviasi_b', 'Deviasi b', 'required');

		// cek apakah validation is run
		if ($this->form_validation->run() === FALSE) {
			// tampilkan form
			$this->load->view('template/global/header',$this->data);
	        $this->load->view('template/pages/addsetting');
	        $this->load->view('template/global/footer');
		} else {
			// lakukan logic buat add
			$deviasi_a = $this->input->post('deviasi_a');
			$deviasi_b = $this->input->post('deviasi_b');
			// masukkan ke array data untuk di pass ke model agar di masukkan ke database
			$data = array(
				'CRITIC_DEVIASI_A' => $deviasi_a,
				'CRITIC_DEVIASI_B' => $deviasi_b,
				'STATUS' => 1
			);

			if ($this->setting_model->add($data)) {

				$setting_data = $this->setting_model->find_setting();
				$id_sebelumnya = $setting_data->CRITIC_ID;
				// print_r($id_sebelumnya); die();
				$data1 = array(
	                'STATUS' => 0
	            );

	            $this->setting_model->update($id_sebelumnya, $data1);
				// set message berhasil
				$this->session->set_flashdata('success', 'Data telah berhasil ditambahkan');

				// arahkan ke list
				redirect(base_url('setting'));
			} else {
				// set message gagal
				$this->session->set_flashdata('fail', 'Data gagal ditambahkan, silahkan ulangi kembali');

				// arahkan ke form untuk diisi kembali
				redirect(base_url('setting'));
			}
		}
	}

	public function delete_modal($id)
    {
        
        $data['list']= $this->setting_model->find($id);
        $data = $data['list'];
        echo json_encode($data);
        
        // $this->load->view('template/pages/delete_setting_modal', $data);
    }

    public function delete($id)
	{
		// ambil data dari database yang mempunyai id = $id
		$setting_data = $this->setting_model->find($id);
		# $variabel_bebas = 0 / 1. tergantung dari fungsi diatas
		# 0: false, 1:true

		// cek terlebih dahulu apakah data tersebut ada atau tidak
		if ($setting_data) {
			// jika ada datanya maka jalankan blok berikut
			// awal blok
			if ($this->setting_model->delete($id)) {
				// set message berhasil
				$this->session->set_flashdata('success', 'Data berhasil di hapus');

				redirect(base_url('setting'));
			} else {
				// set message gagal
				$this->session->set_flashdata('fail', 'Data gagal di hapus');

				// arahkan ke form untuk diisi kembali
				redirect(base_url('setting'));
			}
			// akhir blok
		} else {
			// kalau tidak ada arahkan ke list
			redirect(base_url('setting'));
		}
	}

	 public function edit_modalstatus($id) {

        $data['list'] = $this->setting_model->find($id);
        $data = $data['list'];
        echo json_encode($data);

        // $this->load->view('template/pages/edit_modalsetting', $data);
    }

    public function update_status($id) {

    	$count_data = $this->setting_model->is_active()->COUNT_STATUS;
    	// print_r($count_data); die();
    	// if ($count_data == 0) {
    		
			$this->form_validation->set_rules('status', 'Konfirmasi', 'trim');

	        if ($this->form_validation->run() === FALSE) {

	            redirect(base_url('setting'));
	        } else {
	            $status = $this->input->post('status');

	            $data = array(
	                'STATUS' => $status
	            );

	            if ($data['STATUS'] == 1){

	            	if ($count_data >= 1) {

	            		 $this->session->set_flashdata('fail', 'data aktif tidak boleh lebih dari satu');

		                redirect(base_url('setting'));
	            	}
	            	else{

	            		 if ($this->setting_model->update($id, $data)) {

			                $data4 = array(
			                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
			                    'LOG_ACTION' => 'update status setting',
			                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
			                    'LOG_URL' => $_SERVER['REQUEST_URI']
			                );

			                $this->log_model->add($data4);

			                $this->session->set_flashdata('success', 'data berhasil di ubah');

			                redirect(base_url('setting'));
			            } else {

			                $this->session->set_flashdata('fail', 'data gagal di ubah');

			                redirect(base_url('setting'));
			            }
	            	}

	            }
	            else{

	            	 if ($this->setting_model->update($id, $data)) {

		                $data4 = array(
		                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
		                    'LOG_ACTION' => 'update status setting',
		                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
		                    'LOG_URL' => $_SERVER['REQUEST_URI']
		                );

		                $this->log_model->add($data4);

		                $this->session->set_flashdata('success', 'data berhasil di ubah');

		                redirect(base_url('setting'));
		            } else {

		                $this->session->set_flashdata('fail', 'data gagal di ubah');

		                redirect(base_url('setting'));
		            }
	            }
	           
	        }
        
    }

    public function ews() {

        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'USER_NAME' => $this->session->userdata('SESS_USER_NAME'),
                    'LOG_ACTION' => 'user view setting early warning system',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI'],
                    'CLIENT_HTTP_AGENT' => $_SERVER['HTTP_USER_AGENT']
                );
                // echo json_encode($data4); exit();
        $this->log_model->add_ews($data4);

        $data['list'] = $this->setting_model->get_ews_data();

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/viewsettingews', $data);
        $this->load->view('template/global/footer');
	}
	
	public function edit_ews() {
		$get_data = $_POST;
		$id = 1;

		
		
		for ($i=0; $i < count($get_data); $i++) { 
			$result = $get_data['reminderInput'.$i];
			$this->setting_model->update_ews_data($id, $result);
			$id++;
		}

		 $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'USER_NAME' => $this->session->userdata('SESS_USER_NAME'),
                    'LOG_ACTION' => 'user update setting early warning system, kontak kritis = '.$get_data['reminderInput0'].' dan addendum = '.$get_data['reminderInput1'],
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI'],
                    'CLIENT_HTTP_AGENT' => $_SERVER['HTTP_USER_AGENT']
                );
		 // print_r($data4); die();
		$this->log_model->add_ews($data4);

        $data['list'] = $this->setting_model->get_ews_data();		

        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/viewsettingews', $data);
        $this->load->view('template/global/footer');
	 }
	 
	 public function change($id,$y)
	 {
		 $date = new DateTime();
		//var_dump($date->format('Y'));
		 if ($y == 'Y') {
			$dt = 'N-'.$date->format('Y');
		 }else{
			$dt = 'Y';
		 }
		$this->db->query("UPDATE tx_rkap_investation SET ON_USE = '$dt' WHERE RKAP_INVS_ID = $id ");
		//echo "Berhasil";
		redirect(base_url('rkapinvestasi'));
	 }

	public function ubahpersen($id_po)
	{
		//$this->load->model('subprogramrkap_model');
		$this->setting_model->ubahpersen($id_po);
		//echo json_encode($q);
	}
}
