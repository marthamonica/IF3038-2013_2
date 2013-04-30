//registration form variabel
var taskName = document.getElementById("namaTask");
var valid1;
var valid3;
var valid6;
var submitcreate = document.getElementById("createbut");
	
	taskName.onkeyup = function()
	{
		if (taskName.checkValidity()){
			validtask1.src = "img/benar.png";
			valid1=true;
		}
		else
		{
			validtask1.src = "img/salah.png";
			valid1=false;
		}
	}
	
	function changeDeadline()
	{
		validtask3.src = "img/benar.png";
		valid3=true;
	}
	
	function cekvalidcreate()
	{
		if(valid1==true && valid3==true){
			submitcreate.disabled=false;
		}else{
			submitcreate.disabled="disabled";
		}
	}
	
function showAssignee(str)
{
	var string1 = str.split(",");
	var s = string1[string1.length-1];
	
	if (s.length==0)
	  { 
	  document.getElementById("hasilsearchassignee").innerHTML="";
	  document.getElementById("hasilsearchassignee").style.visibility="hidden";
	  return;
	  }
	
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
			var string = xmlhttp.responseText.split("<br>");
			var result = "";
			var check = true;
			result = "<ul>";
			if (string.length > 1)
			{
				for (var s=1; s<string.length; s++)
				{
					if (document.getElementById("Assignee").value.toLowerCase() == string[s].toLowerCase())
						check = false;
					result += "<li onclick=\"auto_complete_assignee(this.innerHTML);\">"+string[s]+"</li>";
				}
			}
			if (check)
			{
				result += "</ul>";
				document.getElementById("hasilsearchassignee").innerHTML=result;
				document.getElementById("hasilsearchassignee").style.visibility="visible";
			}
			else
			{
				document.getElementById("hasilsearchassignee").innerHTML="";
				document.getElementById("hasilsearchassignee").style.visibility="none";
			}
	   }
	  }
	xmlhttp.open("GET","autoassignee.php?q="+s,true);
	xmlhttp.send();
}

function auto_complete_assignee(str)
{
	var currentassignee = document.getElementById("Assignee").value;
	//str toAdd assignee
	if(currentassignee.lastIndexOf(",")!=-1){
		var last = currentassignee.substring(0,currentassignee.lastIndexOf(","))+","+str+",";
	}else{
		var last = str+",";
	}
	document.getElementById("Assignee").value = last;
	document.getElementById("hasilsearchassignee").innerHTML="";
	document.getElementById("hasilsearchassignee").style.visibility="none";
}