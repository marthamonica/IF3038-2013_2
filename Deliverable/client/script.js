/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var t = "0";

function createTask() {
    var regex = /^[a-zA-Z0-9]{5,25}$/;

    if ((regex.test(document.getElementById("namaTask").value))) {
        var k = document.getElementById("listtugas");
        k.innerHTML = "<a class='listTugas' onclick='showRinci();'><a class='listTugas' onclick='showRinci();'></a> <a class='listTugas' onclick='showRinci();'></a><a class='listTugas' onclick='showRinci();'></a><a class='listTugas' onclick='showRinci();'></a><a 	class='listTugas' onclick='showRinci();'></a><a class='listTugas' onclick='showRinci();'></a><a class='listTugas' onclick='showRinci();'></a><a onclick='showBuat()' class='addTask'></a>";
        document.getElementById("namaTask").value = 0;
        showList();
    } else {
        alert("task name must be 5-25 long");
    }
}

function addCat() {
    var k = document.getElementById("category");
    var l = document.getElementById("cate").value;
    if (l !== "") {
        k.innerHTML += "<div class='kategori' onclick='showList2();'>" + l + "</div>";
        restore();
        showList();
    } else {
        alert("Input category name");
    }
}

function addCategory() {
    var overlay = document.createElement("div");
    overlay.setAttribute("id", "overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);

    document.getElementById('add').style.display = 'block';
}

var clickable = false;

function Redirect() {
    window.location = "index.php";
}

function rinciRedirect(id){
	window.location = "rincitask.php?id="+id;
}

function edit() {
    if ((document.getElementById("regname").value.indexOf(" ") < 0)) {
        //alert("Name should be constructed by two or more words separated by space.");
    } else if ((document.getElementById("regpassword1").value.length < 8)) {
        alert("Password should be at least 8 characters long.");
    } else if ((document.getElementById("regpassword1").value !== document.getElementById("regpassword2").value)) {
        alert("Confirmed password and password are not the same.");
    }
}

function Submit() {
    if (clickable) {
        window.location = "Dashboard.php";
        localStorage.username = document.getElementById("regusername").value;
        localStorage.name = document.getElementById("regname").value;
        localStorage.date = document.getElementById("regdate").value;
        localStorage.email = document.getElementById("regemail").value;
        document.getElementById("foto").src = "img/foto_anonim.png";
    }
}

function auto_complete(str)
{
    document.getElementById("box").value = str;
    document.getElementById("hasilsearch").innerHTML = "";
    document.getElementById("hasilsearch").style.visibility = "none";
}

function showfilter() {
    document.getElementById("filter").style.height = "64px";
}

function hiddenfilter() {
    document.getElementById("filter").style.height = "0px";
}

function filter(str)
{
    document.getElementById("selectedKategori").value = str;
    document.getElementById("filter").style.height = "0px";
}

function showHint(str,username)
{
    if (str.length == 0)
    {
        document.getElementById("hasilsearch").innerHTML = "";
        document.getElementById("hasilsearch").style.visibility = "hidden";
        return;
    }

    var tipe = document.getElementById("selectedKategori").value;

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (tipe == "task") {
                var string = xmlhttp.responseText.split("<br>");
                var result = "";
                var check = true;
                result = "<ul>";
                if (string.length > 1)
                {
                    result += "<li class=\"judul\">task</li>";
                    for (var s = 1; s < string.length; s++)
                    {
                        if (document.getElementById("box").value.toLowerCase() == string[s].toLowerCase())
                            check = false;
                        result += "<li onclick=\"auto_complete(this.innerHTML);\">" + string[s] + "</li>";
                    }
                }
                if (check)
                {
                    result += "</ul>";
                    document.getElementById("hasilsearch").innerHTML = result;
                    document.getElementById("hasilsearch").style.visibility = "visible";
                }
                else
                {
                    document.getElementById("hasilsearch").innerHTML = "";
                    document.getElementById("hasilsearch").style.visibility = "none";
                }
            } else if (tipe == "username") {
                var string = xmlhttp.responseText.split("<br>");
                var result = "";
                var check = true;
                result = "<ul>";
                if (string.length > 1)
                {
                    result += "<li class=\"judul\">user</li>";
                    for (var s = 1; s < string.length; s++)
                    {
                        if (document.getElementById("box").value.toLowerCase() == string[s].toLowerCase())
                            check = false;
                        result += "<li onclick=\"auto_complete(this.innerHTML);\">" + string[s] + "</li>";
                    }
                }
                if (check)
                {
                    result += "</ul>";
                    document.getElementById("hasilsearch").innerHTML = result;
                    document.getElementById("hasilsearch").style.visibility = "visible";
                }
                else
                {
                    document.getElementById("hasilsearch").innerHTML = "";
                    document.getElementById("hasilsearch").style.visibility = "none";
                }
            } else if (tipe == "category") {
                var string = xmlhttp.responseText.split("<br>");
                var result = "";
                var check = true;
                result = "<ul>";
                if (string.length > 1)
                {
                    result += "<li class=\"judul\">kategori</li>";
                    for (var s = 1; s < string.length; s++)
                    {
                        if (document.getElementById("box").value.toLowerCase() == string[s].toLowerCase())
                            check = false;
                        result += "<li onclick=\"auto_complete(this.innerHTML);\">" + string[s] + "</li>";
                    }
                }
                if (check)
                {
                    result += "</ul>";
                    document.getElementById("hasilsearch").innerHTML = result;
                    document.getElementById("hasilsearch").style.visibility = "visible";
                }
                else
                {
                    document.getElementById("hasilsearch").innerHTML = "";
                    document.getElementById("hasilsearch").style.visibility = "none";
                }
            } else if (tipe == "all result") {
                var string = xmlhttp.responseText.split(",");
                var result = "";
                var check = true;
                result = "<ul>";
                for (var s in string)
                {
                    var string2 = string[s].split("<br>");
                    if (string2.length > 1)
                    {
                        result += "<li class=\"judul\">" + string2[0] + "</li>";
                        for (var s2 = 1; s2 < string2.length; s2++)
                        {
                            if (document.getElementById("box").value.toLowerCase() == string2[s2].toLowerCase())
                                check = false;
                            result += "<li onclick=\"auto_complete(this.innerHTML);\">" + string2[s2] + "</li>";
                        }
                    }
                }
                if (check)
                {
                    result += "</ul>";
                    document.getElementById("hasilsearch").innerHTML = result;
                    document.getElementById("hasilsearch").style.visibility = "visible";
                }
                else
                {
                    document.getElementById("hasilsearch").innerHTML = "";
                    document.getElementById("hasilsearch").style.visibility = "none";
                }
            }
        }
    }
    xmlhttp.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/autosearch?q=" + str + "&tipe=" + tipe + "&username=" + username, true);
    xmlhttp.send();
}

