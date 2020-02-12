<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		if($this->input->cookie('campaign_title') && $this->session->userdata('id') != null) {
			$this->addCampaign();
		}
		$query = @$this->input->get("query",TRUE);
		$query = ($query) ? $query :null;
		$data['campaigns'] = $this->campaign->last_campaigns(8,0,$query);
		
		$data['statistics'] = $this->db->get('statistics')->row();
		$header['meta'] = array(
			'title'				=>	'Birimza.com İmza Kampanyası Başlat ve Birşeylerin Değişmesini Sağla',
			'description'		=>	'Online imza kampanyası sitesi'
		);
		$header["active"] = "homepage";
		$this->load->view('template/header',$header);
		$this->load->view('index',$data);
		$this->load->view('template/footer');
	}

	public function addCampaign() {
		if($this->input->cookie('campaign_title') && $this->session->userdata('id') != null) {
			$insert = $this->campaign->insertCampaign($this->input->cookie('campaign_title'),$this->input->cookie('campaign_petition'),$this->session->userdata('id'));
			if($insert ){
				delete_cookie('campaign_title');
				delete_cookie('campaign_petition');
				redirect($insert["id"]."/".$insert["sef_link"]);
			}
		} else {
			redirect('/');
		}
	}
	

	
}
