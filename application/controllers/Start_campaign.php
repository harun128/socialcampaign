<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class start_campaign extends CI_Controller {


    public function start() {
        $header['meta'] = array(
			'title'				=>	'İmza Kampanyası Başlat',
			'description'		=>	' '
		);
        $this->load->view('template/header',$header);
        $this->form_validation->set_rules('title', 'Başlık', 'trim|required|min_length[20]|max_length[100]');
        $this->form_validation->set_rules('petition', 'Kampanya Dilekçesi', 'trim|required|min_length[40]|max_length[1000]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
        <strong>Hata !</strong>','</div>');
        $this->form_validation->set_message('min_length', ' {field} alanı minimum {param} karakter olmalı.');
        $this->form_validation->set_message('required', ' {field} alanı zorunludur');

        if($this->form_validation->run()) {
            $title = $this->input->post('title',TRUE);
            $petition = $this->input->post('petition',TRUE);
            if($this->session->userdata('id')) {
                $insert = $this->campaign->insertCampaign($title,$petition,$this->session->userdata('id'));
                redirect($insert["id"]."/".$insert["sef_link"]);
                
            } else {
                $titleCookie= array(
                    'name'   => 'campaign_title',
                    'value'  => $title,
                    'expire' => '5600',
                );
                $this->input->set_cookie($titleCookie);
                $petitionCookie= array(
                    'name'   => 'campaign_petition',
                    'value'  => $petition,
                    'expire' => '5600',
                );
                $this->input->set_cookie($petitionCookie);
                redirect('register');

            }
        }
        

        $this->load->view('start-campaign');
        $this->load->view('template/footer');
    }


}

?>