<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mTask extends CI_Model {

    private $table = "task";

    function selectAll(){
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }
    function getById($id){
        $this->db->from("$this->table as t");
        $this->db->where("t.id", $id);
        $this->db->select("t.*");
        return $this->db->get()->row();
    }
    function create($data){
        $prefix = '';
        $this->db->set('created_at', 'NOW()', FALSE);
        $status = $this->db->insert($this->table, [
            "name"=>$data[$prefix."name"],
            "priority"=>$data[$prefix."priority"],
            "color"=>$data[$prefix."color"],
            "timeset"=>$data[$prefix."timeset"],
            "status"=>$data[$prefix."status"]
        ]);
        return $status;
    }
    function update($id, $data){
        $prefix = '';
        $status = $this->db->update($this->table, [
            "name"=>$data[$prefix."name"],
            "priority"=>$data[$prefix."priority"],
            "color"=>$data[$prefix."color"],
            "timeset"=>$data[$prefix."timeset"],
            "status"=>$data[$prefix."status"]
        ], $id);

        $status = $this->db->affected_rows();
        return $status;
    }
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);

    }
    function search($q){}

    // function getError(){
    //     return $this->db->_error_message();
    // }
}