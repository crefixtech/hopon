
<?php
include "functions.php";
$data='';
$method=$_GET["method"];
if(isset($_GET['data'])){
$data=$_GET['data'];
}

switch ($method) {
    case '1':
        register($data);
        break;
    
    case '2':
        login($data);
        break;
        
    case '3':
        ride($data);
        break;
        
    case '4':
        ride1($data);
        break;
        
    case '5':
        display_results();
        break;
        
         
   

    default:
        echo "Some error";
}

?>