function suggestion(str) {
    if (str.length == 0)
    {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var string = xmlhttp.responseText.split(",");

            for (var s in string)
            {
                document.getElementById("join").innerHTML = "<option value=" + string[s] + ">";
            }
        }
    }
    xmlhttp.open("GET", "joinhint.php?q=" + str, true);
    xmlhttp.send();
}

function selectedkategori(str,username) {
    t = str;
    showTask(t,username);
}

function showKategori(username) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {

            if (xmlhttp.responseText != "")
            {
                var result = "";
                var string = xmlhttp.responseText.split("<br>");
                for (var s = 1; s < string.length; s++)
                {
                    result += "<div class=\"kategori\" onclick=\"selectedkategori(this.innerHTML,\'"+username+"\');\">" + string[s] + "</div>";
                }

                document.getElementById("category").innerHTML = result;
            }
            else
            {
                document.getElementById("category").innerHTML = "";
            }
        }
    }
    xmlhttp.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/allkategori?username="+username, true);
    xmlhttp.send();
}

function showTask(str,username) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp2 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp2.onreadystatechange = function()
    {
        if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200)
        {
            if (xmlhttp2.responseText != "")
            {
                if (str == "0")
                {
                    var result = "";
                    var string1 = xmlhttp2.responseText.split("<br>");
                    for (var s = 1; s < string1.length; s++)
                    {
                        var string2 = string1[s].split(",");
                        result += "<div class=\"task\">";
                        result += "<a href=\"rincitask.php?id=" + string2[3] + "\">" + string2[0] + "</a>";
                        result += "<span><br>deadline : " + string2[1] + "</span>";

                        if (string2.length > 4)
                        {
                            result += "<span><br>tag : ";
                            for (var i = 5; i < string2.length; i++)
                            {
                                result += string2[i] + ",";
                            }
                        }

                        if (string2[2] == "0") {
                            result += "<br><input type=\"checkbox\" name=\"done\" value=\"done\" onclick=\"cektugasdone(" + string2[3] + ");\"> done";
                        } else if (string2[2] == "1")
                        {
                            result += "<br><input type=\"checkbox\" name=\"done\" value=\"done\" checked onclick=\"cektugasdone(" + string2[3] + ");\"> done";
                        }

                        if (string2[4] == "yes") {
                            result += "<button onclick=\"deletetask(" + string2[3] + ")\">delete</button>";
                        }

                        result += "</div>";
                    }

                    document.getElementById("listtugas").innerHTML = result;
                }
                else
                {
                    var result = "";
                    var string1 = xmlhttp2.responseText.split("<br>");
                    if (string1[0] == "creator") {
                        result += "<div><button onclick=\"deletekategori("+username+");\">delete kategori</button></div>";
                    }
                    result += "<div class=\"addtask\"><a href=\"createtask.php?namakategori=" + str + "\">+ task</a></div>";
                    for (var s = 1; s < string1.length; s++)
                    {
                        var string2 = string1[s].split(",");
                        result += "<div class=\"task\">";
                        result += "<a href=\"rincitask.php?id=" + string2[3] + "\">" + string2[0] + "</a>";
                        result += "<span><br>deadline : " + string2[1] + "</span>";

                        if (string2.length > 4)
                        {
                            result += "<span><br>tag : ";
                            for (var i = 5; i < string2.length; i++)
                            {
                                result += string2[i] + ",";
                            }
                        }

                        if (string2[2] == "0") {
                            result += "<br><input type=\"checkbox\" name=\"done\" value=\"1\" onclick=\"cektugasdone(" + string2[3] + ");\"> done";
                        } else if (string2[2] == "1")
                        {
                            result += "<br><input type=\"checkbox\" name=\"done\" value=\"0\" checked onclick=\"cektugasdone(" + string2[3] + ");\"> done";
                        }

                        if (string2[4] == "yes") {
                            result += "<button onclick=\"deletetask(" + string2[3] + ")\">delete</button>"
                        }

                        result += "</div>";
                    }

                    document.getElementById("listtugas").innerHTML = result;
                }
            }
            else {
                document.getElementById("listtugas").innerHTML = "";
            }
        }
    }
    xmlhttp2.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/showTask?q=" + str +"&username="+username, true);
    xmlhttp2.send();
}

