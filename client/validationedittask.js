//registration form variabel
var valid1;
var valid3;
var submitcreate = document.getElementById("editbut");
	
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
	  document.getElementById("hasilsearchassigneeedit").innerHTML="";
	  document.getElementById("hasilsearchassigneeedit").style.visibility="hidden";
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
				document.getElementById("hasilsearchassigneeedit").innerHTML=result;
				document.getElementById("hasilsearchassigneeedit").style.visibility="visible";
			}
			else
			{
				document.getElementById("hasilsearchassigneeedit").innerHTML="";
				document.getElementById("hasilsearchassigneeedit").style.visibility="none";
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
	document.getElementById("hasilsearchassigneeedit").innerHTML="";
	document.getElementById("hasilsearchassigneeedit").style.visibility="none";
}

function showTag(str)
{
	var string1 = str.split(",");
	var s = string1[string1.length-1];
	
	if (s.length==0)
	  { 
	  document.getElementById("hasilsearchtag").innerHTML="";
	  document.getElementById("hasilsearchtag").style.visibility="hidden";
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
					if (document.getElementById("tag").value.toLowerCase() == string[s].toLowerCase())
						check = false;
					result += "<li onclick=\"auto_complete_tag(this.innerHTML);\">"+string[s]+"</li>";
				}
			}
			if (check)
			{
				result += "</ul>";
				document.getElementById("hasilsearchtag").innerHTML=result;
				document.getElementById("hasilsearchtag").style.visibility="visible";
			}
			else
			{
				document.getElementById("hasilsearchtag").innerHTML="";
				document.getElementById("hasilsearchtag").style.visibility="none";
			}
	   }
	  }
	xmlhttp.open("GET","autotag.php?q="+s,true);
	xmlhttp.send();
}

function auto_complete_tag(str)
{
	var currenttag = document.getElementById("tag").value;
	//str toAdd assignee
	if(currenttag.lastIndexOf(",")!=-1){
		var last = currenttag.substring(0,currenttag.lastIndexOf(","))+","+str+",";
	}else{
		var last = str+",";
	}
	document.getElementById("tag").value = last;
	document.getElementById("hasilsearchtag").innerHTML="";
	document.getElementById("hasilsearchtag").style.visibility="none";
}