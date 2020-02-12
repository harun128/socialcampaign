<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signature extends CI_Model {
    function __construct() {
        $this->tableName = 'signs';
        
    }

    public function isItSigned($petitionId) {
        if($this->input->cookie('campaign'.$petitionId)) {
            return true;
        } else if($this->session->userdata('id')) {            
            return $this->db
            ->where(array('petition_id' =>$petitionId,'user' =>$this->session->userdata('id')))
            ->get($this->tableName)
            ->row_array();
        } else {
            return false;
        }
    }


    public function last_signs($petition,$limit,$start){
        return $this->db->query('CALL last_signs(?,?,?)',array('petition' => $petition,'limits' => $limit,'startpage'=>$start))->result();
    }

    


    
    
}