function deletekategori(username)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp4 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp4 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp4.onreadystatechange = function()
    {
        if (xmlhttp4.readyState == 4 && xmlhttp4.status == 200)
        {
            if (xmlhttp4.responseText == t)
            {
                alert("delete " + xmlhttp4.responseText);
                selectedkategori(0,username);
                showTask(t,username);
            }
            else
            {
                alert("delete kategori failed");
            }
        }
    }
    xmlhttp4.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/hapusKategori?q="+t,true);
    xmlhttp4.send();
}

function deletetask(str)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp5 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp5 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp5.onreadystatechange = function()
    {
        if (xmlhttp5.readyState == 4 && xmlhttp5.status == 200)
        {
            if (xmlhttp5.responseText == "deleted")
            {
                alert(xmlhttp5.responseText);
                showTask(t,username);
            }
            else
            {
                alert("delete failed");
            }
        }
    }
    xmlhttp5.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/hapusTask?q=" + str, true);
    xmlhttp5.send();
}

function cektugasdone(str) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp9 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp9 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp9.onreadystatechange = function()
    {
        if (xmlhttp9.readyState == 4 && xmlhttp9.status == 200)
        {
            if (xmlhttp9.responseText != "")
            {
                alert(xmlhttp9.responseText);
            }
            else
            {
                alert("update error");
            }
        }
    }
    xmlhttp9.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/checkTask?q="+str,true);
    xmlhttp9.send();
}

