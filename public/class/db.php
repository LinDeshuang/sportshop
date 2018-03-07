<?php
  /*
  *数据库类，封装pdo的各种方法
  */
  class DB
  {
    private $con;

    public function __construct($dbname)
    {
    	try{
    		$this->con=new PDO("mysql:host=localhost;dbname={$dbname}","root","1c360ee002");
     		$this->con->exec('set names utf8');
    	}catch(Exception $e){
    		echo 'database error: '.$e->getMessage();
    	}
     
    }

    public function exec($sql)
    {
     return $this->con->exec($sql);
    }

    public function query($sql)
    {
     $stmt=$this->con->query($sql);
     if($stmt)
     {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     else
     {
      return $stmt;
     }

    }

    public function getRows($sql)
    {
     $stmt=$this->con->query($sql);

      if($stmt)
     {
        return $stmt->fetch(PDO::FETCH_NUM)[0];  
     }
     else
     {
        return $stmt;
     }
    }

    public function rowCount($sql)
    {
    	$stmt=$this->con->query($sql);
      if($stmt === false){
        return 0;
      }else{
        return $stmt->rowCount();
      }
    }

    public function prepare($sql,$array=array()){
      $stmt=$this->con->prepare($sql);
      $stmt->execute($array);
      $res = $stmt->errorInfo();
      if($res[0] =='00000'){
        return true;
      }else{
        return false;
      }
    }

    public function lastInsertId($id_name){
      return $this->con->lastInsertId($id_name);
    }

    public function errorInfo(){
    	return $this->con->errorInfo();
    }
  }
  const SEC = 'b097de0EcC0F16b7dc7A0Da4';
  $_SQL = new DB('sport_shop');
?>