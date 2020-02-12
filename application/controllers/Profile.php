<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    

    public function index($id) {

        $user["user"] = $this->User->getUserById($id);
       
        if(!$user["user"]) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if($this->session->userdata('id')){
            $user["my"] = $this->session->userdata('id') == $user["user"]->id;
        } else {
            $user["my"] = false;
        }
        $header["meta"] = array(
            'title'    => $user["user"]->first_name." ".$user["user"]->last_name." Profil Sayfası",
            'description'   =>  ''
        );
        $user["signs"] = $this->User->last_signs($id);
        $user["opens"] = $this->User->open_campaigns($id);
        
        $this->load->view('template/header',$header);

        $this->load->view('profile',$user);
        $this->load->view('template/footer');
    }

    public function change_password() {
        if($_POST) {
            header('Content-Type: application/json');
            $this->form_validation->set_rules('oldpassword', 'Eski Şifre', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('password', 'Şifre', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('password', 'Şifre', 'trim|required|min_length[8]|matches[password]');
            if($this->form_validation->run()) {
                $old = $this->input->post('oldpassword');
                $password = $this->input->post('password');
                $my =$this->User->getUserById($this->session->userdata('id'));
                
                if($my->password != md5($old)) {  echo json_encode(array('msg' => 'Eski Şifreniz Uyuşmuyor !')); return; }

                $this->db
                ->where('id',$this->session->userdata('id'))
                ->update('users',array('password'=>md5($password)));
                echo  json_encode(array("msg"=> "Şifreniz Değiştirildi"));
            } else {
                echo json_encode(array("msg"=>"Formda birşeyler eksik !"));
            }
        } else {
            echo 'Yanlış Yollardasınız !';
        }
    }

    public function edit_profile(){
        if($_POST) {
            
            if($this->session->userdata('id')) {
                header('Content-Type: application/json');
                $this->form_validation->set_rules('first_name', 'Ad', 'trim|required|min_length[3]');
                $this->form_validation->set_rules('last_name', 'Soyad', 'trim|required|min_length[2]');

                if($this->form_validation->run()) {
                    $first_name = $this->input->post('first_name',TRUE);
                    $last_name = $this->input->post('last_name',TRUE);
                    $update = $this->db->where('id',$this->session->userdata('id'))
                    ->update('users',array(
                        'first_name'    =>  $first_name,
                        'last_name'     =>  $last_name
                    ));
                    if ($update) {
                         $this->session->set_userdata(array('first_name'=>$first_name,'last_name'=>$last_name));
                         echo json_encode(array('msg'=>'Profil Bilgileri Değiştirildi'));
                        
                    }else {
                        echo json_encode(array('msg'=>'Bir hata Oluştu !')); 
                    }                    
                }
            }
        }

    }

    public function edit_profile_image(){
        
        if(!$this->session->userdata("id"))
            return;
        $this->load->library('upload');
        $configSmall = array(
            'file_name'     =>  url_seo($this->session->userdata("first_name")."-".$this->session->userdata('last_name')."-".$this->session->userdata('id')),
            'upload_path'   =>  'images/profile/small/',
            'allowed_types' =>  'gif|jpg|png',
            'max_size'      =>  5120,
            'max_width'     =>  1024,
            'overwrite'     =>  TRUE,
            'max_height'    =>  768 );
        $small = $this->upload->initialize($configSmall);
        
        if($small->do_upload("image")) {
            $data =$this->upload->data();            
            copy("./images/profile/small/".$data["file_name"],"./images/profile/medium/".$data["file_name"]);
            copy("./images/profile/small/".$data["file_name"],"./images/profile/large/".$data["file_name"]);
            $update = $this->db->where('id',$this->session->userdata('id'));
            $update->update('users',array('picture'=>$data["file_name"]));
            $this->session->set_userdata('picture',$data["file_name"]);
            $this->profile_image_manipilation($data["file_name"]);
            
        } else {
            echo json_encode(array("msg",$small->display_errors()));
        }

    }

    private function profile_image_manipilation($image){
        if(!$this->session->userdata("id"))
            return;
        $small = "./images/profile/small/".$image;
        $medium = "./images/profile/medium/".$image;
        $large = "./images/profile/large/".$image;
        
        $smallConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $small,
            
            'width'         =>  60,
            'maintain_ratio'=>  TRUE    
            
        );
        $mediumConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $medium,
            
            'width'         =>  140,
            'maintain_ratio'=>  TRUE 
            
        );
        $largeConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $large,
            
            'width'         =>  354,
            'maintain_ratio'=>  TRUE 
            
        );
        $this->load->library('image_lib');
        $this->image_lib->initialize($smallConfig);
        $this->image_lib->resize();
        $this->image_lib->initialize($mediumConfig);
        $this->image_lib->resize();
        $this->image_lib->initialize($largeConfig);
        $this->image_lib->resize();
       

    }


    public function update_social_media_accounts() {
        if(!$this->session->userdata("id"))
            return;
        $data = json_encode($this->input->post());
       

        $this->db->where('id',$this->session->userdata('id'));
        $this->db->update('users',array(
            'social_media'  =>  $data
        ));
        echo json_encode(array('msg',"Bilgiler güncellendi"));

        
    }
}