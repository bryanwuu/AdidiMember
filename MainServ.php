<?php
$jsonString = false;


if(count($_GET)>0)
	$jsonString = $_GET['Param'];
else if(count($_POST) > 0){
	$jsonString =  $_POST['Param'];

}else{
	echo "no param";
	return;
}
//echo 'php Param=' . $jsonString;
$paramObject = JSON_decode ( $jsonString );

// echo 'password = ' . $paramObject->password;
// echo 'username = ' . $paramObject->username;
// echo 'email = ' . $paramObject->email;
echo '{"bSuccess":true}';

?>
