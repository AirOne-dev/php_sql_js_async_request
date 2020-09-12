<?php

class Vehicle {

	private $idvehicle, $model, $brand, $power, $color, $energy, $price;

	// Le constructeur unique (pas de polymorphisme en php !)
	public function __construct() { }

	public function __toString() {
		return
		'
		<table>
			<tr>
				<td>Id du véhicule : </td>
				<td>' . $this->idvehicle . '</td>
			</tr>
			<tr>
				<td>Modèle : </td>
				<td>' . $this->model . '</td>
			</tr>
			<tr>
				<td>Marque : </td>
				<td>' . $this->brand . '</td>
			</tr>
			<tr>
				<td>Puissance : </td>
				<td>' . $this->power . '</td>
			</tr>
			<tr>
				<td>Couleur : </td>
				<td style="background-color: '.$this->color.'">' . $this->color . '</td>
			</tr>
			<tr>
				<td>Energie : </td>
				<td>' . $this->energy . '</td>
			</tr>
			<tr>
				<td>Prix : </td>
				<td>' . $this->price . '€</td>
			</tr>
		</table>
		';
	}


	public function __get($attr) {
		if (property_exists(get_class($this), $attr))
			return $this->$attr; 
		else
			throw new Exception("L'attribut n'existe pas !");
	}
	public function __set($attr, $value) {   
		if (property_exists(get_class($this), $attr)) {
			$this->$attr = $value;
			global $db;
			$stm = $db->prepare('UPDATE vehicle_martine SET ?=? WHERE idvehicle=?');
			$stm->execute([$attr, $value, $this->idvehicle]);
		}
		else
			throw new Exception("L'attribut n'existe pas !");
	}

	public static function load_by_id ($idvehicle) {
      	global $db;

      	$stm = $db->prepare('SELECT * FROM vehicle_martine WHERE idvehicle = :idvehicle');
      	$stm->bindValue(":idvehicle", $idvehicle);
      	$stm->execute();

      	return $stm->fetchObject(__CLASS__);
   }

   public static function get_vehicle_range($start, $length) {
		global $db;

		$stm = $db->prepare('SELECT * FROM vehicle_martine order by idvehicle offset ? limit ?');
		$stm->execute([$start, $length]);

		$return = array();

		while ($vehicle = $stm->fetchObject(__CLASS__)) { $return[] = $vehicle; }

		return $return;

   }

   public static function insert_voiture_db($voiture) {
   		global $db;

   		$stm = $db->prepare('INSERT INTO vehicle_martine (model, brand, power, color, energy, price) VALUES(?, ?, ?, ?, ?, ?)');
   		$stm->execute([$voiture->model, $voiture->brand, $voiture->power, $voiture->color, $voiture->energy, $voiture->price]);
   }


}