<script type="text/javascript">
console.log(sessionStorage.getItem("token"));
if(sessionStorage.getItem("token")=="cM=xK2v=yB7?35Z3V2+Be$-?=$P@!3nEkT9_whgmp=rw5tKU7$Wp42Gjna%gMAxKrUXkmMHzzn_N7&g-WF@wxG$*xGAZY=jr&*=&c9?qf?W%Y23#=3JGWxF8g^%jMZSP")
{}
else
{ window.location='index.php';
}

</script>
<html>
<head>
<title>Street light</title>
<link rel="stylesheet"
          href="https://fonts.google.com/specimen/Poppins?sidebar.open&selection.family=Poppins">
<link rel="stylesheet" type="text/css"  href="stlight.css">
<meta http-equiv="refresh" content="60" > 
</head>

<body>
<div class="top1">
<h1 id="toph1">Sehaj Synergy Technologies Pvt. Ltd.</h1>
<img id="img1" src="logo.png" alt="SSTPL-IMG">
<img id="img2" src="ok.png" alt="SSTPL-IMG">
<form action="index.php" method="post">
<input type="submit" id="logout1" name="functio1" value="Logout"/>
</form>
<form action="port.php" method="post" >
<input type="submit" id="logout2" name="functio2" value="Add Location "/>
</form>
<?php
                      $url = 'http://testing.siotel.in:8080/api/internal/login';
                      $jsonString = json_encode(array( "password" => "Alyr!020","username" => "admin"  ));
                      $ch = curl_init();
                      $Timeout = 0; // Set 0 for no Timeout.
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                      curl_setopt($ch, CURLOPT_URL, $url);
                      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'Content-Type: application/json',
                      'Accept: application/json',)
                      );
                      //curl_setopt($ch, CURLOPT_CONNECTTimeOUT, $Timeout);
                      $jwtk = curl_exec($ch);
                      $ch_error = curl_error($ch);
                      if ($ch_error) { 
                          echo "cURL Error: $ch_error"; 
                      } else {
                      }
                      $token = json_decode($jwtk);
                      curl_close($ch);
$url = 'http://testing.siotel.in:8080/api/gateways/506f980000000081';
$jsonString = json_encode(array('506f980000000081'));
$gateway_mac='506f980000000081';

$ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept: application/json',
				"Grpc-Metadata-Authorization:$token->jwt",)
				);
    $output=curl_exec($ch);
 //print_r(json_decode($output));
 $opt=json_decode($output);


    curl_close($ch);
$inputDate = gmdate("Y-m-d H:i:s");

//echo "LAST SEEN: ".$opt->lastSeenAt;
$date = new DateTime( $opt->lastSeenAt);
$vari=json_encode($date);
//echo $vari;
$lst=substr($vari,9,19);
//echo "$lst<br>";
$nowtime=strtotime($inputDate);
$lastseen=strtotime($lst);
$timediff=abs($nowtime-$lastseen);


 function enqueue_downlink($deveui,$data){
                  
    
                    $url = "http://testing.siotel.in:8080/api/devices/".$deveui."/queue";
                    $jsonString = json_encode(array( 
                       "deviceQueueItem"=>array(
                         "confirmed"=> true, 
                        "data"=> $data,
                        "devEUI"=> $deveui,
                        "fCnt"=> 0,
                        "fPort"=> 7
                    )));                  

                    $ch = curl_init();
                    $Timeout = 0; // Set 0 for no Timeout.
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Grpc-Metadata-Authorization:$token->jwt",)
                    );
                    //curl_setopt($ch, CURLOPT_CONNECTTimeOUT, $Timeout);
                    $jwt = curl_exec($ch);
                    $ch_error = curl_error($ch);
                      if ($ch_error) { 
                          echo "cURL Error: $ch_error";                     
                      } else {
                      }
                      curl_close($ch);
        } 
      function hex_to_base64($hex){
              $return = '';
              foreach(str_split($hex, 2) as $pair){
              $return .= chr(hexdec($pair));
              }
              return base64_encode($return);
             }
      function ascii2hex($ascii) {
            $hex = '';
            for ($i = 0; $i < strlen($ascii); $i++) {
              $byte = strtoupper(dechex(ord($ascii{$i})));
              $byte = str_repeat('0', 2 - strlen($byte)).$byte;
              $hex.=$byte;
            }
            return $hex;
          }       


     
	$servername = "testing.siotel.in";
	$username ="root";
	$password ="Alyr!020";
	$databasename ="SSTPL_UPLINK";
	
	$connection = mysqli_connect($servername,$username,$password,$databasename);
	
	if(!$connection)
	{
		die("connection Unsuccessfull:".mysqli_connect_error());
	}
	
     $sql="select * from SSTPL_UP_Data where Address='506f980000003499' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn=$row['Port_no'];
	 $strpayload1=$payload;
	 endwhile ;
