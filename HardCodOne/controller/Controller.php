<?php
require_once '../model/DAO.php';

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}


class Controller{
	
	public function index(){
		include 'login.php';
	}
	
	public function showinsert(){
		include 'insertvozilo.php';
	}
	
	public function insert(){
		$imepro=isset($_GET['imepro'])?$_GET['imepro']:"";
		$model=isset($_GET['model'])?$_GET['model']:"";
		$kategorija=isset($_GET['kategorija'])?$_GET['kategorija']:"";
		$godiste=isset($_GET['godiste'])?$_GET['godiste']:"";
		$kubikaza=isset($_GET['kubikaza'])?$_GET['kubikaza']:"";
		$cena=isset($_GET['cena'])?$_GET['cena']:"";
		
		//prazan niz za greske
		$errors=array();
		
		if(empty($imepro)|| $imepro=='Odaberite proizvodjaca'){
			$errors['imepro']='Morate odabrati proizvodjaca';
		}
		
		if(empty($model)){
			$errors['model']='Morate uneti model vozila.';
		}
		
		if(empty($kategorija)|| $kategorija=='Odaberite kategoriju'){
			$errors['kategorija']='Morate odabrati kategoriju vozila.';
		}
		
		if(empty($godiste)){
			$errors['godiste']='Morate uneti godiste vozila';
		}else{
			if(is_numeric($godiste)){
			    if($godiste>1940 || $godiste<2018){				
			    }else{
					$errors['godiste']='Ne postoji odabrano godiste.';
			    }					
			}else{
				$errors['godiste']='Godiste mora biti numericka vrednost';
			}
		}
	
		
		if (empty($kubikaza)){
			$errors['kubikaza']='Morate uneti kubikazu';
		}else{
			if (is_numeric($kubikaza)){
				if ($kubikaza<6000 || $kubikaza>49){
				}else{
				$errors['kubikaza']='Morate uneti kubikazu koja je manja od 6000 i veca od 49';
				}
			}else{
			$errors['kubikaza']='Kubikaza mora biti numericka vrednost';
			}
		}
		
		if (!empty($cena)){
			if (is_numeric($cena)){
				if ( $cena>0){
				}else{
					$errors['cena']='Cena mora biti broj veci od 0';
				}
			}else{
				$errors['cena']='Cena mora biti numericka vrednost';
			}
		}else{	
			$errors['cena']='Morate uneti cenu vozila';
		}
	
		if(count($errors)==0){
			$dao=new DAO();
			$dao->insertVozilo($imepro, $model, $kategorija, $godiste, $kubikaza, $cena);
			$msg='Uspesno ste uneli vozilo';
			include 'insertvozilo.php';
		}else{
			$msg='Vozilo nije uneseno';
			include 'insertvozilo.php';
		}
		
	}
	

	public function showvozacvozilo(){
		include 'vozacvozilo.php';
	}


	public function insertvozacvozilo(){
			$idvzl=isset($_GET['idvzl'])?$_GET['idvzl']:"";
			$idvoz=isset($_GET['idvoz'])?$_GET['idvoz']:"";
			
			if(!empty($idvoz)&&!empty($idvzl)){
				
				$dao=new DAO();
				$dao->insertVozacVozilo($idvzl, $idvoz);
				$msg="Uspesna dodela.";
				include 'vozacvozilo.php';
				
			}else{
				$msg="Morate odabrati i vozaca i vozilo.";
				include 'vozacvozilo.php';
			}
		
	}
	public function showinsertvozac(){
		include 'insertvozac.php';
	}
	
	public function insertvozac(){
        
        $ime= isset($_GET['ime'])? $_GET['ime']:"";
        $prezime= isset($_GET['prezime'])? $_GET['prezime']:"";
        $godiste= isset($_GET['godiste'])? $_GET['godiste']:"";
        
        $errors= array();
        
        if(empty($ime))
        
        $errors['ime']='Morate popuniti ime';
        
            if(empty($prezime))
        
        $errors['prezime']='Morate popuniti prezime';
        
            if(empty($godiste)){
        
        $errors['godiste']='Morate popuniti godiste';
        
            }else{
                if(is_numeric($godiste)){

                    if($godiste<1960 || $godiste>= (2017-18))  // provera godista za vozaca
                    
                     $errors['godiste']='Godiste mora biti izmedju 1960 i 1999';     
                    
                }else{
                    
                $errors['godiste']='Godiste mora biti broj';
                }
            }
            // do ove linije sve bilo za greske 
            
            if(count($errors)==0){
                
                $dao=new DAO();
                $dao-> insertVozac($ime, $prezime, $godiste);
                $msg='Uspesan unos';    
                
            }else{
                $msg='Morate popuniti sva polja';
                
            }
            include 'insertvozac.php';
    }
    
	public function svivozaci(){
			$dao=new DAO();
			$listavozaca=$dao->getVozaci();
			include 'svivozaci.php';		
	}
		
