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
}