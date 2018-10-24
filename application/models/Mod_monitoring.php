<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_monitoring extends CI_Model {

    function insert($data){
        $this->db->insert("t_monitoring",$data);
        return $this->db->affected_rows();
    }
    
    function update($api_key,$data){
        $this->db->where('api_key', $api_key);
        $this->db->update('t_monitoring', $data); 
        return $this->db->affected_rows();
    }

    function select($api_key){
        $this->db->select('*');
        $this->db->from('t_monitoring');
        $this->db->where('api_key', $api_key);
        $query = $this->db->get();
        return $query->result();
    }

    function admin_monitoring(){
        $this->db->select('*');
        $this->db->from('t_monitoring');
        $this->db->join('t_user','t_monitoring.api_key = t_user.api_key','inner');
        $query = $this->db->get();
        return $query->result();
    }

    function delete($api_key){
        $this->db->delete('t_monitoring', array('api_key' => $api_key)); 
        return $this->db->affected_rows();
    }



}