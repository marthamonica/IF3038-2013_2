//edit form variabel
var valid1edit = true;
var valid2edit = true;
var valid3edit = true;
var valid4edit = true;
var valid5edit = true;
var editname = document.getElementById("editname");
var editdob = document.getElementById("editdob");
var editpass1 = document.getElementById("editpassword1");
var editpass2 = document.getElementById("editpassword2");
var editfile = document.getElementById("editavatar");
var submitedit = document.getElementById("editbutton");
	
	editname.onkeyup = function()
	{
		if (editname.checkValidity()){
			edit1.src = "img/benar.png";
			valid1edit=true;
		}
		else
		{
			edit1.src = "img/salah.png";
			valid1edit=false;
		}
		cekvalid2();
	}
	
	function dateChange2()
	{
		edit2.src = "img/benar.png";
		valid2edit = true;
		cekvalid2();
	}
	
	function checkImage2()
	{
		var extensi = editavatar.value.match("^.+\.(jpe?g|JPE?G)$");
		if(extensi){
			edit3.src = "img/benar.png";
			edit3valid=true;
		}else{
			edit3.src = "img/salah.png";
			edit3valid=false;
		}
		cekvalid2();
	}
	
	editpass1.onkeyup = function()
	{
		if (editpass1.checkValidity()){
			edit4.src = "img/benar.png";
			valid4edit=true;
		}
		else
		{
			edit4.src = "img/salah.png";
			valid4edit=false;
		}
		cekvalid2();
	}
	
	editpass2.onkeyup = function()
	{
		if (editpass2.checkValidity() && (editpass1.value == editpass2.value)){
			edit5.src = "img/benar.png";
			valid5edit=true;
		}
		else
		{
			edit5.src = "img/salah.png";
			valid5edit=false;
		}
		cekvalid2();
	}
	
	function cekvalid2(){
		if (valid1edit==false || valid2edit==false || valid3edit == false || valid4edit == false || valid5edit == false) 
		{
			submitedit.disabled="disabled";
		}
		else
		{
			submitedit.disabled=false;
		}
	}
	
	function Editaja(){
		//Variable for authentication
		var username = document.getElementById("editname").value;
		var birthday = document.getElementById("editdob").value;
		var password = document.getElementById("logpassword").value;
		//var xmlhttp3;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp3=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp3.onreadystatechange=function()
		{
			if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
			{
				if(xmlhttp3.responseText==0){
					alert("Your username and/or password is wrong!");
				}else{
					window.location = "Dashboard.php";
				}
			}
		}
		xmlhttp3.open("GET","authentication.php?usr="+username+"&psw="+password,true);
		xmlhttp3.send();
	}