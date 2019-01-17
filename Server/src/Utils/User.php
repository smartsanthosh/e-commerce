<?php 
	
	namespace App\Utils;
	use App\DOA\SqlConn;
	class User{
		private $__tablename__="USER";
		private $name,$email,$password,$role,$tmp,$db_connect;
		public function __construct(){
			//echo var_dump(User);
			//echo "user class called";
			$this->db_connect= new SqlConn();
		}
		public function addUser($name,$email,$password){
			$this->name=$name;
			$this->email=$email;
			$this->tmp=$password;
			$this->password=password_hash($password,PASSWORD_BCRYPT);
			$resp=$this->db_connect->addTableData($this->__tablename__,['name','email','password'],[$this->name,$this->email,$this->password]);
			//echo var_dump($resp);
			if($resp['response']==1){
				unset($resp['last_id']);
			}
			return $resp;
		}
		public function query($username){
			$object=array("table_name"=>"USER","fields"=>array("*"),"where"=>array("email"=>$username));			
			$result=$this->db_connect->query($object,0);
			if(count($result)==1){
				$this->name= $result[0]['name'];
				$this->email=$result[0]['email'];
				$this->password=$result[0]['password'];
				$this->role=$result[0]['role'];
			}
		}
		public function getRole(){
			return $this->role;
		}
		public function checkUser($password){
				if(password_verify($password,$this->password))
					return true;
			return false;
		}
	}
?>