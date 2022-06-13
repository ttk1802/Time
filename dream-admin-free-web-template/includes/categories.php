<?php
    class category{

        private $conn;
        private $table = "blog_category";

        public $n_category_id;
        public $v_category_title;
        public $v_category_meta_title;
        public $v_category_path;
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

        public function read_single(){
            $sql = "SELECT * FROM $this->table where n_category_id = :getid ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':getid',$this->n_category_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->n_category_id = $row['n_category_id'];
            $this->v_category_title = $row['v_category_title'];
            $this->v_category_meta_title = $row['v_category_meta_title'];
            $this->v_category_path = $row['v_category_path'];
            $this->d_date_created = $row['d_date_created'];
            $this->d_time_created = $row['d_time_created'];
            
        }

        public function create(){
            $sql = "INSERT INTO $this->table
                    SET v_category_title  = :category_title,
                    v_category_meta_title = :category_meta_title,
                    v_category_path       = :category_path,
                    d_date_created        = :date_created,
                    d_time_created        = :time_created";
            
            $stmt = $this->conn->prepare($sql);

            $this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
            $this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
            $this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));

            $stmt->bindParam(':category_title', $this->v_category_title);
            $stmt->bindParam(':category_meta_title', $this->v_category_meta_title);
            $stmt->bindParam(':category_path', $this->v_category_path);
            $stmt->bindParam(':date_created', $this->d_date_created);
            $stmt->bindParam(':time_created', $this->d_time_created);

            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        public function update(){
            $query = "Update $this->table
                      SET v_category_title = :category_title,
                          v_category_meta_title = :category_meta_title,
                          v_category_path = :category_path,
                          d_date_created = :date_created,
                          d_time_created = :time_created
                      where 
                          n_category_id = :get_id";
            
            $stmt = $this->conn->prepare($query);

            $this->v_category_title = htmlspecialchars(strip_tags($this->v_category_title));
            $this->v_category_meta_title = htmlspecialchars(strip_tags($this->v_category_meta_title));
            $this->v_category_path = htmlspecialchars(strip_tags($this->v_category_path));

            $stmt->bindParam(':get_id',$this->n_category_id);
            $stmt->bindParam(':category_title',$this->v_category_title);
            $stmt->bindParam(':category_meta_title',$this->v_category_meta_title);
            $stmt->bindParam(':category_path',$this->v_category_path);
            $stmt->bindParam(':date_created',$this->d_date_created);
            $stmt->bindParam(':time_created',$this->d_time_created);

            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


        public function delete(){
            $sql = "delete from $this->table
                    where n_category_id = :get_id";
            
            $stmt = $this->conn->prepare($sql);

            $this->n_category_id = htmlspecialchars(strip_tags($this->n_category_id));
            
            $stmt->bindParam(':get_id', $this->n_category_id);
            
            if($stmt->execute()){
                return true;
            }
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    
?>