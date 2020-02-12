<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {

    public function index($id) {

        
        $id = $this->security->xss_clean($id);
        $data['signed'] = $this->signature->isItSigned($id);
        $data["detail"] = $this->campaign->detailForSign($id);
        if(!isset($data["detail"]))
            redirect('/');
        if($data['signed'] == true) {
           
            redirect(base_url('3/'.$data["detail"]["sef_link"]."?signed=true"));
        }

        $header['meta'] = array(
			'title'				=>	$data["detail"]["title"].' İmza Kampanyasını İmzala',
			'description'		=>	$data["detail"]["content"]
		);
        
        $this->load->view('template/header',$header);
        
        $this->load->config("facebook");
        $this->config->set_item('facebook_login_redirect_url', $this->config->item("facebook_login_redirect_url")."?redirect=".base_url(uri_string()));

        $data["facebookLoginLink"] = $this->facebook->login_url();
      
        $this->load->view('sign_petition',$data);
        $this->load->view('template/footer');
    }


    public function process() {

        $data['signed'] = $this->signature->isItSigned($this->input->post('id',TRUE));
        if($data['signed'] == true) {
            print (json_encode(array('success'=>0,'error' => 'yanlış Yoldasın')));
            return false;
        }
        if(!$this->session->userdata('id')) {
            $this->form_validation->set_rules('first_name', 'Ad', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Soyad', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_issigned');
        }
        $this->form_validation->set_rules('country', 'Ülke', 'trim|required');
        $this->form_validation->set_rules('city', 'Şehir', 'trim|required');
        $this->form_validation->set_rules('comment', 'Yorum', 'trim');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
        <strong>Hata !</strong>','</div>');
        $this->form_validation->set_message('issigned', ' Bu kampanya bu mail adresiyle daha önceden imzalanmıştır.');
        if($this->form_validation->run()) {

            $insert = array(
                'user'          =>  ($this->session->userdata('id')) ? $this->session->userdata('id'): null,
                'city'          =>  $this->input->post('city',TRUE),
                'comment'       =>  $this->input->post('comment',TRUE),
                'petition_id'   =>  $this->input->post('id',TRUE),
                'name'          =>  ($this->session->userdata('first_name')) ? $this->session->userdata('first_name'): $this->input->post('first_name',TRUE),
                'surname'       =>  ($this->session->userdata('last_name')) ? $this->session->userdata('last_name'): $this->input->post('last_name',TRUE),
                'mail'          =>  ($this->session->userdata('email')) ? $this->session->userdata('email'): $this->input->post('email',TRUE),
            );

            $insert = $this->db->insert('signs',$insert);
            if($insert) {
                $titleCookie= array(
                    'name'   => 'campaign'.$this->input->post('id',TRUE),
                    'value'  => "1",
                    'expire' => '5600',
                );
                $this->input->set_cookie($titleCookie);
            }
            $this->db->set('count','count+1',FALSE)->where('id',$this->input->post('id',TRUE))->update('campaigns');
            $result = $insert ? array('success' => 1) : array('success'=>0,'error'=>'Hata !');
            print(json_encode($result));
        } else {
            print (json_encode(array('success'=>0,'error' => validation_errors())));
        }
        
    }


    public function isSigned() {
        $id = $this->input->post('id',TRUE);
        $mail = $this->input->post('email',TRUE);
        $db = $this->db->where(array('petition_id'=>$id,'mail'=>($this->session->userdata('email')) ? $this->session->userdata('email'): $this->input->post('email',TRUE)))->get('signs')->row_array();
        return ($db) ? false: true;
    }

}
