<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class json extends CI_Controller {

    public function cities() {
        if($_POST) {
            if($_POST["id"]) {
                $data = $this->db->where('country_id',$this->input->post('id',TRUE))->get('states')->result_array();
                echo (json_encode($data));
            }
        }
    }


}
