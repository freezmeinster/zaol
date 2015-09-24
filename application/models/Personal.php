<?php
class Personal extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_zakat_maal($id,$year)
        {
                $result = array();
                for ($i = 1; $i <= 12; $i++){
                        array_push($result,
                                    array("month" => (string)$year."-".str_pad((string)$i, 2, "0", STR_PAD_LEFT),
                                          "value" => (string)100));
                }
                return $result;
        }
}
?>