
<html>
<head><title>Port Name</title></head>
<style>
body{
	background-color: lightblue;
}
h1{
	text-align: center;
	font-size: 54px;
	margin-top: 60px;
	box-shadow: 10px 10px 8px 10px ;
}
form{
	margin-top: 200px;
	
}

#uid1{
	
	 margin-left: 630px;
	 height: 40px;
	 width: 210px;
	 border-radius: 25px; 
	 box-shadow: 10px 10px 8px 10px green;
}
#pid1{
	margin-top: 10px;
	 margin-left: 630px;
	 height: 40px;
	  width: 210px;
	 border-radius: 25px;
	  box-shadow: 10px 10px 8px 10px green;
}
#upn1{
	
     margin-left: 660px;
	 height: 40px;
	 width: 150px;
	 border-radius: 25px;
	 margin-top: 10px;
	  box-shadow: 10px 10px 8px 10px green;
}
</style>
<body>
<h1>Welcome In Defining Prot Number of Street Light</h1>
<form action="#" method="post">
<input type="text" name="uid" placeholder="Enter Device ID"  id="uid1"></br>
<input type="text" name="pid" placeholder="Enter Port Number" id="pid1"></br>
<input type="submit" name="upn"  value="Update Port Number"   id="upn1"></br>
</form>
</body>
</html>

<?php


    $servername = "testing.siotel.in";
	$username ="test_user";
	$password ="Alyr!020";
	$databasename ="SSTPL_UPLINK";
	$connection = mysqli_connect($servername,$username,$password,$databasename);
	
	if(!$connection)
	{
		die("connection Unsuccessfull:".mysqli_connect_error());
	}
	
     
	 
   if(isset($_POST['upn']))
  {
	 $uname=$_POST['uid'];
	 $pname=$_POST['pid'];
	   $sql="update SSTPL_UP_Data set Port_no='$pname' where Address='$uname'";
	    if(mysqli_query($connection,$sql))
		{
		echo "Insert Successfully";
		sleep(5);
		header("Location: stlight.php");
		}
		else{
			echo "insert not done";
			sleep(5);
	
		}
		
  } 
  
   
	
	 
	 
	 
	 
	 
	 
?>
