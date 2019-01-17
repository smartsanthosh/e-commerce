<?php
	namespace App\DOA;

	class SqlConn{
	private $servername= "localhost";
	private $username= "user";
	private $password= "user";
	private $database="ecommerce";
	protected $conn=null;
		public function __construct(){
			// Create connection
			$this->conn = new \mysqli($this->servername, $this->username, $this->password,$this->database);

			// Check connection
			if ($this->conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			//echo "Connected to MYSQL successfully.";

		}
		public function addTableData($table_name,$attributes,$values){
			for($i=0;$i<count($values);$i++){
				$values[$i]=mysqli_real_escape_string($this->conn,$values[$i]);
			}
			$query='INSERT INTO '.$table_name.'('.join(',',$attributes).') VALUES("'.join('","',$values).'");';
				$resp=null;
				//echo $query;
				if ($this->conn->query($query) === TRUE) {
					$last_id = $this->conn->insert_id;
				    $resp=array("response"=>1,"message"=>"success","last_id"=>$last_id);
				} else {
					$resp=array("response"=>0,"message"=>'error in '.$this->conn->error);
				}
				return $resp;
		}
		public function query($object,$flag){
			$__tablename__=$object['table_name'];
			$fields=$object['fields'];
			$query='SELECT '.join(',',$fields).' FROM '.$__tablename__;
			if(array_key_exists("where", $object)){
				$where=$object['where'];
				if($flag==0)
				foreach ($where as $key => $value) {
					$query=$query.' WHERE '.$key.'="'.mysqli_real_escape_string($this->conn,$value).'";';
				}
			}
			//echo $query;
			$resp=array();
			$result=$this->conn->query($query);
			while($row = $result->fetch_assoc()){
				array_push($resp, $row);
			}
			return $resp;
		}
		public function __destruct(){
			$this->conn->close();
		}
	}
?>