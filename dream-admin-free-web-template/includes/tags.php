<?php
    class tag{

        private $conn;
        private $table = "blog_tags";

        public $n_tag_id;
        public $n_blog_post_id;
        public $v_tag;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sql = "SELECT * FROM  $this->table ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt; 
        }

        public function read_single(){
            $sql = "SELECT * FROM $this->table
            where n_blog_post_id = :get_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':get_id',$this->n_blog_post_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->n_tag_id = $row['n_tag_id'];
            $this->n_blog_post_id = $row['n_blog_post_id'];
            $this->v_tag = $row['v_tag'];
            
        }

        public function create(){
            $sql = "INSERT INTO $this->table
                    SET n_blog_post_id  = :blog_post_id,
                        v_tag = :tag";
            

            
            $stmt = $this->conn->prepare($sql);
            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));
            $this->n_blog_post_id = htmlspecialchars(strip_tags($this->n_blog_post_id));

            $stmt->bindParam(':blog_post_id', $this->n_blog_post_id);
            
            $stmt->bindParam(':tag', $this->v_tag);
            

            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        public function update(){
            $query = "  Update $this->table
                        SET
                        v_tag = :tag
                        where 
                        n_tag_id  = :get_id";
            
            $stmt = $this->conn->prepare($query);

            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            $stmt->bindParam(':get_id', $this->n_tag_id);
            $stmt->bindParam(':tag', $this->v_tag);

            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


        public function delete(){
            $sql = "delete from $this->table
                    where n_tag_id = :get_id";
            
            $stmt = $this->conn->prepare($sql);

            $this->v_tag = htmlspecialchars(strip_tags($this->v_tag));

            $stmt->bindParam(':get_id', $this->n_tag_id);
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    
?>