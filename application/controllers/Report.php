<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

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
        $this->load->model('main_model');
        $this->load->model('announcement_model');
        $this->load->model('setting_model');
        $this->load->model('Report_model');
        $this->load->model('Report_detail_mmr_model');
        
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $this->load->library('m_pdf');
        $this->load->library('excel');
    }

    public function export_kpi_program(){
        //load library PHPExcel
        // $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user export excel kpi program',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

        $this->log_model->add($data4);

        // merubah style border pada cell yang aktif (cell yang terisi)
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
                    ), 
                ), 
            );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $style_header = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          )
        );
   
        $style_row = array(
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $name_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        //color cell
        $color_1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f6d71d')
            )
        );

        $color_2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4583ed')
            )
        );

        $color_3 = array(
          'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'ffffff')
            ), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000000')
            )
        );

        //membuat object baru bernama $objPHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./assets/img/ipc_logo.png');

        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(130);
        $objDrawing->setWidth(130);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // data dibuat pada sheet pertama
        $objPHPExcel->setActiveSheetIndex(0); 
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PT PELABUHAN INDONESIA II (PERSERO)');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'REKAPITULASI LAPORAN KPI REALISASI PROGRAM BULANAN');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:B9');
        $objPHPExcel->getActiveSheet()->mergeCells('C7:K7');
        $objPHPExcel->getActiveSheet()->mergeCells('C8:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('G8:J8');
        $objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
        $objPHPExcel->getActiveSheet()->mergeCells('A23:B23');

        //set header kolom
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "NO"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "Cabang Pelabuhan / Unit"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', "KPI PROGRAM"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "Jumlah Program Dalam RKAP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E9', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "Jumlah Program Berjalan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I9', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "Persentase");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($color_2);

        // style footer

        $objPHPExcel->getActiveSheet()->getStyle('A23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('B23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('C23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('D23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('E23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('F23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('G23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('H23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('I23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('J23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('K23')->applyFromArray($color_3);

        $report = $this->main_model->get_cabang_2();

        $sipil_rkap = $this->main_model->sipil_rkap();
        $peralatan_rkap = $this->main_model->peralatan_rkap();
        $non_fisik_rkap = $this->main_model->non_fisik_rkap();
        $total_report_rkap = $this->main_model->total_report_rkap();

        $jumlah_sipil_rkap = $this->main_model->jumlah_sipil_rkap();
        $jumlah_peralatan_rkap = $this->main_model->jumlah_peralatan_rkap();
        $jumlah_non_fisik_rkap = $this->main_model->jumlah_non_sipil_rkap();
        $jumlah_total_rkap = $this->main_model->jumlah_total_rkap();

        $sipil_berjalan = $this->main_model->sipil_berjalan();
        $peralatan_berjalan = $this->main_model->peralatan_berjalan();
        $non_fisik_berjalan = $this->main_model->non_fisik_berjalan();
        $total_report_berjalan = $this->main_model->total_report_berjalan();

        $jumlah_sipil_berjalan = $this->main_model->jumlah_sipil_berjalan();
        $jumlah_peralatan_berjalan = $this->main_model->jumlah_peralatan_berjalan();
        $jumlah_non_fisik_berjalan = $this->main_model->jumlah_non_sipil_berjalan();
        $jumlah_total_berjalan = $this->main_model->jumlah_total_berjalan();

        $persentase_berjalan = $this->main_model->persentase_berjalan();
        $persentase_berjalan_footer = $this->main_model->persentase_berjalan_footer();

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach($report as $data){ // Lakukan looping pada variabel siswa

                foreach ($sipil_rkap as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $sipil = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $sipil = '0';
                            }
                        }
                    }

                foreach ($peralatan_rkap as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $peralatan = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $peralatan = '0';
                            }
                        }
                    }

                foreach ($non_fisik_rkap as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $non_fisik = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $non_fisik = '0';
                            }
                        }
                    }

                foreach ($total_report_rkap as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $total_report = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $total_report = '0';
                            }
                        }
                    }

                foreach ($sipil_berjalan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $sipil_jalan = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $sipil_jalan = '0';
                            }
                        }
                    }

                foreach ($peralatan_berjalan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $peralatan_jalan = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $peralatan_jalan = '0';
                            }
                        }
                    }

                foreach ($non_fisik_berjalan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $non_fisik_jalan = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $non_fisik_jalan = '0';
                            }
                        }
                    }

                foreach ($total_report_berjalan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_PROGRAM > 0) {
                                $total_berjalan = $list->TOTAL_PROGRAM;
                            }
                        else{
                                $total_berjalan = '0';
                            }
                        }
                    }

                foreach ($persentase_berjalan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->PERSENTASE_BERJALAN > 0) {
                                $persentase = round($list->PERSENTASE_BERJALAN);
                            }
                        else{
                                $persentase = '0';
                            }
                        }
                    }

                // FOOTER
                foreach ($jumlah_sipil_rkap as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_sipil = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_sipil = '0';
                        }
                    }

                foreach ($jumlah_peralatan_rkap as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_peralatan = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_peralatan = '0';
                        }
                    }

                foreach ($jumlah_non_fisik_rkap as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_non_fisik = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_non_fisik = '0';
                        }
                    }

                foreach ($jumlah_total_rkap as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_total = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_total = '0';
                        }
                    }

                foreach ($jumlah_sipil_berjalan as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_sipil_jalan = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_sipil_jalan = '0';
                        }
                    }

                foreach ($jumlah_peralatan_berjalan as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_peralatan_jalan = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_peralatan_jalan = '0';
                        }
                    }

                foreach ($jumlah_non_fisik_berjalan as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $jumlah_non_fisik_jalan = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $jumlah_non_fisik_jalan = '0';
                        }
                    }

                foreach ($jumlah_total_berjalan as $list) {
                    if ($list->TOTAL_PROGRAM > 0) {
                            $total_berjalan_report = $list->TOTAL_PROGRAM;
                        }
                    else{
                            $total_berjalan_report = '0';
                        }
                    }

                foreach ($persentase_berjalan_footer as $list) {
                    if ($list->PERSENTASE_BERJALAN > 0) {
                            $persentase_footer = round($list->PERSENTASE_BERJALAN);
                        }
                    else{
                            $persentase_footer = '0';
                        }
                    }

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->BRANCH_NAME);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $sipil);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $peralatan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $non_fisik);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_report);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sipil_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $peralatan_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $non_fisik_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $total_berjalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $persentase.'%');

                // set footer
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A23', "JUMLAH");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C23', $jumlah_sipil);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D23', $jumlah_peralatan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E23', $jumlah_non_fisik);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F23', $jumlah_total);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G23', $jumlah_sipil_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H23', $jumlah_peralatan_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I23', $jumlah_non_fisik_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J23', $total_berjalan_report);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K23', $persentase_footer.'%');
              
              // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
              $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
              
              $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }

        // Set width kolom
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $objPHPExcel->getActiveSheet(0)->setTitle("Rekapitulasi KPI Program");
        $objPHPExcel->setActiveSheetIndex(0);

        $objWorksheet = $objPHPExcel->getActiveSheet();

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save("test_".date('Y-m-d H-i-s').".xlsx");

        //Header
        ob_end_clean();
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //Nama File
        header('Content-Disposition: attachment;filename="report_kpi_program.xls"');
        //Download
        $objWriter->save("php://output");
        
    }

    public function coba()
    {
        // $tgl = $this->input->get('tgl');
        // $ex = explode('-',$tgl);
        // //$date = new DateTime($tgl);
        // $get_bulan = $ex[1].'-'.$ex[0];
        // $get_tahun = $ex[1];
        // $get_month = $tgl;

        $jumlah_realisasi_rkap_non = $this->Report_model->jumlah_realisasi_rkap_non('2019-01', '2019');
        $jumlah_realisasi_rkap_total = $this->Report_model->jumlah_realisasi_rkap_total('2019-01', '2019');

        echo var_dump($jumlah_realisasi_rkap_non);
        echo "<br>";
        echo "<br>";
        echo var_dump($jumlah_realisasi_rkap_total);


        // foreach ($jumlah_realisasi_rkap_peralatan as $list) {
        //     if ($list->VALUE > 0) {
        //             $row_jumlah_realisasi_rkap_peralatan = number_format($list->VALUE, 2, ',', '.').'%';
        //         }
        //     else{
        //             $row_jumlah_realisasi_rkap_peralatan = '0';
        //         }
        //     }

        // foreach ($jumlah_realisasi_rkap_non as $list) {
        //     if ($list->VALUE > 0) {
        //             $row_jumlah_realisasi_rkap_non = number_format($list->VALUE, 2, ',', '.').'%';
        //         }
        //     else{
        //             $row_jumlah_realisasi_rkap_non = '0';
        //         }
        //     }

        //$jumlah_realisasi_rkap_sipil;

        // foreach ($jumlah_realisasi_rkap_non as $list) {
        //     if ($list->VALUE > 0) {
        //             $row_jumlah_realisasi_rkap_sipil = number_format($list->VALUE, 2, ',', '.').'%';
        //         }
        //     else{
        //             $row_jumlah_realisasi_rkap_sipil = '0';
        //         }
        //     }
        
    }

    public function export_kpi_fisik(){
    
        $this->load->library('PHPExcel/IOFactory');

        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user export excel kpi fisik',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

        $this->log_model->add($data4);

        // merubah style border pada cell yang aktif (cell yang terisi)
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
                    ), 
                ), 
            );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $style_header = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          )
        );
   
        $style_row = array(
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $name_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        //color cell
        $color_1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f6d71d')
            )
        );

        $color_2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4583ed')
            )
        );

        $color_3 = array(
          'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'ffffff')
            ), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000000')
            )
        );

        //membuat object baru bernama $objPHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./assets/img/ipc_logo.png');

        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(130);
        $objDrawing->setWidth(130);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        // deklarasi tanggal
        $tgl = $this->input->get('tgl');
        $ex = explode('-',$tgl);

        //$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_bulan = (int)$ex[1].'-'.$ex[0];
        $get_bulan2 = (int)$ex[0];
        $get_tahun = (int)$ex[1];
        
        $get_month = $tgl;

        $title = "RKAP TAHUN ".$get_tahun." S/D BULAN ".$get_month;
        $title = strtoupper($title);
        // data dibuat pada sheet pertama
        $objPHPExcel->setActiveSheetIndex(0); 
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PT PELABUHAN INDONESIA II (PERSERO)');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'REKAPITULASI LAPORAN KPI REALISASI FISIK BULANAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $title);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:K4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:K5');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:B9');
        $objPHPExcel->getActiveSheet()->mergeCells('C7:K7');
        $objPHPExcel->getActiveSheet()->mergeCells('C8:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('G8:J8');
        $objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
        $objPHPExcel->getActiveSheet()->mergeCells('A23:B23');

        // anak perusahaan
        $objPHPExcel->getActiveSheet()->mergeCells('A27:A29');
        $objPHPExcel->getActiveSheet()->mergeCells('B27:B29');
        $objPHPExcel->getActiveSheet()->mergeCells('C27:K27');
        $objPHPExcel->getActiveSheet()->mergeCells('C28:F28');
        $objPHPExcel->getActiveSheet()->mergeCells('G28:J28');
        $objPHPExcel->getActiveSheet()->mergeCells('K28:K29');
        $objPHPExcel->getActiveSheet()->mergeCells('A44:B44');

        //set header kolom
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "NO"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "Cabang Pelabuhan / Unit"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', "KPI REALISASI"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "Realisasi S/D Bulan Berjalan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E9', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "Total Nilai Kontrak Tahun Berjalan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I9', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "Persentase");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A27', "NO"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B27', "Anak Perusahaan / Unit"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C27', "KPI REALISASI"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C28', "Realisasi S/D Bulan Berjalan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C29', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D29', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E29', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F29', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G28', "Total Nilai Kontrak Tahun Berjalan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G29', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H29', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I29', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J29', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K28', "Persentase");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($color_2);

        // anak perusahaan
        $objPHPExcel->getActiveSheet()->getStyle('A27')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A28')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('A29')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B27')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B28')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('B29')->applyFromArray($style_col);
        $objPHPExcel->getActiveSheet()->getStyle('C27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('H29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('I29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('J29')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K27')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K28')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('K29')->applyFromArray($color_2);

        // style footer

        $objPHPExcel->getActiveSheet()->getStyle('A23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('B23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('C23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('D23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('E23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('F23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('G23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('H23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('I23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('J23')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('K23')->applyFromArray($color_3);

        $objPHPExcel->getActiveSheet()->getStyle('A44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('B44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('C44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('D44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('E44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('F44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('G44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('H44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('I44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('J44')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('K44')->applyFromArray($color_3);

        $report = $this->main_model->get_cabang_2();
        $unit = $this->main_model->get_anak_perusahaan();

        $realisasi_sipil = $this->main_model->realisasi_sipil_berjalan($get_bulan, $get_tahun);
        $realisasi_peralatan = $this->main_model->realisasi_peralatan_berjalan($get_bulan, $get_tahun);
        $realisasi_non_fisik = $this->main_model->realisasi_non_fisik_berjalan($get_bulan, $get_tahun);
        $realisasi_total_report = $this->main_model->realisasi_total_report_berjalan($get_bulan, $get_tahun);
        $jumlah_realisasi_sipil = $this->main_model->jumlah_realisasi_sipil_berjalan($get_bulan, $get_tahun);
        $jumlah_realisasi_peralatan = $this->main_model->jumlah_realisasi_peralatan_berjalan($get_bulan, $get_tahun);
        $jumlah_realisasi_non_fisik = $this->main_model->jumlah_realisasi_non_fisik_berjalan($get_bulan, $get_tahun);
        $jumlah_realisasi_total_report = $this->main_model->jumlah_realisasi_total_report_berjalan($get_bulan, $get_tahun);

        $kontrak_sipil = $this->main_model->kontrak_sipil_berjalan($get_tahun);
        $kontrak_peralatan = $this->main_model->kontrak_peralatan_berjalan($get_tahun);
        $kontrak_non_fisik = $this->main_model->kontrak_non_fisik_berjalan($get_tahun);
        $kontrak_total_report = $this->main_model->kontrak_total_report_berjalan($get_tahun);
        $jumlah_kontrak_sipil = $this->main_model->jumlah_kontrak_sipil_berjalan($get_tahun);
        $jumlah_kontrak_peralatan = $this->main_model->jumlah_kontrak_peralatan_berjalan($get_tahun);
        $jumlah_kontrak_non_fisik = $this->main_model->jumlah_kontrak_non_fisik_berjalan($get_tahun);
        $jumlah_kontrak_total_report = $this->main_model->jumlah_kontrak_total_report_berjalan($get_tahun);

        $persentase = $this->main_model->fisik_persentase_berjalan($get_bulan2, $get_tahun);
        $persentase_footer = $this->main_model->fisik_persentase_berjalan_footer($get_bulan2, $get_tahun);

        // anak perusahaan
        $jumlah_realisasi_sipil_2 = $this->main_model->jumlah_realisasi_sipil_berjalan_2($get_bulan, $get_tahun);
        $jumlah_realisasi_peralatan_2 = $this->main_model->jumlah_realisasi_peralatan_berjalan_2($get_bulan, $get_tahun);
        $jumlah_realisasi_non_fisik_2 = $this->main_model->jumlah_realisasi_non_fisik_berjalan_2($get_bulan, $get_tahun);
        $jumlah_realisasi_total_report_2 = $this->main_model->jumlah_realisasi_total_report_berjalan_2($get_bulan, $get_tahun);
        $jumlah_kontrak_sipil_2 = $this->main_model->jumlah_kontrak_sipil_berjalan_2($get_tahun);
        $jumlah_kontrak_peralatan_2 = $this->main_model->jumlah_kontrak_peralatan_berjalan_2($get_tahun);
        $jumlah_kontrak_non_fisik_2 = $this->main_model->jumlah_kontrak_non_fisik_berjalan_2($get_tahun);
        $jumlah_kontrak_total_report_2 = $this->main_model->jumlah_kontrak_total_report_berjalan_2($get_tahun);
        $persentase_footer_2 = $this->main_model->fisik_persentase_berjalan_footer_2($get_bulan, $get_tahun);

        // print_r($jumlah_realisasi_sipil_2); exit();

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach($report as $data){ // Lakukan looping pada variabel siswa

                foreach ($realisasi_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $sipil = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $sipil = '0';
                            }
                        }
                    }

                foreach ($realisasi_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $peralatan = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $peralatan = '0';
                            }
                        }
                    }

                foreach ($realisasi_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $non_fisik = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $non_fisik = '0';
                            }
                        }
                    }

                foreach ($realisasi_total_report as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $total_report = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $total_report = '0';
                            }
                        }
                    }

                foreach ($kontrak_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $sipil_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $sipil_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $peralatan_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $peralatan_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $non_fisik_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $non_fisik_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_total_report as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $kontrak_total = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $kontrak_total = '0';
                            }
                        }
                    }

                foreach ($persentase as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->PERSENTASE > 0) {
                                $persentase_report = round($list->PERSENTASE);
                            }
                        else{
                                $persentase_report = '0';
                            }
                        }
                    }

                // FOOTER
                foreach ($jumlah_realisasi_sipil as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_sipil = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_sipil = '0';
                        }
                    }

                foreach ($jumlah_realisasi_peralatan as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_peralatan = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_peralatan = '0';
                        }
                    }

                foreach ($jumlah_realisasi_non_fisik as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_non_fisik = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_non_fisik = '0';
                        }
                    }

                foreach ($jumlah_realisasi_total_report as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_total = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_total = '0';
                        }
                    }

                foreach ($jumlah_kontrak_sipil as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_sipil_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_sipil_jalan = '0';
                        }
                    }

                foreach ($jumlah_kontrak_peralatan as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_peralatan_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_peralatan_jalan = '0';
                        }
                    }

                foreach ($jumlah_kontrak_non_fisik as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_non_fisik_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_non_fisik_jalan = '0';
                        }
                    }

                foreach ($jumlah_kontrak_total_report as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_total_report = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_total_report = '0';
                        }
                    }

                foreach ($persentase_footer as $list) {
                    if ($list->PERSENTASE > 0) {
                            $persentase_footer_report = round($list->PERSENTASE);
                        }
                    else{
                            $persentase_footer_report = '0';
                        }
                    }

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->BRANCH_NAME);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $sipil);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $peralatan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $non_fisik);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_report);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sipil_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $peralatan_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $non_fisik_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $kontrak_total);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $persentase_report.'%');

                // set footer
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A23', "JUMLAH");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C23', $jumlah_sipil);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D23', $jumlah_peralatan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E23', $jumlah_non_fisik);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F23', $jumlah_total);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G23', $jumlah_sipil_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H23', $jumlah_peralatan_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I23', $jumlah_non_fisik_jalan);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J23', $jumlah_total_report);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K23', $persentase_footer_report.'%');
              
              // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
              $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
              
              $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 30; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach($unit as $data){ // Lakukan looping pada variabel siswa

                foreach ($realisasi_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $sipil = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $sipil = '0';
                            }
                        }
                    }

                foreach ($realisasi_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $peralatan = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $peralatan = '0';
                            }
                        }
                    }

                foreach ($realisasi_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $non_fisik = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $non_fisik = '0';
                            }
                        }
                    }

                foreach ($realisasi_total_report as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $total_report = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $total_report = '0';
                            }
                        }
                    }

                foreach ($kontrak_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $sipil_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $sipil_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $peralatan_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $peralatan_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $non_fisik_jalan = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $non_fisik_jalan = '0';
                            }
                        }
                    }

                foreach ($kontrak_total_report as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_NILAI_CONTRACT > 0) {
                                $kontrak_total = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                            }
                        else{
                                $kontrak_total = '0';
                            }
                        }
                    }

                foreach ($persentase as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->PERSENTASE > 0) {
                                $persentase_report = round($list->PERSENTASE);
                            }
                        else{
                                $persentase_report = '0';
                            }
                        }
                    }

                // FOOTER
                foreach ($jumlah_realisasi_sipil_2 as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_sipil2 = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_sipil2 = '0';
                        }
                    }

                foreach ($jumlah_realisasi_peralatan_2 as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_peralatan2 = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_peralatan2 = '0';
                        }
                    }

                foreach ($jumlah_realisasi_non_fisik_2 as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_non_fisik2 = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_non_fisik2 = '0';
                        }
                    }

                foreach ($jumlah_realisasi_total_report_2 as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $jumlah_total2 = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $jumlah_total2 = '0';
                        }
                    }

                foreach ($jumlah_kontrak_sipil_2 as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_sipil_jalan2 = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_sipil_jalan2 = '0';
                        }
                    }

                foreach ($jumlah_kontrak_peralatan_2 as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_peralatan_jalan2 = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_peralatan_jalan2 = '0';
                        }
                    }

                foreach ($jumlah_kontrak_non_fisik_2 as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_non_fisik_jalan2 = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_non_fisik_jalan2 = '0';
                        }
                    }

                foreach ($jumlah_kontrak_total_report_2 as $list) {
                    if ($list->TOTAL_NILAI_CONTRACT > 0) {
                            $jumlah_total_report2 = number_format($list->TOTAL_NILAI_CONTRACT, 2, ',', '.');
                        }
                    else{
                            $jumlah_total_report2 = '0';
                        }
                    }

                foreach ($persentase_footer_2 as $list) {
                    if ($list->PERSENTASE > 0) {
                            $persentase_footer_report2 = round($list->PERSENTASE);
                        }
                    else{
                            $persentase_footer_report2 = '0';
                        }
                    }

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->BRANCH_NAME);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $sipil);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $peralatan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $non_fisik);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_report);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $sipil_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $peralatan_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $non_fisik_jalan);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $kontrak_total);
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $persentase_report.'%');

                // set footer
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A44', "JUMLAH");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C44', $jumlah_sipil2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D44', $jumlah_peralatan2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E44', $jumlah_non_fisik2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F44', $jumlah_total2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G44', $jumlah_sipil_jalan2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H44', $jumlah_peralatan_jalan2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I44', $jumlah_non_fisik_jalan2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J44', $jumlah_total_report2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K44', $persentase_footer_report2.'%');
              
              // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
              $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($name_row);
              $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
              $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
              
              $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }

        // Set width kolom
            // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $objPHPExcel->getActiveSheet(0)->setTitle("Rekapitulasi KPI Fisik");
        $objPHPExcel->setActiveSheetIndex(0);

        $objWorksheet = $objPHPExcel->getActiveSheet();

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save("test_".date('Y-m-d H-i-s').".xlsx");

        //$get_month = $date->format('d-M-Y');
        $file_name = "Report KPI Fisik ".$get_month.".xls";

        //Header
        ob_end_clean();
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //Nama File
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        //Download
        $objWriter->save("php://output");
        
    }

    public function export_MMR(){
    
        $this->load->library('PHPExcel/IOFactory');

        $data4 = array(
                    'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                    'LOG_ACTION' => 'user export excel kpi fisik',
                    'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                    'LOG_URL' => $_SERVER['REQUEST_URI']
                );

        $this->log_model->add($data4);

        // merubah style border pada cell yang aktif (cell yang terisi)
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
                    ), 
                ), 
            );

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $style_header = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          )
        );
   
        $style_row = array(
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        $name_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );

        //color cell
        $color_1 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b7b7b7')
            )
        );

        $color_2 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '5cb85c')
            )
        );

        $color_3 = array(
          'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'ffffff')
            ), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000000')
            )
        );

        $color_4 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ff0000')
            )
        );

        $color_5 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '04c2cc')
            )
        );

        $color_6 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f4d802')
            )
        );

        $color_7 = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '06f402')
            )
        );

        //membuat object baru bernama $objPHPExcel
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./assets/img/ipc_logo.png');

        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(130);
        $objDrawing->setWidth(130);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $tgl = $this->input->get('tgl');
        $ex = explode('-',$tgl);
        $tgl2 = $ex[1].'-'.$ex[0];
        $date = new DateTime($tgl2);
        $get_bulan = $date->format('Y-m');
        $get_tahun = $date->format('Y');
        $get_month = $date->format('F');
        $month = $date->format('m');

        $title = "RKAP TAHUN ".$get_tahun." S/D BULAN ".$get_month;
        $title_RKAP = "RKAP".$get_tahun;
        $title_TARGET = "TARGET S/D BULAN ".$get_month;
        $title_REALISASI = "REALISASI S/D BULAN ".$get_month;
        $title_DEVIASI = "DEVIASI REALISASI TERHADAP TARGET S/D BULAN ".$get_month;
        $title_PERSENTASE = "PERSENTASE REALISASI TERHADAP TARGET S/D BULAN ".$get_month;
        $title_PERSENTASE_RKAP = "PERSENTASE REALISASI S/D BULAN ".$get_month." TERHADAP RKAP";

        $title = strtoupper($title);
        $title_RKAP = strtoupper($title_RKAP);
        $title_TARGET = strtoupper($title_TARGET);
        $title_REALISASI = strtoupper($title_REALISASI);
        $title_DEVIASI = strtoupper($title_DEVIASI);
        $title_PERSENTASE = strtoupper($title_PERSENTASE);
        $title_PERSENTASE_RKAP = strtoupper($title_PERSENTASE_RKAP);

        // data dibuat pada sheet pertama
        $objPHPExcel->setActiveSheetIndex(0); 
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PT PELABUHAN INDONESIA II (PERSERO)');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'REKAPITULASI LAPORAN REALISASI FISIK INVESTASI BULANAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', $title);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:Z2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:Z3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:Z4');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:Z5');

        $objPHPExcel->getActiveSheet()->mergeCells('A7:A10');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:B10');
        $objPHPExcel->getActiveSheet()->mergeCells('C7:F9');
        $objPHPExcel->getActiveSheet()->mergeCells('G7:J9');
        $objPHPExcel->getActiveSheet()->mergeCells('K7:N9');
        $objPHPExcel->getActiveSheet()->mergeCells('O7:R9');
        $objPHPExcel->getActiveSheet()->mergeCells('S7:V9');
        $objPHPExcel->getActiveSheet()->mergeCells('W7:Z9');
        $objPHPExcel->getActiveSheet()->getStyle('S7:S'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
        $objPHPExcel->getActiveSheet()->getStyle('W7:W'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

        //FOOTER CABANG
        $objPHPExcel->getActiveSheet()->mergeCells('A24:B24');

        // anak perusahaan
        $objPHPExcel->getActiveSheet()->mergeCells('A27:A29');
        $objPHPExcel->getActiveSheet()->mergeCells('B27:B29');
        $objPHPExcel->getActiveSheet()->mergeCells('C27:K27');
        $objPHPExcel->getActiveSheet()->mergeCells('C28:F28');
        $objPHPExcel->getActiveSheet()->mergeCells('G28:J28');
        $objPHPExcel->getActiveSheet()->mergeCells('K28:K29');
        $objPHPExcel->getActiveSheet()->mergeCells('A44:B44');

        //set header kolom
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "NO"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "Cabang Pelabuhan / Unit"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', $title_RKAP); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F10', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G7', $title_TARGET);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K7', $title_REALISASI);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O7', $title_DEVIASI);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S7', $title_PERSENTASE);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V10', "Total");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W7', $title_PERSENTASE_RKAP);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W10', "Sipil");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "Peralatan"); 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y10', "Non FIsik");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z10', "Total");

        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A27', "NO"); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B27', "Anak Perusahaan / Unit"); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C27', "KPI REALISASI"); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C28', "Realisasi S/D Bulan Berjalan");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C29', "Sipil");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D29', "Peralatan"); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E29', "Non FIsik");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F29', "Total");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G28', "Total Nilai Kontrak Tahun Berjalan");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G29', "Sipil");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H29', "Peralatan"); 
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I29', "Non FIsik");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J29', "Total");
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K28', "Persentase");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('A10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('B10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('C10')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('E10')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($color_2);
        $objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('G10')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('H10')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('I10')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('J10')->applyFromArray($color_4);
        $objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('K8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('K10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('L8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('L9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('L10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('M8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('M9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('M10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('N8')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('N9')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('N10')->applyFromArray($color_1);
        $objPHPExcel->getActiveSheet()->getStyle('O7')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('O8')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('O9')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('O10')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('P7')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('P8')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('P9')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('P10')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('Q7')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('Q8')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('Q9')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('Q10')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('R7')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('R8')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('R9')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('R10')->applyFromArray($color_5);
        $objPHPExcel->getActiveSheet()->getStyle('S7')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('S8')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('S9')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('S10')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('T7')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('T8')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('T9')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('T10')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('U7')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('U8')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('U9')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('U10')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('V7')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('V8')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('V9')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('V10')->applyFromArray($color_6);
        $objPHPExcel->getActiveSheet()->getStyle('W7')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('W8')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('W9')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('W10')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('X7')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('X8')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('X9')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('X10')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Y7')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Y8')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Y9')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Y10')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Z7')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Z8')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Z9')->applyFromArray($color_7);
        $objPHPExcel->getActiveSheet()->getStyle('Z10')->applyFromArray($color_7);

        // anak perusahaan
        // $objPHPExcel->getActiveSheet()->getStyle('A27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('A28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('A29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('B27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('B28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('B29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('C27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('C28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('C29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('D27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('D28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('D29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('E27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('E28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('E29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('F27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('F28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('F29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('G27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('G28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('G29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('H27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('H28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('H29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('I27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('I28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('I29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('J27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('J28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('J29')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('K27')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('K28')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('K29')->applyFromArray($style_col);

        // style footer

        $objPHPExcel->getActiveSheet()->getStyle('A24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('B24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('C24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('D24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('E24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('F24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('G24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('H24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('I24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('J24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('K24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('L24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('M24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('N24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('O24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('P24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('Q24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('R24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('S24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('T24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('U24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('V24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('W24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('X24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('Y24')->applyFromArray($color_3);
        $objPHPExcel->getActiveSheet()->getStyle('Z24')->applyFromArray($color_3);

        // $objPHPExcel->getActiveSheet()->getStyle('A44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('B44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('C44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('D44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('E44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('F44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('G44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('H44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('I44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('J44')->applyFromArray($style_col);
        // $objPHPExcel->getActiveSheet()->getStyle('K44')->applyFromArray($style_col);

        $cabang = $this->main_model->get_cabang_2();
        $unit = $this->main_model->get_anak_perusahaan();

        $rkap_sipil = $this->Report_model->rkap_sipil($get_tahun);
        $rkap_peralatan = $this->Report_model->rkap_peralatan($get_tahun);
        $rkap_non_fisik = $this->Report_model->rkap_non_fisik($get_tahun);
        $jumlah_rkap = $this->Report_model->jumlah_rkap($get_tahun);
        $jumlah_rkap_sipil = $this->Report_model->jumlah_rkap_sipil($get_tahun);
        $jumlah_rkap_peralatan = $this->Report_model->jumlah_rkap_peralatan($get_tahun);
        $jumlah_rkap_non_fisik = $this->Report_model->jumlah_rkap_non_fisik($get_tahun);
        $total_rkap = $this->Report_model->total_rkap($get_tahun);

        $realisasi_sipil = $this->Report_model->realisasi_sipil($get_bulan, $get_tahun);
        $realisasi_peralatan = $this->Report_model->realisasi_peralatan($get_bulan, $get_tahun);
        $realisasi_non_fisik = $this->Report_model->realisasi_non_fisik($get_bulan, $get_tahun);
        $total_realisasi = $this->Report_model->realisasi_total($get_bulan, $get_tahun);
        $jumlah_realisasi_sipil = $this->Report_model->jumlah_realisasi_sipil($get_bulan, $get_tahun);
        $jumlah_realisasi_peralatan = $this->Report_model->jumlah_realisasi_peralatan($get_bulan, $get_tahun);
        $jumlah_realisasi_non_fisik = $this->Report_model->jumlah_realisasi_non_fisik($get_bulan, $get_tahun);
        $jumlah_realisasi_total = $this->Report_model->jumlah_realisasi_total($get_bulan, $get_tahun);

        $target_sipil = $this->Report_model->target_sipil($month, $get_tahun);
        $target_peralatan = $this->Report_model->target_peralatan($month, $get_tahun);
        $target_non_fisik = $this->Report_model->target_non_fisik($month, $get_tahun);
        $target_total = $this->Report_model->target_total($month, $get_tahun);
        $jumlah_target_sipil = $this->Report_model->jumlah_target_sipil($month, $get_tahun);
        $jumlah_target_peralatan = $this->Report_model->jumlah_target_peralatan($month, $get_tahun);
        $jumlah_target_non_fisik = $this->Report_model->jumlah_target_non_fisik($month, $get_tahun);
        $jumlah_target_total = $this->Report_model->jumlah_target_total($month, $get_tahun);

        $realisasi_target_sipil = $this->Report_model->realisasi_target_sipil($get_bulan, $get_tahun, $month);
        $realisasi_target_peralatan = $this->Report_model->realisasi_target_peralatan($get_bulan, $get_tahun, $month);
        $realisasi_target_non_fisik = $this->Report_model->realisasi_target_non_fisik($get_bulan, $get_tahun, $month);
        $total_realisasi_target = $this->Report_model->total_realisasi_target($get_bulan, $get_tahun, $month);
        $jumlah_realisasi_target_sipil = $this->Report_model->jumlah_realisasi_target_sipil($get_bulan, $get_tahun, $month);
        $jumlah_realisasi_target_peralatan = $this->Report_model->jumlah_realisasi_target_peralatan($get_bulan, $get_tahun, $month);
        $jumlah_realisasi_target_non_fisik = $this->Report_model->jumlah_realisasi_target_non_fisik($get_bulan, $get_tahun, $month);
        $jumlah_realisasi_target_total = $this->Report_model->jumlah_realisasi_target_total($get_bulan, $get_tahun, $month);

        $realisasi_rkap_sipil = $this->Report_model->realisasi_rkap_sipil($get_bulan, $get_tahun);
        $realisasi_rkap_peralatan = $this->Report_model->realisasi_rkap_peralatan($get_bulan, $get_tahun);
        $realisasi_rkap_non = $this->Report_model->realisasi_rkap_non($get_bulan, $get_tahun);
        $total_realisasi_rkap = $this->Report_model->total_realisasi_rkap($get_bulan, $get_tahun);
        $jumlah_realisasi_rkap_sipil = $this->Report_model->jumlah_realisasi_rkap_sipil($get_bulan, $get_tahun);
        $jumlah_realisasi_rkap_peralatan = $this->Report_model->jumlah_realisasi_rkap_peralatan($get_bulan, $get_tahun);
        $jumlah_realisasi_rkap_non = $this->Report_model->jumlah_realisasi_rkap_non($get_bulan, $get_tahun);
        $jumlah_realisasi_rkap_total = $this->Report_model->jumlah_realisasi_rkap_total($get_bulan, $get_tahun);

        $deviasi_sipil = $this->Report_model->deviasi_sipil($get_bulan, $get_tahun, $month);
        $deviasi_peralatan = $this->Report_model->deviasi_peralatan($get_bulan, $get_tahun, $month);
        $deviasi_non_fisik = $this->Report_model->deviasi_non_fisik($get_bulan, $get_tahun, $month);
        $total_deviasi = $this->Report_model->total_deviasi($get_bulan, $get_tahun, $month);
        $jumlah_deviasi_sipil = $this->Report_model->jumlah_deviasi_sipil($get_bulan, $get_tahun, $month);
        $jumlah_deviasi_peralatan = $this->Report_model->jumlah_deviasi_peralatan($get_bulan, $get_tahun, $month);
        $jumlah_deviasi_non_fisik = $this->Report_model->jumlah_deviasi_non_fisik($get_bulan, $get_tahun, $month);
        $jumlah_deviasi_total = $this->Report_model->jumlah_deviasi_total($get_bulan, $get_tahun, $month);
        // print_r($jumlah_realisasi_rkap_non); exit();


        // print_r($deviasi_sipil); exit();

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 11; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach($cabang as $data){ // Lakukan looping pada variabel siswa

                //RKAP
                foreach ($rkap_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->RKAP_INVS_VALUE > 0) {
                                $row_rkap_sipil = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                            }
                        else{
                                $row_rkap_sipil = '0';
                            }
                        }
                    }

                foreach ($rkap_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->RKAP_INVS_VALUE > 0) {
                                $row_rkap_peralatan = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                            }
                        else{
                                $row_rkap_peralatan = '0';
                            }
                        }
                    }

                foreach ($rkap_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->RKAP_INVS_VALUE > 0) {
                                $row_rkap_non = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                            }
                        else{
                                $row_rkap_non = '0';
                            }
                        }
                    }

                foreach ($jumlah_rkap as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->RKAP_INVS_VALUE > 0) {
                                $row_jumlah_rkap = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                            }
                        else{
                                $row_jumlah_rkap = '0';
                            }
                        }
                    }

                    //JUMLAH FOOTER RKAP
                foreach ($jumlah_rkap_sipil as $list) {
                    if ($list->RKAP_INVS_VALUE > 0) {
                            $row_jumlah_rkap_sipil = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_rkap_sipil = '0';
                        }
                    }

                foreach ($jumlah_rkap_peralatan as $list) {
                    if ($list->RKAP_INVS_VALUE > 0) {
                            $row_jumlah_rkap_peralatan = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_rkap_peralatan = '0';
                        }
                    }

                foreach ($jumlah_rkap_non_fisik as $list) {
                    if ($list->RKAP_INVS_VALUE > 0) {
                            $row_jumlah_rkap_non = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_rkap_non = '0';
                        }
                    }

                foreach ($total_rkap as $list) {
                    if ($list->RKAP_INVS_VALUE > 0) {
                            $row_total_rkap = number_format($list->RKAP_INVS_VALUE, 2, ',', '.');
                        }
                    else{
                            $row_total_rkap = '0';
                        }
                    }

                //REALISASI
                foreach ($realisasi_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $row_realisasi_sipil = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $row_realisasi_sipil = '0';
                            }
                        }
                    }

                foreach ($realisasi_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $row_realisasi_peralatan = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $row_realisasi_peralatan = '0';
                            }
                        }
                    }

                foreach ($realisasi_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $row_realisasi_non_fisik = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $row_realisasi_non_fisik = '0';
                            }
                        }
                    }

                foreach ($total_realisasi as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_REALISASI > 0) {
                                $row_total_realisasi = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                            }
                        else{
                                $row_total_realisasi = '0';
                            }
                        }
                    }

                foreach ($jumlah_realisasi_sipil as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $row_jumlah_realisasi_sipil = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_realisasi_sipil = '0';
                        }
                    }

                foreach ($jumlah_realisasi_peralatan as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $row_jumlah_realisasi_peralatan = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_realisasi_peralatan = '0';
                        }
                    }

                foreach ($jumlah_realisasi_non_fisik as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $row_jumlah_realisasi_non_fisik = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_realisasi_non_fisik = '0';
                        }
                    }

                foreach ($jumlah_realisasi_total as $list) {
                    if ($list->TOTAL_REALISASI > 0) {
                            $row_jumlah_realisasi_total = number_format($list->TOTAL_REALISASI, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_realisasi_total = '0';
                        }
                    }

                //TARGET

                foreach ($target_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_TARGET > 0) {
                                $row_target_sipil = number_format($list->TOTAL_TARGET, 2, ',', '.');
                            }
                        else{
                                $row_target_sipil = '0';
                            }
                        }
                    }

                foreach ($target_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_TARGET > 0) {
                                $row_target_peralatan = number_format($list->TOTAL_TARGET, 2, ',', '.');
                            }
                        else{
                                $row_target_peralatan = '0';
                            }
                        }
                    }

                foreach ($target_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_TARGET > 0) {
                                $row_target_non_fisik = number_format($list->TOTAL_TARGET, 2, ',', '.');
                            }
                        else{
                                $row_target_non_fisik = '0';
                            }
                        }
                    }

                foreach ($target_total as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->TOTAL_TARGET > 0) {
                                $row_target_total = number_format($list->TOTAL_TARGET, 2, ',', '.');
                            }
                        else{
                                $row_target_total = '0';
                            }
                        }
                    }

                foreach ($jumlah_target_sipil as $list) {
                    if ($list->TOTAL_TARGET > 0) {
                            $row_jumlah_target_sipil = number_format($list->TOTAL_TARGET, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_target_sipil = '0';
                        }
                    }

                foreach ($jumlah_target_peralatan as $list) {
                    if ($list->TOTAL_TARGET > 0) {
                            $row_jumlah_target_peralatan = number_format($list->TOTAL_TARGET, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_target_peralatan = '0';
                        }
                    }

                foreach ($jumlah_target_non_fisik as $list) {
                    if ($list->TOTAL_TARGET > 0) {
                            $row_jumlah_target_non = number_format($list->TOTAL_TARGET, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_target_non = '0';
                        }
                    }

                foreach ($jumlah_target_total as $list) {
                    if ($list->TOTAL_TARGET > 0) {
                            $row_jumlah_target_total = number_format($list->TOTAL_TARGET, 2, ',', '.');
                        }
                    else{
                            $row_jumlah_target_total = '0';
                        }
                    }

                //REALISASI TERHADAP TARGET

                foreach ($realisasi_target_sipil as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->VALUE > 0) {
                                $row_realisasi_target_sipil = number_format($list->VALUE, 2, ',', '.').'%';
                            }
                        else{
                                $row_realisasi_target_sipil = '0';
                            }
                        }
                    }

                foreach ($realisasi_target_peralatan as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->VALUE > 0) {
                                $row_realisasi_target_peralatan = number_format($list->VALUE, 2, ',', '.').'%';
                            }
                        else{
                                $row_realisasi_target_peralatan = '0';
                            }
                        }
                    }

                foreach ($realisasi_target_non_fisik as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->VALUE > 0) {
                                $row_realisasi_target_non_fisik = number_format($list->VALUE, 2, ',', '.').'%';
                            }
                        else{
                                $row_realisasi_target_non_fisik = '0';
                            }
                        }
                    }

                foreach ($total_realisasi_target as $list) {
                    if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                        if ($list->VALUE > 0) {
                            $row_total_realisasi_target = number_format($list->VALUE, 2, ',', '.').'%';
                        }
                    else{
                            $row_total_realisasi_target = '0';
                        }
                    }
                }

            foreach ($jumlah_realisasi_target_sipil as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_target_sipil = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_target_sipil = '0';
                    }
                }

            foreach ($jumlah_realisasi_target_peralatan as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_target_peralatan = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_target_peralatan = '0';
                    }
                }

            foreach ($jumlah_realisasi_target_non_fisik as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_target_non = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_target_non = '0';
                    }
                }

            foreach ($jumlah_realisasi_target_total as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_target_total = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_target_total = '0';
                    }
                }

            //REALISASI TERHADAP RKAP

            foreach ($realisasi_rkap_sipil as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->VALUE > 0) {
                            $row_realisasi_rkap_sipil = number_format($list->VALUE, 2, ',', '.').'%';
                        }
                    else{
                            $row_realisasi_rkap_sipil = '0';
                        }
                    }
                }

            foreach ($realisasi_rkap_peralatan as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->VALUE > 0) {
                            $row_realisasi_rkap_peralatan = number_format($list->VALUE, 2, ',', '.').'%';
                        }
                    else{
                            $row_realisasi_rkap_peralatan = '0';
                        }
                    }
                }

            foreach ($realisasi_rkap_non as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->VALUE > 0) {
                            $row_realisasi_rkap_non = number_format($list->VALUE, 2, ',', '.').'%';
                        }
                    else{
                            $row_realisasi_rkap_non = '0';
                        }
                    }
                }

            foreach ($total_realisasi_rkap as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->VALUE > 0) {
                            $row_total_realisasi_rkap = number_format($list->VALUE, 2, ',', '.').'%';
                        }
                    else{
                            $row_total_realisasi_rkap = '0';
                        }
                    }
                }

            foreach ($jumlah_realisasi_rkap_sipil as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_rkap_sipil = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_rkap_sipil = '0';
                    }
                }

            foreach ($jumlah_realisasi_rkap_peralatan as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_rkap_peralatan = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_rkap_peralatan = '0';
                    }
                }

            foreach ($jumlah_realisasi_rkap_non as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_rkap_non = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_rkap_non = '0';
                    }
                }

            foreach ($jumlah_realisasi_rkap_total as $list) {
                if ($list->VALUE > 0) {
                        $row_jumlah_realisasi_rkap_total = number_format($list->VALUE, 2, ',', '.').'%';
                    }
                else{
                        $row_jumlah_realisasi_rkap_total = '0';
                    }
                }

            //REALISASI TERHADAP TARGET

            foreach ($deviasi_sipil as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->DEVIASI) {
                            $row_deviasi_sipil = number_format($list->DEVIASI, 2, ',', '.');
                        }
                    else{
                            $row_deviasi_sipil = '0';
                        }
                    }
                }
                // print_r($row_deviasi_sipil); exit();

            foreach ($deviasi_peralatan as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->DEVIASI) {
                            $row_deviasi_peralatan = number_format($list->DEVIASI, 2, ',', '.');
                        }
                    else{
                            $row_deviasi_peralatan = '0';
                        }
                    }
                }

            foreach ($deviasi_non_fisik as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->DEVIASI) {
                            $row_deviasi_non_fisik = number_format($list->DEVIASI, 2, ',', '.');
                        }
                    else{
                            $row_deviasi_non_fisik = '0';
                        }
                    }
                }

            foreach ($total_deviasi as $list) {
                if ($list->BRANCH_NAME == $data->BRANCH_NAME) {
                    if ($list->DEVIASI) {
                            $row_total_deviasi = number_format($list->DEVIASI, 2, ',', '.');
                        }
                    else{
                            $row_total_deviasi = '0';
                        }
                    }
                }

            foreach ($jumlah_deviasi_sipil as $list) {
                if ($list->DEVIASI) {
                        $row_jumlah_deviasi_sipil = number_format($list->DEVIASI, 2, ',', '.');
                    }
                else{
                        $row_jumlah_deviasi_sipil = '0';
                    }
                }

            foreach ($jumlah_deviasi_peralatan as $list) {
                if ($list->DEVIASI) {
                        $row_jumlah_deviasi_peralatan = number_format($list->DEVIASI, 2, ',', '.');
                    }
                else{
                        $row_jumlah_deviasi_peralatan = '0';
                    }
                }

            foreach ($jumlah_deviasi_non_fisik as $list) {
                if ($list->DEVIASI) {
                        $row_jumlah_deviasi_non = number_format($list->DEVIASI, 2, ',', '.');
                    }
                else{
                        $row_jumlah_deviasi_non = '0';
                    }
                }

            foreach ($jumlah_deviasi_total as $list) {
                if ($list->DEVIASI) {
                        $row_jumlah_deviasi_total = number_format($list->DEVIASI, 2, ',', '.');
                    }
                else{
                        $row_jumlah_deviasi_total = '0';
                    }
                }

            // FOOTER

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->BRANCH_NAME);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row_rkap_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row_rkap_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row_rkap_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $row_jumlah_rkap);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row_target_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row_target_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row_target_non_fisik);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $row_target_total);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row_realisasi_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row_realisasi_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row_realisasi_non_fisik);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row_total_realisasi);

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $row_deviasi_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $row_deviasi_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $row_deviasi_non_fisik);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $row_total_deviasi);

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $row_realisasi_target_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $row_realisasi_target_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $row_realisasi_target_non_fisik);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, $row_total_realisasi_target);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$numrow, $row_realisasi_rkap_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('x'.$numrow, $row_realisasi_rkap_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, $row_realisasi_rkap_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, $row_total_realisasi_rkap);

            // set footer
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A24', "JUMLAH"); 
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C24', $row_jumlah_rkap_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D24', $row_jumlah_rkap_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E24', $row_jumlah_rkap_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F24', $row_total_rkap);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G24', $row_jumlah_target_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H24', $row_jumlah_target_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I24', $row_jumlah_target_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J24', $row_jumlah_target_total);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K24', $row_jumlah_realisasi_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L24', $row_jumlah_realisasi_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M24', $row_jumlah_realisasi_non_fisik);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N24', $row_jumlah_realisasi_total);

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O24', $row_jumlah_deviasi_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P24', $row_jumlah_deviasi_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q24', $row_jumlah_deviasi_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R24', $row_jumlah_deviasi_total);

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S24', $row_jumlah_realisasi_target_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T24', $row_jumlah_realisasi_target_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U24', $row_jumlah_realisasi_target_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V24', $row_jumlah_realisasi_target_total);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W24', $row_jumlah_realisasi_rkap_sipil);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X24', $row_jumlah_realisasi_rkap_peralatan);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y24', $row_jumlah_realisasi_rkap_non);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z24', $row_jumlah_realisasi_rkap_total);
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($name_row);
          $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($name_row);
          $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($style_row);
          $objPHPExcel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($style_row);
          // $objPHPExcel->getActiveSheet()->getStyle('0'.$numrow)->applyFromArray($style_row);
          
          $no++; // Tambah 1 setiap kali looping
          $numrow++; // Tambah 1 setiap kali looping
        }


    // Set width kolom
        // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Set orientasi kertas jadi LANDSCAPE
    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    // Set judul file excel nya
    $objPHPExcel->getActiveSheet(0)->setTitle("Rekapitulasi Laporan MMR");
    $objPHPExcel->setActiveSheetIndex(0);

    $objWorksheet = $objPHPExcel->getActiveSheet();

    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    // $objWriter->save("test_".date('Y-m-d H-i-s').".xlsx");

    $get_month = $date->format('d-M-Y');
    $file_name = "Report MMR ".$get_month.".xls";

    //Header
    ob_end_clean();
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //Nama File
    header('Content-Disposition: attachment;filename="'.$file_name.'"');
    //Download
    $objWriter->save("php://output");
    
}

