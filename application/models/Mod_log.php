<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_log extends CI_Model {
    
    function insert($data){
        $this->db->insert("t_log",$data);
        return $this->db->affected_rows();
    }

    function select($api_key){
        $this->db->select('*');
        $this->db->from('t_log');
        $this->db->where('api_key', $api_key);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    function delete($api_key){
        $this->db->delete('t_log', array('api_key' => $api_key)); 
        return $this->db->affected_rows();
    }

}