	public function svavozila(){
			$dao=new DAO();
			$listavozila=$dao->getVozila();
			include 'svavozila.php';		
	}
	
		
	public function deletevozac(){
			$idvoz=isset($_GET['idvoz'])?$_GET['idvoz']:"";
			
			if (!empty($idvoz)){
				$dao=new DAO();
				$dao->deleteVozac($idvoz);		
			}
			
			$dao=new DAO();
			$listavozaca=$dao->getVozaci();
			include 'svivozaci.php';			
	}
	
	
	public function deletevozilo(){
			$idvzl=isset($_GET['idvzl'])?$_GET['idvzl']:"";
			
			if (!empty($idvzl)){
				$dao=new DAO();
				$dao->deleteVozilo($idvzl);			
			}
			
			$dao=new DAO();
			$listavozila=$dao->getVozila();
			include 'svavozila.php';
	}
	
	
	public function showeditvozac(){
			$idvoz=isset($_GET['idvoz'])?$_GET['idvoz']:"";
			
			if (!empty($idvoz)){
				$dao=new DAO();
				$vozac=$dao->getVozacById($idvoz);
				include 'editvozac.php';
			}else{
				$msg="Los idvoz";
				$dao=new DAO();
				$listavozaca= $dao->getVozaci();
				include 'svivozaci.php';
			}
	}

    public function editvozac(){
		
		$ime= isset($_POST['ime'])? $_POST['ime']:"";
		$prezime= isset($_POST['prezime'])? $_POST['prezime']:"";
		$godiste= isset($_POST['godiste'])? $_POST['godiste']:"";
		$idvoz= isset($_POST['idvoz'])? $_POST['idvoz']:"";
		
		//var_dump($idvoz);
		$errors= array();
		
		if(empty($ime))
		
		$errors['ime']='Morate popuniti ime';
		
			if(empty($prezime))
		
		$errors['prezime']='Morate popuniti prezime';
		
			if(empty($godiste)){
		
		$errors['godiste']='Morate popuniti godiste';
		
			}else{
				if(is_numeric($godiste)){

					if($godiste<1960 || $godiste>= (2017-18))  // provera godista za vozaca
					
					 $errors['godiste']='Godiste mora biti izmedju 1960 i 1999';	 
					
				}else{
					
		        $errors['godiste']='Godiste mora biti broj';
				}
			}
			
			// sve dovde  
			
			if(count($errors)==0){
				
				$dao=new DAO();
				$dao->updateVozacById($ime, $prezime, $godiste, $idvoz);
				$msg='Uspesan edit';
				$listavozaca= $dao->getVozaci();
				
				$editovaniidvoz=$idvoz;
					
				include 'svivozaci.php';
				
			}else{
				$msg='Neuspesan edit';
				include 'editvozac.php';				
			}						
	}
	
	
	public function showeditvozilo(){
			$idvzl=isset($_GET['idvzl'])?$_GET['idvzl']:"";
			
			if (!empty($idvzl)){
				$dao=new DAO();
				$vozilo=$dao->getVoziloById($idvzl);
				include 'editvozilo.php';
			}else{
				$msg="Los idvzl";
				$dao=new DAO();
				$listavozila= $dao->getVozila();
				include 'svavozila.php';
			}
	}
	
	public function editvozilo(){
		
		$imepro= isset($_POST['imepro'])? $_POST['imepro']:"";
		$model= isset($_POST['model'])? $_POST['model']:"";
		$kategorija= isset($_POST['kategorija'])? $_POST['kategorija']:"";
		$godiste= isset($_POST['godiste'])? $_POST['godiste']:"";
		$kubikaza= isset($_POST['kubikaza'])? $_POST['kubikaza']:"";
		$cena= isset($_POST['cena'])? $_POST['cena']:"";		
		$idvzl= isset($_POST['idvzl'])? $_POST['idvzl']:"";
		
		//var_dump($idvoz);
		$errors= array();
		

		if(empty($imepro)){
			$errors['imepro']='Morate odabrati proizvodjaca';
		}
		
		if(empty($model)){
			$errors['model']='Morate uneti model vozila.';
		}
		
		if(empty($kategorija)){
			$errors['kategorija']='Morate odabrati kategoriju vozila.';
		}
		
		if(empty($godiste)){
			$errors['godiste']='Morate uneti godiste vozila';
		}else{
			if(is_numeric($godiste)){
			    if($godiste>1940 || $godiste<2018){				
			    }else{
					$errors['godiste']='Ne postoji odabrano godiste.';
			    }					
			}else{
				$errors['godiste']='Godiste mora biti numericka vrednost';
			}
		}
	
		if (empty($kubikaza)){
			$errors['kubikaza']='Morate uneti kubikazu';
		}else{
			if (is_numeric($kubikaza)){
				if ($kubikaza<6000 || $kubikaza>49){
				}else{
				$errors['kubikaza']='Morate uneti kubikazu koja je manja od 6000 i veca od 49';
				}
			}else{
			$errors['kubikaza']='Kubikaza mora biti numericka vrednost';
			}
		}
		
		if (!empty($cena)){
			if (is_numeric($cena)){
				if ( $cena>0){
				}else{
					$errors['cena']='Cena mora biti broj veci od 0';
				}
			}else{
				$errors['cena']='Cena mora biti numericka vrednost';
			}
		}else{	
			$errors['cena']='Morate uneti cenu vozila';
		}
	
			
	
			
			if(count($errors)==0){
				
				$dao=new DAO();
				$dao->updateVoziloById($imepro, $model, $kategorija, $godiste, $kubikaza, $cena, $idvzl);
				$msg='Uspesan edit';
				$listavozila= $dao->getVozila();

				$editovaniidvzl=$idvzl;
				
				include 'svavozila.php';
				
			}else{
				$msg='Neuspesan edit';
				include 'editvozilo.php';
		
				
			}
									
	}
	
	
    public function insertUser(){
    	
        $first_name=isset($_POST['first_name'])?$_POST['first_name']:"";
    	$last_name=isset($_POST['last_name'])?$_POST['last_name']:"";
    	$email=isset($_POST['email'])?$_POST['email']:"";
    	$username=isset($_POST['username'])?$_POST['username']:"";
    	$password=isset($_POST['password'])?$_POST['password']:"";
    	$cpassword=isset($_POST['cpassword'])?$_POST['cpassword']:"";
    	

    	
    	$errors= array();
        
        if(empty($first_name)){        
            $errors['first_name']='Morate popuniti ime';
    	}else{
        	$first_name = test_input($first_name);
        	if (!preg_match("/^[a-zA-Z ]*$/",$first_name)){
            	$errors['first_name'] = 'Za ime koristite iskljucivo slova i prazan prostor'; 
        	}
    	}    
        
        if(empty($last_name)){        
             $errors['last_name']='Morate popuniti prezime.';
        }else{
        	$last_name = test_input($last_name);
        	if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
            	$errors['last_name'] = 'Za prezime koristite iskljucivo slova i prazan prostor'; 
        	}
    	}       
             