public function detail($id_branch, $show_month, $show_years, $show_tanggal){

    $this->load->library('PHPExcel/IOFactory');

    $data4 = array(
                'USER_ID' => $this->session->userdata('SESS_USER_ID'),
                'LOG_ACTION' => 'user export excel Detail MMR',
                'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
                'LOG_URL' => $_SERVER['REQUEST_URI']
            );

    $this->log_model->add($data4);

    // merubah style border pada cell yang aktif (cell yang terisi)
    $styleArray = array( 'borders' => 
        array( 'allborders' => 
            array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
                ), 
            ), 
        );

    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_line = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
      )
    );

    $style_pro = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $style_sub = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $style_sub_2 = array(
      'borders' => array(
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $style_header = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      )
    );

    $style_total = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );


    $style_row = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $name_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    //color cell
    $color_1 = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'f6d71d')
        )
    );

    $color_2 = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4583ed')
        )
    );

    $color_3 = array(
      'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'ffffff')
        ), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000000')
        )
    );

    $color_4 = array(
      'font' => array('color' => array('rgb' => 'ffffff')), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis]
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $color_5 = array(
      'font' => array('color' => array('rgb' => 'ffffff')), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    $indikator_color = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        // 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => '2ECC71')
            )
    );
    $indikator_color2 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        // 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => 'F5AB35')
            )
    );

    $indikator_color3 = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        // 'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      ),
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => 'D91E18')
            )
    );

    $color_aktiva = array(
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => '2ECC71')
            )
    );
    $color_aktiva2 = array(
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => '34cbf5')
            )
    );
    $color_aktiva3 = array(
      'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                
                'color' => array('rgb' => 'f1f534')
            )
    );

    //membuat object baru bernama $objPHPExcel
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('./assets/img/ipc_logo.png');

    $objDrawing->setCoordinates('B2');
    $objDrawing->setHeight(130);
    $objDrawing->setWidth(130);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    // deklarasi tanggal
    $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

    $get_tahun = $show_years;
    $get_bulan = $show_tanggal;
    $get_month = $show_month;

    $title = "RKAP TAHUN ".$get_tahun." S/D BULAN ".$get_month;
    $branch = $this->Report_model->get_branch($id_branch)[0]->BRANCH_NAME;

    // data dibuat pada sheet pertama
    $objPHPExcel->setActiveSheetIndex(0); 
    $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO');
    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PT PELABUHAN INDONESIA II (PERSERO)');
    $objPHPExcel->getActiveSheet()->setCellValue('A4', 'REKAPITULASI LAPORAN DETAIL MMR BULANAN');
    $objPHPExcel->getActiveSheet()->setCellValue('A5', $title);
    $objPHPExcel->getActiveSheet()->mergeCells('A2:AQ2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:AQ3');
    $objPHPExcel->getActiveSheet()->mergeCells('A4:AQ4');
    $objPHPExcel->getActiveSheet()->mergeCells('A5:AQ5');
    $objPHPExcel->getActiveSheet()->mergeCells('A7:A9');
    $objPHPExcel->getActiveSheet()->mergeCells('A11:E11');
    $objPHPExcel->getActiveSheet()->mergeCells('B7:C7');
    $objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
    $objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
    $objPHPExcel->getActiveSheet()->mergeCells('D7:H7');
    $objPHPExcel->getActiveSheet()->mergeCells('D8:F8');
    $objPHPExcel->getActiveSheet()->mergeCells('D9:E9');
    $objPHPExcel->getActiveSheet()->mergeCells('I7:O7');
    $objPHPExcel->getActiveSheet()->mergeCells('I8:I9');
    $objPHPExcel->getActiveSheet()->mergeCells('J8:J9');
    $objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
    $objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
    $objPHPExcel->getActiveSheet()->mergeCells('Q7:R7');
    $objPHPExcel->getActiveSheet()->mergeCells('S7:AF7');
    $objPHPExcel->getActiveSheet()->mergeCells('S8:V8');
    $objPHPExcel->getActiveSheet()->mergeCells('W8:Z8');
    $objPHPExcel->getActiveSheet()->mergeCells('AA8:AD8');
    $objPHPExcel->getActiveSheet()->mergeCells('AE8:AF8');
    $objPHPExcel->getActiveSheet()->mergeCells('AG7:AG8');
    $objPHPExcel->getActiveSheet()->mergeCells('AH7:AP7');
    $objPHPExcel->getActiveSheet()->mergeCells('AH8:AI8');
    $objPHPExcel->getActiveSheet()->mergeCells('AK8:AM8');
    $objPHPExcel->getActiveSheet()->mergeCells('AN8:AO8');
    $objPHPExcel->getActiveSheet()->freezePane('I12');

    $objPHPExcel->getActiveSheet()->getStyle('A7:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('L8:L'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('M8:M'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('N8:N'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('O8:O'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('I8:I'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('K8:K'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('M8:M'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('C14:F999')->getAlignment()->setWrapText(true); 
    // $objPHPExcel->getActiveSheet()->getStyle('E14:E100'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('AD8:AD'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('AP8:AP'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('AE8:AE'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('AK8:AK'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

    //set header kolom
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "JENIS INVESTASI"); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11', $branch); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "JENIS AKTIVA"); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "COA"); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "AKTIVA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', "DATA RKAP ".$get_tahun);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "URAIAN INVESTASI"); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "KEB. DANA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', "RKAP ".$get_tahun);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', "ITEM INDUK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', "SUB ITEM");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I7', "DATA KONTRAK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', "KONTRAK KE-");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8', "NOMOR KONTRAK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "TANGGAL KONTRAK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "KONTRAKTOR PELAKSANA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', "JANGKA WAKTU PELAKSANAAN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N8', "TOTAL NILAI KONTRAK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O8', "KONTRAK ".$get_tahun);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M9', "BULAN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P7', "TARGET");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P8', "S/D ".$get_month);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q7', "REALISASI S/D TAHUN LALU");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q8', "% FISIK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R8', "NILAI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q9', "%");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S7', "REALISASI BULANAN (x Rp.1000)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S8', "S/D BULAN SEBELUM");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S9', "%FISIK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T9', "NILAI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U9', "BIAYA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V9', "TOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W8', "BULAN ".$get_month);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W9', "%FISIK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X9', "NILAI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y9', "BIAYA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z9', "TOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA8', "S/D BULAN ".$get_month);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA9', "%FISIK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB9', "NILAI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC9', "BIAYA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD9', "TOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE8', "TOTAL REALISASI DARI TAHUN LALU");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE9', "% FISIK");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF9', "NILAI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG7', "TAKSASI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG9', "x Rp.1000");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH7', "KETERANGAN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH8', "STATUS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH9', "KODE");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI9', "STATUS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ8', "INDIKATOR KINERJA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ9', "S/D ".$get_month);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK8', "POSISI SAAT INI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN8', "KENDALA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP8', "DEADLINE PENYELESAIAN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK9', "KODE");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL9', "POSISI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM9', "DESKRIPSI POSISI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN9', "KODE KENDALA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO9', "JENIS KENDALA");

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_header);
    $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_header);
    $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_header);

    $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('O7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('O9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('P7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('P9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('R7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('R8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('R9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('S7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('S8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('S9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('T7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('T8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('T9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('U7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('U8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('U9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('V7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('V8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('V9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('W7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('W8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('W9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('X7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('X8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('X9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Y7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Y8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Y9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Z7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Z8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Z9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AA7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AA8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AA9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AB7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AB8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AB9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AC7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AC8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AC9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AD7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AD8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AD9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AE7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AE8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AE9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AF7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AF8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AF9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AG7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AG8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AG9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AH7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AH8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AH9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AI7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AI8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AI9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AJ7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AJ8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AJ9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AK7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AK8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AK9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AL7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AL8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AL9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AM7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AM8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AM9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AN7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AN8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AN9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AO7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AO8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AO9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AP7')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AP8')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AP9')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('AP10')->applyFromArray($style_line);
    $objPHPExcel->getActiveSheet()->getStyle('AP11')->applyFromArray($style_line);
    $objPHPExcel->getActiveSheet()->getStyle('AP12')->applyFromArray($style_line);
    $objPHPExcel->getActiveSheet()->getStyle('AP13')->applyFromArray($style_line);

    $assets     = $this->Report_detail_mmr_model->get_assets($id_branch);
    $assets_num = 13;
    foreach ($assets as $value) {
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$assets_num.':AP'.$assets_num);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$assets_num, $value->INVS_TYPE_NAME);

        if ($value->INVS_TYPE_ID == 1) {

            $objPHPExcel->getActiveSheet()->getStyle('A'.$assets_num)->applyFromArray($color_aktiva);
        } else if ($value->INVS_TYPE_ID == 2) {

            $objPHPExcel->getActiveSheet()->getStyle('A'.$assets_num)->applyFromArray($color_aktiva2);
        } else {

            $objPHPExcel->getActiveSheet()->getStyle('A'.$assets_num)->applyFromArray($color_aktiva3);
        }

        $aktiva_years     = $this->Report_detail_mmr_model->aktiva_years($id_branch, $value->INVS_TYPE_ID, $get_tahun);
        // print_r($aktiva_years); exit();

        
        $aktiva   = $this->Report_detail_mmr_model->get_aktiva($id_branch, $value->INVS_TYPE_ID);
        $years_num        = $assets_num + 1;


        foreach ($aktiva_years as $years) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$years_num, $value->INVS_TYPE_NAME.' '.$years->RKAP_INVS_YEAR);
            
            $aktiva  = $this->Report_detail_mmr_model->get_aktiva($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);
            $no =1;
            $act_num = $years_num + 1;
            // print_r($aktiva); exit();
            foreach ($aktiva as $act) {
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$act_num, $act->ASSETS_NAME);
                $rkap            = $this->Report_detail_mmr_model->get_rkap($id_branch, $value->INVS_TYPE_ID, $act->ASSETS_ID, $years->RKAP_INVS_YEAR);
                $status          = $this->Report_detail_mmr_model->get_status($id_branch, $get_tahun, $value->INVS_TYPE_ID);
                // print_r($rkap); exit();
                $sub_program     = $this->Report_detail_mmr_model->count_subpro($id_branch, $value->INVS_TYPE_ID, $act->ASSETS_ID, $years->RKAP_INVS_YEAR);
                $addendum        = $this->Report_detail_mmr_model->count_addendum($id_branch, $value->INVS_TYPE_ID, $act->ASSETS_ID, $years->RKAP_INVS_YEAR);
                $activa          = $this->Report_detail_mmr_model->get_value_rkap($id_branch, $act->ASSETS_ID, $value->INVS_TYPE_ID, $get_tahun);

                $jumlah_rkap     = count($rkap);
                $jumlah_sub      = count($sub_program);
                $jumlah_addendum = count($addendum);
                $jumlah_aktiva   = count($activa);
                // print_r($rkap); exit();
                $numrow          = $act_num + 1; 

                foreach ($rkap as $row) {
                    $get_assets_name  = $this->Report_detail_mmr_model->get_assets_name($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $get_tahun);
                    $value_rkap       = $this->Report_detail_mmr_model->get_value_rkap($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);
                    $total_contract   = $this->Report_detail_mmr_model->total_contract($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);
                    $total_contract_y = $this->Report_detail_mmr_model->total_contact_year($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun);
                    $total_target     = $this->Report_detail_mmr_model->total_target($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID,$years->RKAP_INVS_YEAR, $get_bulan, $get_tahun);
                    $total_previous_y = $this->Report_detail_mmr_model->total_previous_year($id_branch, $years->RKAP_INVS_YEAR, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $get_tahun);
                    $total_previous_m = $this->Report_detail_mmr_model->total_previous_month($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $total_this_m     = $this->Report_detail_mmr_model->total_this_month($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $total_until_m    = $this->Report_detail_mmr_model->total_until($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $total_value_real = $this->Report_detail_mmr_model->total_value_real($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $get_bulan, $years->RKAP_INVS_YEAR);
                    $total_tax        = $this->Report_detail_mmr_model->total_tax($id_branch, $row->RKAP_INVS_ASSETS, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);

                    // print_r($total_target);exit();
                    //total investasi pertahun
                    $value_rkap_y           = $this->Report_detail_mmr_model->value_rkap_y($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);
                    $invs_type_contract     = $this->Report_detail_mmr_model->invs_type_contract($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);
                    $invs_type_contact_year = $this->Report_detail_mmr_model->invs_type_contact_year($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun);
                    $invs_type_target       = $this->Report_detail_mmr_model->invs_type_target($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_bulan, $get_tahun);
                    $invs_type_previous_y   = $this->Report_detail_mmr_model->invs_type_previous_year($id_branch, $years->RKAP_INVS_YEAR, $value->INVS_TYPE_ID, $get_tahun);
                    $invs_type_previous_m   = $this->Report_detail_mmr_model->invs_type_previous_month($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $invs_type_this_m       = $this->Report_detail_mmr_model->invs_type_this_month($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $invs_type_until_m      = $this->Report_detail_mmr_model->invs_type_until($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun, $get_bulan);
                    $invs_type_value_real   = $this->Report_detail_mmr_model->invs_type_value_real($id_branch, $years->RKAP_INVS_YEAR, $value->INVS_TYPE_ID, $get_bulan, $get_tahun);
                    $invs_type_tax          = $this->Report_detail_mmr_model->invs_type_tax($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR);

                    $tot_val          = $act_num + $jumlah_rkap + $jumlah_sub + $jumlah_addendum + 1;
                    $tot_act_year     = $tot_val +1;

                    // print_r($invs_type_value_real); exit();

                    foreach ($value_rkap_y as $rkap_years) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$tot_act_year, 'Total '.$value->INVS_TYPE_NAME.' '.$years->RKAP_INVS_YEAR);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$tot_act_year, number_format($rkap_years->RKAP_INVS_COST_REQ, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$tot_act_year, number_format($rkap_years->RKAP_INVS_VALUE, 2, ',', '.'));
                        foreach ($invs_type_contract    as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$tot_act_year, number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'));
                        }
                        foreach ($invs_type_contact_year  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$tot_act_year, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
                        }
                        foreach ($invs_type_target      as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$tot_act_year, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
                        }
                        foreach ($invs_type_previous_y  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$tot_act_year, number_format($list->REALISASI, 2, ',', '.'));
                        }
                        foreach ($invs_type_previous_m  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$tot_act_year, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$tot_act_year, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$tot_act_year, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($invs_type_this_m      as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$tot_act_year, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$tot_act_year, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$tot_act_year, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($invs_type_until_m     as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$tot_act_year, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$tot_act_year, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$tot_act_year, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($invs_type_value_real  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$tot_act_year, number_format($list->REALISASI, 2, ',', '.'));
                        }
                        foreach ($invs_type_tax         as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$tot_act_year, number_format($list->TAX, 2, ',', '.'));
                        }

                        $objPHPExcel->getActiveSheet()->getStyle('A'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('E'.$tot_act_year)->applyFromArray($name_row);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('I'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('J'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('K'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('L'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('M'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('N'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('O'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('P'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('Q'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('R'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('S'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('T'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('U'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('V'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('W'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('X'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('Y'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('Z'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AA'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AB'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AC'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AD'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AE'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AF'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AG'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AH'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AI'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AJ'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AK'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AL'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AM'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AN'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AO'.$tot_act_year)->applyFromArray($style_pro);
                        $objPHPExcel->getActiveSheet()->getStyle('AP'.$tot_act_year)->applyFromArray($style_pro);

                        $tot_act_year ++;
                    }

                    foreach ($value_rkap as $rkap) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$tot_val, number_format($rkap->RKAP_INVS_COST_REQ, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$tot_val, number_format($rkap->RKAP_INVS_VALUE, 2, ',', '.'));

                        foreach ($get_assets_name   as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$tot_val, $list->ASSETS_NAME);
                        }
                        foreach ($total_contract    as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$tot_val, number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'));
                        }
                        foreach ($total_contract_y  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$tot_val, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
                        }
                        foreach ($total_target      as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$tot_val, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
                        }
                        foreach ($total_previous_y  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$tot_val, number_format($list->REALISASI, 2, ',', '.'));
                        }
                        foreach ($total_previous_m  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$tot_val, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$tot_val, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$tot_val, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($total_this_m      as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$tot_val, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$tot_val, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$tot_val, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($total_until_m     as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$tot_val, number_format($list->REALISASI, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$tot_val, number_format($list->COST, 2, ',', '.'));
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$tot_val, number_format($list->TOTAL, 2, ',', '.'));
                        }
                        foreach ($total_value_real  as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$tot_val, number_format($list->REALISASI, 2, ',', '.'));
                        }
                        foreach ($total_tax         as $list) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$tot_val, number_format($list->TAX, 2, ',', '.'));
                        }

                            $objPHPExcel->getActiveSheet()->getStyle('A'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('C'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('D'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('E'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('H'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('I'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('J'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('K'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('L'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('M'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('N'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('O'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('P'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('Q'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('R'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('S'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('T'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('U'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('V'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('W'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('X'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('Y'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('Z'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AA'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AB'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AC'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AD'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AE'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AF'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AG'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AH'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AI'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AJ'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AK'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AL'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AM'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AN'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AO'.$tot_val)->applyFromArray($style_pro);
                            $objPHPExcel->getActiveSheet()->getStyle('AP'.$tot_val)->applyFromArray($style_pro);

                        $tot_val ++;
                    }

                    

                    foreach ($status as $list_status) { 
                        if ($list_status->RKAP_INVS_ID == $row->RKAP_INVS_ID) {
                            if ($list_status->REAL_SUBPRO_STATUS > 0) {
                                    $status_id   = '1';
                                    $status_name = 'Berjalan';
                                } else {
                                    $status_id   = '2';
                                    $status_name = 'Belum Berjalan';
                                }
                            }
                    }

                    $sub_number = $numrow + 1;

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $row->RKAP_INVS_ID);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $row->ASSETS_COA);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $row->ASSETS_NAME);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->RKAP_INVS_TITLE);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, number_format($row->RKAP_INVS_COST_REQ, 2, ',', '.'));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, number_format($row->RKAP_INVS_VALUE, 2, ',', '.'));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, number_format($row->RKAP_INVS_TAKSASI, 2, ',', '.'));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$numrow, $status_id);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$numrow, $status_name);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$numrow, $row->POSPROG_ID);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL'.$numrow, $row->POSPROG_NAME);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$numrow, '  ');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$numrow, '  ');
                    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$numrow, '  ');

                    $until          = $this->Report_detail_mmr_model->until($get_tahun, $get_bulan);
                    $target         = $this->Report_detail_mmr_model->get_target($get_bulan);
                    $subpro         = $this->Report_detail_mmr_model->get_subpro($row->RKAP_INVS_ID);
                    $deviasi        = $this->Report_detail_mmr_model->get_deviasi($get_bulan);
                    $contract       = $this->Report_detail_mmr_model->get_contract($get_tahun);
                    $total_real     = $this->Report_detail_mmr_model->total_real($get_bulan);
                    $this_month     = $this->Report_detail_mmr_model->this_month($get_bulan);
                    $constraint     = $this->Report_detail_mmr_model->get_constraints($get_bulan);
                    $previous_year  = $this->Report_detail_mmr_model->previous_year($get_tahun);
                    $previous_month = $this->Report_detail_mmr_model->previous_month($get_tahun, $get_bulan);
                    // print_r($previous_month); exit();
                    foreach ($subpro as $sub) {
                        $no = 1;
                        $add_num = $sub_number + 1;

                        foreach ($contract as $list) { 
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->NILAI_KONTRAK > 0) {
                                    $kontrak = $list->NILAI_KONTRAK;
                                }
                            else{
                                    $kontrak = '0';
                                }
                            }
                        }

                        foreach ($target as $rows) {
                        if ($rows->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($rows->NILAI_KONTRAK > 0) {
                                    $targets = $rows->NILAI_KONTRAK;
                                }
                            else{
                                    $targets = '0';
                                }
                            }
                        }

                        foreach ($previous_year as $list) {
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->REALISASI > 0) {
                                    $previous_real    = $list->REALISASI;
                                    $previous_percent = $list->PERCENT;
                                }
                            else{
                                    $previous_real    = '0';
                                    $previous_percent = '0';
                                }
                            }
                        }

                        foreach ($previous_month as $list) {
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->REALISASI > 0) {
                                    $realisasi_before = $list->REALISASI;
                                    $percent_before   = $list->PERCENT;
                                    $cost_before      = $list->COST;
                                    $total_before     = $list->TOTAL;
                                }
                            else{
                                    $realisasi_before = '0';
                                    $percent_before   = '0';
                                    $cost_before      = '0';
                                    $total_before     = '0';
                                }
                            }
                        }

                        foreach ($until as $list) {
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->REALISASI > 0) {
                                    $realisasi_until = $list->REALISASI;
                                    $percent_until   = $list->PERCENT;
                                    $cost_until      = $list->COST;
                                    $total_until     = $list->TOTAL;
                                }
                            else{
                                    $realisasi_until = '0';
                                    $percent_until   = '0';
                                    $cost_until      = '0';
                                    $total_until     = '0';
                                }
                            }
                        }

                        foreach ($this_month as $list) {
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->REALISASI > 0) {
                                    $realisasi_now = $list->REALISASI;
                                    $percent_now   = $list->PERCENT;
                                    $cost_now      = $list->COST;
                                    $total_now     = $list->TOTAL;
                                }
                            else{
                                    $realisasi_now = '0';
                                    $percent_now   = '0';
                                    $cost_now      = '0';
                                    $total_now     = '0';
                                }
                            }
                        }

                        foreach ($total_real as $list) {
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->REALISASI > 0) {
                                    $real    = $list->REALISASI;
                                    $percent = $list->PERCENT;
                                }
                            else{
                                    $real    = '0';
                                    $percent = '0';
                                }
                            }
                        }

                        foreach ($constraint as $list) { 
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->CONTRAINTS_ID > 0) {
                                    $id_kendala = $list->CONTRAINTS_ID;
                                    $kendala    = $list->CONTRAINTS_NAME;
                                    
                                    if ($list->REAL_SUBPRO_DEADLINE > 0) {
                                        $deadline = $list->REAL_SUBPRO_DEADLINE;
                                    } else {
                                        $deadline ='-';
                                    }
                                }
                            else{
                                    $id_kendala = '';
                                    $kendala    = '';
                                    $deadline   = '';
                                }
                            }
                        }

                        foreach ($deviasi as $list) { 
                        if ($list->RKAP_SUBPRO_ID == $sub->RKAP_SUBPRO_ID) {
                            if ($list->DEVIASI != '') {
                                    $indikator = $list->DEVIASI;
                                }
                            else{
                                    $indikator = '';
                                }
                            }
                        }

                        $get_addendum   = $this->Report_detail_mmr_model->get_addendum($sub->RKAP_SUBPRO_ID);

                        foreach ($get_addendum as $vall) {


                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$add_num, 'Add '.$no++);   
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$add_num, $vall->SUBPRO_ADD_NUM);  
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$add_num, $vall->SUBPRO_ADD_DATE);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$add_num, $vall->RKAP_SUBPRO_CONTRACTOR);  
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$add_num, $vall->SUBPRO_ADD_PERIODE);  

                            // style addendum
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('C'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('D'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('E'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('H'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('I'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('J'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('K'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('L'.$add_num)->applyFromArray($style_sub); 
                            $objPHPExcel->getActiveSheet()->getStyle('M'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('N'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('O'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('P'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('Q'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('R'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('S'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('T'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('U'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('V'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('W'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('X'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('Y'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('Z'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AA'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AB'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AC'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AD'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AE'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AF'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AG'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AH'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AI'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AJ'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AK'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AL'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AM'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AN'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AO'.$add_num)->applyFromArray($style_sub);
                            $objPHPExcel->getActiveSheet()->getStyle('AP'.$add_num)->applyFromArray($style_sub);


                            // $add_num = $tot_num++;
                            $add_num ++;
                        }

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sub_number, $sub->RKAP_SUBPRO_ID);       
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sub_number, $sub->RKAP_SUBPRO_TITTLE);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sub_number, '1');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sub_number, $sub->RKAP_SUBPRO_CONTRACT_NO);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sub_number, $sub->RKAP_SUBPRO_CONTRACT_DATE);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sub_number, $sub->RKAP_SUBPRO_CONTRACTOR);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sub_number, $sub->RKAP_SUBPRO_PERIODE);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sub_number, number_format($sub->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sub_number, number_format($kontrak, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$sub_number, number_format($targets, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$sub_number, number_format($previous_percent, 0, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$sub_number, number_format($previous_real, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$sub_number, number_format($percent_before, 0, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$sub_number, number_format($realisasi_before, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$sub_number, number_format($cost_before, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$sub_number, number_format($total_before, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$sub_number, number_format($percent_now, 0, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$sub_number, number_format($realisasi_now, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$sub_number, number_format($cost_now, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$sub_number, number_format($total_now, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$sub_number, number_format($percent_until, 0, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$sub_number, number_format($realisasi_until, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$sub_number, number_format($cost_until, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$sub_number, number_format($total_until, 2, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$sub_number, number_format($percent, 0, ',', '.'));
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$sub_number, number_format($real, 2, ',', '.'));
                        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$sub_number, $indikator);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN'.$sub_number, $id_kendala);      
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO'.$sub_number, $kendala);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP'.$sub_number, $deadline);

                        // style sub program
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$sub_number)->applyFromArray($color_4);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('E'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$sub_number)->applyFromArray($style_sub_2);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('I'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('J'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('K'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('L'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('M'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('N'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('O'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('P'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('Q'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('R'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('S'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('T'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('U'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('V'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('W'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('X'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('Y'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('Z'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AA'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AB'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AC'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AD'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AE'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AF'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AG'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AH'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AI'.$sub_number)->applyFromArray($style_sub);

                        if ($indikator >= 90) {
                            $objPHPExcel->getActiveSheet()->getStyle('AJ'.$sub_number)->applyFromArray($indikator_color);
                        } else if ($indikator >= 50 && $indikator < 90) {
                            $objPHPExcel->getActiveSheet()->getStyle('AJ'.$sub_number)->applyFromArray($indikator_color2);
                        } else if ($indikator > 0 && $indikator < 50){
                            $objPHPExcel->getActiveSheet()->getStyle('AJ'.$sub_number)->applyFromArray($indikator_color3);
                        }

                        $objPHPExcel->getActiveSheet()->getStyle('AK'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AL'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AM'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AN'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AO'.$sub_number)->applyFromArray($style_sub);
                        $objPHPExcel->getActiveSheet()->getStyle('AP'.$sub_number)->applyFromArray($style_sub);

                        $sub_number = $add_num++;
                        // $sub_number++;


                    }

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($color_5);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('V'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('W'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('X'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('Y'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('Z'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AA'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AB'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AC'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AD'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AE'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AF'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AG'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('AH'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('AI'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AK'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('AL'.$numrow)->applyFromArray($style_pro);
                    $objPHPExcel->getActiveSheet()->getStyle('AM'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AN'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AO'.$numrow)->applyFromArray($name_row);
                    $objPHPExcel->getActiveSheet()->getStyle('AP'.$numrow)->applyFromArray($name_row);

                    $numrow = $sub_number++; // Tambah 1 setiap kali looping

                }
                
                $tot_aktiva      = $tot_act_year;
                $act_num = $numrow ++;
            }
            $years_num = $tot_aktiva ++;
        }
        // print_r($tot_aktiva);exit();
        // total jenis investasi
        $val_investasi    = $this->Report_detail_mmr_model->invs_value_rkap     ($id_branch, $value->INVS_TYPE_ID, $get_tahun);
        $val_contract     = $this->Report_detail_mmr_model->invs_contract       ($id_branch, $value->INVS_TYPE_ID, $get_tahun);
        $val_contract_y   = $this->Report_detail_mmr_model->invs_contact_year   ($id_branch, $value->INVS_TYPE_ID, $get_tahun);
        $val_target       = $this->Report_detail_mmr_model->invs_target         ($id_branch, $value->INVS_TYPE_ID, $get_bulan, $get_tahun);
        $val_previous_y   = $this->Report_detail_mmr_model->invs_previous_year  ($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_tahun);
        $val_previous_m   = $this->Report_detail_mmr_model->invs_previous_month ($id_branch, $value->INVS_TYPE_ID, $get_tahun, $get_bulan);
        $val_this_m       = $this->Report_detail_mmr_model->invs_this_month     ($id_branch, $value->INVS_TYPE_ID, $get_tahun, $get_bulan);
        $val_until_m      = $this->Report_detail_mmr_model->invs_until          ($id_branch, $value->INVS_TYPE_ID, $get_tahun, $get_bulan);
        $val_value_real   = $this->Report_detail_mmr_model->invs_value_real     ($id_branch, $value->INVS_TYPE_ID, $years->RKAP_INVS_YEAR, $get_bulan);
        $val_tax          = $this->Report_detail_mmr_model->invs_tax            ($id_branch, $value->INVS_TYPE_ID, $get_tahun);
        // print_r($val_target); exit();
        foreach ($val_investasi as $invs_val) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$tot_aktiva, $value->INVS_TYPE_NAME);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$tot_aktiva, number_format($invs_val->RKAP_INVS_COST_REQ, 2, ',', '.'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$tot_aktiva, number_format($invs_val->RKAP_INVS_VALUE, 2, ',', '.'));

            foreach ($val_contract   as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$tot_aktiva, number_format($list->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'));
            }

            foreach ($val_contract_y as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$tot_aktiva, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
            }

            foreach ($val_target     as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$tot_aktiva, number_format($list->NILAI_KONTRAK, 2, ',', '.'));
            }

            foreach ($val_previous_y as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$tot_aktiva, number_format($list->REALISASI, 2, ',', '.'));
            }

            foreach ($val_previous_m  as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$tot_aktiva, number_format($list->REALISASI, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$tot_aktiva, number_format($list->COST, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$tot_aktiva, number_format($list->TOTAL, 2, ',', '.'));
            }
            foreach ($val_this_m      as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$tot_aktiva, number_format($list->REALISASI, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$tot_aktiva, number_format($list->COST, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$tot_aktiva, number_format($list->TOTAL, 2, ',', '.'));
            }
            foreach ($val_until_m     as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$tot_aktiva, number_format($list->REALISASI, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$tot_aktiva, number_format($list->COST, 2, ',', '.'));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$tot_aktiva, number_format($list->TOTAL, 2, ',', '.'));
            }

            foreach ($val_value_real  as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$tot_aktiva, number_format($list->REALISASI, 2, ',', '.'));
            }
            foreach ($val_tax         as $list) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$tot_aktiva, number_format($list->TAX, 2, ',', '.'));
            }

                $objPHPExcel->getActiveSheet()->getStyle('A'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('R'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('S'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('T'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('U'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('V'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('W'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('X'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('Y'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('Z'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AA'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AB'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AC'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AD'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AE'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AF'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AG'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AH'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AI'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AJ'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AK'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AL'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AM'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AN'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AO'.$tot_aktiva)->applyFromArray($style_total);
                $objPHPExcel->getActiveSheet()->getStyle('AP'.$tot_aktiva)->applyFromArray($style_total);

            $tot_aktiva ++;
        }

        $assets_num = $tot_aktiva++;
    }

    //total percabang
    $branch_num = $assets_num ++;

    $branch_investasi    = $this->Report_detail_mmr_model->branch_value_rkap        ($id_branch, $get_tahun);
    $branch_contract     = $this->Report_detail_mmr_model->branch_contract          ($id_branch, $get_tahun);
    $branch_contract_y   = $this->Report_detail_mmr_model->branch_contact_year      ($id_branch, $get_tahun);
    $branch_target       = $this->Report_detail_mmr_model->branch_target            ($id_branch, $get_bulan, $get_tahun);
    $branch_previous_y   = $this->Report_detail_mmr_model->branch_previous_year     ($id_branch, $get_tahun);
    $branch_previous_m   = $this->Report_detail_mmr_model->branch_previous_month    ($id_branch, $get_tahun, $get_bulan);
    $branch_this_m       = $this->Report_detail_mmr_model->branch_this_month        ($id_branch, $get_tahun, $get_bulan);
    $branch_until_m      = $this->Report_detail_mmr_model->branch_until             ($id_branch, $get_tahun, $get_bulan);
    $branch_value_real   = $this->Report_detail_mmr_model->branch_value_real        ($id_branch, $get_bulan, $get_tahun);
    $branch_tax          = $this->Report_detail_mmr_model->branch_tax               ($id_branch, $get_tahun);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$branch_num, $branch); 
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$branch_num, number_format($branch_investasi->RKAP_INVS_COST_REQ, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$branch_num, number_format($branch_investasi->RKAP_INVS_VALUE, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$branch_num, number_format($branch_contract->RKAP_SUBPRO_CONTRACT_VALUE, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$branch_num, number_format($branch_contract_y->NILAI_KONTRAK, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$branch_num, number_format($branch_target->NILAI_KONTRAK, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$branch_num, number_format($branch_previous_y->REALISASI, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$branch_num, number_format($branch_previous_m->REALISASI, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$branch_num, number_format($branch_previous_m->COST, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$branch_num, number_format($branch_previous_m->TOTAL, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$branch_num, number_format($branch_this_m->REALISASI, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$branch_num, number_format($branch_this_m->COST, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$branch_num, number_format($branch_this_m->TOTAL, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$branch_num, number_format($branch_until_m->REALISASI, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$branch_num, number_format($branch_until_m->COST, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$branch_num, number_format($branch_until_m->TOTAL, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$branch_num, number_format($branch_value_real->REALISASI, 2, ',', '.'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$branch_num, number_format($branch_tax->TAX, 2, ',', '.'));


    // print_r($branch_value_real); exit();

    $objPHPExcel->getActiveSheet()->getStyle('A'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('M'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('O'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('P'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('R'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('S'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('T'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('U'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('V'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('W'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('X'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('Z'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AA'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AB'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AC'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AD'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AE'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AF'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AG'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AH'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AI'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AJ'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AK'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AL'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AM'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AN'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AO'.$branch_num)->applyFromArray($color_3);
    $objPHPExcel->getActiveSheet()->getStyle('AP'.$branch_num)->applyFromArray($color_3);

    // Set width kolom
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20); 
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);


    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Set orientasi kertas jadi LANDSCAPE
    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    // Set judul file excel nya
    $objPHPExcel->getActiveSheet(0)->setTitle("Detail MMR");
    $objPHPExcel->setActiveSheetIndex(0);

    $objWorksheet = $objPHPExcel->getActiveSheet();

    $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
    // $objWriter->save("test_".date('Y-m-d H-i-s').".xlsx");

    // $get_month = $date->format('d-M-Y');
    $file_name = "Report Detail MMR ".$branch." ".$get_month."-".$get_tahun.".xls";

    //Header
    ob_end_clean();
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //Nama File
    header('Content-Disposition: attachment;filename="'.$file_name.'"');
    //Download
    $objWriter->save("php://output");
    
}

}