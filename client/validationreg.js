//registration form variabel
var username = document.getElementById("regusername1");
var fullname = document.getElementById("regname");
var pass1 = document.getElementById("regpassword1");
var pass2 = document.getElementById("regpassword2");
var email = document.getElementById("regemail");
var file = document.getElementById("regfile");
var submit = document.getElementById("regbutton");
var regForm = document.getElementById("regForm");
var valid1bool;
var valid2bool;
var valid3bool;
var valid4bool;
var valid5bool;
var valid6bool;
var valid7bool;
	
	username.onkeyup = function()
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// alert(xmlhttp.responseText);
				// document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				if(xmlhttp.responseText>0){
					valid1.src = "img/salah.png";
					valid1bool = false;
				}else{
					if (username.checkValidity()){
						valid1.src = "img/benar.png";
						valid1bool = true;
					}
					else
					{
						valid1.src = "img/salah.png";
						valid1bool = false;
					}
					if (username.value == pass1.value)
					{
						valid1.src = "img/salah.png";
						valid1bool = false;
					}
					cekvalid();
				}
			}
		}
		xmlhttp.open("GET","getuser.php?q="+username.value,true);
		xmlhttp.send();
	}
	
	fullname.onkeyup = function()
	{
		if (fullname.checkValidity()){
			valid2.src = "img/benar.png";
			valid2bool=true;
		}
		else
		{
			valid2.src = "img/salah.png";
			valid2bool=false;
		}
		cekvalid();
	}
	
	pass1.onkeyup = function()
	{

		if (pass1.checkValidity()){
			valid3.src = "img/benar.png";
			valid3bool=true;
		}
		else
		{
			valid3.src = "img/salah.png";
			valid3bool=false;
		}
		
		if (username.value == pass1.value)
		{
			valid3bool=false;
			valid3.src = "img/salah.png";
		}
		else if (pass1.value == email.value)
			{
				valid3.src = "img/salah.png";
				valid3bool=false;
			}
			
		cekvalid();
	}
	
	pass2.onkeyup = function()
	{
		if (pass2.checkValidity() && (pass1.value == pass2.value)){
			valid4.src = "img/benar.png";
			valid4bool=true;
		}
		else
		{
			valid4.src = "img/salah.png";
			valid4bool=false;
		}
		
		cekvalid();
	}
	
	email.onkeyup = function()
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// alert(xmlhttp.responseText);
				// document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
				if(xmlhttp.responseText>0){
					valid5.src = "img/salah.png";
					valid5bool=false;
				}else{
					if (email.checkValidity()){
						valid5.src = "img/benar.png";
						valid5bool=true;
					}
					else
					{
						valid5.src = "img/salah.png";
						valid5bool=false;
					}
					if (pass1.value == email.value)
					{
						valid5.src = "img/salah.png";
						valid5bool=false;
					}
					cekvalid();
				}
			}
		}
		xmlhttp.open("GET","getemail.php?",true);
		xmlhttp.send();
	}
	
	function checkImage()
	{
		var extensi = file.value.match("^.+\.(jpe?g|JPE?G)$");
		if(extensi){
			valid6.src = "img/benar.png";
			valid6bool=true;
		}else{
			valid6.src = "img/salah.png";
			valid6bool=false;
		}
		cekvalid();
	}
	
	function dateChange()
	{
		valid7.src = "img/benar.png";
		valid7bool = true;
	}
	
	function cekvalid(){
		if (valid1bool==true && valid2bool==true && valid3bool==true && valid4bool==true && valid5bool==true && valid6bool==true && valid7bool==true) 
		{
			submit.disabled=false;
		}
		else
		{
			submit.disabled="disabled";
		}
	}