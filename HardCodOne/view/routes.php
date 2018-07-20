<?php

if(!isset($_SESSION)){
    session_start();
}
		if(isset($_SESSION['time']) && time()- $_SESSION['time']>900){
			header("Location:routes.php?page=logout");
		}else{
			 $_SESSION['time'] = time(); 
		}


require_once '../controller/Controller.php';

$controller = new Controller();

// u slucaju da ne stize nijedna akcija tj page setovali smo defaultni naziv da bude index
$pageGet=isset($_GET['page'])?$_GET['page']:"index";
$pagePost=isset($_POST['page'])?$_POST['page']:"index";

$page=($pageGet!='index')?$pageGet:$pagePost;


switch ($page){
	
	case 'index':
		$controller->index();
	break;
	
	case 'Registrujte se':
		$controller->insertUser();
	break;
	


}