function update(username) {
    showTask(t,username);
    showKategori(username);
}

//setInterval(function(){update();},5000)

function Loginaja() {
    //Variable for authentication
    var username = document.getElementById("logusername").value;
    var password = document.getElementById("logpassword").value;
    //var xmlhttp3;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp3 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp3.onreadystatechange = function()
    {
        if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200)
        {
            if (xmlhttp3.responseText == 0) {
                alert("Your username and/or password is wrong!");
            } else {
                // console.log("gettin to dashboard");
                window.location = "setsession.php?username=" + username;
            }
        }
    }
    xmlhttp3.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/authentication?usr=" + username + "&psw=" + password, true);
    xmlhttp3.send();
}

function restore() {
    document.body.removeChild(document.getElementById("overlay"));
    document.getElementById('add').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function editProfile() {
    var overlay = document.createElement("div");
    overlay.setAttribute("id", "overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);

    document.getElementById('edit').style.display = 'block';
}

function profileRestore() {
    document.body.removeChild(document.getElementById("overlay"));
    document.getElementById('edit').style.display = 'none';
    // document.getElementById('overlay').style.display='none';
}

function showStatus(id) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp2 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp2.onreadystatechange = function()
    {
        if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200)
        {
            var result = "";
            var string1 = xmlhttp2.responseText.split(",");
            if (string1[1] == "0") {
                result += "<input type=\"checkbox\" name=\"Done\" value=\"0\" onclick=\"cektugasdone(" + string1[0] + ");\"> Done";
            } else {
                result += "<input type=\"checkbox\" name=\"Done\" value=\"1\" checked onclick=\"cektugasdone(" + string1[0] + ");\"> Done";
            }
            document.getElementById("status_detail").innerHTML = result;
        }
    }
    xmlhttp2.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/showStatus?id="+id,true);
    xmlhttp2.send();
}

function showAssignee(id) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp3 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp3.onreadystatechange = function()
    {
        if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200)
        {
            var result = "";
            var string1 = xmlhttp3.responseText.split(",");

            for (var s = 0; s < string1.length; s++) {
                result += "<div class=\"assignee\">";
                result += "<a href=\"userprofile.php?usr=" + string1[s] + "\">" + string1[s] + "</a>";
                result += "</div>";
            }
            document.getElementById("assignee").innerHTML = result;
        }
    }
	xmlhttp3.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/showAssignee?q="+id,true);
    xmlhttp3.send();
}

function showTags(id) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp4 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp4 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp4.onreadystatechange = function()
    {
        if (xmlhttp4.readyState == 4 && xmlhttp4.status == 200)
        {
            var result = "";
            result += xmlhttp4.responseText;
            document.getElementById("tag").innerHTML = result;
        }
    }
	xmlhttp4.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/showTags?q="+id,true);
    xmlhttp4.send();
}

