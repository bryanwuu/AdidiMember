<?php
$jsonString = false;


if(count($_GET)>0)
	$jsonString = $_GET['Param'];
else if(count($_POST) > 0){
	$jsonString =  $_POST['Param'];

}else{
	echo '{"bSuccess":false,"Message":"no param"}';
	return;
}

$paramObject = JSON_decode ( $jsonString );
echo $jsonString;
return;
// echo 'password = ' . $paramObject->password;
// echo 'username = ' . $paramObject->username;
// echo 'email = ' . $paramObject->email;


$cmd = $paramObject->cmd;
if($cmd == 'NewUser'){
	NewUser($paramObject);
	return;
}else if($cmd == 'UpdateUserProfile'){
	UpdateUserProfile($paramObject);
	return;
	
}else if($cmd == 'DeleteUser'){
	DeleteUser($paramObject);
	return;
	
}else if($cmd == 'UpdateUserPassword'){
	UpdateUserPassword($paramObject);
	return;
	
}else if($cmd == 'ListUser'){
	echo 'abc';
	ListUser($paramObject);
	return;
	
}else if($cmd == 'SignIn'){
	SignIn($paramObject);
	return;
	
}else{
	echo '{"bSuccess":false,"Message":"no command"}';
	return;
}
	

echo '{"bSuccess":true}';

function NewUser (&$param){
	//echo '{"bSuccess":false,"Request = ":'.$jsonString.'"}';
$fp=fopen("password.txt","w");
 fputs($fp,$param->username .':'.$param->password);
 fclose($fp);
 
 $fp=fopen("userprofile.txt","w");
 fputs($fp,$param->username .':'.$param->email);
 fclose($fp);
 
}

function ListUser (&$param){
	//echo '{"bSuccess":false,"Request = ":'.$jsonString.'"}';
	$fp=fopen("userprofile.txt","r");
	$linenumber = 0;
	while(!feof($fp)){
		$mycsv[]=fgetcsv($fp,2048,":");
		$linenumber++;
	//	echo $mycsv[];
	}
	fclose($fp);
	echo 'abc';
	//print_r($fp);
	
}

function UpdateUserProfile (&$param){
	$fp=fopen("userprofile.txt","w");
	$linenumber = 0;
	while(!feof($fp)){
		$mycsv[]=fgetcsv($fp,2048,":");
		$linenumber++;
		echo $mycsv[];
	}
	fclose($fp);
}

function DeleteUser(&$param){
}

function SignIn(&$param){
}

function UpdateUserPassword(&$param){
}




?>
