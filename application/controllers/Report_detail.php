<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_detail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified:' . gmdate('D,d M Y H:i:s') . 'GMT');


        $this->load->model('Report_model');
        $this->load->model('Detail_mmr');
        $this->load->library('excel');
    }


    public function detailmmr($id_branch, $show_month, $show_years, $show_tanggal,$a,$b){
        $this->load->library('PHPExcel/IOFactory');

        //--------------------STYLE---------------------------------------
        $style_header = array(
            'font' => array('bold' => true,'size'=>14,'name'=>'Gotham Book'), 
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
          );

          $styehedernama = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi di tengah secara vertical (middle)
            ),
            'font'  => array(
            'size'  => 24,
            'bold'  => true,
            'color' => array('rgb' => 'ffffff')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000000')
        ));

        $styletambahan = array(
            'font'  => array(
            'size'  => 16,
            'bold'  => true
        ));

          $style1 = array(// Set font nya jadi bold
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'font' => array('bold' => true),
            'borders' => array(
              'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
              'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
              'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
              'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
          );

          $style1warna = array(// Set font nya jadi bold
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'font' => array('bold' => true),
            'borders' => array(
              'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
              'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
              'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
              'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '00ff08'))
          );

          $style2 = array(// Set font nya jadi bold
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi di tengah secara vertical (middle)
            )
          );

        $warna[1] = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00ff08'))
        
        );

        $warna[2] = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00f3ff'))
        );

        $warna[3] = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fbff00'))
        );

        $warnajm1 = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi di tengah secara vertical (middle)
            ),
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'a3a4ab'),
        ));
        $warnajm2 = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi di tengah secara vertical (middle)
            ),
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'ffffff')), // Set font nya jadi bold
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000000')
        ));

        $allborder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //PENGATURAN-----------------------------------------------------
        $cb = $id_branch;
        //----------------------------------------------------------------

        $hf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                    'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
                    'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
                    'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');
        
        $ak = array('0','1','2','3','4','5','6','7','8','9','10');
        
        $bl = array('','JANUARI','FEBRUARY','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER');

        $objPHPExcel = new PHPExcel();

        //SET DEFAULT
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(11);
        $objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setShowGridlines(false);
        
        //zoom
        $objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
        $sheet->getSheetView()->setZoomScale(55);

        //logo IPC
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./assets/img/ipc_logo.png');
        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(130);
        $objDrawing->setWidth(130);
        $objDrawing->setOffsetX(110);
        $objDrawing->setWorksheet($sheet);

        

        // judul
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $get_tahun = $show_years;
        $get_bulan = $show_tanggal;
        $get_bulan22 = (int)$b;
        $get_month = $show_month;
        $title = "RKAP TAHUN ".$get_tahun." S/D BULAN ".$bl[$b];
        $branch = $this->Report_model->get_branch($id_branch)[0]->BRANCH_NAME;
        $br_id = (int)$this->Report_model->get_branch($id_branch)[0]->BRANCH_ID;
        $nama_cabang = ($br_id > 120) ? 'ANAK PERUSAHAAN ' : 'CABANG ';
        $objPHPExcel->setActiveSheetIndex(0); 
        $sheet->setCellValue('A2', 'DIREKTORAT TEKNIK DAN MANAJEMEN RESIKO');
        $sheet->setCellValue('A3', 'PT PELABUHAN INDONESIA II (PERSERO)');
        $sheet->setCellValue('A4', 'REKAPITULASI LAPORAN DETAIL MMR BULANAN');
        $sheet->setCellValue('A5', $title);
        $sheet->mergeCells('A2:AQ2');
        $sheet->mergeCells('A3:AQ3');
        $sheet->mergeCells('A4:AQ4');
        $sheet->mergeCells('A5:AQ5');
        $sheet->getStyle('A2')->applyFromArray($style_header);
        $sheet->getStyle('A3')->applyFromArray($style_header);
        $sheet->getStyle('A4')->applyFromArray($style_header);
        $sheet->getStyle('A5')->applyFromArray($style_header);


        //header tabel
        $sheet->getRowDimension('8')->setRowHeight(35);
    
        $sheet->mergeCells('B7:B9')->setCellValue('B7', 'Jenis Investasi');
        $sheet->getStyle('B7:B9')->applyFromArray($style1);
        $sheet->mergeCells('C7:D7')->setCellValue('C7', 'Jenis Aktiva');
        $sheet->getStyle('C7:D7')->applyFromArray($style1);
        $sheet->mergeCells('C8:C9')->setCellValue('C8', 'COA');
        $sheet->getStyle('C8:C9')->applyFromArray($style1);
        $sheet->mergeCells('D8:D9')->setCellValue('D8', 'Aktiva');
        $sheet->getStyle('D8:D9')->applyFromArray($style1);
        $sheet->mergeCells('E7:I7')->setCellValue('E7', 'DATA RKAP '.$show_years);
        $sheet->getStyle('E7:I7')->applyFromArray($style1);
        $sheet->mergeCells('E8:G8')->setCellValue('E8', 'URAIAN INVESTASI');
        $sheet->getStyle('E8:G8')->applyFromArray($style1);
        $sheet->mergeCells('E9:F9')->setCellValue('E9', 'ITEM INDUK');
        $sheet->getStyle('E9:F9')->applyFromArray($style1);
        $sheet->setCellValue('G9', 'SUB ITEM');
        $sheet->getStyle('G9')->applyFromArray($style1);
        $sheet->setCellValue('H8', 'KEB. DANA');
        $sheet->getStyle('H8')->applyFromArray($style1warna);
        $sheet->setCellValue('I8', 'RKAP '.$show_years);
        $sheet->getStyle('I8')->applyFromArray($style1warna);
        $sheet->setCellValue('H9', 'x Rp.1000');
        $sheet->getStyle('H9')->applyFromArray($style1warna);
        $sheet->setCellValue('I9', 'x Rp.1000');
        $sheet->getStyle('I9')->applyFromArray($style1warna);
        $sheet->mergeCells('J7:P7')->setCellValue('J7', 'DATA KONTRAK');
        $sheet->getStyle('J7:P7')->applyFromArray($style1);
        $sheet->mergeCells('J8:J9')->setCellValue('J8', 'KONTRAK KE');
        $sheet->getStyle('J8:J9')->applyFromArray($style1);
        $sheet->mergeCells('K8:K9')->setCellValue('K8', 'NOMOR KONTRAK');
        $sheet->getStyle('K8:K9')->applyFromArray($style1);
        $sheet->mergeCells('L8:L9')->setCellValue('L8', 'TANGGAL KONTRAK');
        $sheet->getStyle('L8:L9')->applyFromArray($style1);
        $sheet->mergeCells('M8:M9')->setCellValue('M8', 'KONTRAKTOR PELAKSANA');
        $sheet->getStyle('M8:M9')->applyFromArray($style1);
        $sheet->setCellValue('N8', 'JANGKA WAKTU PELAKSANAAN');
        $sheet->getStyle('N8')->applyFromArray($style1);
        $sheet->setCellValue('N9', 'BULAN');
        $sheet->getStyle('N9')->applyFromArray($style1);
        $sheet->setCellValue('O8', 'TOTAL NILAI KONTRAK');
        $sheet->getStyle('O8')->applyFromArray($style1warna);
        $sheet->setCellValue('O9', 'x Rp.1000');
        $sheet->getStyle('O9')->applyFromArray($style1warna);
        $sheet->setCellValue('P8', 'TARGET '.$bl[$b]);
        $sheet->getStyle('P8')->applyFromArray($style1);
        $sheet->setCellValue('P9', 'x Rp.1000');
        $sheet->getStyle('P9')->applyFromArray($style1);
        $sheet->mergeCells('Q7:R7')->setCellValue('Q7', 'REALISASI S/D TAHUN LALU');
        $sheet->getStyle('Q7:R7')->applyFromArray($style1);
        $sheet->setCellValue('Q8', '% FISIK');
        $sheet->getStyle('Q8')->applyFromArray($style1);
        $sheet->setCellValue('Q9', '%');
        $sheet->getStyle('Q9')->applyFromArray($style1);
        $sheet->setCellValue('R8', 'NILAI');
        $sheet->getStyle('R8')->applyFromArray($style1warna);
        $sheet->setCellValue('R9', 'x Rp.1000');
        $sheet->getStyle('R9')->applyFromArray($style1warna);
        
        
        $bla1 = $a;
        $bla2 = $b;
        $mi = 0;

        $akhirrows = 0;
        //header bulan
        for ($i=$bla1; $i <= $bla2; $i++) { 

            $sheet->mergeCells($hf[18+$mi].$ak[8].':'.$hf[21+$mi].$ak[8])->setCellValue($hf[18+$mi].$ak[8], $bl[$i]);
            $sheet->getStyle($hf[18+$mi].$ak[8].':'.$hf[21+$mi].$ak[8])->applyFromArray($style1);
            $sheet->setCellValue($hf[18+$mi].$ak[9], 'FISIK');
            $sheet->getStyle($hf[18+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[18+$mi])->setWidth("15");
            $sheet->setCellValue($hf[19+$mi].$ak[9], 'NILAI');
            $sheet->getStyle($hf[19+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[19+$mi])->setWidth("15");
            $sheet->setCellValue($hf[20+$mi].$ak[9], 'BIAYA');
            $sheet->getStyle($hf[20+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[20+$mi])->setWidth("15");
            $sheet->setCellValue($hf[21+$mi].$ak[9], 'TOTAL');
            $sheet->getStyle($hf[21+$mi].$ak[9])->applyFromArray($style1warna);
            $sheet->getColumnDimension($hf[21+$mi])->setWidth("15");
            $sheet->getColumnDimension($hf[21+$mi])->setWidth("15");
            $sheet->mergeCells($hf[22+$mi].$ak[8].':'.$hf[25+$mi].$ak[8])->setCellValue($hf[22+$mi].$ak[8], 'S/D '.$bl[$i]);
            $sheet->getStyle($hf[22+$mi].$ak[8].':'.$hf[25+$mi].$ak[8])->applyFromArray($style1);
            $sheet->setCellValue($hf[22+$mi].$ak[9], 'FISIK');
            $sheet->getStyle($hf[22+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[22+$mi])->setWidth("15");
            $sheet->setCellValue($hf[23+$mi].$ak[9], 'NILAI');
            $sheet->getStyle($hf[23+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[23+$mi])->setWidth("15");
            $sheet->setCellValue($hf[24+$mi].$ak[9], 'BIAYA');
            $sheet->getStyle($hf[24+$mi].$ak[9])->applyFromArray($style1);
            $sheet->getColumnDimension($hf[24+$mi])->setWidth("15");
            $sheet->setCellValue($hf[25+$mi].$ak[9], 'TOTAL');
            $sheet->getStyle($hf[25+$mi].$ak[9])->applyFromArray($style1warna);
            $sheet->getColumnDimension($hf[25+$mi])->setWidth("15");
            $mi = $mi+8;            
        }
        $mi=$mi-8;
        $sheet->mergeCells($hf[26+$mi].$ak[8].':'.$hf[27+$mi].$ak[8])->setCellValue($hf[26+$mi].$ak[8], 'REALISASI S/D TAHUN LALU');
        $sheet->getStyle($hf[26+$mi].$ak[8].':'.$hf[27+$mi].$ak[8])->applyFromArray($style1warna);
        $sheet->setCellValue($hf[26+$mi].$ak[9], 'FISIK');
        $sheet->getStyle($hf[26+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[27+$mi].$ak[9], 'NILAI');
        $sheet->getStyle($hf[27+$mi].$ak[9])->applyFromArray($style1warna);
        $sheet->mergeCells($hf[18].$ak[7].':'.$hf[27+$mi].$ak[7])->setCellValue($hf[18].$ak[7], 'REALISASI');
        $sheet->getStyle($hf[18].$ak[7].':'.$hf[27+$mi].$ak[7])->applyFromArray($style1);
        $sheet->mergeCells($hf[28+$mi].$ak[7].':'.$hf[36+$mi].$ak[7])->setCellValue($hf[28+$mi].$ak[7], 'KETERANGAN');
        $sheet->getStyle($hf[28+$mi].$ak[7].':'.$hf[36+$mi].$ak[7])->applyFromArray($style1);
        $sheet->mergeCells($hf[28+$mi].$ak[8].':'.$hf[29+$mi].$ak[8])->setCellValue($hf[28+$mi].$ak[8], 'STATUS');
        $sheet->getStyle($hf[28+$mi].$ak[8].':'.$hf[29+$mi].$ak[8])->applyFromArray($style1);
        $sheet->setCellValue($hf[30+$mi].$ak[8], 'INDIKATOR KERJA');
        $sheet->getStyle($hf[30+$mi].$ak[8])->applyFromArray($style1);
        $sheet->mergeCells($hf[31+$mi].$ak[8].':'.$hf[33+$mi].$ak[8])->setCellValue($hf[31+$mi].$ak[8], 'STATUS');
        $sheet->getStyle($hf[31+$mi].$ak[8].':'.$hf[33+$mi].$ak[8])->applyFromArray($style1);
        $sheet->mergeCells($hf[34+$mi].$ak[8].':'.$hf[35+$mi].$ak[8])->setCellValue($hf[34+$mi].$ak[8], 'KENDALA');
        $sheet->getStyle($hf[34+$mi].$ak[8].':'.$hf[35+$mi].$ak[8])->applyFromArray($style1);
        $sheet->mergeCells($hf[36+$mi].$ak[8].':'.$hf[36+$mi].$ak[9])->setCellValue($hf[36+$mi].$ak[8], 'DEADLINE PENYELESAIAN');
        $sheet->getStyle($hf[36+$mi].$ak[8].':'.$hf[36+$mi].$ak[9])->applyFromArray($style1);
        $akhirrows = 36 + $mi;
        $sheet->setCellValue($hf[28+$mi].$ak[9], 'KODE');
        $sheet->getStyle($hf[28+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[29+$mi].$ak[9], 'STATUS');
        $sheet->getStyle($hf[29+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[30+$mi].$ak[9], 'S/D '.$bl[$i-1]);
        $sheet->getStyle($hf[30+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[31+$mi].$ak[9], 'KODE');
        $sheet->getStyle($hf[31+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[32+$mi].$ak[9], 'POSISI');
        $sheet->getStyle($hf[32+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[33+$mi].$ak[9], 'DESKRIPSI POSISI');
        $sheet->getStyle($hf[33+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[34+$mi].$ak[9], 'KODE KENDALA');
        $sheet->getStyle($hf[34+$mi].$ak[9])->applyFromArray($style1);
        $sheet->setCellValue($hf[35+$mi].$ak[9], 'JENIS KENDALA');
        $sheet->getStyle($hf[35+$mi].$ak[9])->applyFromArray($style1);


        //dimension
        $sheet->getColumnDimension('E')->setAutoSize(false);
        $sheet->getColumnDimension('E')->setWidth("30");
        $sheet->getColumnDimension('B')->setWidth("15");
        $sheet->getColumnDimension('D')->setWidth("15");
        $sheet->getColumnDimension('H')->setWidth("18");
        $sheet->getColumnDimension('I')->setWidth("18");
        
        $sheet->getRowDimension('11')->setRowHeight(15);
        $sheet->mergeCells("B10:F10")->setCellValue("B10", $nama_cabang.strtoupper($branch));
        $sheet->getStyle("B10:F10")->applyFromArray($styehedernama);
        //conten
        $arraybl = array('JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DEC');
        
        
        $aw = $arraybl[$a];
        $ak = $arraybl[$b];

        $invest = $this->Detail_mmr->investasi($cb,$get_tahun);
        $invest2 = $this->Detail_mmr->investasi2($cb,$get_tahun);

        foreach ($invest2 as $key => $va) {
            $typeinvest[$key] = $va->RKAP_INVS_TYPE;
            $tahuninvest[$key]= $va->RKAP_INVS_YEAR;
            $coa_invest[$key] = $va->ASSETS_COA;
        }
        foreach ($invest2 as $key => $va) {
            if ($va->RKAP_SUBPRO_ID <> 0) {
                $subprogram[$key] = array($va->RKAP_INVS_ID,$va->RKAP_SUBPRO_ID);
            }
            if ($va->SUBPRO_ADD_ID <> 0) {
                $adden[$key] = array('sub'=>$va->RKAP_SUBPRO_ID,'add'=>$va->SUBPRO_ADD_ID);
            }
        }

        $result1 = array_values(array_unique($typeinvest,SORT_REGULAR));
        $result2 = array_values(array_unique($tahuninvest,SORT_REGULAR));
        $result3 = array_values(array_unique($coa_invest,SORT_REGULAR));
        $result4 = array_values(array_unique($subprogram,SORT_REGULAR));
        $result5 = array_values(array_unique($adden,SORT_REGULAR));
        sort($result1);
        sort($result2);
        sort($result3);
        sort($result4);
        sort($result5);
        $mn = array('','MURNI','MULTY YEAR','CARY OVER');
        $z =  0;
        $ada= 0;
        
        
        for ($l1=1; $l1 <= 3 ; $l1++) {
            $z++;
            $dataz[$z] = "type-".$mn[$l1].'-'.$l1.'-'."0";
            for ($l2=0; $l2 <count($result2) ; $l2++) {
                $ada2 =0; 
                for ($l3=0; $l3 <count($result3) ; $l3++) {
                        $ada = 0; 
                        foreach ($invest as $key => $value) {
                            if ($value->RKAP_INVS_TYPE == $l1 && $value->RKAP_INVS_YEAR == $result2[$l2] && $value->ASSETS_COA == $result3[$l3]) {
                                $z++;
                                $ada = 1;
                                $coa = $value->ASSETS_COA.'-'.$value->RKAP_INVS_YEAR.'-'.$value->RKAP_INVS_TYPE;   
                                $dataz[$z] = "inv-".$value->RKAP_INVS_ID.'-'.$value->RKAP_INVS_TYPE.'-'.$value->ASSETS_COA.'-'.$value->RKAP_INVS_YEAR;
                            }
                            if ($value->RKAP_INVS_TYPE == $l1 && $value->RKAP_INVS_YEAR == $result2[$l2]) {
                                $ada2 = 1;
                                $tn = $value->RKAP_INVS_YEAR.'-'.$value->RKAP_INVS_TYPE.'-'."0";
                            }
                        }
                        if ($ada == 1) {
                            $z++;
                            $dataz[$z] = "jumlahcoa-".$coa;
                        }
                }
                if ($ada2 == 1) {
                    $z++;
                    $dataz[$z] = "jumlahtahun-".$tn;
                }

            }
            $z++;
            $dataz[$z] = "jumlahtype-".$l1.'-'."0".'-'."0";
        }

        
        $j=0;
        for ($i=1; $i <=count($dataz); $i++) { 
            $dat = explode('-',$dataz[$i]);
            if ($dat[0]=='inv') {
                $sub = $this->Detail_mmr->subprogramkode($dat[1]);
                $datax2[$j++] = $dat[0].'-'.$dat[1].'-'.$dat[2].'-'.$dat[3].'-'.$dat[4];
                foreach ($sub as $key => $v) {
                    if ($v->RKAP_SUBPRO_ID <> "0") {
                        $datax2[$j++] = 'sub-'.$v->RKAP_SUBPRO_ID.'-0-0';
                        if ($v->SUBPRO_ADD_ID <> "0") {
                            $add2 = $this->Detail_mmr->addendumkode($v->RKAP_SUBPRO_ID);
                            foreach ($add2 as $key => $v2) {
                                $datax2[$j++] = 'add-'.$v2->SUBPRO_ADD_ID.'-sub-'.$v->RKAP_SUBPRO_ID;
                            };
                        }
                    }
                }
            }else{
                $datax2[$j++] = $dat[0].'-'.$dat[1].'-'.$dat[2].'-'.$dat[3];
            }
        }
        //---------------------------------
        //--------------------------------
        $jmlcoa = 0;
        $ix = 0;
        $posisiin = array("","Tidak Ada Progress","Tahap Kordinasi","Sertifikasi","Pembebasan Lahan","Perijinan","Persiapan Lelang","Konsultan Desain","Lelang Konsultan Desain","Perencanaan","Persiapan Lelang Kontraktor","Lelang Kontraktor","Pelaksanaan/Kontruksi","Pekerjaan Selesai");
        $shape = array('','./assets/img/shape1.png','./assets/img/shape2.png','./assets/img/shape3.png');
        $shape1 = 0;
        $typei = 0;
        $jumlahrow = count($datax2);
        $jumlahprogjalan = 0;
        $arrayno1 = array(0,1,2,3,1,2,3,1,2,3,1,2,3);
        $arrayno2 = array(0,0,0,0,3,3,3,6,6,6,9,9,9);
        $akh = 11 + $jumlahrow;
        for ($ii=0; $ii < $jumlahrow; $ii++) {
            $dat = explode('-',$datax2[$ii]); 
            if ($dat[0]=='inv') {
                if ($dat[1] == $invest[$ix]->RKAP_INVS_ID) {      
                    $mul1 =11 + $ii;
                    $sheet->setCellValue('B'.$mul1,$invest[$ix]->RKAP_INVS_YEAR);
                    $sheet->getStyle('B'.$mul1)->applyFromArray($style1);
                    $sheet->setCellValue('C'.$mul1, $invest[$ix]->ASSETS_COA);
                    $sheet->getStyle('C'.$mul1)->applyFromArray($style1);
                    $sheet->setCellValue('D'.$mul1, $invest[$ix]->ASSETS_NAME);
                    $sheet->getStyle('D'.$mul1)->applyFromArray($style1);
                    $sheet->mergeCells('E'.$mul1.':'.'F'.$mul1)->setCellValue('E'.$mul1, $invest[$ix]->RKAP_INVS_TITLE);
                    $sheet->getStyle('E'.$mul1.':'.'F'.$mul1)->applyFromArray($style2);
                    $dana = $invest[$ix]->RKAP_INVS_COST_REQ / 1000;
                    $rkap = $invest[$ix]->RKAP_INVS_VALUE / 1000;
                    $sheet->setCellValue('H'.$mul1,$dana);
                    $sheet->getStyle('H'.$mul1)->applyFromArray($style1);
                    $sheet->setCellValue('I'.$mul1,$rkap);
                    $sheet->getStyle('I'.$mul1)->applyFromArray($style1);
                    $sheet->getRowDimension($mul1)->setRowHeight(60);
                    $sheet->getStyle('H'.$mul1.':'.'I'.$mul1)->getNumberFormat()->setFormatCode('#,##0');

                    $sheet->setCellValue($hf[28+$mi].$mul1,$invest[$ix]->JALAN);
                    $sheet->getStyle($hf[28+$mi].$mul1)->applyFromArray($style1);
                    $sheet->setCellValue($hf[29+$mi].$mul1,$invest[$ix]->POSISI);
                    $sheet->getStyle($hf[29+$mi].$mul1)->applyFromArray($style1);
                    $jumlahprogjalan += $invest[$ix]->JALAN;
                    
                    //RKAP_INVS_POS
                    $sheet->setCellValue($hf[31+$mi].$mul1,$invest[$ix]->RKAP_INVS_POS);
                    $sheet->getStyle($hf[31+$mi].$mul1)->applyFromArray($style1);
                    $sheet->setCellValue($hf[32+$mi].$mul1,$posisiin[$invest[$ix]->RKAP_INVS_POS]);
                    $sheet->getStyle($hf[32+$mi].$mul1)->applyFromArray($style1);

                    

                    //a.RKAP_INVS_QUARTER_I,a.RKAP_INVS_QUARTER_II,a.RKAP_INVS_QUARTER_III,a.RKAP_INVS_QUARTER_IV,
                    //$arraytarget = array(0,$invest[$ix]->RKAP_INVS_QUARTER_I,$invest[$ix]->RKAP_INVS_QUARTER_I,$invest[$ix]->RKAP_INVS_QUARTER_I,$invest[$ix]->RKAP_INVS_QUARTER_II,$invest[$ix]->RKAP_INVS_QUARTER_II,$invest[$ix]->RKAP_INVS_QUARTER_II,$invest[$ix]->RKAP_INVS_QUARTER_III,$invest[$ix]->RKAP_INVS_QUARTER_III,$invest[$ix]->RKAP_INVS_QUARTER_III,$invest[$ix]->RKAP_INVS_QUARTER_IV,$invest[$ix]->RKAP_INVS_QUARTER_IV,$invest[$ix]->RKAP_INVS_QUARTER_IV);
                    $tar = $this->Detail_mmr->target($dat[1],$get_bulan22,$show_years);
                    $target = $tar[0]->TARGETZ;
                    //$target = $arraytarget[$arrayno2[$b]] + ($arraytarget[$b]  / 3 * $arrayno1[$b]);
                    $target1 = $target / 1000;
                    $sheet->setCellValue('P'.$mul1,$target1);
                    $sheet->getStyle('P'.$mul1)->applyFromArray($style1);
                    $sheet->getStyle('P'.$mul1)->getNumberFormat()->setFormatCode('#,##0');

                    $statpos = $this->Detail_mmr->statpos($dat[1],$show_years,$b);
                    $if11 = 0.5 * $target;
                    $if12 = 0.9 * $target;
                    
                    if ($statpos[0]->VAL < $if11) {
                        $shape1 = 1;
                        $kendala = $this->Detail_mmr->kendala2($dat[1]);
                    }else if ($statpos[0]->VAL >= $if12) {
                        $shape1 = 3;
                        $kendala = $this->Detail_mmr->kendala1($dat[1]);
                    }else {
                        $shape1 = 2;
                        $kendala = $this->Detail_mmr->kendala1($dat[1]);
                    }

                    

                    if ($shape1 == 3 && $kendala[0]->DUA == 'Progress Terlambat') {
                        $kendalaupdate = '';
                    }else{
                        $kendalaupdate = $kendala[0]->DUA;
                    }
                    
                    //ac.real_subpro_constraints,ad.contraints_name
                    $sheet->setCellValue($hf[34+$mi].$mul1,$kendala[0]->SATU);
                    $sheet->getStyle($hf[34+$mi].$mul1)->applyFromArray($style1);
                    $sheet->setCellValue($hf[35+$mi].$mul1,$kendalaupdate);
                    $sheet->getStyle($hf[35+$mi].$mul1)->applyFromArray($style1);

                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('Logo');
                    $objDrawing->setDescription('Logo');
                    $objDrawing->setPath($shape[$shape1]);
                    $objDrawing->setCoordinates($hf[30+$mi].$mul1);
                    $objDrawing->setOffsetX(20);
                    $objDrawing->setOffsetY(15);
                    $objDrawing->setHeight(70);
                    $objDrawing->setWidth(70);
                    $objDrawing->setWorksheet($sheet);
                    $ix=$ix+1;
                }
            }else if ($dat[0]=='type') {
                $mul1 =11 + $ii;

                $sheet->mergeCells('B'.$mul1.':'.'I'.$mul1)->setCellValue('B'.$mul1,$mn[$dat[2]]);
                $sheet->getStyle('B'.$mul1.':'.$hf[36+$mi].$mul1)->applyFromArray($warna[$dat[2]]);
            }else if ($dat[0]=='jumlahcoa') {
                $mul1 =11 + $ii;
                $sheet->mergeCells('B'.$mul1.':'.'G'.$mul1)->setCellValue('B'.$mul1,'JUMLAH COA '.$dat[1]);
                $sheet->getStyle('B'.$mul1.':'.$hf[36+$mi].$mul1)->applyFromArray($warnajm1);
                $where = "AND a.RKAP_INVS_TYPE = ".$dat[3]." AND a.RKAP_INVS_YEAR = ".$dat[2]." AND d.ASSETS_COA = ".$dat[1]."";
                $jml11 = $this->Detail_mmr->jumlah($cb,$where,$get_tahun);
                $isi1 = $jml11[0]->REQ / 1000;
                $isi2 = $jml11[0]->VAL / 1000;
                $sheet->setCellValue('H'.$mul1,$isi1);
                $sheet->getStyle('H'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('I'.$mul1,$isi2);
                $sheet->getStyle('I'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('H'.$mul1.':'.'I'.$mul1)->getNumberFormat()->setFormatCode('#,##0');

            }
            else if ($dat[0]=='jumlahtahun') {
                $mul1 =11 + $ii;
                $sheet->mergeCells('B'.$mul1.':'.'G'.$mul1)->setCellValue('B'.$mul1,'JUMLAH TAHUN '.$dat[1]);
                $sheet->getStyle('B'.$mul1.':'.$hf[36+$mi].$mul1)->applyFromArray($warnajm1);
                $where = "AND a.RKAP_INVS_TYPE = ".$dat[2]." AND a.RKAP_INVS_YEAR = ".$dat[1]."";
                $jml11 = $this->Detail_mmr->jumlah($cb,$where,$get_tahun);
                $isi1 = $jml11[0]->REQ / 1000;
                $isi2 = $jml11[0]->VAL / 1000;
                $sheet->setCellValue('H'.$mul1,$isi1);
                $sheet->getStyle('H'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('I'.$mul1,$isi2);
                $sheet->getStyle('I'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('H'.$mul1.':'.'I'.$mul1)->getNumberFormat()->setFormatCode('#,##0');
            }
            else if ($dat[0]=='jumlahtype') {
                $mul1 =11 + $ii;
                $sheet->mergeCells('B'.$mul1.':'.'G'.$mul1)->setCellValue('B'.$mul1,'JUMLAH INVESTASI '.$mn[$dat[1]]);
                $sheet->getStyle('B'.$mul1.':'.$hf[36+$mi].$mul1)->applyFromArray($warnajm2);
                $where = "AND a.RKAP_INVS_TYPE = ".$dat[1]."";
                $jml11 = $this->Detail_mmr->jumlah($cb,$where,$get_tahun);
                $isi1 = $jml11[0]->REQ / 1000;
                $isi2 = $jml11[0]->VAL / 1000;
                $sheet->setCellValue('H'.$mul1,$isi1);
                $sheet->getStyle('H'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('I'.$mul1,$isi2);
                $sheet->getStyle('I'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('H'.$mul1.':'.'I'.$mul1)->getNumberFormat()->setFormatCode('#,##0');
                
            }
        }
        //a.RKAP_INVS_QUARTER_I,a.RKAP_INVS_QUARTER_II,a.RKAP_INVS_QUARTER_III,a.RKAP_INVS_QUARTER_IV,d.RKAP_SUBPRO_TITTLE,d.RKAP_SUBPRO_CONTRACT_NO,d.RKAP_SUBPRO_CONTRACT_DATE,d.RKAP_SUBPRO_CONTRACTOR,d.RKAP_SUBPRO_PERIODE,d.RKAP_CONTRACT_VALUE_HISTORY
        $sheet->getColumnDimension("G")->setWidth("30");
        $sheet->getColumnDimension('G')->setAutoSize(false);
        $jmlcoa1=0;
        $jmltahun1=0;
        $jmltype1=0;
        $jmlall1=0;
        $addendno= 1;
        for ($ii2=0; $ii2 <$jumlahrow ; $ii2++) {
            $dat = explode('-',$datax2[$ii2]); 
            if ($dat[0]=='sub') {
                $datkon = $this->Detail_mmr->datakontrak($dat[1],$show_years);
                $mul1 =11 + $ii2;
                $sheet->setCellValue('G'.$mul1,$datkon[0]->RKAP_SUBPRO_TITTLE);
                $sheet->getStyle('G'.$mul1)->applyFromArray($style2);
                
                $sheet->setCellValue('J'.$mul1,"Kontrak-1");
                $sheet->getStyle('J'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('K'.$mul1,$datkon[0]->RKAP_SUBPRO_CONTRACT_NO);
                $sheet->getStyle('K'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('L'.$mul1,$datkon[0]->RKAP_SUBPRO_CONTRACT_DATE);
                $sheet->getStyle('L'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('M'.$mul1,$datkon[0]->RKAP_SUBPRO_CONTRACTOR);
                $sheet->getStyle('M'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('N'.$mul1,$datkon[0]->RKAP_SUBPRO_PERIODE);
                $sheet->getStyle('N'.$mul1)->applyFromArray($style1);
                $val = $datkon[0]->RKAP_CONTRACT_VALUE_HISTORY / 1000;
                $sheet->setCellValue('O'.$mul1,$val);
                $sheet->getStyle('O'.$mul1)->applyFromArray($style1);
                $jmlcoa1 = $jmlcoa1 + $val;
                $jmltahun1= $jmltahun1 + $val;
                $jmltype1 = $jmltype1 + $val;
                $jmlall1  = $jmlall1 + $val;
                $sheet->getStyle('O'.$mul1)->getNumberFormat()->setFormatCode('#,##0');

                $sheet->setCellValue('Q'.$mul1,$datkon[0]->REAL_SEB);
                $sheet->getStyle('Q'.$mul1)->applyFromArray($style1);

                $real_seb = $datkon[0]->REAL_SEB * ($datkon[0]->RKAP_CONTRACT_VALUE_HISTORY / 100);
                $real_seb = $real_seb / 1000; 
                $sheet->setCellValue('R'.$mul1,$real_seb);
                $sheet->getStyle('R'.$mul1)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                $addendno = 1;
            }else if($dat[0]=='add') {
                //SUBPRO_ADD_NUM,SUBPRO_ADD_DATE,SUBPRO_ADD_VALUE,SUBPRO_ADD_PERIODE,real_seb,real_ses
                $datkon = $this->Detail_mmr->addendum($dat[1],$dat[3],$show_years);
                $mul1 =11 + $ii2;
                $sheet->setCellValue('J'.$mul1,'Add ke -'.$addendno++);
                $sheet->getStyle('J'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('K'.$mul1,$datkon[0]->SUBPRO_ADD_NUM);
                $sheet->getStyle('K'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('L'.$mul1,$datkon[0]->SUBPRO_ADD_DATE);
                $sheet->getStyle('L'.$mul1)->applyFromArray($style1);
                $sheet->setCellValue('N'.$mul1,$datkon[0]->SUBPRO_ADD_PERIODE);
                $sheet->getStyle('N'.$mul1)->applyFromArray($style1);
                $addval = $datkon[0]->SUBPRO_ADD_VALUE / 1000;
                $sheet->setCellValue('O'.$mul1,$addval);
                $sheet->getStyle('O'.$mul1)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->setCellValue('Q'.$mul1,$datkon[0]->REAL_SEB);
                $sheet->getStyle('Q'.$mul1)->applyFromArray($style1);

                $real_seb = $datkon[0]->REAL_SEB * ($datkon[0]->SUBPRO_ADD_VALUE / 100);
                $real_seb = $real_seb / 1000;
                $sheet->setCellValue('R'.$mul1,$real_seb);
                $sheet->getStyle('R'.$mul1)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                
                
                //$sheet->getStyle('O'.$mul1)->getNumberFormat()->setFormatCode('#,##0');

            }else if($dat[0]=='jumlahcoa'){
                $mul1 =11 + $ii2;
                $sheet->setCellValue('O'.$mul1,$jmlcoa1);
                $sheet->getStyle('O'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('O'.$mul1)->getNumberFormat()->setFormatCode('#,##0'); 
                $jmlcoa1 = 0;
            }else if($dat[0]=='jumlahtahun'){
                $mul1 =11 + $ii2;
                $sheet->setCellValue('O'.$mul1,$jmltahun1);
                $sheet->getStyle('O'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('O'.$mul1)->getNumberFormat()->setFormatCode('#,##0'); 
                $jmltahun1 = 0;
            }else if($dat[0]=='jumlahtype'){
                $mul1 =11 + $ii2;
                $sheet->setCellValue('O'.$mul1,$jmltype1);
                $sheet->getStyle('O'.$mul1)->applyFromArray($style1);
                $sheet->getStyle('O'.$mul1)->getNumberFormat()->setFormatCode('#,##0'); 
                $jmltype1 = 0;
            }
        }

        $arrno1 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno2 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno3 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno4 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno5 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno6 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno7 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno8 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');

        $arrno11 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno21 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno31 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno41 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno51 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno61 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno71 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno81 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');

        $arrno12 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno22 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno32 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno42 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno52 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno62 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno72 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno82 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');

        $arrno13 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno23 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno33 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno43 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno53 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno63 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno73 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
        $arrno83 = array('0','0','0','0','0','0','0','0','0','0','0','0','0');

        for ($ii2=0; $ii2 <$jumlahrow ; $ii2++) {
            $dat = explode('-',$datax2[$ii2]); 
            $mi1 = 0;
            $mi2 = 0;
            $mi3 = 0;
            $mi4 = 0;
            $mi5 = 0;
            $kode11 = "";
            $ak111 = 11 + $ii2;
            if ($dat[0]=='sub' or $dat[0]=='add') {
                $kode11 = $dat[1];
                if ($dat[0]=='add') {
                    $kode11 = 010;
                }
                $datrelno = 0;
                for ($i=$bla1; $i <= $bla2; $i++) {
                    $val11 = 0;
                    $val12 = 0;
                    $cos11 = 0;
                    $cos12 = 0;

                    $tot1 = 0;
                    $tot2 = 0;

                    //REAL_SUBPRO_PERCENT	REAL_SUBPRO_VAL	PER	VAL    
                    $datrel = $this->Detail_mmr->realisasi($kode11,$show_years,$i);
                    //PER	VAL	PER1	VAL1
                    $val11 = ($datrel[0]->VAL - $datrel[0]->COST) / 1000;
                    $cos11 = $datrel[0]->COST / 1000;
                    $tot1 =  $datrel[0]->VAL / 1000;
                    $sheet->setCellValue($hf[18+$mi1].$ak111, $datrel[0]->PER);
                    $sheet->getStyle($hf[18+$mi1].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[19+$mi1].$ak111, $val11);
                    $sheet->getStyle($hf[19+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[20+$mi1].$ak111, $cos11);
                    $sheet->getStyle($hf[20+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[21+$mi1].$ak111, $tot1);
                    $sheet->getStyle($hf[21+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    
                    $val12 = (($datrel[0]->VAL1 - $datrel[0]->COST1) / 1000);
                    $cos12 = $datrel[0]->COST1 / 1000;
                    $tot2 = $datrel[0]->VAL1 / 1000;
                    $sheet->setCellValue($hf[22+$mi1].$ak111, $datrel[0]->PER1);
                    $sheet->getStyle($hf[22+$mi1].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[23+$mi1].$ak111, $val12);
                    $sheet->getStyle($hf[23+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[24+$mi1].$ak111, $cos12);
                    $sheet->getStyle($hf[24+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[25+$mi1].$ak111, $tot2);
                    $sheet->getStyle($hf[25+$mi1].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    
                    //-----------------------------------------
                    $arrno1[$i] = $arrno1[$i] + $datrel[0]->PER;
                    $arrno2[$i] = $arrno2[$i] + $val11;
                    $arrno3[$i] = $arrno3[$i] + $cos11;
                    $arrno4[$i] = $arrno4[$i] + $tot1;
                    $arrno5[$i] = $arrno5[$i] + $datrel[0]->PER1;
                    $arrno6[$i] = $arrno6[$i] + $val12;
                    $arrno7[$i] = $arrno7[$i] + $cos12;
                    $arrno8[$i] = $arrno8[$i] + $tot2;

                    $arrno11[$i] = $arrno11[$i] + $datrel[0]->PER;
                    $arrno21[$i] = $arrno21[$i] + $val11;
                    $arrno31[$i] = $arrno31[$i] + $cos11;
                    $arrno41[$i] = $arrno41[$i] + $tot1;
                    $arrno51[$i] = $arrno51[$i] + $datrel[0]->PER1;
                    $arrno61[$i] = $arrno61[$i] + $val12;
                    $arrno71[$i] = $arrno71[$i] + $cos12;
                    $arrno81[$i] = $arrno81[$i] + $tot2;

                    $arrno12[$i] = $arrno12[$i] + $datrel[0]->PER;
                    $arrno22[$i] = $arrno22[$i] + $val11;
                    $arrno32[$i] = $arrno32[$i] + $cos11;
                    $arrno42[$i] = $arrno42[$i] + $tot1;
                    $arrno52[$i] = $arrno52[$i] + $datrel[0]->PER1;
                    $arrno62[$i] = $arrno62[$i] + $val12;
                    $arrno72[$i] = $arrno72[$i] + $cos12;
                    $arrno82[$i] = $arrno82[$i] + $tot2;

                    $arrno13[$i] = $arrno13[$i] + $datrel[0]->PER;
                    $arrno23[$i] = $arrno23[$i] + $val11;
                    $arrno33[$i] = $arrno33[$i] + $cos11;
                    $arrno43[$i] = $arrno43[$i] + $tot1;
                    $arrno53[$i] = $arrno53[$i] + $datrel[0]->PER1;
                    $arrno63[$i] = $arrno63[$i] + $val12;
                    $arrno73[$i] = $arrno73[$i] + $cos12;
                    $arrno83[$i] = $arrno83[$i] + $tot2;
                    //-----------------------------------------
                    $mi1 = $mi1+8;
                    $datrelno++;
                }
            }else if($dat[0]=='jumlahcoa'){
                for ($i=$bla1; $i <= $bla2; $i++) {
                    $sheet->setCellValue($hf[18+$mi2].$ak111,$arrno1[$i]);
                    $sheet->getStyle($hf[18+$mi2].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[19+$mi2].$ak111,$arrno2[$i]);
                    $sheet->getStyle($hf[19+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[20+$mi2].$ak111,$arrno3[$i]);
                    $sheet->getStyle($hf[20+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[21+$mi2].$ak111,$arrno4[$i]);
                    $sheet->getStyle($hf[21+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[22+$mi2].$ak111,$arrno5[$i]);
                    $sheet->getStyle($hf[22+$mi2].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[23+$mi2].$ak111,$arrno6[$i]);
                    $sheet->getStyle($hf[23+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[24+$mi2].$ak111,$arrno7[$i]);
                    $sheet->getStyle($hf[24+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[25+$mi2].$ak111,$arrno8[$i]);
                    $sheet->getStyle($hf[25+$mi2].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $mi2  = $mi2 +8;
                    $arrno1[$i] = 0;
                    $arrno2[$i] = 0;
                    $arrno3[$i] = 0;
                    $arrno4[$i] = 0;
                    $arrno5[$i] = 0;
                    $arrno6[$i] = 0;
                    $arrno7[$i] = 0;
                    $arrno8[$i] = 0;
                } 
            
            }else if($dat[0]=='jumlahtahun'){
                for ($i=$bla1; $i <= $bla2; $i++) {
                    $sheet->setCellValue($hf[18+$mi3].$ak111,$arrno11[$i]);
                    $sheet->getStyle($hf[18+$mi3].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[19+$mi3].$ak111,$arrno21[$i]);
                    $sheet->getStyle($hf[19+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[20+$mi3].$ak111,$arrno31[$i]);
                    $sheet->getStyle($hf[20+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[21+$mi3].$ak111,$arrno41[$i]);
                    $sheet->getStyle($hf[21+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[22+$mi3].$ak111,$arrno51[$i]);
                    $sheet->getStyle($hf[22+$mi3].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[23+$mi3].$ak111,$arrno61[$i]);
                    $sheet->getStyle($hf[23+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[24+$mi3].$ak111,$arrno71[$i]);
                    $sheet->getStyle($hf[24+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[25+$mi3].$ak111,$arrno81[$i]);
                    $sheet->getStyle($hf[25+$mi3].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $mi3  = $mi3 +8;
                    $arrno11[$i] = 0;
                    $arrno21[$i] = 0;
                    $arrno31[$i] = 0;
                    $arrno41[$i] = 0;
                    $arrno51[$i] = 0;
                    $arrno61[$i] = 0;
                    $arrno71[$i] = 0;
                    $arrno81[$i] = 0;
                }

            }else if($dat[0]=='jumlahtype'){
                for ($i=$bla1; $i <= $bla2; $i++) {
                    $sheet->setCellValue($hf[18+$mi4].$ak111,$arrno12[$i]);
                    $sheet->getStyle($hf[18+$mi4].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[19+$mi4].$ak111,$arrno22[$i]);
                    $sheet->getStyle($hf[19+$mi4].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[20+$mi4].$ak111,$arrno32[$i]);
                    $sheet->getStyle($hf[20+$mi4].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[21+$mi4].$ak111,$arrno42[$i]);
                    $sheet->getStyle($hf[21+$mi4].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[22+$mi4].$ak111,$arrno52[$i]);
                    $sheet->getStyle($hf[22+$mi4].$ak111)->applyFromArray($style1);
                    $sheet->setCellValue($hf[23+$mi4].$ak111,$arrno62[$i]);
                    $sheet->getStyle($hf[23+$mi4].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[24+$mi4].$ak111,$arrno72[$i]);
                    $sheet->getStyle($hf[24+$mi4].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->setCellValue($hf[25+$mi].$ak111,$arrno82[$i]);
                    $sheet->getStyle($hf[25+$mi].$ak111)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                    $mi4  = $mi4 +8;
                    $arrno12[$i] = 0;
                    $arrno22[$i] = 0;
                    $arrno32[$i] = 0;
                    $arrno42[$i] = 0;
                    $arrno52[$i] = 0;
                    $arrno62[$i] = 0;
                    $arrno72[$i] = 0;
                    $arrno82[$i] = 0;
                }

            }
        }
        
        
        $mi5= 0;
        $akh = 11 + $jumlahrow;

        $sheet->mergeCells('B'.$akh.':'.'G'.$akh)->setCellValue('B'.$akh,'JUMLAH SEMUA DATA');
        $sheet->getStyle('B'.$akh.':'.$hf[36+$mi].$akh)->applyFromArray($warnajm2);


        for ($i=$bla1; $i <= $bla2; $i++) {
            $sheet->setCellValue($hf[18+$mi5].$akh,$arrno13[$i]);
            $sheet->getStyle($hf[18+$mi5].$akh)->applyFromArray($style1);
            $sheet->setCellValue($hf[19+$mi5].$akh,$arrno23[$i]);
            $sheet->getStyle($hf[19+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue($hf[20+$mi5].$akh,$arrno33[$i]);
            $sheet->getStyle($hf[20+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue($hf[21+$mi5].$akh,$arrno43[$i]);
            $sheet->getStyle($hf[21+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue($hf[22+$mi5].$akh,$arrno53[$i]);
            $sheet->getStyle($hf[22+$mi5].$akh)->applyFromArray($style1);
            $sheet->setCellValue($hf[23+$mi5].$akh,$arrno63[$i]);
            $sheet->getStyle($hf[23+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue($hf[24+$mi5].$akh,$arrno73[$i]);
            $sheet->getStyle($hf[24+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue($hf[25+$mi5].$akh,$arrno83[$i]);
            $sheet->getStyle($hf[25+$mi5].$akh)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
            $mi5  = $mi5 +8;
        }
        
        $where = "";
        $jml11 = $this->Detail_mmr->jumlah($cb,$where,$get_tahun);
        $isi1 = $jml11[0]->REQ / 1000;
        $isi2 = $jml11[0]->VAL / 1000;
        $sheet->setCellValue('H'.$akh,$isi1);
        $sheet->getStyle('H'.$akh)->applyFromArray($style1);
        $sheet->setCellValue('I'.$akh,$isi2);
        $sheet->getStyle('I'.$akh)->applyFromArray($style1);
        $sheet->getStyle('H'.$akh.':'.'I'.$akh)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('O'.$akh,$jmlall1);
        $sheet->getStyle('O'.$akh)->applyFromArray($style1);
        $sheet->getStyle('O'.$akh)->getNumberFormat()->setFormatCode('#,##0'); 


        for ($ii3=0; $ii3 <$jumlahrow ; $ii3++) {
            $dat = explode('-',$datax2[$ii3]); 
            $ak112 = 11 + $ii3;
            if ($dat[0]=='sub') {
                $datkon = $this->Detail_mmr->rel_seb($dat[1],$b,$show_years);
                $sheet->setCellValue($hf[26+$mi].$ak112,$datkon[0]->PER_SEB);
                $sheet->getStyle($hf[26+$mi].$ak112)->applyFromArray($style1);
                $val = $datkon[0]->VAL_SEB / 1000;
                $sheet->setCellValue($hf[27+$mi].$ak112,$val);
                $sheet->getStyle($hf[27+$mi].$ak112)->applyFromArray($style1)->getNumberFormat()->setFormatCode('#,##0');
                
            }   
        }
        

        $sheet->getColumnDimension('J')->setWidth("17");
        $sheet->getColumnDimension('O')->setWidth("20");
        $sheet->getColumnDimension('R')->setWidth("20");
        $sheet->getColumnDimension($hf[27+$mi])->setWidth("20");

        $sheet->getColumnDimension($hf[29+$mi])->setWidth("25");
        $sheet->getColumnDimension($hf[30+$mi])->setWidth("15");
        $sheet->getColumnDimension($hf[32+$mi])->setWidth("25");
        $sheet->getColumnDimension($hf[34+$mi])->setWidth("25");
        $sheet->getColumnDimension($hf[35+$mi])->setWidth("25");
        $sheet->getColumnDimension($hf[36+$mi])->setWidth("25");
        $hd = array('K','L','M','N','P');
        foreach ($hd as $column) {
            $sheet->getColumnDimension($column)->setWidth("30");
            $sheet->getColumnDimension($column)->setOutlineLevel(1);
            $sheet->getColumnDimension($column)->setVisible(false);
            $sheet->getColumnDimension($column)->setCollapsed(true);
        }

        $jumlahrow = $jumlahrow + 11;
        $akhirrows1 = $hf[36+$mi].$jumlahrow;
        $sheet->getStyle('B11:'.$akhirrows1)->applyFromArray($allborder);


        //tambahan
        $akh += 1;
        $akh11 = $akh+1; 
        $sheet->mergeCells('B'.$akh11.':'.'D'.$akh11)->setCellValue('B'.$akh11,'REKAP JUMLAH');
        
        $akh1 = $akh+2; 
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'Jumlah Kebutuhan Dana');
        $sheet->setCellValue('E'.$akh1,$isi1);
        $sheet->getStyle('E'.$akh1)->getNumberFormat()->setFormatCode('#,##0');
        $akh1 = $akh+3; 
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'Jumlah RKAP');
        $sheet->setCellValue('E'.$akh1,$isi2);
        $sheet->getStyle('E'.$akh1)->getNumberFormat()->setFormatCode('#,##0');
        $akh1 = $akh+4; 
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'Jumlah Nilai Kontrak');
        $sheet->setCellValue('E'.$akh1,$jmlall1);
        $sheet->getStyle('E'.$akh1)->getNumberFormat()->setFormatCode('#,##0');
        
        $akh1 = $akh+5; 
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'Total Program Berjalan');
        $sheet->setCellValue('E'.$akh1,$jumlahprogjalan);

        $akh1 = $akh+6; 
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'Realisasi Tahun Ini S/D Bulan '.strtolower($bl[$b]));
        $sheet->setCellValue('E'.$akh1,$arrno83[$bla2]);
        $sheet->getStyle('E'.$akh1)->getNumberFormat()->setFormatCode('#,##0');
        
        $sheet->getStyle('B'.$akh11.':E'.$akh1)->applyFromArray($allborder);
        
        $kpifisik =  $arrno83[$bla2] / $isi2 * 100;
        $akh1 = $akh+8;
        $sheet->mergeCells('B'.$akh1.':'.'D'.$akh1)->setCellValue('B'.$akh1,'KPI REALISASI FISIK');
        $sheet->setCellValue('E'.$akh1,$kpifisik);
        $sheet->getStyle('E'.$akh1)->getNumberFormat()->setFormatCode('#.##');
        $sheet->getStyle('B'.$akh1.':'.'E'.$akh1)->applyFromArray($styletambahan);
        //

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $objPHPExcel->getActiveSheet(0)->setTitle("Detail MMR");
        $objPHPExcel->setActiveSheetIndex(0);

        $objWorksheet = $sheet;

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save("test_".date('Y-m-d H-i-s').".xlsx");

        // $get_month = $date->format('d-M-Y');
        $file_name = "Report Detail MMR ".$branch." ".$bl[$b]."-".$get_tahun.".xls";

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

    public function coba()
    {
        $cb = '010';
        $invest = $this->Detail_mmr->investasi($cb,'2019');
        $invest2 = $this->Detail_mmr->investasi2($cb,'2019');

        //NVL(ac.RKAP_SUBPRO_ID,0),NVL(ac.SUBPRO_ADD_ID,0)
        
        foreach ($invest2 as $key => $va) {
            $typeinvest[$key] = $va->RKAP_INVS_TYPE;
            $tahuninvest[$key]= $va->RKAP_INVS_YEAR;
            $coa_invest[$key] = $va->ASSETS_COA;
        }

        foreach ($invest2 as $key => $va) {
            if ($va->RKAP_SUBPRO_ID <> 0) {
                $subprogram[$key] = array($va->RKAP_INVS_ID,$va->RKAP_SUBPRO_ID);
            }
            if ($va->SUBPRO_ADD_ID <> 0) {
                $adden[$key] = array('sub'=>$va->RKAP_SUBPRO_ID,'add'=>$va->SUBPRO_ADD_ID);
            }
        }

        $result1 = array_values(array_unique($typeinvest,SORT_REGULAR));
        $result2 = array_values(array_unique($tahuninvest,SORT_REGULAR));
        $result3 = array_values(array_unique($coa_invest,SORT_REGULAR));
        //$result4 = array_values(array_unique($subprogram,SORT_REGULAR));
        //$result5 = array_values(array_unique($adden,SORT_REGULAR));

        sort($result1);
        sort($result2);
        sort($result3);
        //sort($result4);
        //sort($result5);

        // //print_r($invest);
        // echo '<br>';
        // print_r(count($result1));
        // echo '<br>';
        // print_r(count($result2));
        // echo '<br>';
        // print_r(count($result3));
        // echo '<br>';
        //echo json_encode($result4);
        // echo '<br>';
        //echo json_encode($result5);
        $mn = array('','Murni','Multy Year','Cary Over');
        $z =  0;
        $ada= 0;
        for ($l1=1; $l1 <= 3 ; $l1++) {
            $z++;
            $dataz[$z] = "type-".$mn[$l1].'-'."0".'-'."0";
            for ($l2=0; $l2 <count($result2) ; $l2++) {
                $ada2 =0; 
                for ($l3=0; $l3 <count($result3) ; $l3++) {
                        $ada = 0; 
                        foreach ($invest as $key => $value) {
                            if ($value->RKAP_INVS_TYPE == $l1 && $value->RKAP_INVS_YEAR == $result2[$l2] && $value->ASSETS_COA == $result3[$l3]) {
                                $z++;
                                $ada = 1;
                                $coa = $value->ASSETS_COA.'-'.$value->RKAP_INVS_YEAR.'-'.$value->RKAP_INVS_TYPE;   
                                $dataz[$z] = "inv-".$value->RKAP_INVS_ID.'-'.$value->RKAP_INVS_TYPE.'-'.$value->ASSETS_COA.'-'.$value->RKAP_INVS_YEAR;
                            }
                            if ($value->RKAP_INVS_TYPE == $l1 && $value->RKAP_INVS_YEAR == $result2[$l2]) {
                                $ada2 = 1;
                                $tn = $value->RKAP_INVS_YEAR.'-'.$value->RKAP_INVS_TYPE.'-'."0";
                            }
                        }
                        if ($ada == 1) {
                            $z++;
                            $dataz[$z] = "jumlahcoa-".$coa;
                        }
                }
                if ($ada2 == 1) {
                    $z++;
                    $dataz[$z] = "jumlahtahun-".$tn;
                }

            }
            $z++;
            $dataz[$z] = "jumlahtype-".$l1.'-'."0".'-'."0";
        } 

        $aw = "JAN";
        $ak = "APR";
        $j=1;
        for ($i=1; $i <=count($dataz); $i++) { 
            $dat = explode('-',$dataz[$i]);
            if ($dat[0]=='inv') {
                $sub = $this->Detail_mmr->subprogramkode($dat[1]);
                $datax2[$j++] = $dat[0].'-'.$dat[1].'-'.$dat[2].'-'.$dat[3].'-'.$dat[4];
                foreach ($sub as $key => $v) {
                    if ($v->RKAP_SUBPRO_ID <> "0") {
                        $datax2[$j++] = 'sub-'.$v->RKAP_SUBPRO_ID.'-0-0';
                        if ($v->SUBPRO_ADD_ID <> "0") {
                            $add2 = $this->Detail_mmr->addendumkode($v->RKAP_SUBPRO_ID);
                            foreach ($add2 as $key => $v2) {
                                $datax2[$j++] = 'add-'.$v2->SUBPRO_ADD_ID.'-sub-'.$v->RKAP_SUBPRO_ID;
                            };
                        }
                    }
                }
            }else{
                $datax2[$j++] = $dat[0].'-'.$dat[1].'-'.$dat[2].'-'.$dat[3];
            }
        }

        echo json_encode($dataz);
        //$datrel = $this->Detail_mmr->realisasi("1000","2018","2");
        //echo json_encode($datrel);
        //             $data[$l][$i] = array("BRANCH_ID" => $v->BRANCH_ID,
        //             "RKAP_INVS_YEAR" => $v->RKAP_INVS_YEAR,
        //             "RKAP_INVS_TYPE" => $v->RKAP_INVS_TYPE,
        //             "ASSETS_COA" => $v->ASSETS_COA,
        //             "ASSETS_NAME" => $v->ASSETS_NAME,
        //             "RKAP_INVS_TITLE" => $v->RKAP_INVS_TITLE,
        //             "RKAP_INVS_COST_REQ" => $v->RKAP_INVS_COST_REQ,
        //             "RKAP_INVS_VALUE" => $v->RKAP_INVS_VALUE,
        //             "RKAP_INVS_POS" => $v->RKAP_INVS_POS,
        //             "POSISI" => $v->POSISI,
        //             "RKAP_INVS_ID" => $v->RKAP_INVS_ID);
        
    }

}