?>

</form>
<?php 
  if (isset($_POST['functio1']))
  {
	  header("Location: index.php");
  }  
   
   if(isset($_POST['functio2']))
   {
	   header("Location: port.php ");
   }
	?>
</div>
<div class="main-div">
<div class="first-div">
<div class="row1">
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000003499' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
	 
</div>
<div class="row1">
<?php

	
     $sql="select * from SSTPL_UP_Data where Address='506f9800000040a0' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn1=$row['Port_no'];
	 $strpayload2=$payload;
	 endwhile ;?>
	 <table>
	 
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn1</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f9800000040a0' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row1">
<?php


	 $sql="select * from SSTPL_UP_Data where Address='506f980000003f39' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn2=$row['Port_no'];
	 $strpayload3=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn2</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000003f39' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row1">
<?php


	
 $sql="select * from SSTPL_UP_Data where Address='506f980000004158' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	  $portn3=$row['Port_no'];
	 $strpayload4=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn3</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000004158' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row1">
<?php


	
 $sql="select * from SSTPL_UP_Data where Address='506f980000004066' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn4=$row['Port_no'];
	 $strpayload5=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn4</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000004066' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
</div>
<div class="second-div">
<div class="row2">
<?php


	 $sql="select * from SSTPL_UP_Data where Address='506f980000004076' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn5=$row['Port_no'];
	 $strpayload6=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn5</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000004076' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row2">
<?php


	 $sql="select * from SSTPL_UP_Data where Address='506f980000003e02' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn6=$row['Port_no'];
	 $strpayload7=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn6</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000003e02' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row2">
<?php


      $sql="select * from SSTPL_UP_Data where Address='506f980000003f2f' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn7=$row['Port_no'];
	 $strpayload8=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn7</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000003f2f' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row2">
<?php

    
	 $sql="select * from SSTPL_UP_Data where Address='506f980000003462' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	 $portn8=$row['Port_no'];
	 $strpayload9=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn8</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f980000003462' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
