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
			
		public function showTags(){
			$username = "ArieDoank";
			$id_task =$this->_request['q'];
			$result = "";
			
			$sql_tags = "SELECT * FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task = '$id_task')";
			$tags = mysql_query($sql_tags);
			
				while(($tags != null) && ($tags_fetched = mysql_fetch_array($tags))){
					$result .= $tags_fetched['name'].",";
				}	
			
			echo $result;
		}
		
		public function hapusKategori(){
			$nameCat =$this->_request['q'];
			$sql = "SELECT id_cat FROM category WHERE name = '$nameCat'";
			$user = mysql_query($sql);
			$data = mysql_fetch_array($user);
			$idCat = $data['id_cat'];
			
			$sql2 = "SELECT id_task FROM task WHERE id_cat = '$idCat'";
			$user2 = mysql_query($sql2);
			while(($user2 != null) && ($data2 = mysql_fetch_array($user2)))
			{
				$idTask = $data2['id_task'];
				$sqla = "DELETE FROM assignee WHERE id_task='$idTask'";
				$sqlb = "DELETE FROM comment WHERE id_task='$idTask'";
				$sqlc = "DELETE FROM task WHERE id_task='$idTask'";
				$sqld = "DELETE FROM taskattachment WHERE id_task='$idTask'";
				$sqle = "DELETE FROM tasktag WHERE id_task='$idTask'";

				mysql_query($sqla);
				mysql_query($sqlb);
				mysql_query($sqlc);
				mysql_query($sqld);
				mysql_query($sqle);
			}
			
			$sql3 = "DELETE FROM category WHERE id_cat = '$idCat'";
			$sql4 = "DELETE FROM joincategory WHERE id_cat = '$idCat'";
			$sql5 = "DELETE FROM categorycreator WHERE id_cat = '$idCat'";
			mysql_query($sql3);
			mysql_query($sql4);
			mysql_query($sql5);
			
			echo $nameCat;
		}
		
		public function hapusTask(){
			$idTask = $this->_request['q'];

			$sql1 = "DELETE FROM assignee WHERE id_task='$idTask'";
			$sql2 = "DELETE FROM comment WHERE id_task='$idTask'";
			$sql3 = "DELETE FROM task WHERE id_task='$idTask'";
			$sql4 = "DELETE FROM taskattachment WHERE id_task='$idTask'";
			$sql5 = "DELETE FROM tasktag WHERE id_task='$idTask'";
			
			mysql_query($sql1);
			mysql_query($sql2);
			mysql_query($sql3);
			mysql_query($sql4);
			mysql_query($sql5);
			
			echo "deleted";
		}
		
		public function checkTask(){
			$idtask = $this->_request['q'];
			$hint = "";
			$sql = "SELECT status FROM task WHERE id_task = '$idtask'";
			$user = mysql_query($sql);
			$status = mysql_fetch_array($user);
			
			if ($status['status'] == 0)
			{
				$sql2 = "UPDATE task SET status='1' WHERE id_task = '$idtask'";
				mysql_query($sql2);
				$hint = "tugas done";
			} else if ($status['status'] == 1)
			{
				$sql2 = "UPDATE task SET status='0' WHERE id_task = '$idtask'";
				mysql_query($sql2);
				$hint = "tugas undone";
			}
			
			if ($hint == "")
			{
				$response="";
			}
			else
			{
			  $response=$hint;
			}
			
			echo $response;
		}
		
		public function showStatus(){
			$id_task = $this->_request["id"];
			//$username = $_SESSION['username'];
			
			$result = "";
			
			//PLEASE CHANGE EndyDoank with $username!!!!!!!!!!!!!!!!!
			$sql_status = "SELECT * FROM task WHERE id_task='$id_task'";
			$status = mysql_query($sql_status);
			$status_fetched = mysql_fetch_array($status);
			
			$result .= $status_fetched['id_task'].",".$status_fetched['status'];
			
			echo $result;
		}
		
		public function showAssignee(){
			//include "login.php";
			//$username = $_SESSION['username'];
			$username = "ArieDoank";
			$id_task = $this->_request['q'];
			
			$result = "";
			
			//ALL IN DUMMY HERE
			$sql_assignee = "SELECT * FROM assignee WHERE id_task = '$id_task'";
			$assignee = mysql_query($sql_assignee);
			
			while(($assignee != null) && ($assignee_fetched = mysql_fetch_array($assignee))){
				$result .= $assignee_fetched['username'].",";
			}
			
			echo $result;
		}
		
		public function showAttachment(){
			//include "login.php";
			//$username = $_SESSION['username'];
			$username = "ArieDoank";
			$id_task = $this->_request['q'];
			
			$result = "";
			
			//ALL IN DUMMY HERE
			$sql_attachment = "SELECT * FROM attachment WHERE id_attachment in (SELECT id_attachment FROM taskattachment WHERE id_task = '$id_task')";
			$attachment = mysql_query($sql_attachment);
			
			while(($attachment != null) && ($attachment_fetched = mysql_fetch_array($attachment))){
				$result .= $attachment_fetched['path'].",";
			}
			
			echo $result;
		}
		
		public function showComment(){
			//include "login.php";
			//$username = $_SESSION['username'];
			$username = "ArieDoank";
			$id_task = $this->_request['q'];
			
			$result = "";
			
			//ALL DUMMY HERE!
			$sql_comment = "SELECT * FROM comment WHERE id_task='$id_task'";
			$comment = mysql_query($sql_comment);
			
			while(($comment != null) && ($comment_fetched = mysql_fetch_array($comment))){
				$cur_username = $comment_fetched['username'];
				
				$sql_avatar = "SELECT * FROM user WHERE username = '$cur_username'";
				$avatar = mysql_query($sql_avatar);
				$avatar_fetched = mysql_fetch_array($avatar);
				
				$result .= "<br>".$avatar_fetched['avatar'].",".$comment_fetched['time'].",".$comment_fetched['content'].",".$comment_fetched['username'].",$cur_username,".$comment_fetched['id_comment'];
			}
			
			echo $result;
		}
		
		public function hapusComment(){
			//include "login.php";
			
			$id_comment = $this->_request['q'];
			
			$sql_del = "DELETE FROM comment WHERE id_comment='$id_comment'";
			mysql_query($sql_del);
			
			echo "deleted";
		}
		
		public function storeComment(){
			//include "login.php";
			//$username = $_SESSION['username'];
			$username = "ArieDoank";
			$id_task = $this->_request['id'];
			$q = $this->_request['q']; //comment
			$tanggal = getdate();
			$current_date = "";
			$current_date .= ($tanggal['hours']-6)." : ".$tanggal['minutes']." - ".$tanggal['mday']."/".$tanggal['mon'];
			
			require "config.php";
			$result = "";
			
			$sql_user = "SELECT pemilik FROM task WHERE id_task='$id_task'";
			$user = mysql_query($sql_user);
			$user_fetched = mysql_fetch_array($user);
			$pemilik = $user_fetched['pemilik'];
			
			//ALL IN DUMMY HERE
			if($update_comment = "INSERT INTO `comment`(`id_task`, `username`, `time`, `content`) VALUES ('$id_task','$pemilik','$current_date','$q')"){
				mysql_query($update_comment);
				echo "";
			}else{
				echo "a";
			}
		}
		
		
		public function showTask(){
			//include "login.php";
			//$username = $_SESSION['username'];
			$username = "ArieDoank";
			$q=$this->_request['q'];
			$hasil = "";
			if ($q == "0")
			{	
				$sql = "SELECT * FROM task WHERE id_task in (SELECT id_task FROM assignee WHERE username='$username')";
				$user = mysql_query($sql);
				while(($user != null) && ($data = mysql_fetch_array($user)))
				{
					$idtask = $data['id_task'];
					$sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
					$user2 = mysql_query($sql2);
					$tag = array();
					while(($user2 != null) && ($data2 = mysql_fetch_array($user2)))
					{
						$tag[] = $data2['name'];
					}
					$hasil .= "<br>".$data['name'].",".$data['deadline'].",".$data['status'].",".$data['id_task'];
					
					if ($username == $data['pemilik'])
					{
						$hasil .= ",yes";
					}
					else
					{
						$hasil .= ",no";
					}
					
					for($i = 0; $i < count($tag); $i++)
					{
						$hasil .= ",".$tag[$i];
					}
				}
			} else
			{
				$sql3 = "SELECT username FROM categorycreator WHERE id_cat in (SELECT id_cat FROM category WHERE name='$q')";
				$user3 = mysql_query($sql3);
				$data3 = mysql_fetch_array($user3);
				
				if ($data3['username'] == $username){
					$pembuatkategori = "creator";
				}
				else $pembuatkategori = "noncreator";
					
				$hasil .= $pembuatkategori;
			
				$sql = "SELECT task.id_task as id_task,task.name as name,task.deadline as deadline,task.status as status,task.pemilik as pemilik FROM assignee INNER JOIN task ON assignee.id_task = task.id_task WHERE username='$username' AND task.id_cat in (SELECT id_cat FROM category WHERE name='$q')";
				$user = mysql_query($sql);
				while(($user != null) && ($data = mysql_fetch_array($user)))
				{
					$idtask = $data['id_task'];
					$sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
					$user2 = mysql_query($sql2);
					$tag = array();
					while(($user2 != null) && ($data2 = mysql_fetch_array($user2)))
					{
						$tag[] .= $data2['name'];
					}
					
					$hasil .= "<br>".$data['name'].",".$data['deadline'].",".$data['status'].",".$data['id_task'];
					
					if ($username == $data['pemilik'])
					{
						$hasil .= ",yes";
					}
					else
					{
						$hasil .= ",no";
					}
					
					for($i = 0; $i < count($tag); $i++)
					{
						$hasil .= ",".$tag[$i];
					}
				}
			}
			
			if ($hasil == "")
			{
				$response="";
			}
			else
			{
			  $response=$hasil;
			}

			//output the response
			echo $response;
		}
		
		public function ubahtask(){
			$id_task = $this->_request['idtask'];
			//dummy here
			$username = "ArieDoank";
			$deadline = $this->_request['deadline'];
			$assignee = $this->_request['Assignee'];
			$updatedeadline = "UPDATE task SET deadline='$deadline' WHERE id_task='$id_task'";
			mysql_query($updatedeadline);
			//id cat
			$search_cat_sql = "SELECT id_cat FROM task where id_task='$id_task'";
			$search_result = mysql_query($search_cat_sql);
			$cat = mysql_fetch_array($search_result);
			$id_cat = $cat['id_cat'];
			
			//delete semua assignee yg berhub dgn task kecuali task creator
			$delassquery = "DELETE FROM assignee WHERE id_task='$id_task'";
			mysql_query($delassquery);
			//cari creator
			$searchcreator = "SELECT pemilik from task where id_task='$id_task'";
			$creator_result = mysql_query($searchcreator);
			$creator = mysql_fetch_array($creator_result);
			$id_creator = $creator['pemilik'];
			
			$sqlassignee = "INSERT INTO assignee(`username`, `id_task`) VALUES ('$id_creator','$id_task')";
			mysql_query($sqlassignee);
			
			//delete semua tag yg berhub dgn task
			$deltagquery = "DELETE FROM tasktag WHERE tasktag.id_task='$id_task'";
			mysql_query($deltagquery);
			$array_assignee = explode(",",$assignee);
			$arraylength1 = count($array_assignee);
			for($i=0;$i<$arraylength1-1;$i++)
				{
					$sqlassignee = "REPLACE INTO assignee SET username='$array_assignee[$i]', id_task='$id_task'";
					mysql_query($sqlassignee);
					//insert ke kategori
					$sqljoincat = "REPLACE INTO joincategory SET username='$array_assignee[$i]', id_cat='$id_cat'";
					mysql_query($sqljoincat);
				}
			
			$tag = $_POST['tag'];
			$array_tag = explode(",",$tag);
			$arraylength2 = count($array_tag);
			for($j=0;$j<$arraylength2;$j++)
				{
					$searchtagsql = "SELECT name FROM tag WHERE name='$array_tag[$j]'";
					if($getsearchtagresult = mysql_query($searchtagsql)){
						$row_count = mysqli_num_rows($getsearchtagresult);
					}
					if($row_count===0){
						$sqltag = "INSERT INTO tag(`name`) VALUES ('$array_tag[$j]')";
						mysql_query($sqltag);
					}
					//cari id_tag
					$search_idtag_sql = "SELECT id_tag FROM tag where name='$array_tag[$j]'";
					$search_idtag_result = mysql_query($search_idtag_sql);
					$searchtag = mysql_fetch_array($search_idtag_result);
					$id_tag = $searchtag['id_tag'];
					//insert tasktag
					$sqltasktag = "INSERT INTO tasktag(`id_task`, `id_tag`) VALUES ('$id_task','$id_tag')";
					mysql_query($sqltasktag);
				}
			header("Location: rincitask.php?idtask=$id_task");
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