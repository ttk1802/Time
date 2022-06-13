<?php
    class contact{

        private $conn;
        private $table = "blog_contact";

        public $n_contact_id;
        public $v_fullname;
        public $v_email;
        public $v_phone;
        public $v_message;
        public $d_date_created;
        public $d_time_created;
        public $f_contact_status;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sql = "SELECT * FROM  $this->table ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt; 
        }

        public function delete(){
            $sql = "DELETE from $this->table
                    Where
                    n_contact_id  = :get_id";
            
            $stmt = $this->conn->prepare($sql);

            $this->n_contact_id = htmlspecialchars(strip_tags($this->n_contact_id ));
            
            $stmt->bindParam(':get_id', $this->n_contact_id );
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
     
    }

 
    
?>