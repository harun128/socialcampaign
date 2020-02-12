<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class campaign extends CI_Model {
    function __construct() {
        $this->tableName = 'campaigns';
        $this->relevant = 'relevant_institutions';
        $this->primaryKey = 'id';
    }

    public function last_campaigns($limit,$page,$like = null) {
        $data = $this->db->select('campaigns.*, users.first_name, users.last_name, users.picture')
       
        ->join('users','users.id = campaigns.user')
        ->where('campaigns.publish',1)
        ->order_by('campaigns.id','desc')
        ->limit($limit,$page);
        if($like !=null) {
            $data->like('LOWER(campaigns.title)',mb_strtolower($like),"both");
        }

        return $data->get('campaigns')
        ->result();
    }


    public function insertCampaign($title,$petition,$user) {
        
        $this->db->insert($this->tableName,array(
            'user'      => $user,
            'sef_link'  =>  url_seo($title),
            'title'     =>  $title,
            'content'   =>  $petition
        ));
        $id = $this->db->insert_id();
        return $this->db->where(array('id' => $id))->get($this->tableName)->row_array();

    } 
    public function getDetail($id,$link = null) {
        $where = ($link == null) ? array('campaigns.id' => $id) : array('campaigns.id' => $id, 'campaigns.sef_link' => $link);

        $data =  $this->db 
            ->select('users.first_name,users.last_name,users.picture,campaigns.*')
            ->join('users','campaigns.user = users.id')           
            ->where($where)
            ->get('campaigns')
            ->row_array();
        $data["relevant"] = $this->relevant_institutions($id);
        return $data;
    }


    public function relevant_institutions($id) {
        return $this->db->where(array('petition_id' => $id))->get($this->relevant)->result_array();
    }

    public function updateField($where,$fields) {
        return $this->db->where($where)
        ->update($this->tableName,$fields);
    }

    public function close($user,$id) {
        $campaign = $this->db->where(array('user' => $user,'id' => $id))
        ->get($this->tableName)->row_array();
        if($campaign) {
            return $this->db->where(array('user' => $user,'id' =>$id))
            ->update($this->tableName,array(
                'statement' =>  $campaign["statement"] == 0 ? 1 : 0
            ));
        }
    }

    public function publish($user,$id) {
        $campaign = $this->db->where(array('user' => $user,'id' => $id))
        ->get($this->tableName)->row_array();
        if($campaign) {
            return $this->db->where(array('user' => $user,'id' =>$id))
            ->update($this->tableName,array(
                'publish' =>  $campaign["publish"] == 0 ? 1 : 0
            ));
        }
    }

    public function delete($user,$id) {
        return $this->db->delete($this->tableName,array(
            'user'  =>  $user,
            'id'    =>  $id
        ));
    }

    public function success($user,$id,$comment) {        
        return $this->db->where(array('user' => $user,'id' =>$id))
        ->update($this->tableName,array(
            'successfull' =>  1,
            'state_comment' => $comment
        ));        
    }

    public function insert_institution($id,$name,$mail) {
        $campaign = $this->getDetail($id);
        if($campaign["user"] == $this->session->userdata('id')) {
            return $this->db->insert($this->relevant,array(
                'petition_id'   =>  $id,
                'name'          =>  $name,
                'mail'          =>  $mail
            ));
        }
    }

    public function delete_institution($petitionId,$id) {
        $campaign = $this->getDetail($petitionId);
        print_r($campaign);
        if($campaign["user"] == $this->session->userdata('id')) {
            return $this->db->where('id',$id)->delete($this->relevant);
        }
    }

    public function getCampaignDetailByUser($id,$user) {
        return $this->db->where(array('user'=>$user,'id'=>$id))->get('campaigns')->row();
    }

    public function detailForSign($id) {
        $data =  $this->db            
            ->where(array(
                'id'        =>  $id,
                'publish'   =>  1
            ))
            ->get('campaigns')
            ->row_array();
        return $data;
    }



}
    


