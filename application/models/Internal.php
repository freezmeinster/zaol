<?php
class Internal extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
        
        public function get_all_bank(){
            $query = $this->db->query("select * from bank_account");
            $row = $query->result();
            if (isset($row)) {
                return $row;
            } else {
                return FALSE;
            }
        }
        
        public function get_type($type){
            if ( $type == 1 ){
                return "Sudah Transfer";
            } else {
                return "Belum Transfer";
            }
        }
        
        public function get_bank($id){
            $query = $this->db->query("select * from bank_account where id =".$id);
            $row = $query->row();
            print_r($row);
            if (isset($row)) {
                return $row;
            } else {
                return FALSE;
            }
        }
}