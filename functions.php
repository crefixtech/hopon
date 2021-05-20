<?php
require "connection.php";

function register($data){
    global $conn1;
    $myArray = explode('-', $data);
    $name=$myArray[0];
    $mobile=$myArray[1];
    $email=$myArray[2];
    $dob=$myArray[3];
    $gender=$myArray[4];
    $address=$myArray[5];
    $city=$myArray[6];
    $state=$myArray[7];
    $pincode=$myArray[8];
    $profession=$myArray[9];
    $income=$myArray[10];
    $candrive=$myArray[11];
    $owncar=$myArray[12];
    $referralcode=$myArray[13];
    $cash = 0;
    $newuserid = 0;

    $sql=mysqli_query($conn1,"insert into user(name,mobile,email,dob,gender,address,city,state,pincode,profession,income,candrive,owncar,referralcode) values('$name','$mobile','$email','$dob','$gender','$address','$city','$state','$pincode','$profession','$income','$candrive','$owncar','$referralcode')");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    
    if($sql){
        

        
  
    $query1=mysqli_query($conn1,"select * from user where mobile='".$mobile."'");
if($query1)
    {
        while($row=mysqli_fetch_array($query1))
        {
        $newuserid = ($row[0]);
        print(($row[0]));
        }
        
        if ($referralcode !== '')
        {
            
        $query2=mysqli_query($conn1,"select cashback_earned from user where id='".$referralcode."'");
        
    if($query2)
    {
        while($row=mysqli_fetch_array($query2))
        {
      //  print(($row[0]));
         $cash = (int) ($row[0]) + 50;
         
               $sq11=mysqli_query($conn1,"UPDATE user SET cashback_earned='".$cash."' WHERE id='".$referralcode."'");
               
                $sq11=mysqli_query($conn1,"UPDATE user SET cashback_earned='50' WHERE id='".$newuserid."'");
        
        }

        
    }
    

    
        }
        


        
    }
    
    }
    else{
        print("0");
    }
}


function ride($data){
    

    global $conn1;
    
    $myArray = explode('-', $data);
  
    $userid=$myArray[0];
    $pickup_location=$myArray[1];
    $pickup_id=$myArray[2];
    $dropoff_location=$myArray[3];
    $dropoff_id=$myArray[4];
    $pickup_time=$myArray[5];
    $dropoff_time=$myArray[6];
    $deliverytype=$myArray[7];
    
    
    $sql = "INSERT INTO rides (userid,pickup_location,pickup_id,pickup_time,deliverytype)
VALUES ('$userid','$pickup_location','$pickup_id','$pickup_time','$deliverytype')";

if (mysqli_query($conn1, $sql)) {
    $last_id = mysqli_insert_id($conn1);
    print($last_id);
} else {
    print("0");
}
    

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


}



function ride1($data){
    

    global $conn1;
    
    $myArray = explode('-', $data);
  
    $rideid=$myArray[0];
    $cartype=$myArray[1];
    $transmission=$myArray[2];
  


$sql=mysqli_query($conn1,"UPDATE rides SET cartype='".$cartype."',transmission='".$transmission."' WHERE id='".$rideid."'");

        if($sql){
        echo "Updated";
    }
    else{
        echo "Error";
    }

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


}


function display_results(){
global $conn1;

    $query=mysqli_query($conn1,"SELECT * FROM result");
    if($query)
    {
        while($row=mysqli_fetch_array($query))
        {
            $flag[]=$row;
        }

        print(json_encode($flag));
    }
    mysqli_close($conn1);


}




function login($data){
    global $conn1;
 
$myArray = explode('-', $data);
$mobile=$myArray[0];
$otp=$myArray[1];


$query="select * from user where mobile='".$mobile."'";
$result=mysqli_query($conn1,$query);





$fields = array(
    "message" => "Welcome to Hop On. Your Verification Code is ".$otp,
    "language" => "english",
    "route" => "q",
    "numbers" => $mobile,
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($fields),
  CURLOPT_HTTPHEADER => array(
    "authorization: yZXwcqTi3H7QrYOl1Gu6hWtVnCkmjI895gEsL0pvxD2MFzKPoNlF3Tz1BHfY5Duam0C7oNe8Gb94iRE6",
    "accept: */*",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//  echo $response;
}

if(mysqli_num_rows($result)>0){

    $query1=mysqli_query($conn1,"select id from user where mobile='".$mobile."'");
if($query1)
    {
        while($row=mysqli_fetch_array($query1))
        {
        print(($row[0]));
        }

        
    }
    
    
}
else{
   print("0");
}

    
    
}


?>