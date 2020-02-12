<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
    function __construct() {
        $this->tableName = 'users';
        $this->primaryKey = 'id';
    }
    
    /*
     * Insert / Update facebook profile data into the database
     * @param array the data for inserting into the table
     */
    public function checkUser($userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select($this->primaryKey);
            $this->db->from($this->tableName);
            $this->db->where(array('oauth_provider'=>$userData['oauth_provider'], 'oauth_uid'=>$userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $userData['modified'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName, $userData, array('id' => $prevResult['id']));
                
                //get user ID
                $userID = $prevResult['id'];
            }else{
                //insert user data
                $userData['created']  = date("Y-m-d H:i:s");
                $userData['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName, $userData);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID ? $userID:FALSE;
    }

    public function getUser($email,$password) {
        return $this->db->where(array('email'=>$email,'password'=>md5($password)))->get('users')->row_array();
    }

    public function register($data) {
        $insert = $this->db->insert('users',$data);
        if($insert) {
            $id = $this->db->insert_id();
            $q = $this->db->get_where($this->tableName, array('id' => $id));
            return $q->row_array();
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        return $this->db->where('id',$id)
        ->get($this->tableName)->row();
    }

    public function last_signs($user) {
        return
        $this->db->from('signs as s')
        ->select('c.id,c.title,c.sef_link,c.image,s.sign_date')
        ->where('s.user',$user)
        ->join('campaigns as c','s.petition_id = c.id')
        ->order_by('s.sign_date','DESC')
        ->get()->result();

    }

    public function open_campaigns($user) {
        return 
        $this->db->where('c.user',$user)
        ->select('c.content,c.id,c.image,c.title,c.sef_link,c.start_date')
        ->get('campaigns as c')->result();
    }
}