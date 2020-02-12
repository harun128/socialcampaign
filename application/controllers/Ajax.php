<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {


    public function index_campaigns() {
        if(!$_POST)
            return;
        $page   = $this->input->post("page",TRUE);
        $query  = $this->input->post("query",TRUE);
        $page = ($page > 1) ? $page : 1;
        $query = ($query) ? $query :null;
       
        $limit = 8;
        $start = ($page -1)*$limit ;
 
        $data['campaigns'] = $this->campaign->last_campaigns($limit,$start,$query);
        if(!$data['campaigns']) {
            echo json_encode(array('number'=>0));
            return;
        }
        $view = $this->load->view('ajax/index_campaigns',$data,TRUE);

        echo json_encode(array('number'=>1,'html'=>$view));
        
        return;
    
    
    } 


    public function last_signs() {
        if($_POST) {
            $id = $this->input->post('id',TRUE);
            $page   = $this->input->post("page",TRUE);
            $page = ($page > 1) ? $page : 1;
            $limit = 8;
            $start = ($page -1)*$limit ;

            $data["last_signs"] = $this->signature->last_signs($id,$limit,$start);
            //print_r($data);
            if(!$data['last_signs']) {
                echo json_encode(array('number'=>0));
                return;
            }
            $view = $this->load->view('ajax/last_signs',$data,TRUE);
            echo json_encode(array('number'=>1,'html'=>$view));            
        }
    }

}
