<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class tes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control:no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control:post-check=0,pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $this->load->model('setting_model');
        $this->load->model('ews_model');
    }

    public function send_mail_kontrak_kritis() {
        $this->load->library('email');

        $id_branch = array('010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $reminderKontrakKritis = $this->setting_model->get_data_reminder_kon_krit()->DATA_REMINDER;

        $reminderKontrakKritis = $reminderKontrakKritis == null ? 0 : $reminderKontrakKritis;

        $data['ews'] = 'Kontrak Kritis';

        $a = 0;
        $i = '010';

        $jml = count($id_branch);

        while ($i == $id_branch[$a]) {
            $data['total_kontrak_kritis'] = $this->ews_model->total_kontrak_kritis($id_branch[$a], $get_bulan, $reminderKontrakKritis);
            $data['detail_kontrak_kritis'] = $this->ews_model->detail_kontrak_kritis($id_branch[$a], $get_bulan, $reminderKontrakKritis);

            // Merubah bentuk data dari array ke objek

            if (is_array($data['total_kontrak_kritis'])) {
                $object = new stdClass();
                foreach ($data['total_kontrak_kritis'] as $key) {
                    $object->KETERLAMBATAN = 0;
                }

                $data['total_kontrak_kritis'] = $object;
            }

            // Format email

            if ($data['total_kontrak_kritis']->KETERLAMBATAN > 0) {
                $subject = 'EWS - Kontrak Kritis';

                $result = $this->email
                        ->from('no-reply@indonesiaport.co.id')
                        ->to($data['detail_kontrak_kritis'][0]->USER_EMAIL)
                        ->subject($subject)
                        ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                        ->send();
            }

            $a = $a + 1;

            if ($jml == $a) {
                break;
            }

            $i = $id_branch[$a];
            unset($data['total_kontrak_kritis']);
            unset($data['detail_kontrak_kritis']);
        }

        $this->session->set_flashdata('message', 'Email telah terkirim ke ');
        redirect(base_url(''));

        exit;
    }

    public function send_mail_start_subpro() {
        $this->load->library('email');

        $id_branch = array('010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');

        $data['ews'] = 'Start Sub Program';

        $a = 0;
        $i = '010';

        $jml = count($id_branch);

        while ($i == $id_branch[$a]) {
            $data['total_sub_program'] = $this->ews_model->total_start_sub_program($id_branch[$a]);
            $data['detail_sub_program'] = $this->ews_model->detail_start_sub_program($id_branch[$a]);

            // Format email

            if (count($data['total_sub_program']) > 0) {
                $subject = 'EWS - Start Sub Program';

                $result = $this->email
                        ->from('no-reply@indonesiaport.co.id')
                        ->to($data['detail_sub_program'][0]->USER_EMAIL)
                        ->subject($subject)
                        ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                        ->send();
            }
            $a = $a + 1;

            if ($jml == $a) {
                break;
            }

            $i = $id_branch[$a];
            unset($data['total_sub_program']);
            unset($data['detail_sub_program']);
        }

        $this->session->set_flashdata('message', 'Email telah terkirim ke ');
        redirect(base_url(''));

        exit;
    }

    public function send_mail_realisasi_pelaporan() {
        $this->load->library('email');

        $id_branch = array('010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');

        $data['ews'] = 'Input Realisasi Pelaporan';

        $a = 0;
        $i = '010';

        $jml = count($id_branch);

        while ($i == $id_branch[$a]) {
            $tempData = $this->ews_model->get_rkap_id_not_current_date_realisasi_pelaporan($id_branch[$a]);
            $tempId = '';

            for ($i = 0; $i < count($tempData); $i++) {
                $tempId = $tempId . $tempData[$i]->RKAP_SUBPRO_ID . ', ';
            }

            $id_rkap_not_current_date = $tempId != '' ? rtrim($tempId, ', ') : 'null';

            $id_rkap_duplicate = $this->ews_model->get_id_rkap_duplicate_realisasi_pelaporan($id_branch[$a], $id_rkap_not_current_date);
            $id_real = '';

            for ($i = 0; $i < count($id_rkap_duplicate); $i++) {
                if ($id_rkap_duplicate[$i]->RKAP_SUBPRO_ID == $id_rkap_duplicate[$i - 1]->RKAP_SUBPRO_ID) {
                    $id_real = $id_real . $id_rkap_duplicate[$i]->REAL_SUBPRO_ID . ', ';
                }
            }

            $id_real = $id_real != '' ? rtrim($id_real, ', ') : 'null';

            $data['total_realisasi_pelaporan'] = $this->ews_model->total_realisasi_pelaporan($id_branch[$a], $id_real);
            $data['detail_realisasi_pelaporan'] = $this->ews_model->detail_realisasi_pelaporan($id_branch[$a], $id_real);

            // Format email

            if (count($data['total_realisasi_pelaporan']) > 0) {
                $subject = 'EWS - Input Realisasi Pelaporan';

                $result = $this->email
                        ->from('no-reply@indonesiaport.co.id')
                        ->to($data['detail_realisasi_pelaporan'][0]->USER_EMAIL)
                        ->subject($subject)
                        ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                        ->send();
            }

            $a = $a + 1;

            if ($jml == $a) {
                break;
            }

            $i = $id_branch[$a];
            unset($data['total_realisasi_pelaporan']);
            unset($data['detail_realisasi_pelaporan']);
        }

        $this->session->set_flashdata('message', 'Email telah terkirim ke ');
        redirect(base_url(''));

        exit;
    }

    public function send_mail_kontrak_b_a() {
        $this->load->library('email');

        $id_branch = array('010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');

        $reminderKontrakBA = $this->setting_model->get_data_reminder_kontrak_b_a()->DATA_REMINDER;
        $reminderKontrakBA = $reminderKontrakBA == null ? 0 : $reminderKontrakBA;

        $data['ews'] = 'Kontrak Berakhir / Addendum';

        $a = 0;
        $i = '010';

        $jml = count($id_branch);

        while ($i == $id_branch[$a]) {
            $data['total_kontrak_b_a'] = $this->ews_model->total_kontrak_b_a($id_branch[$a], $reminderKontrakBA);
            $data['detail_kontrak_b_a'] = $this->ews_model->detail_kontrak_b_a($id_branch[$a], $reminderKontrakBA);

            // Format email

            if (count($data['total_kontrak_b_a']) > 0) {
                $subject = 'EWS - Kontrak Berakhir / Addendum';

                $result = $this->email
                        ->from('no-reply@indonesiaport.co.id')
                        ->to($data['detail_kontrak_b_a'][0]->USER_EMAIL)
                        ->subject($subject)
                        ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                        ->send();
            }

            $a = $a + 1;

            if ($jml == $a) {
                break;
            }

            $i = $id_branch[$a];
            unset($data['total_kontrak_b_a']);
            unset($data['detail_kontrak_b_a']);
        }

        $this->session->set_flashdata('message', 'Email telah terkirim ke ');
        redirect(base_url(''));

        exit;
    }

    public function real_prev_year() {
        $this->load->model('login_model');
        $this->load->model('rkap_model');
        $this->load->model('log_model');
        $this->load->model('notifikasi_model');
        $this->load->model('realisasi_model');
        $this->load->model('ganttchart_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $cek_month = $date->format('m');
        $cek_year = $date->format('Y');

        $data = $this->rkap_model->sampai_bulan_ini($get_bulan);

        if ($cek_month == '12') {
            for ($i = 0; $i < count($data); $i++) {
                $result = $data[$i]->REAL_SUBPRO_VAL;
                $id = $data[$i]->RKAP_SUBPRO_INVS_ID;
                $this->setting_model->update_real_prev_year($id, $result);
            }
        }
    }

    public function real_prev_year_subpro() {
        $this->load->model('login_model');
        $this->load->model('rkap_model');
        $this->load->model('log_model');
        $this->load->model('notifikasi_model');
        $this->load->model('realisasi_model');
        $this->load->model('ganttchart_model');
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $cek_month = $date->format('m');
        $cek_year = $date->format('Y');

        $data = $this->rkap_model->sampai_bulan_ini_subpro($get_bulan);
        // print_r($data); die();
        if ($cek_month == '12') {
            for ($i = 0; $i < count($data); $i++) {
                $result = $data[$i]->REAL_SUBPRO_VAL;
                $id = $data[$i]->RKAP_SUBPRO_ID;
                $this->setting_model->update_real_prev_year_subpro($id, $result);
            }
        }
    }

    public function coba2() {
        // $id_branch = array('010','020','030', '040', '050', '060', '070','080', '090', '100', '110', '120');
        // $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        // $get_bulan = $date->format('Y-m');		
        // $reminderKontrakKritis = $this->setting_model->get_data_reminder_kon_krit()->DATA_REMINDER;
        // $reminderKontrakKritis = $reminderKontrakKritis == null ? 0 : $reminderKontrakKritis;
        // if (is_array($data['total_kontrak_kritis'])) {
        // 	$object = new stdClass();
        // 	foreach ($data['total_kontrak_kritis'] as $key) {
        // 		$object->KETERLAMBATAN = 0;
        // 	}
        // 	$data['total_kontrak_kritis'] = $object;
        // }
        // $data['ews'] = 'Kontrak Kritis';
        // $data['total_kontrak_kritis']	= $this->ews_model->total_kontrak_kritis('010', $get_bulan, $reminderKontrakKritis);
        // $data['detail_kontrak_kritis'] 	= $this->ews_model->detail_kontrak_kritis('010', $get_bulan, $reminderKontrakKritis);
        //echo json_encode($data);
        //$this->load->view('template/pages/sendmail_ews',$data);	



        $branch = $this->setting_model->dtemail();
        echo json_encode($branch);
    }

    public function emailkontrakkritis() {
        $this->load->library('email');
        $this->load->model('main_model');

        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $data['ews'] = 'Kontrak Kritis';

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_kontrak_end = $date->format('Y-m-d');
        $get_bulan = $date->format('Y-m');

        $id_branch = $this->setting_model->dtemail();

        for ($i = 0; $i < count($id_branch); $i++) {

            $data['data1'] = $this->main_model->d_gauge_kritis_1($id_branch[$i]->BRANCH_ID, $get_bulan, $deviasi_till70);
            $data['data2'] = $this->main_model->d_gauge_kritis_2($id_branch[$i]->BRANCH_ID, $get_bulan, $deviasi_till100);
            $data['data3'] = $this->main_model->d_gauge_kritis_3($id_branch[$i]->BRANCH_ID, $get_bulan, $get_kontrak_end);
            $data['id'] = $id_branch[$i]->BRANCH_NAME;
            $jumlah = count($data['data1']) + count($data['data2']) + count($data['data3']);

            if ($jumlah > 0) {

                $subject = 'EWS - Kontrak Kritis';
                $result = $this->email
                        ->from('no-reply@indonesiaport.co.id')
                        ->to($id_branch[$i]->USER_EMAIL)
                        ->subject($subject)
                        ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                        ->send();
            }

            unset($data['data1']);
            unset($data['data2']);
            unset($data['data3']);
        }

        //$this->load->view('template/pages/sendmail_ews',$data);
        //echo json_encode($id_branch);
        // echo $id_branch[9]->USER_EMAIL;
        // echo $jumlah;
    }

    public function emailrealisasi() {
        //$DB2 = $this->load->database('dbprod', TRUE);
        $this->load->library('email');
        //$id_branch = array('010','020','030', '040', '050', '060', '070','080', '090', '100', '110', '120');
        $data['ews'] = 'Input Realisasi Pelaporan';

        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_kontrak_end = $date->format('Y-m-d');
        $get_bulan = $date->format('m-Y');
        $tg = '01-' . $get_bulan;
        $date1 = new DateTime($tg);
        $date1->modify('-1 month');
        $tg2 = $date1->format('d-m-Y');

        $branch = $this->setting_model->dtemail();


        for ($i = 0; $i < count($branch); $i++) {

            $data['id'] = $branch[$i]->BRANCH_NAME;
            $data['data1'] = $this->ews_model->email_realisasi($branch[$i]->BRANCH_ID, $tg2)->result();
            $jumlah = $this->ews_model->email_realisasi($branch[$i]->BRANCH_ID, $tg2)->num_rows();

            if ($jumlah > 0) {


                try {
                    $subject = 'EWS - Input Realisasi Pelaporan Bulanan';
                    $result = $this->email
                            ->from('no-reply@indonesiaport.co.id')
                            ->to($branch[$i]->USER_EMAIL)
                            ->subject($subject)
                            ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                            ->send();
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                }
            }
            unset($data['data1']);
        }

        //$this->load->view('template/pages/sendmail_ews', $data);
        //echo json_encode($data);
    }

    public function cekemail($branch) {
        $this->load->library('email');
        $data['ews'] = 'Input Realisasi Pelaporan';
        $data['id'] = "kan";
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_kontrak_end = $date->format('Y-m-d');
        $get_bulan = $date->format('m-Y');
        $tg = '01-' . $get_bulan;
        $date1 = new DateTime($tg);
        $date1->modify('-1 month');
        $tg2 = $date1->format('d-m-Y');
        $data['data1'] = $this->ews_model->email_realisasi($branch, $tg2)->result();
        try {
            $subject = 'EWS - Input Realisasi Pelaporan Bulanan';
            $result = $this->email
                    ->from('no-reply@indonesiaport.co.id')
                    ->to("yayancloud@gmail.com")
                    ->subject($subject)
                    ->message($this->load->view('template/pages/sendmail_ews', $data, TRUE))
                    ->send();
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function cemsrealisasi() {
        $branch = $this->setting_model->dtemail();
        foreach ($branch as $key => $value) {
            $this->load->model('notifikasi_model');
            $data['notif_count'] = $this->notifikasi_model->realisasi_no($value->BRANCH_ID)->num_rows();
            $data['notif_isi'] = $this->notifikasi_model->realisasi_no($value->BRANCH_ID)->result();

            if ($data['notif_count'] > 0) {
                $alamat = str_replace(' ', '', $value->USER_EMAIL);

                $this->load->library('email');

                $this->email->from('support_cems@indonesiaport.co.id', 'CEMS IPC ');
                $this->email->to($alamat);
                $this->email->subject('Pemberitahuan Input Realisasi Bulanan');
                $body = $this->load->view('email/email_realisasi.php', $data, TRUE);
                $this->email->message($body);
                if ($this->email->send()) {
                    echo date("Y-m-d h:i:s") . " " . $alamat . " Sukses! email berhasil dikirim \r\n";
                } else {
                    echo date("Y-m-d h:i:s") . " " . $alamat . " Error! email tidak dapat dikirim \r\n";
                }
                unset($data);
            }
        }
    }

    public function clikontrakkritis() {
        $this->load->model('main_model');
        $this->load->model('setting_model');
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_kontrak_end = $date->format('Y-m-d');
        $deviasi_till70 = $this->setting_model->find_setting()->CRITIC_DEVIASI_A;
        $deviasi_till100 = $this->setting_model->find_setting()->CRITIC_DEVIASI_B;
        $branch = $this->setting_model->dtemail();

        foreach ($branch as $key => $value) {
            $data['cabang'] = $value->BRANCH_NAME;
            $alamat = $value->USER_EMAIL;
            $data['kat1'] = $this->main_model->gauge_kritis_1($value->BRANCH_ID, $get_bulan, $deviasi_till70);
            $data['kat2'] = $this->main_model->gauge_kritis_2($value->BRANCH_ID, $get_bulan, $deviasi_till100);
            $data['kat3'] = $this->main_model->gauge_kritis_3($value->BRANCH_ID, $get_bulan, $get_kontrak_end);

            if ($data['kat1']->DEVIASI == 0 && $data['kat2']->DEVIASI == 0 && $data['kat3']->DEVIASI == 0) {
                
            } else {
                $this->load->library('email');
                $this->email->from('support_cems@indonesiaport.co.id', 'CEMS IPC ');
                $this->email->to($alamat);
                $this->email->subject('Pemberitahuan Kontrak Kritis');
                $body = $this->load->view('email/email_kontrakkritis.php', $data, TRUE);
                $this->email->message($body);
                if ($this->email->send()) {
                    echo date("Y-m-d h:i:s") . " " . $alamat . " Sukses! email berhasil dikirim \r\n";
                } else {
                    echo date("Y-m-d h:i:s") . " " . $alamat . " Error! email tidak dapat dikirim \r\n";
                }
            }
        }
    }

    public function realiasi_tahun_sebelumnya_sub() {
        $arr = array('000', '010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');

        foreach ($arr as $key => $valu) {
            $q = $this->db->query("SELECT BRANCH_NAME,RKAP_INVS_ID,RKAP_SUBPRO_ID,ROUND(JML) JML from ( SELECT c.BRANCH_NAME,a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID,NVL(sum(e.real_subpro_val),0) as jml
			FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
			LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
			LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
			LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
			LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
			WHERE e.real_subpro_year < 2020 and c.BRANCH_ID in('$valu')
			group by c.BRANCH_NAME,a.RKAP_INVS_ID,d.RKAP_SUBPRO_ID)");

            foreach ($q->result() as $key => $value) {
                $id = $value->RKAP_SUBPRO_ID;
                $val = $value->JML;
                $this->db->query("UPDATE TX_RKAP_SUB_PROGRAM SET RKAP_SUBPRO_REAL_BEFORE = '$val' WHERE RKAP_SUBPRO_ID = '$id'");
                echo $id . " - " . $val . "\r\n";
            }
        }
    }

    public function realiasi_tahun_sebelumnya_rkap() {
        $arr = array('000', '010', '020', '030', '040', '050', '060', '070', '080', '090', '100', '110', '120');

        foreach ($arr as $key => $valu) {
            $q = $this->db->query("SELECT BRANCH_NAME,RKAP_INVS_ID,ROUND(JML) JML from ( SELECT c.BRANCH_NAME,a.RKAP_INVS_ID,NVL(sum(e.real_subpro_val),0) as jml
			FROM (select * from TX_RKAP_INVESTATION where is_deleted = 0 and on_use = 'Y') a
			LEFT JOIN TM_USERS b ON a.RKAP_INVS_USER_ID = b.USER_ID
			LEFT JOIN TR_BRANCH c ON b.USER_BRANCH = c.BRANCH_ID
			LEFT JOIN (select * from TX_RKAP_SUB_PROGRAM where is_deleted = 0) d ON a.RKAP_INVS_ID = d.RKAP_SUBPRO_INVS_ID
			LEFT JOIN (select * from TX_REAL_SUB_PROGRAM where is_deleted = 0) e ON d.RKAP_SUBPRO_ID = e.RKAP_SUBPRO_ID
			WHERE e.real_subpro_year < 2020
			group by c.BRANCH_NAME,a.RKAP_INVS_ID)");

            foreach ($q->result() as $key => $value) {
                $id = $value->RKAP_INVS_ID;
                $val = $value->JML;
                $this->db->query("UPDATE TX_RKAP_INVESTATION SET RKAP_INVS_REAL_BEFORE = '$val' WHERE RKAP_INVS_ID = '$id'");
                echo $id . " - " . $val . "\r\n";
            }
        }
    }

    public function update($id = null) {
        $this->load->model(array('user_model', 'log_model'));

        $post = $this->input->post();
        $id = ($id === null) ? $post['id'] : $id;
        $modul = '';
        $value = '';

        if ($post) {
            $modul = $post['modul'];
            $value = $post['value'];
        }

        //$user = $this->user_model->finduser($id);
        $status = false;
        $data = array();
        $query = '';

        if ($id !== '') {
            $status = true;

            switch ($modul) {
                case 'username':
                    $data = array(
                        'USER_NAME' => $value,
                    );

                    if ($this->user_model->member_konflik($value) > 0) {
                        $this->session->set_flashdata('username', 'Username telah terdaftar sebelumnya');
                    }
                    break;
                case 'password':
                    $polapassword = "/^.{5,}$/";

                    $data = array(
                        'USER_PASSWORD' => $value,
                    );

                    if (!preg_match($polapassword, $this->input->post('password'))) {
                        $this->session->set_flashdata('password', 'Password minimal terdiri dari 5 karakter');
                    }
                    break;
                case 'nipp':
                    $data = array(
                        'USER_NIPP' => $value,
                    );
                    break;
                case 'email':
                    $polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";

                    $data = array(
                        'USER_EMAIL' => $value,
                    );

                    if (!preg_match($polaemail, $this->input->post('email'))) {
                        $this->session->set_flashdata('valid_email', 'Email Tidak Valid');
                    }
                    break;
                case 'privilage':
                    $data = array(
                        'USER_PRIV' => $value,
                    );
                    break;
                case 'branch':
                    $data = array(
                        'USER_BRANCH' => $value,
                    );
                    break;
                case 'posisi':
                    $data = array(
                        'USER_POSITION' => $value,
                    );
                    break;
                case 'start-date':
                    $query = "UPDATE TM_USERS SET START_DATE = TO_DATE('" . date('Y-m-d', strtotime($value)) . "', 'YYYY/MM/DD') WHERE USER_ID = '" . $id . "'";

//                    $data = array(
//                        //'START_DATE' => "TO_DATE('" . date('Y-m-d', strtotime($value)) . "', 'YYYY/MM/DD')",
//                        'START_DATE' => date('Y-m-d', strtotime($value)),
//                    );
                    break;
                case 'end-date':
                    $query = "UPDATE TM_USERS SET END_DATE = TO_DATE('" . date('Y-m-d', strtotime($value)) . "', 'YYYY/MM/DD') WHERE USER_ID = '" . $id . "'";

//                    $data = array(
//                        //'END_DATE' => "TO_DATE('" . date('Y-m-d', strtotime($value)) . "', 'YYYY/MM/DD')",
//                        'END_DATE' => date('Y-m-d', strtotime($value)),
//                    );
                    break;
            }

            // baca session user id
            $session_ = $this->session->userdata();
            $sess_user_id_ = $session_['SESS_USER_ID'];
            $sess_user_name = $session_['SESS_USER_NAME'];

            $data['CREATED_BY'] = $sess_user_id_;
            $data['LAST_UPDATE_BY'] = $sess_user_id_;
            $data['IS_DELETED'] = 0;

            if ($query != '') { // ada query
                $this->user_model->exec_query($query);
            } else { // tidak ada query
                $this->user_model->update($id, $data);
            }

            $data_log = array(
                'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                'LOG_ACTION' => 'update akun user',
                'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                'LOG_URL' => $_SERVER['REQUEST_URI']
            );

            $this->log_model->add($data_log);
        }

        echo json_encode(array(
            "status" => $status,
            "post" => $post,
            "id" => $id,
            "user" => $user,
            "data" => $data,
            "data_log" => $data_log,
        ));
    }

}
