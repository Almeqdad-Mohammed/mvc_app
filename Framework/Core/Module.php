<?php
   namespace Framework\Core;
    use PDO;

    class Module {
        private static $Instance = null;
        private $pdo ,
                $query,
                $results,
                $errors = false,
                $count;

        public function __construct(){

            try {
                $this->pdo = new \PDO("mysql:host=".config('mysql/host').";dbname=".config('mysql/db_name'),config("mysql/db_user"),config("mysql/db_pass"));
                // echo "Connnection Successfully";
            } catch(\PDOException $e) {
                die($e->getMessage());
            }

        }

        public function dbcon(){
            if (! self::$Instance) {
                return self::$Instance = new Module();
            }
            return self::$Instance;
        }

        // create the Query Funtion
        public function query($sql , $params = [])
        {
            $this->errors = false;
            if ($this->query = $this->pdo->prepare($sql)){
                
                if (count($params)){
                    $x = 1;
                    foreach ($params as $param) {

                        $this->query->bindValue($x , $param);
                        
                    }
                    $x++;
                }
                if ($this->query->execute()){
                    $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                    $this->count = $this->query->rowCount();

                }else{
                    $this->errors = true;
                }
            }
            return $this;
        }
        public  function get($table , $where = []){
            if (count($where) == 3){
                $operators = array('=', '>' , '<' , '<=', '>=');
                $field = $where[0];
                $operate = $where[1];
                $value = $where[2];
                if (in_array($operate , $operators)){
                    $x = 1;
                    foreach ($where as $fields) {
                        $fields = " = ? ";
                        $field;
                        if ($x < count($where)){
                            $fields .=" , ";
                            $x++;
                        }
                    }
                    $sql  = "SELECT * FROM {$table} WHERE {$field} {$operate} {$value} ";
                }else{
                    echo "Your Operator That You Chosen Uncorrect";
                }

            }else{
                $sql = "SELECT * FROM {$table} ";

            }
            return $this->query($sql);
        }
        // create function of insert As Create 
        public function create($table , $where = []){
            if (count($where)) {
                $fields = array_keys($where);
                $values = array_values($where);
                $fieldName = '';
                $param = '';

                $x = 1;
                foreach ($fields as $field) {
                    $param .= '?';
                    $fieldName .=$field;
                    if ($x < count($fields)) {
                        $param .= ', ';
                        $fieldName .= ', ';
                    }
                    $x++;
                }
                $sql = "INSERT INTO {$table}($fieldName) VALUES({$param})";
                // die($sql);
                $this->query($sql , $values);
            }
            return false;
        }
        public  function result(){
            return $this->results;
        }
        public function count(){
            return $this->count;
        }
    }