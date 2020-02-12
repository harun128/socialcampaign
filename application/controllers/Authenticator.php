<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticator extends CI_Controller {


    public function login() {

        if($this->session->userdata('id')) {
            redirect('/');
        }

        $data["facebookLoginLink"] = $this->facebook->login_url();
        if($this->session->userdata('login')) {
            redirect('/');
        }
        $header['meta'] = array(
			'title'				=>	'Giriş Sayfası',
			'description'		=>	'sitemize giriş yapın'
		);
        $this->load->view('template/header',$header);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Şifre', 'trim|required|min_length[8]');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
        <strong>Hata !</strong>','</div>');
        $this->form_validation->set_message('min_length', ' {field} alanı minimum {param} karakter olmalı.');
        $this->form_validation->set_message('required', ' {field} alanı zorunludur');
        if($this->form_validation->run() == FALSE) {
            
            
            
        } else {
            $user = $this->User->getUser($this->input->post('email'),$this->input->post('password'));           
            unset($user['password']);          
            $this->session->set_userdata($user);              
            if($this->input->get('redirect')){
                redirect($this->input->get('redirect'));
            } else {
                redirect('/');
            }
            
            if($user) {
                
            } else {
                $data['hata'] = "Kullanıcı adı veya Şifre Yanlış";
            }
        }
       
        $this->load->view('login',$data);
        $this->load->view('template/footer');
    }

    public function facebook()
    {
        $userData = array();
        //echo $this->session->userdata('fb_access_token');
        //echo '<a href="'.$this->facebook->logout_url().'">go</a>';
        // Check if user is logged in
        //
        if($this->facebook->is_authenticated()){
            // Get user facebook profile details
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture,location');
           
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
            $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
            $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
            $userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
            $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'';
            $userData['link']        = !empty($fbUser['locale'])?$fbUser['locale']:'';
            $this->session->set_userdata('fullName',$userData["first_name"]." ".$userData["last_name"]);
            $this->session->set_userdata('email',$userData["email"]." ".$userData["email"]);
            $this->session->set_userdata('picture',$userData["picture"]." ".$userData["picture"]);

            // Insert or update user data
            $userID = $this->User->checkUser($userData);

            // Check user data insert or update status
            if(!empty($userID)){
                $userData["id"] = $userID;
                $data['userData'] = $userData;                
                $this->session->set_userdata($userData);
            }else{
               $data['userData'] = array();
            }
            
            // Get logout URL
            //$data['logoutURL'] = $this->facebook->logout_url();
            //echo '<a href="'.$data["logoutURL"].'">asd</a>';
            
            if($this->input->get("redirect")) {
                redirect($this->input->get('redirect'));
                
            } else {
                redirect("/");
            }
        }else{
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();        
        }
        
    }

    public function logout(){
        $arr = array('id','oauth_provider','oauth_id','first_name','last_name','email','gender','locale','picture','username','link','modified');
        $this->session->unset_userdata('userData');
        $this->facebook->destroy_session();
        foreach($arr as $a){
            $this->session->unset_userdata($a);
        }
        redirect($_SERVER["HTTP_REFERER"]); 
    }


    public function register() {

        if($this->session->userdata('id')) {
            redirect('/');
        }

        $header['meta'] = array(
			'title'				=>	'Kayıt Ol !',
			'description'		=>	'Kullanıcı kayıt sayfası.'
		);
        $this->load->view('template/header',$header);
        $data["facebookLoginLink"] = $this->facebook->login_url();

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Şifre', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|min_length[8]');
        $this->form_validation->set_rules('first_name', 'Ad', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Soyad', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
        <strong>Hata !</strong>','</div>');
        $this->form_validation->set_message('min_length', ' {field} alanı minimum {param} karakter olmalı.');
        $this->form_validation->set_message('required', ' {field} alanı zorunludur');
        $this->form_validation->set_message('is_unique', ' {field} adresi ile kayıtlı bir kullanıcı bulunmaktadır.');
        $this->form_validation->set_message('matches', 'Şifreler aynı olmalıdır.');

        if($this->form_validation->run()) {
            $data = array(
                'first_name'    =>  $this->input->post('first_name',TRUE),
                'last_name'     =>  $this->input->post('last_name',TRUE),
                'email'         =>  $this->input->post('email',TRUE),
                'password'      =>  md5($this->input->post('password',TRUE))
            );
            $user = $this->User->register($data);
            if($user["id"]) {
                unset($user['password']);          
            
                $this->session->set_userdata($user);
                   
                redirect('/');
            }
        }


        $this->load->view('register',$data);
        $this->load->view('template/footer');
    }

}