<div class="row2">
<?php

    
	 $sql="select * from SSTPL_UP_Data where Address='506f98000000354c' and LENGTH(PAYLOAD) > '17' order by time desc limit 1";
	 $result = mysqli_query($connection,$sql);
	 $rowcount= mysqli_num_rows($result);
	 
	 ?>
	 <?php while($row= $result->fetch_assoc()):
	 $mac=$row['Address'];
	 $Time=$row['Time'];
	 $payload=$row['PAYLOAD'];
	  $portn9=$row['Port_no'];
	 $strpayload10=$payload;
	 endwhile ;?>
	 <table>
	 <tr>
	 <td><?php echo "<h2>Mac Id:</h2>";?></td>
	<td><?php echo "<h2>$mac</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Location:</h2>";?></td>
	<td><?php echo "<h2>$portn9</h2>";?></td>
	</tr>
	<tr>
	 <td><?php echo "<h2>Last Seen:</h2>";?></td>
	<td><?php echo "<h2>$Time</h2>";?></td>
	</tr>
	<tr>
	<td><?php echo "<h2>Status:</h2>";?></td>
    
	<td><?php if(substr($payload,0,16)=="524c593030303030") echo "<h2>ON</h2>"; 
	else if($payload=="506f7765724661696c") echo "<h2>PowerFail</h2>"; 
	else{echo "<h2>OFF</h2>" ;}?></td>
	</tr>
	
	<tr>
	<td><?php echo "<h2>Dim:</h2>";?></td>
	<td><?php 
	if(substr($payload,0,16)=="524c593030303030") 
	   { if(substr($payload,16,16)=="44494d3038303030") echo "<h2>80% Dim</h2>"; 
          else if(substr($payload,16,16)=="44494d3039303030"){echo "<h2>90% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3039393030"){echo "<h2>99% Dim</h2>";}
		  else if(substr($payload,16,16)=="44494d3037303030"){echo "<h2>70% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3036303030"){echo "<h2>60% Dim</h2>";}
          else if(substr($payload,16,16)=="44494d3031353030"){echo "<h2>15% Dim</h2>";}		  
		  else if(substr($payload,16,16)=="44494d3035303030"){echo "<h2>50% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3034303030"){echo "<h2>40% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3033303030"){echo "<h2>30% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3032303030"){echo "<h2>20% Dim</h2>";} 
		  else if(substr($payload,16,16)=="44494d3031303030"){echo "<h2>10% Dim</h2>";} 
		  else {echo "<h2>OFF</h2>";}}?></td>
	</tr>
	<tr>
	
	<td><?php	echo "<h2>Lamp Status:</h2>";?></td>
    <td><?php
	
	if(substr($payload,0,16)=="524c593030303030") 
	{  if(substr($payload,64,8)=="00000000") echo "<h2>Fail</h2>" ; 
       else {
		   $jmp=substr($payload,64,8);
	
		   $jmpdec=hexdec($jmp);
	echo "<h2>$jmpdec mAmp</h2>" ;}}?></td>
	</tr>
	<tr>
	<?php $sql1="select * from SSTPL_UP_Data where Address='506f98000000354c' and LENGTH(payload)='14' order by time desc limit 1";
	 $result1 = mysqli_query($connection,$sql1);
	 $rowcount1= mysqli_num_rows($result1);
	 $row1= $result1->fetch_assoc();
	 $mac1=$row1['PAYLOAD'];
	 
	 ?>
	 
	 <td><?php echo "<h2>Current Sch:</h2>";?></td>
	<td><?php if(substr($mac1,0,6)=="534348"){$newpy = substr($mac1,6,2);$newpy1 = substr($mac1,8,2);$newpy2 = substr($mac1,10,2);$newpy3 = substr($mac1,12,2);
	
	echo "<h2>$newpy:$newpy1 to $newpy2:$newpy3</h2>";}?></td>
	</tr>
	 
	</table>
</div>
</div>
<div id="nml">
</div>
<?php
$nowpayload='';
if (isset($_POST['readstan'])) {
					$MACADDRESS= $_POST['abcde1'];
					
                      $data= "534C5352454144";                    
                      $data= hex_to_base64($data);
                      enqueue_downlink($MACADDRESS,$data);
					  sleep(2);
					  //echo $MACADDRESS;
					 
		            
			
					switch($MACADDRESS){
						case '506f980000003499':
							$nowpayload=$strpayload1;
							break;
						case '506f98000000354c':
							$nowpayload=$strpayload10;
							break;
						case '506f980000003e02':
							$nowpayload=$strpayload7;
							break;	
						
						
						case '506f980000003f2f':
							$nowpayload=$strpayload8;
							break;
						case '506f980000004076':
							$nowpayload=$strpayload6;
							break;
							
							
						case '506f980000004158':
							$nowpayload=$strpayload4;
							break;
						case '506f980000004066':
							$nowpayload=$strpayload5;
							break;
							
						case '506f9800000040a0':
							$nowpayload=$strpayload2;
							break;
						case '506f980000003462':
							$nowpayload=$strpayload9;
							break;
						case '506f980000003f39':
							$nowpayload=$strpayload3;
							break;
							
						default:
						echo "Enter Right Device ID";
					}
					 
}
?>
<div class="table-div" >
<table id="read-table">
<form action="#" method="post" >
<input type="text" name="abcde1" id="abcde12" placeholder="Enter Mac Address" style="margin-left:5%;">

