<?php
class koneksi{
    private $host = "localhost";
    private $dbname = "surat";
    private $user = "root";
    private $pass = "";
	private $conn;
	function __construct(){
		try {
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        }catch(PDOException $exception){
			echo "<center>Koneksi ke Database Gagal. Pesan Kegagalan disebabkan oleh : <br/>: ".$exception->getMessage()."</center>";
		}
		return $this->db;
    }
    public function closeConnection() {
        $this->db = null;
    }

    
}

?>