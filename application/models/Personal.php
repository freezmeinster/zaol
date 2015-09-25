<?php
class Personal extends CI_Model {


        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
        
        public function is_login(){
                if ($this->session->userdata("logged_in") != NULL){
                        return TRUE;
                } else {
                        redirect("/dashboard/login");
                }
        }

        public function login($email,$password){
                $enc_pass = sha1($password);
                $query = $this->db->query("SELECT * FROM users where email ='".$email."' and password ='".$enc_pass."'");
                $row = $query->row();
                if (isset($row))
                {
                        if ($row->is_active == 1 && $row->is_blocked == 0) {
                               $newdata = array(
                                'email' => $email,
                                'id' => $row->id,
                                'name'  => $row->name,
                                'is_admin' => $row->is_admin,
                                'phone' => $row->phone,
                                'logged_in' => TRUE,
                                'reg_date' => $row->reg_date
                                );

                                $this->session->set_userdata($newdata);
                                return TRUE;     
                        } else {
                                return FALSE;
                        }
                       
                } else {
                        return FALSE;
                }
        }
        
        public function user_exist($email){
                $query = $this->db->query("SELECT * FROM users where email ='".$email."'");
                $row = $query->row();
                if (isset($row)){
                        return TRUE;
                } else {
                        return FALSE;
                }   
        }
        
        public function register($data){
                $this->db->insert('users', $data); 
        }

        public function get_zakat($type,$id,$year)
        {
                $q = "select 
                        sum(zi.amount) as value ,
                        month(active_date) as month
                      from 
                        zakat z left join zakat_item zi on zi.zakat_id = z.id
                      where 
                        z.type = ".$type." and
                        z.user = ".$id." and 
                        z.state = 'active' and 
                        year(z.active_date) = ".$year."
                      group by month(z.active_date)";
                $query = $this->db->query($q);
                $row = $query->result_array();
                $result = array();
                for ($i = 1; $i <= 12; $i++){
                        array_push($result,
                                    array("month" => (string)$year."-".str_pad((string)$i, 2, "0", STR_PAD_LEFT),
                                          "value" => (string)0));
                }
                foreach ($row as $item){
                        foreach ( $result as &$target){
                                $month = (string)$year."-".str_pad((string)$item['month'], 2, "0", STR_PAD_LEFT);
                                if ($target['month'] == $month){
                                        $target['value'] = $item['value'];
                                }                                   
                        }
                }
                return $result;
        }
        
        public function get_total_zakat($type,$id,$year){
                $query="
                        select 
                                sum(zi.amount) as value 
                        from 
                                zakat z left join zakat_item zi on zi.zakat_id = z.id
                        where 
                            z.type = ".$type." and
                            z.user = ".$id." and 
                            z.state = 'active' and 
                            year(z.active_date) = ".$year;
                            
                $q = $this->db->query($query);
                $row = $q->row();
                if (isset($row)){
                        return $row->value;
                } else {
                        return 0;
                }
        }
}
?>