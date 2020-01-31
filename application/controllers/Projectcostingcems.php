<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectcostingcems extends CI_Controller {
    public $tanggall;
    public function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->model('Projectcosting_model');
        $this->load->model('announcement_model');
        $this->load->model('main_model');
        $this->load->model('subprogramrkap_model');
        
    }
    //-----------------------------------------------------------------------------------
    // view ke user
    //-----------------------------------------------------------------------------------
    public function index()
    {
        $cab = $this->session->userdata('SESS_USER_BRANCH');
        $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();
        $notif = $this->notifikasi_model->notifintegrasi();
        $this->data['notif_integrasi'] = $notif;
        $data['notif_in'] = $notif;
        $data['notif_re'] = $this->notifikasi_model->notifintegrasireal();
        $data4 = array(
            'USER_ID' => $this->session->userdata('SESS_USER_ID'),
            'LOG_ACTION' => 'user view announcement',
            'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
            'LOG_URL' => $_SERVER['REQUEST_URI']
        );
    
        //$this->log_model->add($data4);
        
        $this->load->view('template/global/header',$this->data);
        $this->load->view('template/pages/viewproc',$data);
        $this->load->view('template/global/footer2');
    }
    
    public function datatable($jenis)
    {
        $qw = $this->Projectcosting_model->tabel_h($jenis);
        echo json_encode($qw);
    }

    public function add_months( $months, \DateTime $object ) 
    {
        $next = new DateTime($object->format('d-m-Y H:i:s'));
        $next->modify('last day of +'.$months.' month');
    
        if( $object->format('d') > $next->format('d') ) {
            return $object->diff($next);
        } else {
            return new DateInterval('P'.$months.'M');
        }
    }

    public function pilihintegrasi()
    {
        // $cab = $this->session->userdata('SESS_USER_BRANCH');
        // $this->data['notif_announcement']= $this->announcement_model->cek_notif();
        // $this->data['notif_count']= $this->notifikasi_model->realisasi_no($cab)->num_rows();
        // $this->data['notif_isi']= $this->notifikasi_model->realisasi_no($cab)->result();

        // $data4 = array(
        //     'USER_ID' => $this->session->userdata('SESS_USER_ID'),
        //     'LOG_ACTION' => 'user view announcement',
        //     'LOG_IPADD' => $_SERVER['REMOTE_ADDR'],
        //     'LOG_URL' => $_SERVER['REQUEST_URI']
        // );
    
        //$this->log_model->add($data4);
        $data = $this->Projectcosting_model->getdatadumm();
        //echo json_encode($data);
        $this->load->view('template/pages/procost_pilih',compact('data'));
    }
    
    //------------------------------------------------------------------------------------
    //fix data integrasi -- penarikan data dari procost
    //------------------------------------------------------------------------------------

    /**
     * proses rkap integrasi semua data
     *
     * @param string $cabang
     * @return void
     */
    public function cliprosesrkap($cabang)
    {
        echo "Date ".date('Y-m-d G:i:s')." \r\n";
        if ($cabang == 82) {
            $urlval = "branch=82&cabang1=Kantor%20Pusat&cabang2=Kantor%20Pusat&cabang3=Kantor%20Pusat&cabang4=Kantor%20Pusat&cabang5=Kantor%20Pusat&cabang6=Kantor%20Pusat&cabang7=Kantor%20Pusat";
            $iduser = '2';
            $datcab = 'kantor Pusat';
        }else if ($cabang == 83) {
            $urlval = "branch=83&cabang1=Tanjung%20Priok&cabang2=Tanjung%20Priok&cabang3=Tanjung%20Priok&cabang4=Tanjung%20Priok&cabang5=Tanjung%20Priok&cabang6=Tanjung%20Priok&cabang7=Tanjung%20Priok";
            $iduser = '5';
        }else if ($cabang == 84) {
            $urlval = "branch=84&cabang1=Panjang&cabang2=Panjang&cabang3=Panjang&cabang4=Panjang&cabang5=Panjang&cabang6=Panjang&cabang7=Panjang";
            $iduser = '293';
        }else if ($cabang == 85) {
            $urlval = "branch=85&cabang1=Palembang&cabang2=Palembang&cabang3=Palembang&cabang4=Palembang&cabang5=Palembang&cabang6=Palembang&cabang7=Palembang";
            $iduser = '289';
        }else if ($cabang == 86) {
            $urlval = "branch=86&cabang1=Teluk%20Bayur&cabang2=Teluk%20Bayur&cabang3=Teluk%20Bayur&cabang4=Teluk%20Bayur&cabang5=Teluk%20Bayur&cabang6=Teluk%20Bayur&cabang7=Teluk%20Bayur";
            $iduser = '301';
        }else if ($cabang == 87) {
            $urlval = "branch=87&cabang1=Cirebon&cabang2=Cirebon&cabang3=Cirebon&cabang4=Cirebon&cabang5=Cirebon&cabang6=Cirebon&cabang7=Cirebon";
            $iduser = '285';
        }else if ($cabang == 88) {
            $urlval = "branch=88&cabang1=Pontianak&cabang2=Pontianak&cabang3=Pontianak&cabang4=Pontianak&cabang5=Pontianak&cabang6=Pontianak&cabang7=Pontianak";
            $iduser = '295';
        }else if ($cabang == 89) {
            $urlval = "branch=89&cabang1=Jambi&cabang2=Jambi&cabang3=Jambi&cabang4=Jambi&cabang5=Jambi&cabang6=Jambi&cabang7=Jambi";
            $iduser = '287';
        }else if ($cabang == 90) {
            $urlval = "branch=90&cabang1=Bengkulu&cabang2=Bengkulu&cabang3=Bengkulu&cabang4=Bengkulu&cabang5=Bengkulu&cabang6=Bengkulu&cabang7=Bengkulu";
            $iduser = '283';
        }else if ($cabang == 91) {
            $urlval = "branch=91&cabang1=Banten&cabang2=Banten&cabang3=Banten&cabang4=Banten&cabang5=Banten&cabang6=Banten&cabang7=Banten";
            $iduser = '241';
        }else if ($cabang == 92) {
            $urlval = "branch=92&cabang1=Sunda%20Kelapa&cabang2=Sunda%20Kelapa&cabang3=Sunda%20Kelapa&cabang4=Sunda%20Kelapa&cabang5=Sunda%20Kelapa&cabang6=Sunda%20Kelapa&cabang7=Sunda%20Kelapa";
            $iduser = '297';
        }else if ($cabang == 93) {
            $urlval = "branch=93&cabang1=Pangkal%20Balam&cabang2=Pangkal%20Balam&cabang3=Pangkal%20Balam&cabang4=Pangkal%20Balam&cabang5=Pangkal%20Balam&cabang6=Pangkal%20Balam&cabang7=Pangkal%20Balam";
            $iduser = '291';
        }else if ($cabang == 94) {
            $urlval = "branch=94&cabang1=Tanjung%20Pandan&cabang2=Tanjung%20Pandan&cabang3=Tanjung%20Pandan&cabang4=Tanjung%20Pandan&cabang5=Tanjung%20Pandan&cabang6=Tanjung%20Pandan&cabang7=Tanjung%20Pandan";
            $iduser = '299';
        }else{
            $urlval ="";
        }
        
        $path = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/rkap_op?".$urlval;
        $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);          
        curl_close($ch);
        $oXML = new SimpleXMLElement($retValue);
        //echo json_encode($oXML);
        $arrayjenis = array('A' => '1','B' => '2','C' => '3' );
        $arrayasset = array('201'=> '1','204'=> '2','211'=> '3','203'=> '4','213'=> '5','221'=> '6','222'=> '7','331'=> '8','212'=> '9','202'=> '10','901'=> '11');
        $jml = 0;
        foreach ($oXML as $key => $value) {
            if ($value->JENIS_INVESTASI == 'A') {
                $j = 1;
            }else if ($value->JENIS_INVESTASI == 'B') {
                $j = 2;
            }else if ($value->JENIS_INVESTASI == 'C') {
               $j = 3;
            }
            $this->Projectcosting_model->proses_rkap_ins($value->PROJECT_ID,$value->NO_PROJEK,str_replace("'","",$value->LONG_NAME),$arrayasset[(int)$value->JENIS_AKTIVA],$j,$value->TAHUN,$value->KEBUTUHAN_DANA,$value->RKAP,$value->TRIWULAN1,$value->TRIWULAN2,$value->TRIWULAN3,$value->TRIWULAN4,'0','0',$iduser,'1');
            $jml++;
            echo "RKAP Id Project ".$value->PROJECT_ID." Done!!! \r\n";
        }

        $this->Projectcosting_model->add_history($datcab,$jml,'RKAP');
        echo "done!";
    }

    /**
     * untuk proses ambil data kontrak dan simpan data ke dummy
     *
     * @param string $cabang
     * @return void
     */
    public function cliproseskontrakdummy($cabang)
    {
        echo "Date ".date('Y-m-d G:i:s')." \r\n";
        if ($cabang == 82) {
            $idu = "2";
            $datcab ="Kantor Pusat";
        }else if ($cabang == 83) {
            $idu = "5";
            $datcab ="Tanjung Priok";
        }else if ($cabang == 84) {
            $idu = "293";
            $datcab ="Panjang";
        }else if ($cabang == 85) {
            $idu = "289";
            $datcab ="Palembang";
        }else if ($cabang == 86) {
            $idu = "301";
            $datcab ="Teluk Bayur";
        }else if ($cabang == 87) {
            $idu = "285";
            $datcab ="Cirebon";
        }else if ($cabang == 88) {
            $idu = "295";
            $datcab ="Pontianak";
        }else if ($cabang == 89) {
            $idu = "287";
            $datcab ="Jambi";
        }else if ($cabang == 90) {
            $idu = "283";
            $datcab ="Bengkulu";
        }else if ($cabang == 91) {
            $idu = "241";
            $datcab ="Banten";
        }else if ($cabang == 92) {
            $idu = "297";
            $datcab ="Sunda Kelapa";
        }else if ($cabang == 93) {
            $idu = "291";
            $datcab ="Pangkal Balam";
        }else if ($cabang == 94) {
            $idu = "299";
            $datcab ="Tanjung Pandan";
        }else{
            $datcab ="";
        }
        

        $iddata = $this->Projectcosting_model->selectidinvestall($idu);
        $tanggal = $this->ftanggal();
        $tanggal2 = $this->ftanggal2();
        foreach ($iddata as $key => $v) {
            $path = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/kontrak_all_2_op?proid=$v->RKAP_INVS_ID&tanggal=$tanggal&tanggal2=$tanggal2";
            $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL,$path);
           curl_setopt($ch, CURLOPT_FAILONERROR,1);
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
           curl_setopt($ch, CURLOPT_TIMEOUT, 300);
           $retValue = curl_exec($ch);          
           curl_close($ch);
           $oXML = new SimpleXMLElement($retValue);
           //echo json_encode($oXML);
   
           foreach ($oXML as $key => $value) {
                $datako = array(
                    'PROJECT_ID' => $value->PROJECT_ID,
                    'PO_NUMBER' => $value->PO_NUMBER,
                    'NO_KONTRAK' => $value->NO_KONTRAK,
                    'PO_DESC' => $value->PO_DESC,
                    'PO_AMT' => $value->PO_AMT,
                    'PO_DATE' => $value->PO_DATE,
                    'VENDOR_NAME' => $value->VENDOR_ID
                );
               $this->Projectcosting_model->insertkontrakdum("PROCOST_KONTRAK_DUMMY",$datako);
               echo "Kontrak dengan id ".$value->PO_NUMBER." Generate done! \r\n";   
           }    
        }
        
        //$this->Projectcosting_model->add_history($datcab,count($oXML),'KONTRAK');

    }
    /**
     * proses realisasi2 system 2 ganti nama clirealisasitocems
     *
     * @param [type] $cabang
     * @return void
     */
    public function clirealisasitocems($cabang)
    {
        echo "Date ".date('Y-m-d G:i:s')." \r\n";
        if ($cabang == 82) {
            $idu = "2";
            $datcab ="Kantor Pusat";
        }else if ($cabang == 83) {
            $idu = "5";
            $datcab ="Tanjung Priok";
        }else if ($cabang == 84) {
            $idu = "293";
            $datcab ="Panjang";
        }else if ($cabang == 85) {
            $idu = "289";
            $datcab ="Palembang";
        }else if ($cabang == 86) {
            $idu = "301";
            $datcab ="Teluk Bayur";
        }else if ($cabang == 87) {
            $idu = "285";
            $datcab ="Cirebon";
        }else if ($cabang == 88) {
            $idu = "295";
            $datcab ="Pontianak";
        }else if ($cabang == 89) {
            $idu = "287";
            $datcab ="Jambi";
        }else if ($cabang == 90) {
            $idu = "283";
            $datcab ="Bengkulu";
        }else if ($cabang == 91) {
            $idu = "241";
            $datcab ="Banten";
        }else if ($cabang == 92) {
            $idu = "297";
            $datcab ="Sunda Kelapa";
        }else if ($cabang == 93) {
            $idu = "291";
            $datcab ="Pangkal Balam";
        }else if ($cabang == 94) {
            $idu = "299";
            $datcab ="Tanjung Pandan";
        }else{
            $datcab ="";
        }
        
        $this->load->model('subprogramrkap_model');
        $iddata = $this->Projectcosting_model->selectidinvestall($idu);
        $jumlah = 0;
        $tanggal = $this->ftanggal();
        $tanggal2 = $this->ftanggal2();
        foreach ($iddata as $key => $v) {
            $path = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/realisasi_up_addendum_op?proid=$v->RKAP_INVS_ID&tanggal=$tanggal&tanggal2=$tanggal2";
            $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL,$path);
            curl_setopt($ch, CURLOPT_FAILONERROR,1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            $retValue = curl_exec($ch);          
            curl_close($ch);
            $oXML = new SimpleXMLElement($retValue);
            //echo $v->RKAP_INVS_ID."--".count($oXML)."\r\n";
            if (count($oXML) > 0) {
                echo "Realisasi Projeck id ".$v->RKAP_INVS_ID." ! \r\n";
                foreach ($oXML as $key => $value) {
                    $time = strtotime($value->RCV_DATE);
                    $newformat = date('Y-m-d',$time);
                    $date1 = date_create($newformat);
                    $bln = date_format($date1,"m");
                    $thn = date_format($date1,"Y");
                    $refer = $this->Projectcosting_model->getref($value->PO_NUMBER);
                    if (count($refer) > 0) {
                        $sama = $this->Projectcosting_model->getsama($refer->ID_REF,$newformat);
                        //echo $refer->ID_REF." --- ".$newformat."\r\n";
                        if (count($sama) == 0) {
                            $this->Projectcosting_model->proses_realisasi_ins($refer->ID_REF,$bln,'0','1','1','-',$thn,0,$value->RCV_AMT,'0',$newformat,'0',$bln);    
                        }else{
                            $val2 = $value->RCV_AMT + $sama->REAL_SUBPRO_VAL;
                            $this->Projectcosting_model->updaterealintegrasi($sama->REAL_SUBPRO_ID,$val2);  
                        }
                        $this->Projectcosting_model->cleanreal($refer->ID_REF);
                        $this->subprogramrkap_model->generates4($refer->ID_REF);
                        $jumlah = $jumlah + 1;
                    }else{
                        $this->Projectcosting_model->insertrealdumpp($value->PO_NUMBER,$value->RCV_DATE,$value->RCV_AMT);
                    }
                    echo "---Realisasi $value->PO_NUMBER tanggal $value->RCV_DATE done! \r\n";
                }
                
            }    
        }
        $this->Projectcosting_model->add_history($datcab,$jumlah,'REALISASI');    
    }
    /**
     * proses untuk addendum bila di projek costing sudah ada referensi
     *
     * @param [type] $cabang
     * @return void
     */
    public function cliaddendum($cabang)
    {
        echo "Date ".date('Y-m-d G:i:s')." \r\n";
        if ($cabang == 82) {
            $idu = "2";
            $datcab ="Kantor Pusat";
        }else if ($cabang == 83) {
            $idu = "5";
            $datcab ="Tanjung Priok";
        }else if ($cabang == 84) {
            $idu = "293";
            $datcab ="Panjang";
        }else if ($cabang == 85) {
            $idu = "289";
            $datcab ="Palembang";
        }else if ($cabang == 86) {
            $idu = "301";
            $datcab ="Teluk Bayur";
        }else if ($cabang == 87) {
            $idu = "285";
            $datcab ="Cirebon";
        }else if ($cabang == 88) {
            $idu = "295";
            $datcab ="Pontianak";
        }else if ($cabang == 89) {
            $idu = "287";
            $datcab ="Jambi";
        }else if ($cabang == 90) {
            $idu = "283";
            $datcab ="Bengkulu";
        }else if ($cabang == 91) {
            $idu = "241";
            $datcab ="Banten";
        }else if ($cabang == 92) {
            $idu = "297";
            $datcab ="Sunda Kelapa";
        }else if ($cabang == 93) {
            $idu = "291";
            $datcab ="Pangkal Balam";
        }else if ($cabang == 94) {
            $idu = "299";
            $datcab ="Tanjung Pandan";
        }else{
            $datcab ="";
        }
        
        $this->load->model('subprogramrkap_model');
        $iddata = $this->Projectcosting_model->selectidinvest($idu);
        $path = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/addendum_month_op?";
        $urlupdatekontrak = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/kontrak_update_op?";
        $urlupdaterealisasi = "http://10.10.32.113:9763/services/INV_PROCOST_ALL/realisasi_up_addendum_op?";
        $tanggal = $this->ftanggal();
        $tanggal2 = $this->ftanggal2();
        foreach ($iddata as $key => $va) {
            echo "Generate Projek id $va->RKAP_INVS_ID \r\n";
            $purl = "proid=$va->RKAP_INVS_ID&tanggal=$tanggal&tanggal2=$tanggal2";
            $oXML1 = $this->wsodss($purl,$path);
            if (count($oXML1) > 0) {
                echo "--Terdapat addendum di $va->RKAP_INVS_ID \r\n";
                foreach ($oXML1 as $key => $v) {
                    echo "----generate addendum di $v->PO_ADENDUM \r\n";
                    $this->Projectcosting_model->proses_addendum_ins($v->PO_ADENDUM,$v->NO_KONTRAK,$v->PO_DATE,$v->PO_AMT,'1',$v->PO_DATE,'0',$v->PO_DATE);
                    $this->tambahmont($v->PO_ADENDUM,$v->PO_DATE,'1');
                    $this->Projectcosting_model->deletekontrak($v->PO_NUMBER);
                }
                $purlupdatekontrak = "proid=$va->RKAP_INVS_ID";
                $oXML3 = $this->wsodss($purlupdatekontrak,$urlupdatekontrak);
                foreach ($oXML3 as $key => $v2) {
                    echo "----update nilai kontrak $v2->PO_NUMBER \r\n";
                    $this->Projectcosting_model->proses_update_k($v2->PO_NUMBER,$v2->PO_AMT);
                    echo "----Delete realisasi pada kontrak $v2->PO_NUMBER \r\n";
                    $this->Projectcosting_model->deletereal($v2->PO_NUMBER);
                }
                $purlupdaterealisasi = "proid=$va->RKAP_INVS_ID&tanggal=02-2000&tanggal2=$tanggal2";   
                $oXML4 = $this->wsodss($purlupdaterealisasi,$urlupdaterealisasi);
                foreach ($oXML4 as $key => $v3) {
                    echo "----Update Realisasi $v3->PO_NUMBER \r\n";
                    $time = strtotime($v3->RCV_DATE);
                    $newformat = date('Y-m-d',$time);
                    $date1 = date_create($newformat);
                    $bln = date_format($date1,"m");
                    $thn = date_format($date1,"Y");
                    $this->Projectcosting_model->proses_realisasi_ins($v3->PO_NUMBER,$bln,'0','1','1','-',$thn,0,$v3->RCV_AMT,'0',$newformat,'0',$bln);    
                    $this->subprogramrkap_model->generates4($v3->PO_NUMBER);
                }
            }      
        }

    }
    //-----------------------------------------------------------------------------------
    // fungsi tambhah untuk memasukan data
    //-----------------------------------------------------------------------------------
    /**
     * proses curl ke wso
     *
     * @param string $parameter
     * @param string $url
     * @return xml
     */
    public function wsodss($parameter,$url)
    {
        $path = $url.$parameter;
        $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $retValue = curl_exec($ch);          
        curl_close($ch);
        $oXML = new SimpleXMLElement($retValue);
        return $oXML;
    }
    /**
     * proses tambah bulan ke montlhy
     *
     * @param string $idrkap1
     * @param date $tgl = 02-2019
     * @param string $i
     * @return 
     */
    public function tambahmont($idrkap1,$tgl,$i)
    {
        $time = new DateTime($tgl);
        $date1 = $time->format('d-M-y');
        $date2 = $time->format('m');
        $data = array(
            'RKAP_SUBPRO_ID' => $idrkap1,
            'SUBPRO_MONTH' => $date2,
            'SUBPRO_VALUE' => 0,
            'SUBPRO_YEARS' => $date1,
            'IS_ADDENDUM' => $i
        );
        $this->Projectcosting_model->add2($data);
    }
    /**
     * pengganti variabel tanggal global
     *
     * @return void
     */
    public function ftanggal()
    {
        // foreach (range(1,10) as $value) {
        $d = strtotime("-1 Months");
        $e = date("m-Y", $d);   
        // }
        //return $e;
        return $e;
    }
    public function ftanggal2()
    {
        // foreach (range(1,10) as $value) {
        $d = strtotime("-1 Months");
        $e = date("m-Y", $d);        
        // }
        //return $e;
        return $e;
    }

    public function coba()
    {
        echo $this->ftanggal();
        echo "\r\n";
        echo $this->ftanggal2();
        $this->Projectcosting_model->cleanreal('71268');
    }
    /**
     * proses memasukan kembali realisasi ke kontrak manual
     *
     * @param Type $var
     * @return void
     */
    public function prosesmasukrealisasi()
    {   
        $oXML = $this->Projectcosting_model->ambildatarealdummy();
        $jumlah = 0;
        foreach ($oXML as $key => $value) {
            $time = strtotime($value->RCV_DATE);
            $newformat = date('Y-m-d',$time);
            $date1 = date_create($newformat);
            $bln = date_format($date1,"m");
            $thn = date_format($date1,"Y");
            $refer = $this->Projectcosting_model->getref($value->PO_NUMBER);
            if (count($refer) > 0) {
                $sama = $this->Projectcosting_model->getsama($refer->ID_REF,$newformat);
                //echo $refer->ID_REF." --- ".$newformat."\r\n";
                if (count($sama) == 0) {
                    $this->Projectcosting_model->proses_realisasi_ins($refer->ID_REF,$bln,'0','1','1','-',$thn,0,$value->RCV_AMT,'0',$newformat,'0',$bln);    
                    echo "---Realisasi $value->PO_NUMBER tanggal $value->RCV_DATE done! \r\n";
                }else{
                    $val2 = $value->RCV_AMT + $sama->REAL_SUBPRO_VAL;
                    $this->Projectcosting_model->updaterealintegrasi($sama->REAL_SUBPRO_ID,$val2);
                    echo "---Realisasi $value->PO_NUMBER tanggal $value->RCV_DATE done! \r\n";  
                }
                $this->Projectcosting_model->cleanreal($refer->ID_REF);
                $this->subprogramrkap_model->generates4($refer->ID_REF);
                $this->Projectcosting_model->hapusdatarealdummy($value->PO_NUMBER,$value->RCV_DATE);
                $jumlah = $jumlah + 1;
            }else{
                echo "tidak ada id yang sama"."\r\n";
                //$this->Projectcosting_model->insertrealdumpp($value->PO_NUMBER,$value->RCV_DATE,$value->RCV_AMT);
            }
            
        }
        //echo var_dump($oXML);
        if ($jumlah > 0) {
            $this->Projectcosting_model->add_history('Manual',$jumlah,'REALISASI');
        }
    }
    //-----------------------------------------------------------------------------------------
    /**
     * Proses ajax untuk post pilihan adendum / kontrak
     *
     * @return void
     */
    public function getdummy()
    {
        $idasli = $_POST['idasli'];
        $jenis = $_POST['jenis'];
        $ref = $_POST['ref'];
        $addnno = $_POST['add'];

        $dump = $this->Projectcosting_model->dump($idasli);
        if($jenis == 'kontrak') {
            $this->Projectcosting_model->proses_kontrak_ins($dump->PO_NUMBER, $dump->PROJECT_ID, $dump->PO_DESC, '1', $dump->NO_KONTRAK, $dump->PO_DATE, $dump->PO_AMT, '1',$dump->PO_DATE, '0', $dump->VENDOR_NAME, '0', '0', $dump->PO_DATE, $dump->PO_AMT,$dump->PO_DATE);
            $this->tambahmont($dump->PO_NUMBER,$dump->PO_DATE,'0');
            $this->Projectcosting_model->updatedump($idasli);//simpan Y jadi N
            $this->Projectcosting_model->inserttointeg($idasli,$idasli); //simpan id sebagai id asli dan referensi
            $this->Projectcosting_model->add_history('Manual','1','KONTRAK');
        }else if($jenis == 'addendum'){
            $cekmon = $this->Projectcosting_model->cekdatamontly($ref,$addnno);
            if ($cekmon == 0) {
                $this->addhitoryadd($ref,$dump->PO_DATE);
                $this->tambahmont($ref,$dump->PO_DATE,$addnno);
                $this->Projectcosting_model->proses_addendum_ins2($ref,$dump->NO_KONTRAK,$dump->PO_DATE,$dump->PO_AMT,'1',$dump->PO_DATE,'0',$dump->PO_DATE);
            }else{
                $this->Projectcosting_model->updatedataaddendum($ref,$dump->PO_DATE,$dump->PO_AMT);
            }
            $this->Projectcosting_model->updatedump($idasli); //simpan Y jadi N
            $this->Projectcosting_model->inserttointeg($idasli,$ref); //simpan id sebagai id asli dan referensi
            $this->Projectcosting_model->add_history('Manual','1','ADDENDUM');
        }
    }
    //-----------------------------------------------------------------------------------------
    /**
     * Dtata table
     *
     * @param [type] $id
     * @return void
     */
    public function ambildata($id)
    {   
        //$id = $_GET['id'];
        $query['data'] = $this->Projectcosting_model->ambildatadttable($id);;
        echo json_encode($query);
    }
    /**
     * proses untuk masuk ke addendum history
     *
     * @param id po $id
     * @param tanggal po $tgl
     * @return void
     */
    public function addhitoryadd($id,$tgl)
    {
        $is_addendum = $this->Projectcosting_model->cek_addendum_yyn($id);
        $is_addendum_update = $is_addendum + 1;
        $data['row_subprogram'] = $this->Projectcosting_model->find_subprogram($id);
        $data3 = array(
            'RKAP_SUBPRO_ID' => $id,
            'SUBPRO_ADD_NUM' => $data['row_subprogram']->RKAP_SUBPRO_CONTRACT_NO,
            'SUBPRO_ADD_DATE' => $data['row_subprogram']->RKAP_SUBPRO_START,
            // 'SUBPRO_ADD_DATE_NEW' => $data['row_subprogram']->RKAP_SUBPRO_DATE_NEW,
            'SUBPRO_ADD_END_REAL' => $data['row_subprogram']->RKAP_SUBPRO_END_REAL,
            'SUBPRO_ADD_VALUE' => $data['row_subprogram']->RKAP_SUBPRO_CONTRACT_VALUE,
            'SUBPRO_ADD_PERIODE' => $data['row_subprogram']->RKAP_SUBPRO_PERIODE,
             'SUBPRO_ADD_PERIOD_TOT' => 0,
             'SUBPRO_ADD_ENDREAL_LAST' => Datetime::createFromFormat('Y-m-d', $tgl)->format('d-M-y'),
            'SUBPRO_ADD_ENDOF_GUARANTEE' => $data['row_subprogram']->RKAP_SUBPRO_ENDOF_GUARANTEE,
            'VERSION' => $is_addendum_update
        );
        $this->Projectcosting_model->add_history_addendumm($data3);
    }

}
