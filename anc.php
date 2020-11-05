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

enqueue_downlink("506f9800000030e2","1234");

?>		  