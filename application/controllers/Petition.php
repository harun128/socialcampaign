<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class petition extends CI_Controller {


    public function detail($id,$link) {
        $id = $this->security->xss_clean($id);
        $link = $this->security->xss_clean($link);
        
        $data['signed'] = $this->signature->isItSigned($id);
        
        $data["detail"] = $this->campaign->getDetail($id,$link);
        if(!isset($data["detail"])) {
            redirect('/');
        }
        $this->db->set('views','views+1',FALSE)->where('id',$id)->update('campaigns');
        //$data["last_signs"] = $this->signature->last_signs($id,2,0);
        //echo $this->db->last_query();
        if($data["detail"]["publish"] == 0) {    
               
            if($this->session->userdata('id') != $data["detail"]["user"]) {
                redirect('/');
            }           
        }
        
        $data["myCampaign"] = ($data["detail"]["user"] == $this->session->userdata('id')) ? TRUE : FALSE;
        $header['meta'] = array(
			'title'				=>	$data["detail"]["title"].' İmza Kampanyası',
            'description'		=>	$data["detail"]["content"],
            'campaign'          =>  $data["detail"]
        );      
        
        $this->load->view('template/header',$header);
        $this->load->view('detail',$data);
        $this->load->view('template/footer');
        
       

    }
    
    
    public function petition_edit_content($id) {
        $data["detail"] = $this->campaign->getDetail($id,null);
        if($data["detail"]["user"] != $this->session->userdata('id')){
            redirect($_SERVER['HTTP_REFERER']);
        }

        if($_POST) {
            $this->form_validation->set_rules('detail', 'Detay', 'trim|required');         
            $this->form_validation->set_message('required', ' {field} alanı zorunludur');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">
            
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
            <strong>Hata !</strong>','</div>');
            if($this->form_validation->run()) {
                $update = $this->campaign->updateField(
                    array(
                        'user'  =>  $this->session->userdata('id'),
                        'id'    =>  $this->security->xss_clean($id)
                    ),
                    array(
                        'petition'  =>  $this->input->post('detail',TRUE)
                    )
                    
                    );
                if($update) {
                    redirect('/'.$id.'/'.$data["detail"]["sef_link"]);
                }
            }
        }

        $header['meta'] = array(
			'title'				=>	$data["detail"]["title"].' Düzenleme Sayfası',
			'description'		=>	'Düzenle'
		);
        $this->load->view('template/header',$header);
        $this->load->view('petition/edit_content',$data);
        $this->load->view('template/footer');                  
                     
    }

    public function change_target_count($id) {
        $data["detail"] = $this->campaign->getDetail($id,null);
        if($data["detail"]["user"] != $this->session->userdata('id')){
            redirect($_SERVER['HTTP_REFERER']);
        }

        if($_POST) {
            $target = $this->input->post('count',TRUE);
            if($target >0 ){                
                $update = $this->campaign->updateField(
                    array(
                        'user'  =>  $this->session->userdata('id'),
                        'id'    =>  $this->security->xss_clean($id)
                    ),
                    array(
                        'target_count'  =>  $target
                    )
                    
                    );
                if($update) {
                    redirect('/'.$id.'/'.$data["detail"]["sef_link"]);
                }                
            }
        }
    }

    public function close($id =null) {
        if($id != null) {
            if($this->session->userdata('id')) {
                $change = $this->campaign->close($this->session->userdata('id'),$this->security->xss_clean($id));
                if($change) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    print('HATA');
                }
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo 'HATA';
        }
    }

    public function publish ($id = null ){
        if($id != null) {
            if($this->session->userdata('id')) {
                $change = $this->campaign->publish($this->session->userdata('id'),$this->security->xss_clean($id));
                if($change) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    print('HATA');
                }
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo 'HATA';
        }
    }


    public function delete ($id = null ){
        if($id != null) {
            if($this->session->userdata('id')) {
                $change = $this->campaign->delete($this->session->userdata('id'),$this->security->xss_clean($id));
                if($change) {
                    redirect('/');
                } else {
                    print('HATA');
                }
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo 'HATA';
        }
    }

    public function success ($id = null ){
        if($id != null) {
            if($this->session->userdata('id')) {
                $change = $this->campaign->success($this->session->userdata('id'),$this->security->xss_clean($id),$this->input->post('story'));
                if($change) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    print('HATA');
                }
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo 'HATA';
        }
    }

    public function insert_institution($id) {
        if($id != null) {
            if($this->session->userdata('id')) {

                $this->form_validation->set_rules('email', 'Email', 'trim|required'); 
                $this->form_validation->set_rules('name', 'Email', 'trim|required');
                if($this->form_validation->run()) {
                    $name = $this->input->post('name',TRUE);
                    $mail = $this->input->post('email',TRUE);
                    $insert = $this->campaign->insert_institution($id,$name,$mail);
                    redirect($_SERVER['HTTP_REFERER']);
                }
                  
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo 'HATA';
        }
    }

    public function delete_institution($id,$petitionId) {
       
        if($id != null && $petitionId != null) {
            if($this->session->userdata('id')) {
                $this->campaign->delete_institution($this->security->xss_clean($petitionId),$this->security->xss_clean($id));
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_petition($id) {
        if(!$id)
            return;
        if(!$this->session->userdata('id'))
            return;
        $id = $this->security->xss_clean($id);
        $id = $this->db->escape_str($id);
        $this->form_validation->set_rules('content', 'Dilekçe', 'trim|required|min_length[100]');
        if($this->form_validation->run()) {
            $this->db->where(array(
                'id'     =>  $id,
                'user'   =>  $this->session->userdata('id')
            ))->update('campaigns',array('content'=>$this->input->post('content')));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function load_campaign_image() {
        if($_FILES["image"]) {
            
            if(!$this->session->userdata('id'))
                return;

            $user = $this->session->userdata('id');
            $id = $this->input->post('id',TRUE);
            
            $campaign =$this->campaign->getCampaignDetailByUser($id,$user);

            if(!$campaign)
                return;

            $this->load->library('upload');

            $config = array(
                'file_name'     =>  url_seo($campaign->title)."-".$id,
                'upload_path'   =>  'images/campaign/small/',
                'allowed_types' =>  'gif|jpg|png',
                'max_size'      =>  5120,
                'max_width'     =>  1024,
                'overwrite'     =>  TRUE,
                'max_height'    =>  768 );

            $image = $this->upload->initialize($config);

            if($image->do_upload("image")) {
                $data =$this->upload->data();
                copy("./images/campaign/small/".$data["file_name"],"./images/campaign/medium/".$data["file_name"]);
                copy("./images/campaign/small/".$data["file_name"],"./images/campaign/large/".$data["file_name"]);
                $update = $this->db->where('id',$id);
                $update->update('campaigns',array('image'=>$data["file_name"]));
                $this->campaign_image_manipulation($data["file_name"]);

                echo json_encode(array("success"=>TRUE,"img" => campaign_image_link($data["file_name"],"large")));
            } else {
                echo json_encode(array("msg"=>$image->display_errors()));
            }            
        } else {
            redirect('/');
        }
    }

    public function campaign_image_manipulation($image) {
        if(!$this->session->userdata("id"))
        return;
        $small = "./images/campaign/small/".$image;
        $medium = "./images/campaign/medium/".$image;
        $large = "./images/campaign/large/".$image;
        
        $smallConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $small,
            
            'width'         =>  140,
            'maintain_ratio'=>  TRUE    
            
        );
        $mediumConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $medium,
            
            'width'         =>  300,
            'maintain_ratio'=>  TRUE 
            
        );
        $largeConfig = array(
            'image_library' =>  'gd2',
            'source_image'  =>  $large,
            
            'width'         =>  360,
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
}