        if(empty($email)){       
             $errors['email']='Morate popuniti email.';            
        }else{
			$email = test_input($email);
           if (filter_var($email, FILTER_VALIDATE_EMAIL)) {              
           }else{
                 $errors['email']="Format email-a nije dobar";
           }       	      	
        }
        
        if(empty($username)){
        
            $errors['username']='Morate popuniti username.';
            
         }else{
         	if (preg_match('/^[A-Za-z0-9_-]*$/', $username)) {
    			$dao=new DAO();
    			$istiun=$dao->getKorisnikByUn($username);
    			if(count($istiun)>0){
    				$errors['username']='Izabrani username je zauzet';
    			}else{
    			}
			}else{
				$errors['username']='Upotrebili ste nedozvoljene karaktere';
         }
         } 
         
         if(empty($password)){        
            $errors['password']='Morate popuniti password';                       
         }elseif (empty($cpassword)){        
            $errors['password']='Morate potvrditi password';
         }else{
         	$password = test_input($password);	
         	$cpassword = test_input($cpassword);
         	if ($password!==$cpassword){ 
            	$errors['password'] = "Uneti i potvrdjeni password se ne podudaraju!";        	          
            }
            elseif (strlen($password) <= '7') {
            	$errors['password'] = "Password mora imati najmanje 7 karaktera!";
        	}
        	elseif(!preg_match("#[0-9]+#",$password)) {
            	$errors['password'] = "Password mora sadrzati barem jedan broj!";
        	}
        	elseif(!preg_match("#[A-Z]+#",$password)) {
            	$errors['password'] = "U passwordu morate upotrebiti barem jedno veliko slovo!";
        	}
        	elseif(!preg_match("#[a-z]+#",$password)) {
            	$errors['password'] = "U passwordu morate upotrebiti barem jedno malo slovo!";
        	}
          }
            var_dump($errors);
            /*
    		if(count($errors)==0){
                
                $dao=new DAO();
                $dao->insertUser($first_name, $last_name, $email, $username, $password);
                $msg='Uspesna registracija, unesite vas username i password';
                include 'login.php';                    
            }else{
            	$msg='Morate pravilno popuniti sva polja'; */
            	include 'registracija.php';
                 
            /*}    	    	*/
    }
	
    
	public function login(){
		$username=isset($_POST['username'])?$_POST['username']:"";
    	$password=isset($_POST['password'])?$_POST['password']:"";
		
    	if(empty($username)){      
            $errors['username']='Morate popuniti username.';
            include 'login.php';            
        }else{         	
    			$dao=new DAO();
    			$user=$dao->getKorisnikByUn($username);
    			
    			if($user){
    				
    				if( $password===$user['password']){
    					    					   					
              				session_start();              				
							$_SESSION['ulogovan']=serialize($user);			
          					include 'welcome.php';
     
    				}else{
    					$errors['password']='Pogresan password';
    					include 'login.php';  				
    				}
    			}else{
    				$msg='Ne postoji uneti username, mozete se registrovati';
    				include 'registracija.php';
    			}	
         }   
    	
	}

	public function logout(){
		session_start();
		session_unset();
		session_destroy();
		include 'login.php';
	
	}

	public function showregistracija(){
		include 'registracija.php';
	
	}	
	
	
}

				
				
				
							
			
  