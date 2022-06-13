<?php
    class comment{

        private $conn;
        private $table = "blog_comment";

        public $n_blog_comment_id ;
        public $n_blog_comment_parent_id;
        public $n_blog_post_id;
        public $v_comment_author;
        public $v_comment_author_email;
        public $v_comment;
        public $d_date_created;
        public $d_time_created;

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
                    n_blog_comment_id  = :get_id";
            
            $stmt = $this->conn->prepare($sql);

            $this->n_blog_comment_id = htmlspecialchars(strip_tags($this->n_blog_comment_id ));
            
            $stmt->bindParam(':get_id', $this->n_blog_comment_id );
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
     
    }

 
    
?>