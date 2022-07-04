<?php
    namespace funeraria\controllers;
    use \funeraria\models\url;

    class config extends url {
        function __construct($con) {
            global $conn;
            $this->conn = $con;
        }

        function insert($table, $data) {
            $columns = implode(", ", array_keys($data));
            
            $sql = "INSERT IGNORE INTO $table ($columns) VALUES(";
            for ($i = 0; $i < count($data); $i++) { 
                $value[$i] = '"'.array_values($data)[$i].'"';
            }
            $sql .= implode(", ", $value).")";
            return (mysqli_query($this->conn, $sql)) ? mysqli_insert_id($this->conn) : "Error: " . $sql . "<br>" . mysqli_error($this->conn);
            mysqli_close($this->conn);
        }


        function delete($table, $where = "") {
            $sql = "DELETE FROM $table WHERE $where";
            return (mysqli_query($this->conn, $sql)) ? '1' : "Error deleting: " . mysqli_error($this->conn);
        }

        function select($operador, $table, $where = "") {
            $sql = (empty($where)) ? "SELECT $operador FROM $table" : "SELECT $operador FROM $table WHERE $where" ;
            return ($result = mysqli_query($this->conn, $sql)) ? $result : "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }

        function select_join($operador, $table_one, $table_two, $on, $where="") {
            $sql = "SELECT $operador FROM $table_one INNER JOIN $table_two ON $on WHERE $where";
            return ($result = mysqli_query($this->conn, $sql)) ? $result : "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }

        function select_table($where) {
            $tables = array('1' => 'produto', '2' => 'servico', '3' => 'transporte');
            $variable = "";
            foreach ($tables as $key => $table) {
                $sql = "SELECT * FROM $table WHERE $where";
                $result = mysqli_query($this->conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    $variable = $table;
                }
            }
            return $variable;
        }

        function update($table, $data, $where = "") {
            foreach ($data as $index => $value) {
                $key[] = $index.' = '.$value;
            }
            $set = implode(", ", $key);
            $sql = "UPDATE $table SET $set WHERE $where";
            return ($result = mysqli_query($this->conn, $sql)) ? "1" : "Error updating : " . mysqli_error($this->conn);
        }

        function logar($table, $data) {
            $sql = "SELECT cliente.id, apelido, email, senha, genero, $table.estado FROM cliente INNER JOIN $table ON $table.usuarioid = cliente.id WHERE cliente.".array_keys($data)[0]." = '".array_values($data)[0]."' AND $table.".array_keys($data)[1]." = '".array_values($data)[1]."' LIMIT 1";
            return mysqli_query($this->conn, $sql);
        }

        function sair() {
            unset($_SESSION['id']);
            unset($_SESSION['nome']);
            unset($_SESSION['email']);
            unset($_SESSION['estado']);
            unset($_SESSION['genero']);
            unset($_SESSION['ref_compra']);
            session_destroy();
        }
    }
?>