<?php
	
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "progin";
		const DB_PASSWORD = "progin";
		const DB = "progin_405_13510032";
		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			if(isset($_REQUEST['rquest'])){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
			}else{
				print "no request<br/>";
			}
		}
		
		public function profile(){
			if ($this->get_request_method() != "GET") {
				$this->response('',406);					// IF not GET method
			}
			$usr = $this->_request['username'];
			$sql1 = mysql_query("SELECT * FROM user WHERE username = '$usr'");
			$result1 = mysql_fetch_array($sql1,MYSQL_ASSOC);
			$this->response($this->json($result1),200);
		}
		
		// MAMON

		public function rincitugas(){
			if ($this->get_request_method() != "GET") {
				$this->response('',406);					// IF not GET method
			}
			$id = $this->_request['idtask'];
			
			$sql_task = mysql_query("SELECT * FROM task WHERE id_task='$id'");
			$current_task = mysql_fetch_array($sql_task,MYSQL_ASSOC);
			$this->response($this->json($current_task),200);
		}
		
		public function curtask(){
			if ($this->get_request_method() != "GET") {
				$this->response('',406);					// IF not GET method
			}
			$id = $this->_request['idtask'];
			
			$task_sql = mysql_query("SELECT * FROM task WHERE id_task = '$id'");
			$cur_task = mysql_fetch_array($task_sql,MYSQL_ASSOC);

			$this->response($this->json($cur_task),200);
		}
		
		public function curassigne(){
			if ($this->get_request_method() != "GET") {
				$this->response('',406);					// IF not GET method
			}
			$id = $this->_request['idtask'];
			//$user = $this->_request['username'];
			
			$assignee_sql = mysql_query("SELECT username FROM assignee WHERE id_task = '$id'");
			
			if (mysql_num_rows($assignee_sql) > 0) {
            $result = array();
            while ($rlt = mysql_fetch_array($assignee_sql, MYSQL_ASSOC)) {
                $result[] = $rlt;
            }
        }
						
			$this->response($this->json($result),200);
		}

		public function curtag(){
			if ($this->get_request_method() != "GET") {
				$this->response('',406);					// IF not GET method
			}
			$id = $this->_request['idtask'];
			//$user = $this->_request['username'];
			
			$tag_sql = mysql_query("SELECT tag.name FROM tasktag,tag WHERE tasktag.id_task = '$id' and tag.id_tag = tasktag.id_tag");
			
			if (mysql_num_rows($tag_sql) > 0) {
            $result = array();
            while ($rlt = mysql_fetch_array($tag_sql, MYSQL_ASSOC)) {
                $result[] = $rlt;
            }
        }
						
			$this->response($this->json($result),200);
		}		

		public function authenticate(){
		
			$usr=$this->_request["usr"];
			$psw=$this->_request["psw"];
			
			$num_row_query = "SELECT * FROM user WHERE username='$usr' AND password='$psw'";
			
			$data = mysql_query( $num_row_query);
			$result = mysql_fetch_array($data);
			$row_cnt = mysql_num_rows($data);
			
			if($row_cnt > 0){
				//SET SESSION
				session_start();
				$_SESSION['username'] = $result['username'];
				$_SESSION['fullname'] = $result['fullname'];
				$_SESSION['birthday'] = $result['birthday'];
				$_SESSION['password'] = $result['password'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['IsEdit'] = false;
				//SET COOKIES, EXPIRED 30 DAYS
				$expire=time()+60*60*24*30;
				setcookie("username", $result['username'], $expire);
				setcookie("fullname", $result['fullname'], $expire);
				setcookie("birthday", $result['birthday'], $expire);
				setcookie("password", $result['password'], $expire);
				setcookie("email", $result['email'], $expire);
			}
			/* close connection */
			//$mysqli->close();
			echo $row_cnt;
		}
		
		public function autoassignee(){
			$q=$this->_request["q"];

			if(strlen($q) > 0){
				$hint="";
				$sql="SELECT username FROM user WHERE username LIKE '%$q%'";
				$user = mysql_query($sql);
				$hasiluser = array();
				while(($user != null) && ($current_user = mysql_fetch_array($user)))
				{
					$hasiluser[] = $current_user['username'];
				}
				
				if (count($hasiluser) > 0)
				{
					for($i=0; $i<count($hasiluser); $i++)
					{
						if (strtolower($q)==strtolower(substr($hasiluser[$i],0,strlen($q))))
						{
							$hint .= "<br>".$hasiluser[$i];
						}
					}
					//$hint.=",";
				}
				if ($hint == ""){
					$response="";
				}else{
					$response=$hint;
				}
				//output the response
				echo $response;
			}
		}
		
		public function autotag(){
					
			$q=$this->_request["q"];
			require "config.php";

			if(strlen($q) > 0){
				$hint="";
				$sql="SELECT name FROM tag WHERE name LIKE '%$q%'";
				$tag = mysql_query($sql);
				$hasiltag = array();
				while(($tag != null) && ($current_tag = mysql_fetch_array($tag)))
				{
					$hasiltag[] = $current_tag['name'];
				}
				
				if (count($hasiltag) > 0)
				{
					for($i=0; $i<count($hasiltag); $i++)
					{
						if (strtolower($q)==strtolower(substr($hasiltag[$i],0,strlen($q))))
						{
							$hint .= "<br>".$hasiltag[$i];
						}
					}
					//$hint.=",";
				}
				if ($hint == ""){
					$response="";
				}else{
					$response=$hint;
				}
				//output the response
				echo $response;
			}
		}
		
		public function autoassignee(){
			$q=$this->_request["q"];

			if(strlen($q) > 0){
				$hint="";
				$sql="SELECT username FROM user WHERE username LIKE '%$q%'";
				$user = mysql_query($sql);
				$hasiluser = array();
				while(($user != null) && ($current_user = mysql_fetch_array($user)))
				{
					$hasiluser[] = $current_user['username'];
				}
				
				if (count($hasiluser) > 0)
				{
					for($i=0; $i<count($hasiluser); $i++)
					{
						if (strtolower($q)==strtolower(substr($hasiluser[$i],0,strlen($q))))
						{
							$hint .= "<br>".$hasiluser[$i];
						}
					}
					//$hint.=",";
				}
				if ($hint == ""){
					$response="";
				}else{
					$response=$hint;
				}
				//output the response
				echo $response;
			}
		}
		
		//END OF MAMON
		
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>