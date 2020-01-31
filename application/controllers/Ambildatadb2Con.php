<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ambildatadb2Con extends CI_Controller {

    public function index(){ 
        $db2 = $this->load->database('databasedev', TRUE);
        $query =$db2->query("select * from tm_assets");
        $data = $query->result();
        $db2->close();
        //print_r($data);
        echo "<br><br>";
        $this->load->model('Addendum_model');
        $query2 = $this->Addendum_model->coba();
        $data2 = $query2;
        $this->db->close();
        //print_r($data2);
        $json = file_get_contents('http://localhost/IPC_DASHBOARD_V2/Ambildatadb2Con/coba');
        $data3 = json_decode($json,true);
        echo json_encode($data3);
     }
     
     public function coba(){ 
        $db2 = $this->load->database('databasedev', TRUE);
        $query =$db2->query("select * from tm_assets");
        $data = $query->result();
        $db2->close();
        echo json_encode($data);
     } 
     
     public function excel()
     {
         $this->load->view('template/pages/excel1');
     }

}