<tr>
<td id="kwh"><?php echo "<h2>Kwh</h2>" ;?> </td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jkl=substr($nowpayload,32,8);}else{ $jkl=substr($nowpayload,16,8);} $jk=hexdec($jkl)/1000;echo "$jk"."kw/h";?></td>
</tr>
<tr>
<td ><?php echo "<h2>voltage</h2>" ;?> </td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jk2=substr($nowpayload,56,8);}else{$jk2=substr($nowpayload,40,8);} $jk2=hexdec($jk2)/10;echo "$jk2"."V";?></td>
</tr>
<tr>
<td ><?php echo "<h2>Current</h2>" ;?></td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jk3=substr($nowpayload,64,8);}else{$jk3=substr($nowpayload,48,8);} $jk3=hexdec($jk3)/1000;echo "$jk3"."Amp";?></td>
</tr>
<tr>
<td><?php echo "<h2>KW</h2>" ;?></td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jk4=substr($nowpayload,80,8);}else{$jk4=substr($nowpayload,56,8);} $jk4=hexdec($jk4)/1000;echo "$jk4"."kw";?></td>
</tr>
<tr>
<td><?php echo "<h2>PF</h2>" ;?></td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jk5=substr($nowpayload,72,8);}else{$jk5=substr($nowpayload,64,8);} $jk5=hexdec($jk5)/100;echo "$jk5";?></td>
</tr>
<tr>
<td><?php echo "<h2>friquency</  h2>" ;?></td>
<td><?php if(substr($nowpayload,0,16)=="524c593030303030"){$jk6=substr($nowpayload,80,8);}else{ $jk6=substr($nowpayload,72,8);} $jk6=hexdec($jk6)/100;echo "$jk6"."hz";?></td>
</tr>
<tr>
<td><input type="Submit" id="readsta" name="readstan" value="Read Status" style="margin-left:10%;"></td>
</tr>
</form>
</table>


<table id="btn-table">
<form action="" method="post">
<tr>
<td>
<input type="text"  name="abc" placeholder="Enter Mac Address" class="bar" style="margin-left:21%;"></td>
</tr>
<tr>
<td>
<input type="Submit" id="On-btn" name="on-btn" value="ON">
</td>

<td>
<input type="Submit" id="Off-btn" name="off-btn" value="OFF">
</td>
</tr>

<tr>
<td>

<input type="Submit" id="btn2" name="submit90" value="90%">

</td>
<td>

<input type="Submit" id="btn3" name="submit80" value="80%">

</td>


<td>

<input type="Submit" id="btn4" name="submit70" value="70%">

</td>
</tr>
<tr>
<td>
<input type="Submit" id="btn5" name="submit60" value="60%">

</td>


<td>

<input type="Submit" id="btn6" name="submit50" value="50%">

</td>
<td>

<input type="Submit" id="btn7" name="submit40" value="40%">

</td>
</tr>
<tr>
<td>

<input type="Submit" id="btn8" name="submit30" value="30%">

</td>
<td>

<input type="Submit" id="btn9" name="submit20" value="20%">

</td>


<td>

<input type="Submit" id="btn10" name="submit10" value="10%">
</td>

</tr>
<table class="gateway-table"">
<?php
if($timediff > 60 ){
$time = date("Y-m-d H:i:s",$lastseen);
echo '<tr><td id="gt"><h3>Gateway MAC : '.$gateway_mac.' </h3></td></tr>';
echo "<tr><td id='gt-t'><h3> Caution!!! <br>Gateway is down since: ".  date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($time)))."</h4></td></tr>";
}
else{
$time = date("Y-m-d H:i:s",$lastseen);
echo '<tr><td id="gt-t"><h3>Gateway MAC : '.$gateway_mac.' </h3></td></tr>';
echo "<tr><td id='gt-t'><h3>Gateway is UP <br> last seen: ".  date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($time)))."</h3></td></tr>";
}
?>
</table>

</form>

</table>

<table class="other-table" >
<form action="#" method="post">
<tr>
<td>
<input type="text" name="abc1" id="abc12" placeholder="Enter Mac Address" style="margin-left:20%;">
</td>
</tr>
<tr>
<td>
<input type="text" id="chs" name="chsn" placeholder="h1:m1 h2:m2">
</td>
<td>
<input type="Submit" id="submitchs" name="submitchsn" value="change schedule">
</td>
</tr>
<tr>
<td>

