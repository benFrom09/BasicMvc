<?php
namespace Ben09\Core;

use \PDO;
use \PDOException;

/**
 * A revoir 
 */


class Database
{

    protected $dsn;
    protected $user;
    protected $password;
    protected $options = [];
    protected $connection;

    public function __construct($dsn,$user,$password,$options = []) {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->options = $options;
        echo __CLASS__ . ': called';
    }

    public function getPdo(){
        if($this->connection === null) {
            try {
                $this->connection = new PDO($this->dsn,$this->user,$this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);              
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }
            catch(PDOException $e) {
                die('DATABASE CONNECTION FAILED ' . $e->getMessage());
            }
             
        }

        return $this;      
    } 

    public function lastIsertId() {
        return $this->getPdo()->lastInsertId();
    }

    public function getTable($table) {
        
        $req = $this->connection->query("SELECT * FROM $table");
        $data = $req->fetchAll();

        $namespace = 'App\Models\\';
        if($table[-1] === 's') {
            $len = strlen($table);
            $model = substr($table,0,$len -1);
        }
        $model = $namespace . $model;
        return new $model($data);
    }

    





}