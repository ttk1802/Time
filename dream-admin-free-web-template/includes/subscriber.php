<?php
    class subscriber{

        private $conn;
        private $table = "blog_subscriber";

        public $n_sub_id;
        public $v_sub_email;
        public $d_date_created;
        public $d_time_created;
        public $f_sub_status;

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
                    n_sub_id  = :get_id";
            
            $stmt = $this->conn->prepare($sql);

            $this->n_sub_id = htmlspecialchars(strip_tags($this->n_sub_id ));
            
            $stmt->bindParam(':get_id', $this->n_sub_id );
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
     
    }

 
    
?>