<input type="text" id="rtc" name="rtcn" placeholder="yy:mm:dd hh:mm:ss">
<p> For Devloper Button 1</p>
</td>
<td>
<input type="Submit" id="submitrtc" name="submitrtcn" value="Set RTC">
</td>
</tr>
<tr>
<td>
<input type="Submit" id="readm" name="readmn" Value="Read Meter">
<p id="p2"> For Devloper Button 2</p>
</td>
<td>
<input type="Submit" id="readshu" name="readshun" Value="Read schedule">
</td>
</tr>

</form>
</table>





<?php

 
        
	       if (isset($_POST['on-btn'])) {
		            $devEui= $_POST['abc'];
                    $data='RLY00000';
					
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
					
					
                    }
                    elseif (isset($_POST['off-btn'])) {
                    $devEui= $_POST['abc'];
					$data='RLY01000';
	
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit10'])) {
                    $devEui= $_POST['abc'];
					$data='DIM01000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit20'])) {
                    $devEui= $_POST['abc'];
					$data='DIM02000';
                    $data=hex_to_base64(ascii2hex($data));
				
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit30'])) {
                    $devEui= $_POST['abc'];
					$data='DIM03000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit40'])) {
                    $devEui= $_POST['abc'];
					$data='DIM04000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit50'])) {
                    $devEui= $_POST['abc'];
					$data='DIM05000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit60'])) {
                     $devEui= $_POST['abc'];
					$data='DIM06000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit70'])) {
                    $devEui= $_POST['abc'];
					$data='DIM07000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit80'])) {
                    $devEui= $_POST['abc'];
					$data='DIM08000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    }
                    elseif (isset($_POST['submit90'])) {
                    $devEui= $_POST['abc'];
					$data='DIM09000';
                    $data=hex_to_base64(ascii2hex($data));
					
                    enqueue_downlink($devEui,$data);
                    } 
                    elseif (isset($_POST['submitrtcn'])) {
                     $devEui= $_POST['abc1'];
					 $inprtc= $_POST['rtcn'];
                     $finaldata='';
                     if(strlen(dechex(substr($inprtc,0,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,0,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,0,2));
                     }

                     if(strlen(dechex(substr($inprtc,3,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,3,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,3,2));
                     }

                     if(strlen(dechex(substr($inprtc,6,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,6,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,6,2));
                     }

                     if(strlen(dechex(substr($inprtc,9,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,9,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,9,2));
                     }

                     if(strlen(dechex(substr($inprtc,12,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,12,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,12,2));
                     }

                     if(strlen(dechex(substr($inprtc,15,2))) == 1){
                      $finaldata=$finaldata."0".dechex(substr($inprtc,15,2));
                     }else{
                      $finaldata=$finaldata.dechex(substr($inprtc,15,2));
                     }
                     $finaldata="70650B8100".$finaldata;
                     
                                        
                      $data= hex_to_base64($finaldata); 
                      
                        enqueue_downlink($devEui,$data);
                    }
                     elseif (isset($_POST['readmn'])) {
						$devEui= $_POST['abcd']; 
                      $data= "AA03000100100C1D";                     
                      $data= hex_to_base64($data); 
					  
                      enqueue_downlink($devEui,$data);
                    }
					 elseif (isset($_POST['readshun'])) {
						$devEui= $_POST['abc1']; 
                      $data= "53434852454144"; 
                    					  
                      $data= hex_to_base64($data); 
					  
					  
                      enqueue_downlink($devEui,$data);
                    }  
                    elseif (isset($_POST['submitchsn'])) {
                      $data= "736368";   
                      $devEui= $_POST['abc1'];					  
                      $inpshedule=$_POST['chsn'];    
                      $finaldata=$data.substr($inpshedule, 0,2).substr($inpshedule, 3,2).substr($inpshedule, 6,2).substr($inpshedule, 9,2); 
                                  
                      $data= hex_to_base64($finaldata);
                     
                      enqueue_downlink($devEui,$data);
                    }

   
	

	 ?>


</div>
</div>
</body>
</html>



