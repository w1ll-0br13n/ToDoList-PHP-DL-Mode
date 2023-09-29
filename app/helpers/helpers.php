<?php
    /**
     * 
     */
    class Database
    {
        public $conn = null;
        
        public function connect()
        {
            
            try
            {
                $servername = "127.0.0.1";
                $user = "root";
                $password = "";
                $charset = "utf8mb4";
                $init_command = "SET NAMES utf8";
                $persistent = "buff";
                $use_buffered_query = true;

                /*
                 * Calling the PDO instance of database connection
                 * No DB is yet selected to allow multiple databases CRUD actions.
                 */ 
                $conn = new PDO("mysql:host=$servername;charset=$charset", $user, $password,  array(PDO::MYSQL_ATTR_INIT_COMMAND => $init_command, PDO::ATTR_PERSISTENT => $persistent, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => $use_buffered_query));
                
                // Setting up the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn = $conn;

            }catch(PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }

        }

        public function close()
        {
            $this->conn->close();
        }
    }
    
    class Cruds
    {
        public $conn;
        public $dbname;
        public $table;
        public $columns = [];
        public $values = [];
        public $conditions = [];
        public $last_id;

        public function __construct($conn, $dbname, $table, $columns, $values, $conditions)
        {
            $this->conn = $conn;
            $this->conn->exec('USE ' . $dbname);
            $this->table = $table;
            $this->columns = $columns;
            $this->values = $values;
            $this->conditions = $conditions;
        }
        
        public function create()
        {
            
                $arrToString = "";
                $valuesString = "";
                for ($i=0; $i < sizeof($this->columns); $i++) { 
                    $arrToString .= $this->columns[$i];
                    $arrToString .= (sizeof($this->columns) > 1 && ($i < sizeof($this->columns) - 1)) ? ", " : "";
                    
                    $valuesString .= "?";
                    $valuesString .= (sizeof($this->columns) > 1 && ($i < sizeof($this->columns) - 1)) ? ", " : "";
                }
                $query = $this->conn->prepare('INSERT INTO ' . $this->table . '(' . $arrToString . ') VALUES (' . $valuesString . ')');
                $query->execute($this->values);

                $this->last_id = $this->conn->lastInsertId();

                return ($query) ? true : false;
        }
        
        public function readAlone()
        {
            
                $arrToString = "";
                for ($i=0; $i < sizeof($this->conditions); $i++) {
                    if($i == 0)
                        $arrToString  .= " WHERE ";

                    $arrToString .= $this->conditions[$i];
                    $arrToString .= (sizeof($this->conditions) > 1 && ($i < sizeof($this->conditions) - 1)) ? " AND " : "";
                }
                $query = $this->conn->prepare('SELECT * FROM ' . $this->table . $arrToString);
                
                $query->execute($this->values);

                return ($query) ? $query : false;
        }
        
        public function readJoin($tablesToJoin, $relations, $toBeSelected = [[]])
        {
            
                $letters = [
                    'main',
                    'first',
                    'second',
                    'third',
                    'fourth',
                    'fifth',
                    'sixth',
                    'seventh'
                ];
                $arrToStringToBeSelected = "";
                if(sizeof($toBeSelected) > 0 && sizeof($toBeSelected[0]) > 0){
                    for ($i=0; $i < sizeof($toBeSelected); $i++) { 
                        for ($j=0; $j < sizeof($toBeSelected[$i]); $j++) { 
                            if($i > 0){
                                $arrToStringToBeSelected .= ", ";
                            }
                            $arrToStringToBeSelected .= $letters[$i] . "." . $toBeSelected[$i][$j] . " AS " . $letters[$i] . "_" . $toBeSelected[$i][$j];
                        }
                    }
                }else{
                    $arrToStringToBeSelected = "*";
                }
                $sql = 'SELECT ' . $arrToStringToBeSelected . ' FROM ' . $this->table . ' AS main ';
                for ($i=0; $i < sizeof($tablesToJoin); $i++) { 
                    $sql .= " INNER JOIN " . $tablesToJoin[$i];
                    $sql .= " AS " . $letters[$i+1];
                    $sql .= " ON " . $letters[$i+1] . '.' . $relations[$i][1] . " = " . $letters[$i] . '.' . $relations[$i][0];
                }
                for ($j=0; $j < sizeof($this->conditions); $j++) { 
                    $sql .= " AND " . $this->conditions[$j];
                }
                $sql .= " ORDER BY main.created_at DESC";
                
                $query = $this->conn->prepare($sql);
                $query->execute($this->values);
                return ($query) ? $query : false;
        }
        
        public function update()
        {
            
                $arrToString = "";
                for ($i=0; $i < sizeof($this->columns); $i++) {
                    $arrToString .= $this->columns[$i] . ' = ?';
                    $arrToString .= (sizeof($this->columns) > 1 && ($i < sizeof($this->columns) - 1)) ? ", " : "";
                }
                $arrToStringCondition = "";
                for ($i=0; $i < sizeof($this->conditions); $i++) {
                    if($i == 0)
                        $arrToStringCondition  .= " WHERE ";

                    $arrToStringCondition .= $this->conditions[$i];
                    $arrToStringCondition .= (sizeof($this->conditions) > 1 && ($i < sizeof($this->conditions) - 1)) ? " AND " : "";
                }
                    
                $query = $this->conn->prepare('UPDATE ' . $this->table . ' SET ' . $arrToString . ' ' . $arrToStringCondition);
                
                $query->execute($this->values);

                $this->last_id = $this->values[sizeof($this->values) - 1];

                return ($query) ? true : false;
        }
        
        public function delete()
        {
            
                $arrToStringCondition = "";
                for ($i=0; $i < sizeof($this->conditions); $i++) {
                    if($i == 0)
                        $arrToStringCondition  .= " WHERE ";

                    $arrToStringCondition .= $this->conditions[$i];
                    $arrToStringCondition .= (sizeof($this->conditions) > 1 && ($i < sizeof($this->conditions) - 1)) ? " AND " : "";
                }
                
                $query = $this->conn->prepare('DELETE FROM ' . $this->table . $arrToStringCondition);

                $query->execute($this->values);

                return ($query) ? true : false;
        }
    }
    
    class Ifexist extends Cruds
    {
        public function exist()
        {
            if($this->readAlone())
            {
                return ($this->readAlone()->rowCount() > 0) ? true : false;
            
            }else{
                return false;
            }
        }
    }

    class Task extends Cruds
    {
                
    }

    class UserTask extends Cruds
    {

    }

    class User extends Cruds
    {

    }

    class UserDevice
    {
        public function getUserIP()
        {
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];
    
            if(filter_var($client, FILTER_VALIDATE_IP))
            {
                $ip = $client;
            }
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
                $ip = $forward;
            }
            else
            {
                $ip = $remote;
            }
    
            return $ip;
        }

        public function getUserTerminal()
        {
            return (isset($_SERVER["HTTP_USER_AGENT"]) && !empty($_SERVER["HTTP_USER_AGENT"])) ? $_SERVER["HTTP_USER_AGENT"] : null;
        }
    }
?>