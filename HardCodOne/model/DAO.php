<?php
require_once '../config/db.php';

class DAO{
	private $db;

	private $GET_PRODUCTS ="SELECT * FROM products ORDER BY product_name ASC";
	private $GET_BRANDS ="SELECT * FROM brands ORDER BY brand_name ASC";
	private $GET_OCCASIONS ="SELECT * FROM ocassions ORDER BY occasion ASC";
	//sledeca mi je najdraza :-)
	private $GET_SEX ="SELECT * FROM sex";
	/*private $INSERT_USER ="INSERT INTO users (first_name, last_name, email, username, password) VALUES (?,?,?,?,?)";*/
	private $INSERT_USER ="INSERT INTO `users`(`first_name`, `last_name`, `email`, `username`, `password`) VALUES ( ?, ?, ?, ?, ?)";
	private $GET_USER_BY_EMAIL ="SELECT * FROM users WHERE email=?";
	




	/*private $SELECT_DELIVERY_BY_ID_DIL="SELECT deliverys.*,auxiliary.*,products.* FROM deliverys JOIN auxiliary ON deliverys.id_del=auxiliary.id_del JOIN products ON auxiliary.id_product=products.id_product WHERE deliverys.id_del=?";*/	
	//private $INSERT_="INSERT INTO ___ ( , , , , , ) VALUES (?,?,?,?,?,?)";	
	//private $DELETE_="DELETE FROM ___ WHERE idvoz=?";
	//private $UPDATE_ ="UPDATE _____ SET __=?, __=?, __=? WHERE __=?";


	
	public function __construct(){
		
		$this->db =DB::createInstance();
		
	}
	
	
	public function getProdutcs(){
	
		$statement =$this->db->prepare($this->GET_PRODUCTS);
	
		$statement->execute();
		
		$result=$statement->fetchAll();
		return $result;
		
	} 
	
		public function getBrands(){
	
		$statement =$this->db->prepare($this->GET_BRANDS);
	
		$statement->execute();
		
		$result=$statement->fetchAll();
		return $result;
		
	} 
	
	
	public function getOccasions(){
	
		$statement =$this->db->prepare($this->GET_OCCASIONS);
	
		$statement->execute();
		
		$result=$statement->fetchAll();
		return $result;
		
	} 
	
	public function getSex(){
	
		$statement =$this->db->prepare($this->GET_SEX);
	
		$statement->execute();
		
		$result=$statement->fetchAll();
		return $result;
		
	} 

	public function insertUser($first_name, $last_name, $email, $username, $password ) {		
		
		$statement = $this->db->prepare($this->INSERT_USER);
		$statement->bindValue(1, $first_name); 
		$statement->bindValue(2, $last_name); 
		$statement->bindValue(3, $email); 		
		$statement->bindValue(4, $username);
		$statement->bindValue(5, $password);
		
		$statement->execute();

	}
		
	public function getUser($email) {		
		
		$statement = $this->db->prepare($this->GET_USER_BY_EMAIL);
		$statement->bindValue(1, $email); 
		
		$statement->execute();
	}	

	/*public function delete____($_____){
	
		$statement =$this->db->prepare($this->DELETE_);
		$statement->bindValue(1, $____);
	
		$statement->execute();	
	}*/

	
	/*public function update____( , , , , , , ) {		
		
		$statement = $this->db->prepare($this->UPDATE_);
		$statement->bindValue(1, $); 
		$statement->bindValue(2, $); 
		$statement->bindValue(3, $); 		
		$statement->bindValue(4, $);
		$statement->bindValue(5, $);
		$statement->bindValue(6, $);   
		$statement->bindValue(7, $); 
		
		$statement->execute();
	}*/
	

	/*public function get_____($____){
		
		$statement=$this->db->prepare($this->GET_);
		$statement->bindValue(1, $____);
		$statement->execute();
		$result=$statement->fetch();
		return $result;
	}*/
	
	
	
}



