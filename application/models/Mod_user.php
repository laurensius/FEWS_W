<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_user extends CI_Model {

    function insert($data){
        $this->db->insert("t_user",$data);
        return $this->db->affected_rows();
    }

    
    function is_registered($username){
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->where('username',$username);
        $query = $this->db->get();
        return $query->result();
    }

    function admin_list_pengguna(){
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->where('tipe != 0');
        $query = $this->db->get();
        return $query->result();
    }

    function user_detail($id){
        $this->db->select('*');
        $this->db->from('t_user');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function user_delete($api_key){
        $this->db->delete('t_user', array('api_key' => $api_key)); 
        return $this->db->affected_rows();
    }

    function update_profil($id,$data){
        $this->db->where('id', $id);
        $this->db->update('t_user', $data); 
        return $this->db->affected_rows();
    }

}