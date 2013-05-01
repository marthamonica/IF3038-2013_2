<?php

require_once("Rest.inc.php");

class API extends REST {

    public $data = "";

    const DB_SERVER = "localhost";
    const DB_USER = "progin";
    const DB_PASSWORD = "progin";
    const DB = "progin_405_13510032";

    private $db = NULL;

    public function __construct() {
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
    }

    /*
     *  Database connection 
     */

    private function dbConnect() {
        $this->db = mysql_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD);
        if ($this->db)
            mysql_select_db(self::DB, $this->db);
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */

    public function processApi() {
        if (isset($_REQUEST['rquest'])) {
            $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));

            if ((int) method_exists($this, $func) > 0)
                $this->$func();
            else
                $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
        }else {
            print "no request<br/>";
        }
    }

    public function edit() {
        $username = $_GET['username'];
        $editfullname = $_GET['editname'];
        $editdob = $_GET['editdob'];
        $editpassword = $_GET['editpassword1'];
        $edit_sql = "UPDATE user SET fullname='$editfullname', birthday='$editdob',password='$editpassword' WHERE username ='$username'";
        mysql_query($edit_sql);
        $this->response("OK", 200);
    }

    public function profile() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $usr = $this->_request['username'];
        $sql1 = mysql_query("SELECT * FROM user WHERE username = '$usr'");
        $result1 = mysql_fetch_array($sql1, MYSQL_ASSOC);
        $this->response($this->json($result1), 200);
    }

    public function getDoneList() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $usr = $this->_request['username'];
        $sql1 = mysql_query("SELECT task.name,task.id_task FROM task, assignee WHERE status='1' and username='$usr' and assignee.id_task = task.id_task");
        if (mysql_num_rows($sql1) > 0) {
            $result = array();
            while ($rlt = mysql_fetch_array($sql1, MYSQL_ASSOC)) {
                $result[] = $rlt;
            }
        }
        $this->response($this->json($result), 200);
    }

    public function getUndoneList() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $usr = $this->_request['username'];
        $sql1 = mysql_query("SELECT task.name,task.id_task FROM task, assignee WHERE status='0' and username='$usr' and assignee.id_task = task.id_task");
        if (mysql_num_rows($sql1) > 0) {
            $result = array();
            while ($rlt = mysql_fetch_array($sql1, MYSQL_ASSOC)) {
                $result[] = $rlt;
            }
        }
        $this->response($this->json($result), 200);
    }

    public function autosearch() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $username = $this->_request['username'];
        $q = $this->_request['q'];
        $tipe = $this->_request['tipe'];
        if (strlen($q) > 0) {
            $hint = "";
            if ($tipe == "all result") {
                $sql = "SELECT name FROM task WHERE name LIKE '%$q%' AND id_task in (SELECT id_task FROM assignee WHERE username='$username')";
                $user = mysql_query($sql);
                $hasiltask = array();
                while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                    $hasiltask[] = $current_user['name'];
                }

                if (count($hasiltask) > 0) {
                    $hint = "task";
                    for ($i = 0; $i < count($hasiltask); $i++) {
                        if (strtolower($q) == strtolower(substr($hasiltask[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasiltask[$i];
                        }
                    }
                    $hint .= ",";
                }

                $sql = "SELECT username FROM user WHERE username LIKE '%$q%'";
                $user = mysql_query($sql);
                $hasiluser = array();
                while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                    $hasiluser[] = $current_user['username'];
                }

                if (count($hasiluser) > 0) {
                    $hint.="user";
                    for ($i = 0; $i < count($hasiluser); $i++) {
                        if (strtolower($q) == strtolower(substr($hasiluser[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasiluser[$i];
                        }
                    }
                    $hint.=",";
                }

                $sql = "SELECT name FROM category WHERE name LIKE '%$q%' AND id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE name LIKE '%$q%' AND username='$username')";
                $user = mysql_query($sql);
                $hasilkategori = array();
                while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                    $hasilkategori[] = $current_user['name'];
                }

                if (count($hasilkategori) > 0) {
                    $hint.="kategori";
                    for ($i = 0; $i < count($hasilkategori); $i++) {
                        if (strtolower($q) == strtolower(substr($hasilkategori[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasilkategori[$i];
                        }
                    }
                }
            } else if ($tipe == "username") {
                $sql = "SELECT username FROM user WHERE username LIKE '%$q%'";
                $user = mysql_query($sql);
                $hasiluser = array();
                while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                    $hasiluser[] = $current_user['username'];
                }

                if (count($hasiluser) > 0) {
                    $hint = "user";
                    for ($i = 0; $i < count($hasiluser); $i++) {
                        if (strtolower($q) == strtolower(substr($hasiluser[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasiluser[$i];
                        }
                    }
                }
            } else if ($tipe == "task") {
                $sql = "SELECT name FROM task WHERE name LIKE '%$q%' AND id_task in (SELECT id_task FROM assignee WHERE username='$username')";
                $user = mysql_query($sql);
                $hasiltask = array();
                while (($user != null) && ($current_user = mysqli_fetch_array($user, MYSQL_ASSOC))) {
                    $hasiltask[] = $current_user['name'];
                }

                if ($hasiltask) {
                    $hint = "task";
                    for ($i = 0; $i < count($hasiltask); $i++) {
                        if (strtolower($q) == strtolower(substr($hasiltask[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasiltask[$i];
                        }
                    }
                }
            } else if ($tipe == "category") {
                $sql = "SELECT name FROM category WHERE name LIKE '%$q%' AND id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE name LIKE '%$q%' AND username='$username')";
                $user = mysql_query($sql);
                $hasilkategori = array();
                while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                    $hasilkategori[] = $current_user['name'];
                }

                if (count($hasilkategori) > 0) {
                    $hint = "kategori";
                    for ($i = 0; $i < count($hasilkategori); $i++) {
                        if (strtolower($q) == strtolower(substr($hasilkategori[$i], 0, strlen($q)))) {
                            $hint .= "<br>" . $hasilkategori[$i];
                        }
                    }
                }
            }
            if ($hint == "") {
                $response = "";
            } else {
                $response = $hint;
            }
            echo $response;
        }
    }

    public function updateSearch() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        // $username = $_SESSION['username'];
        $username = $this->_request['username'];
        $text = $this->_request['q'];
        $tipefilter = $this->_request['t'];
        $posisi = $this->_request['p'];
        $hint = array();
        $tambahan = "";
        if ($tipefilter == "all result") {
            $sql = "SELECT DISTINCT task.id_task as id_task,task.name as name,task.deadline as deadline, task.status as status FROM (task LEFT OUTER JOIN tasktag ON task.id_task = tasktag.id_task) LEFT OUTER JOIN tag ON tasktag.id_tag = tag.id_tag LEFT OUTER JOIN comment ON task.id_task = comment.id_task LEFT OUTER JOIN assignee ON task.id_task = assignee.id_task WHERE (task.name LIKE '%$text%' or tag.name LIKE '%$text%' or comment.content LIKE '%$text%') AND assignee.username = '$username'";
            $user = mysql_query($sql);
            $k = 0;
            $j = 0;
            $hint [$j] = "";
            $hint [$j] .= "task";
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['id_task'] . "," . $current_user['name'] . "," . $current_user['deadline'] . "," . $current_user['status'];
                $idtask = $current_user['id_task'];
                $sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
                $user2 = mysql_query($sql2);
                $tag = array();
                while (($user2 != null) && ($data2 = mysql_fetch_array($user2, MYSQL_ASSOC))) {
                    $tag[] = $data2['name'];
                }
                for ($i = 0; $i < count($tag); $i++) {
                    $hint[$j] .= "," . $tag[$i];
                }
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint [$j] = "task";
                }
                $k++;
            }
            $hint [$j] .= "<x>";
            $hint [$j] .= "username";
            $sql = "SELECT DISTINCT username,fullname,avatar FROM user WHERE username LIKE '%$text%' or fullname LIKE '%$text%' or birthday LIKE '%$text%' or email LIKE '%$text%'";
            $user = mysql_query($sql);
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['username'] . "," . $current_user['fullname'] . "," . $current_user['avatar'];
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint[$j] = "username";
                }
                $k++;
            }
            $hint [$j] .= "<x>";
            $hint [$j] .= "kategory";
            $sql = "SELECT DISTINCT name FROM category WHERE name LIKE '%$text%' AND id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE name LIKE '%$text%' AND username='$username')";
            $user = mysql_query($sql);
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['name'];
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint[$j] = "kategori";
                }
                $k++;
            }
            //$hint [$j] .= "<x>";
            if ($posisi < $j) {
                $num = $posisi + 1;
            }
            else
                $num = $posisi;
            if ($posisi > 0) {
                $numback = $posisi;
            }
            else
                $numback = 0;
            $tambahan .= "<x>" . $numback . "," . $num;
        }
        else if ($tipefilter == "username") {
            $sql = "SELECT DISTINCT username,fullname,avatar FROM user WHERE username LIKE '%$text%' or fullname LIKE '%$text%' or birthday LIKE '%$text%' or email LIKE '%$text%'";
            $user = mysql_query($sql);
            $k = 0;
            $j = 0;
            $hint [$j] = "";
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['username'] . "," . $current_user['fullname'] . "," . $current_user['avatar'];
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint [$j] = "";
                }
                $k++;
            }

            if ($posisi < $j) {
                $num = $posisi + 1;
            }
            else
                $num = $posisi;
            if ($posisi > 0) {
                $numback = $posisi;
            }
            else
                $numback = 0;
            $tambahan .= "<br>" . $numback . "," . $num;
        }
        else if ($tipefilter == "category") {
            $sql = "SELECT DISTINCT name FROM category WHERE name LIKE '%$text%' AND id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE name LIKE '%$text%' AND username='$username')";
            $user = mysql_query($sql);
            $k = 0;
            $j = 0;
            $hint [$j] = "";
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['name'];
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint [$j] = "";
                }
                $k++;
            }
            if ($posisi < $j) {
                $num = $posisi + 1;
            }
            else
                $num = $posisi;
            if ($posisi > 0) {
                $numback = $posisi;
            }
            else
                $numback = 0;
            $tambahan .= "<br>" . $numback . "," . $num;
        }
        else if ($tipefilter == "task") {
            $sql = "SELECT DISTINCT task.id_task as id_task,task.name as name,task.deadline as deadline, task.status as status FROM (task LEFT OUTER JOIN tasktag ON task.id_task = tasktag.id_task) LEFT OUTER JOIN tag ON tasktag.id_tag = tag.id_tag LEFT OUTER JOIN comment ON task.id_task = comment.id_task LEFT OUTER JOIN assignee ON task.id_task = assignee.id_task WHERE (task.name LIKE '%$text%' or tag.name LIKE '%$text%' or comment.content LIKE '%$text%') AND assignee.username = '$username'";
            $user = mysql_query($sql);
            $k = 0;
            $j = 0;
            $hint [$j] = "";
            while (($user != null) && ($current_user = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $hint[$j] .= "<br>" . $current_user['id_task'] . "," . $current_user['name'] . "," . $current_user['deadline'] . "," . $current_user['status'];

                $idtask = $current_user['id_task'];
                $sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
                $user2 = mysql_query($sql2);
                $tag = array();
                while (($user2 != null) && ($data2 = mysql_fetch_array($user2, MYSQL_ASSOC))) {
                    $tag[] = $data2['name'];
                }
                for ($i = 0; $i < count($tag); $i++) {
                    $hint[$j] .= "," . $tag[$i];
                }
                if (($k + 1) % 10 == 0) {
                    $j++;
                    $hint [$j] = "";
                }
                $k++;
            }
            if ($posisi < $j) {
                $num = $posisi + 1;
            }
            else
                $num = $posisi;
            if ($posisi > 0) {
                $numback = $posisi;
            }
            else
                $numback = 0;
            $tambahan .= "<br>" . $numback . "," . $num;
        }
        //output the response
        echo $hint[$posisi] . $tambahan;
    }

    public function authentication() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }

        $usr = $this->_request['usr'];
        $psw = $this->_request['psw'];

        $sql = "SELECT * FROM user WHERE username='$usr' AND password='$psw'";
        $user = mysql_query($sql);

        echo mysql_num_rows($user);
    }

    public function showTask() {
        $username = $this->_request['username'];
        $q = $this->_request['q'];
        $hasil = "";
        if ($q == "0") {
            $sql = "SELECT * FROM task WHERE id_task in (SELECT id_task FROM assignee WHERE username='$username')";
            $user = mysql_query($sql);
            while (($user != null) && ($data = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $idtask = $data['id_task'];
                $sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
                $user2 = mysql_query($sql2);
                $tag = array();
                while (($user2 != null) && ($data2 = mysql_fetch_array($user2, MYSQL_ASSOC))) {
                    $tag[] = $data2['name'];
                }
                $hasil .= "<br>" . $data['name'] . "," . $data['deadline'] . "," . $data['status'] . "," . $data['id_task'];

                if ($username == $data['pemilik']) {
                    $hasil .= ",yes";
                } else {
                    $hasil .= ",no";
                }

                for ($i = 0; $i < count($tag); $i++) {
                    $hasil .= "," . $tag[$i];
                }
            }
        } else {
            $sql3 = "SELECT username FROM categorycreator WHERE id_cat in (SELECT id_cat FROM category WHERE name='$q')";
            $user3 = mysql_query($sql3);
            $data3 = mysql_fetch_array($user3, MYSQL_ASSOC);

            if ($data3['username'] == $username) {
                $pembuatkategori = "creator";
            }
            else
                $pembuatkategori = "noncreator";

            $hasil .= $pembuatkategori;

            $sql = "SELECT task.id_task as id_task,task.name as name,task.deadline as deadline,task.status as status,task.pemilik as pemilik FROM assignee INNER JOIN task ON assignee.id_task = task.id_task WHERE username='$username' AND task.id_cat in (SELECT id_cat FROM category WHERE name='$q')";
            $user = mysql_query($sql);
            while (($user != null) && ($data = mysql_fetch_array($user, MYSQL_ASSOC))) {
                $idtask = $data['id_task'];
                $sql2 = "SELECT name FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task='$idtask')";
                $user2 = mysql_query($sql2);
                $tag = array();
                while (($user2 != null) && ($data2 = mysql_fetch_array($user2, MYSQL_ASSOC))) {
                    $tag[] .= $data2['name'];
                }

                $hasil .= "<br>" . $data['name'] . "," . $data['deadline'] . "," . $data['status'] . "," . $data['id_task'];

                if ($username == $data['pemilik']) {
                    $hasil .= ",yes";
                } else {
                    $hasil .= ",no";
                }

                for ($i = 0; $i < count($tag); $i++) {
                    $hasil .= "," . $tag[$i];
                }
            }
        }

        if ($hasil == "") {
            $response = "";
        } else {
            $response = $hasil;
        }

        //output the response
        echo $response;
    }

    public function allkategori() {
        $username = $this->_request['username'];
        $sql = "SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM joincategory WHERE username='$username') UNION SELECT name FROM category WHERE id_cat in (SELECT id_cat FROM categorycreator WHERE username='$username')";
        $user = mysql_query($sql);
        $hasil = "";
        while (($user != null) && ($data = mysql_fetch_array($user, MYSQL_ASSOC))) {
            $hasil .= "<br>" . $data['name'];
        }

        if ($hasil == "") {
            $response = "";
        } else {
            $response = $hasil;
        }

        //output the response
        echo $response;
    }

    public function getuser() {
        $username = $this->_request['q'];
        $row_cnt = 0;
        $getusername_sql = "SELECT username FROM user WHERE username = '$username'";
        if ($getuser_result = mysql_query($getusername_sql)) {
            /* determine number of rows result set */
            $row_cnt = mysql_num_rows($getuser_result);
        }
        echo $row_cnt;
    }

    public function getemail() {
        $email = $this->_request['q'];
        $getemail_sql = "SELECT username FROM user WHERE email = '$email'";
        if ($getemail_result = mysql_query($getemail_sql)) {
            /* determine number of rows result set */
            $row_cnt = mysql_num_rows($getemail_result);
        }
        echo $row_cnt;
    }

    public function autotag() {

        $q = $this->_request["q"];
        require "config.php";

        if (strlen($q) > 0) {
            $hint = "";
            $sql = "SELECT name FROM tag WHERE name LIKE '%$q%'";
            $tag = mysql_query($sql);
            $hasiltag = array();
            while (($tag != null) && ($current_tag = mysql_fetch_array($tag))) {
                $hasiltag[] = $current_tag['name'];
            }

            if (count($hasiltag) > 0) {
                for ($i = 0; $i < count($hasiltag); $i++) {
                    if (strtolower($q) == strtolower(substr($hasiltag[$i], 0, strlen($q)))) {
                        $hint .= "<br>" . $hasiltag[$i];
                    }
                }
                //$hint.=",";
            }
            if ($hint == "") {
                $response = "";
            } else {
                $response = $hint;
            }
            //output the response
            echo $response;
        }
    }

    public function autoassignee() {
        $q = $this->_request["q"];

        if (strlen($q) > 0) {
            $hint = "";
            $sql = "SELECT username FROM user WHERE username LIKE '%$q%'";
            $user = mysql_query($sql);
            $hasiluser = array();
            while (($user != null) && ($current_user = mysql_fetch_array($user))) {
                $hasiluser[] = $current_user['username'];
            }

            if (count($hasiluser) > 0) {
                for ($i = 0; $i < count($hasiluser); $i++) {
                    if (strtolower($q) == strtolower(substr($hasiluser[$i], 0, strlen($q)))) {
                        $hint .= "<br>" . $hasiluser[$i];
                    }
                }
                //$hint.=",";
            }
            if ($hint == "") {
                $response = "";
            } else {
                $response = $hint;
            }
            //output the response
            echo $response;
        }
    }

    // MAMON

    public function rincitugas() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $id = $this->_request['idtask'];

        $sql_task = mysql_query("SELECT * FROM task WHERE id_task='$id'");
        $current_task = mysql_fetch_array($sql_task, MYSQL_ASSOC);
        $this->response($this->json($current_task), 200);
    }

    public function curtask() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
        }
        $id = $this->_request['idtask'];

        $task_sql = mysql_query("SELECT * FROM task WHERE id_task = '$id'");
        $cur_task = mysql_fetch_array($task_sql, MYSQL_ASSOC);

        $this->response($this->json($cur_task), 200);
    }

    public function curassigne() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
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

        $this->response($this->json($result), 200);
    }

    public function curtag() {
        if ($this->get_request_method() != "GET") {
            $this->response('', 406);     // IF not GET method
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

        $this->response($this->json($result), 200);
    }

    public function autotag() {

        $q = $this->_request["q"];
        require "config.php";

        if (strlen($q) > 0) {
            $hint = "";
            $sql = "SELECT name FROM tag WHERE name LIKE '%$q%'";
            $tag = mysql_query($sql);
            $hasiltag = array();
            while (($tag != null) && ($current_tag = mysql_fetch_array($tag))) {
                $hasiltag[] = $current_tag['name'];
            }

            if (count($hasiltag) > 0) {
                for ($i = 0; $i < count($hasiltag); $i++) {
                    if (strtolower($q) == strtolower(substr($hasiltag[$i], 0, strlen($q)))) {
                        $hint .= "<br>" . $hasiltag[$i];
                    }
                }
                //$hint.=",";
            }
            if ($hint == "") {
                $response = "";
            } else {
                $response = $hint;
            }
            //output the response
            echo $response;
        }
    }

    public function autoassignee() {
        $q = $this->_request["q"];

        if (strlen($q) > 0) {
            $hint = "";
            $sql = "SELECT username FROM user WHERE username LIKE '%$q%'";
            $user = mysql_query($sql);
            $hasiluser = array();
            while (($user != null) && ($current_user = mysql_fetch_array($user))) {
                $hasiluser[] = $current_user['username'];
            }

            if (count($hasiluser) > 0) {
                for ($i = 0; $i < count($hasiluser); $i++) {
                    if (strtolower($q) == strtolower(substr($hasiluser[$i], 0, strlen($q)))) {
                        $hint .= "<br>" . $hasiluser[$i];
                    }
                }
                //$hint.=",";
            }
            if ($hint == "") {
                $response = "";
            } else {
                $response = $hint;
            }
            //output the response
            echo $response;
        }
    }

    public function showTags() {
        $username = "ArieDoank";
        $id_task = $this->_request['q'];
        $result = "";

        $sql_tags = "SELECT * FROM tag WHERE id_tag in (SELECT id_tag FROM tasktag WHERE id_task = '$id_task')";
        $tags = mysql_query($sql_tags);

        while (($tags != null) && ($tags_fetched = mysql_fetch_array($tags))) {
            $result .= $tags_fetched['name'] . ",";
        }

        echo $result;
    }

    public function hapusKategori() {
        $nameCat = $this->_request['q'];
        $sql = "SELECT id_cat FROM category WHERE name = '$nameCat'";
        $user = mysql_query($sql);
        $data = mysql_fetch_array($user);
        $idCat = $data['id_cat'];

        $sql2 = "SELECT id_task FROM task WHERE id_cat = '$idCat'";
        $user2 = mysql_query($sql2);
        while (($user2 != null) && ($data2 = mysql_fetch_array($user2))) {
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

    public function hapusTask() {
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

    public function checkTask() {
        $idtask = $this->_request['q'];
        $hint = "";
        $sql = "SELECT status FROM task WHERE id_task = '$idtask'";
        $user = mysql_query($sql);
        $status = mysql_fetch_array($user);

        if ($status['status'] == 0) {
            $sql2 = "UPDATE task SET status='1' WHERE id_task = '$idtask'";
            mysql_query($sql2);
            $hint = "tugas done";
        } else if ($status['status'] == 1) {
            $sql2 = "UPDATE task SET status='0' WHERE id_task = '$idtask'";
            mysql_query($sql2);
            $hint = "tugas undone";
        }

        if ($hint == "") {
            $response = "";
        } else {
            $response = $hint;
        }

        echo $response;
    }

    public function showStatus() {
        $id_task = $this->_request["id"];
        //$username = $_SESSION['username'];

        $result = "";

        //PLEASE CHANGE EndyDoank with $username!!!!!!!!!!!!!!!!!
        $sql_status = "SELECT * FROM task WHERE id_task='$id_task'";
        $status = mysql_query($sql_status);
        $status_fetched = mysql_fetch_array($status);

        $result .= $status_fetched['id_task'] . "," . $status_fetched['status'];

        echo $result;
    }

    public function showAssignee() {
        //include "login.php";
        //$username = $_SESSION['username'];
        $username = "ArieDoank";
        $id_task = $this->_request['q'];

        $result = "";

        //ALL IN DUMMY HERE
        $sql_assignee = "SELECT * FROM assignee WHERE id_task = '$id_task'";
        $assignee = mysql_query($sql_assignee);

        while (($assignee != null) && ($assignee_fetched = mysql_fetch_array($assignee))) {
            $result .= $assignee_fetched['username'] . ",";
        }

        echo $result;
    }

    public function showAttachment() {
        //include "login.php";
        //$username = $_SESSION['username'];
        $username = "ArieDoank";
        $id_task = $this->_request['q'];

        $result = "";

        //ALL IN DUMMY HERE
        $sql_attachment = "SELECT * FROM attachment WHERE id_attachment in (SELECT id_attachment FROM taskattachment WHERE id_task = '$id_task')";
        $attachment = mysql_query($sql_attachment);

        while (($attachment != null) && ($attachment_fetched = mysql_fetch_array($attachment))) {
            $result .= $attachment_fetched['path'] . ",";
        }

        echo $result;
    }

    public function showComment() {
        //include "login.php";
        //$username = $_SESSION['username'];
        $username = "ArieDoank";
        $id_task = $this->_request['q'];

        $result = "";

        //ALL DUMMY HERE!
        $sql_comment = "SELECT * FROM comment WHERE id_task='$id_task'";
        $comment = mysql_query($sql_comment);

        while (($comment != null) && ($comment_fetched = mysql_fetch_array($comment))) {
            $cur_username = $comment_fetched['username'];

            $sql_avatar = "SELECT * FROM user WHERE username = '$cur_username'";
            $avatar = mysql_query($sql_avatar);
            $avatar_fetched = mysql_fetch_array($avatar);

            $result .= "<br>" . $avatar_fetched['avatar'] . "," . $comment_fetched['time'] . "," . $comment_fetched['content'] . "," . $comment_fetched['username'] . ",$cur_username," . $comment_fetched['id_comment'];
        }

        echo $result;
    }

    public function hapusComment() {
        //include "login.php";

        $id_comment = $this->_request['q'];

        $sql_del = "DELETE FROM comment WHERE id_comment='$id_comment'";
        mysql_query($sql_del);

        echo "deleted";
    }

    public function storeComment() {
        //include "login.php";
        //$username = $_SESSION['username'];
        $username = "ArieDoank";
        $id_task = $this->_request['id'];
        $q = $this->_request['q']; //comment
        $tanggal = getdate();
        $current_date = "";
        $current_date .= ($tanggal['hours'] - 6) . " : " . $tanggal['minutes'] . " - " . $tanggal['mday'] . "/" . $tanggal['mon'];

        require "config.php";
        $result = "";

        $sql_user = "SELECT pemilik FROM task WHERE id_task='$id_task'";
        $user = mysql_query($sql_user);
        $user_fetched = mysql_fetch_array($user);
        $pemilik = $user_fetched['pemilik'];

        //ALL IN DUMMY HERE
        if ($update_comment = "INSERT INTO `comment`(`id_task`, `username`, `time`, `content`) VALUES ('$id_task','$pemilik','$current_date','$q')") {
            mysql_query($update_comment);
            echo "";
        } else {
            echo "a";
        }
    }

    public function ubahtask() {
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
        $array_assignee = explode(",", $assignee);
        $arraylength1 = count($array_assignee);
        for ($i = 0; $i < $arraylength1 - 1; $i++) {
            $sqlassignee = "REPLACE INTO assignee SET username='$array_assignee[$i]', id_task='$id_task'";
            mysql_query($sqlassignee);
            //insert ke kategori
            $sqljoincat = "REPLACE INTO joincategory SET username='$array_assignee[$i]', id_cat='$id_cat'";
            mysql_query($sqljoincat);
        }

        $tag = $_POST['tag'];
        $array_tag = explode(",", $tag);
        $arraylength2 = count($array_tag);
        for ($j = 0; $j < $arraylength2; $j++) {
            $searchtagsql = "SELECT name FROM tag WHERE name='$array_tag[$j]'";
            if ($getsearchtagresult = mysql_query($searchtagsql)) {
                $row_count = mysqli_num_rows($getsearchtagresult);
            }
            if ($row_count === 0) {
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
     * 	Encode array into JSON
     */

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}

// Initiiate Library

$api = new API;
$api->processApi();
?>