<?php 
	include "login.php";
	$username = $_SESSION['username'];
	// $username = "ArieDoank";
	require "config.php";
	$text = $_POST['Search'];
	$tipefilter = $_POST['namafilter'];
	
?>

<!DOCTYPE html>
<html>
    <head>
        <title>BANG!!!-DASHBOARD</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css.css" media="screen" />
        
    </head>
    <body>
		<?php
        include "header.php";
		?>
            <div id="category">
            </div>
        
        <div id ="listtugas" class="list">
			
        </div>
		
        <script type="text/javascript" src="script.js">
		</script>
		<script>
		var posisi = 0;
		
		window.onload=updateSearch;
		
		function paginasi(q,t,p){
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
					result = "";
					
					if (t == "all result")
					{
						var string = xmlhttp.responseText.split("<x>");
						
						for (var a=0; a < string.length-1;a++)
						{
							var string1 = string[a].split("<br>");
							
							result += "<div class=\"judulhasil\">"+string1[0]+"</div>";
							if (string1[0] == "task")
							{
								for (var s=1;s<string1.length;s++)
								{
									var string11 = string1[s].split(",");
									result += "<div class=\"task\">";
									result += "<a href=\"rincitask.php?id="+string11[0]+"\">"+string11[1]+"</a>";
									result += "<span><br>deadline : "+string11[2]+"</span>";
									if (string11.length > 3)
									{
										result += "<span><br>tag : ";
										for (var i=4; i< string11.length; i++)
										{
											result += string11[i]+",";
										}
									}
									if (string11[3] == "0"){
										result += "<br><input type=\"checkbox\" name=\"done\" value=\"1\" onclick=\"cektugasdone("+string11[0]+");\"> done";
									} else if (string11[3] == "1")
									{
										result += "<br><input type=\"checkbox\" name=\"done\" value=\"0\" checked onclick=\"cektugasdone("+string11[0]+");\"> done";
									}
									result += "</div>";
								}
							}
							else if (string1[0] == "username")
							{
								for (var s=1;s<string1.length;s++)
								{
									var string22 = string1[s].split(",");
									result += "<div class=\"task\">";
									result += "<a href=\"userprofile.php?usr="+string22[0]+"\">"+string22[0]+"</a>";
									result += "<span><br>fullname : "+string22[1]+"</span>";
									result += "<span><br>Avatar :</span>";
									result += "<span><img src=\""+string22[2]+"\" width=40px; height=40px;></span>";
									result += "</div>";
								}
							}
							else if (string1[0] == "kategory")
							{
								
								for (var s=1;s<string1.length;s++)
								{
									var string33 = string1[s].split(",");		
									result += "<div class=\"judulhasil2\">"+string33[0]+"</div>";
									result += "</div>";
								}
							}
						}
						
						result += "<div class=\"judulhasil\">";
						var str = string[string.length-1].split(",");
						if (str[0] > 0){
							result += "<button onclick=\"prevpage("+str[0]+")\">prev</button>";
						}
						if (str[1] > posisi)
						{
							result += "<button onclick=\"nextpage("+str[1]+")\">next</button>";
						}
						result += "</div>";
					}
					else if (t == "task"){
						result += "<div class=\"judulhasil\">task</div>";
						var string = xmlhttp.responseText.split("<br>");
						for (var s=1;s<string.length-1;s++)
						{
							var string1 = string[s].split(",");
							result += "<div class=\"task\">";
							result += "<a href=\"rincitask.php?id="+string1[0]+"\">"+string1[1]+"</a>";
							result += "<span><br>deadline : "+string1[2]+"</span>";
							if (string1.length > 3)
							{
								result += "<span><br>tag : ";
								for (var i=4; i< string1.length; i++)
								{
									result += string1[i]+",";
								}
							}
							if (string1[3] == "0"){
								result += "<br><input type=\"checkbox\" name=\"done\" value=\"1\" onclick=\"cektugasdone("+string1[0]+");\"> done";
							} else if (string1[3] == "1")
							{
								result += "<br><input type=\"checkbox\" name=\"done\" value=\"0\" checked onclick=\"cektugasdone("+string1[0]+");\"> done";
							}
							result += "</div>";
						}
						
						result += "<div class=\"judulhasil\">";
						var string1 = string[string.length-1].split(",");
						if (string1[0] > 0){
							result += "<button onclick=\"prevpage("+string1[0]+")\">prev</button>";
						}
						if (string1[1] > posisi)
						{
							result += "<button onclick=\"nextpage("+string1[1]+")\">next</button>";
						}
						result += "</div>";
					}
					else if (t == "username"){
						result += "<div class=\"judulhasil\">username</div>";
						var string = xmlhttp.responseText.split("<br>");
						for (var s=1;s<string.length-1;s++)
						{
							var string2 = string[s].split(",");
							result += "<div class=\"task\">";
							result += "<a href=\"userprofile.php?usr="+string2[0]+"\">"+string2[0]+"</a>";
							result += "<span><br>fullname : "+string2[1]+"</span>";
							result += "<span><br>Avatar :</span>";
							result += "<span><img src=\""+string2[2]+"\" width=40px; height=40px;></span>";
							result += "</div>";
						}
						
						result += "<div class=\"judulhasil\">";
						var string2 = string[string.length-1].split(",");
						if (string2[0] > 0){
							result += "<button onclick=\"prevpage("+string2[0]+")\">prev</button>";
						}
						if (string2[1] > posisi)
						{
							result += "<button onclick=\"nextpage("+string2[1]+")\">next</button>";
						}
						result += "</div>";
					
						
					}
					else if (t == "category"){
						result += "<div class=\"judulhasil\">kategori</div>";
						var string = xmlhttp.responseText.split("<br>");
						for (var s=1;s<string.length-1;s++)
						{
							var string3 = string[s].split(",");
							result += "<div class=\"judulhasil2\">"+string3[0]+"</div>";
							result += "</div>";
						}
						
						result += "<div class=\"judulhasil\">";
						var string3 = string[string.length-1].split(",");
						if (string3[0] > 0){
							result += "<button onclick=\"prevpage("+string3[0]+")\">prev</button>";
						}
						if (string3[1] > posisi)
						{
							result += "<button onclick=\"nextpage("+string3[1]+")\">next</button>";
						}
						result += "</div>";
						
					}
					
					document.getElementById("listtugas").innerHTML=result;
				  }
			  }
			xmlhttp.open("GET","http://localhost/_tubes4/updateSearch?q="+q+"&t="+t+"&p="+p+"&username=/"+'<?php echo $username?>',true);
			xmlhttp.send();
		}
		
		function nextpage(str){
			posisi = str;
			paginasi("<?php echo $text;?>","<?php echo $tipefilter;?>",posisi);
		}
		
		function prevpage(str){
			posisi = str-1;
			paginasi("<?php echo $text;?>","<?php echo $tipefilter;?>",posisi);
		}
		
		function updateSearch(){
			paginasi("<?php echo $text;?>","<?php echo $tipefilter;?>",posisi);
		}
		
		</script>
    </body>
</html>