function showAttachment(id) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp5 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp5 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp5.onreadystatechange = function()
    {
        if (xmlhttp5.readyState == 4 && xmlhttp5.status == 200)
        {
            var result = "";
            var string1 = xmlhttp5.responseText.split(",");

            for (var s = 0; s < string1.length; s++) {
                var string2 = string1[s].split(".");
                if (string2[1] == "jpg" || string2[1] == "jpeg") {
                    result += "<img src=\"" + string1[s] + "\"  alt=\"This is picture\" width=\"30%\"  height=\"30%\"></img>";
                } else if (string2[1] == "mp4" || string2[1] == "ogg" || string2[1] == "webm" || string2[1] == "swf") {
                    result += "<video width=\"50%\" height=\"50%\" controls>";
                    result += "<source src=\"" + string1[s] + "\" type=\"video/mp4\">";
                    result += "<source src=\"" + string1[s] + "\" type=\"video/ogg\">";
                    result += "<source src=\"" + string1[s] + "\" type=\"video/webm\">";
                    result += "<object data=\"" + string1[s] + "\" width=\"50%\" height=\"50%\" controls>";
                    result += "<embed src=\"" + string1[s] + "\" width=\"50%\" height=\"50%\" controls>";
                    result += "</object>";
                } else {
                    result += "<a href=\"" + string1[s] + "\" target=\"_blank\">" + string1[s] + "</a>";
                }
                result += "</br>";
            }

            document.getElementById("attachment").innerHTML = result;
        }
    }
	xmlhttp5.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/showAttachment?q="+id,true);
    xmlhttp5.send();
}

function showComment(id) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp7 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp7 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp7.onreadystatechange = function()
    {
        if (xmlhttp7.readyState == 4 && xmlhttp7.status == 200)
        {
            var result = "";
            var string1 = xmlhttp7.responseText.split("<br>");
            result += "Total comments = " + (string1.length - 1) + "<br\>";

            for (var s = 1; s < string1.length; s++) {
                var string2 = string1[s].split(",");

                result += s + ". <img src=\"" + string2[0] + "\" height=15% width=15%><br\>";
                result += "Time: " + string2[1] + "<br\>";
                result += string2[2] + "<br\>";

                if (string2[3] == string2[4]) {
                    result += "<input type =\"button\" id=\"delTask\" value=\"Delete\" onclick=\"deleteComment(" + string2[5] + ");\"><br\>";
                }
            }
            document.getElementById("list_comment").innerHTML = result;
        }
    }
    xmlhttp7.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/showComment?q=" + id, true);
    xmlhttp7.send();
}

function deleteComment(str) {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp8 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp8 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp8.onreadystatechange = function()
    {
        if (xmlhttp8.readyState == 4 && xmlhttp8.status == 200)
        {
            if (xmlhttp8.responseText == "deleted")
            {
                alert("Delete success");
                showComment();
            }
            else
            {
                alert("Delete failed");
            }
        }
    }
	xmlhttp8.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/hapusComment?q="+str,true);
    xmlhttp8.send();
}

function generate_page(id) {
    showStatus(id);
    showAttachment(id);
    showAssignee(id);
    showTags(id);
    showComment(id);
}

function storeComment(id,username) {
    var comment = document.getElementById("comment").value;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp6 = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp6 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp6.onreadystatechange = function()
    {
        if (xmlhttp6.readyState == 4 && xmlhttp6.status == 200)
        {
            if (xmlhttp6.responseText == "") {
                alert("Komentar berhasil disimpan");
            } else {
                alert("Komentar gagal disimpan");
            }
        }
    }
    xmlhttp6.open("GET", "http://nicholasrio.ap01.aws.af.cm/rest/storeComment?q=" + comment + "&id=" + id + "&username="+username, true);
    xmlhttp6.send();
}

function deleteTask(str)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            if (xmlhttp.responseText == "deleted")
            {
                alert(xmlhttp.responseText);
                window.location = "Dashboard.php";
            }
            else
            {
                alert("delete failed");
            }
        }
    }
	xmlhttp.open("GET","http://nicholasrio.ap01.aws.af.cm/rest/hapusTask?q="+str,true);
    xmlhttp.send();
}