<?php
class Sql extends PDO {
	// Atributos.
	private $conn;
	// Métodos;
	public function __construct() {
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
	}
	// Associando os parametros ao comando. Outro métodos poderão reutilizar.
	private function setParams($statment, $parameters = array()) {
		foreach ($parameters as $key => $value) {
			// Chamada do método caso seja necessário algum tratamento.
			$this->setParam($key, $value);
		}
	}
	// bind de um paramentro somente.
	private function setParam($statment, $key, $value){
		$statment->bindParam($key, $value);
	}
	// $rawQuery = query bruta a ser tratada.
	public function query($rawQuery, $params = array()) {
		$stmt = $this->conn->prepare($rawQuery);
		// Associando os parametros ao comando. Vai saber o que fazer com cada um dos parametros.
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt;
	}
	public function select($rawQuery, $params = array()):array {
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>