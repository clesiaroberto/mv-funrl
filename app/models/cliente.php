<?php
    namespace funeraria\models;

    class cliente {

        private $id;
        private $nome;
        private $genero;
        private $nascimento;
        private $enderecoid;
        private $contacto;
        private $email;
        private $estado;
        private $registo;

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getNome() {
            return $this->nome;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function getGenero() {
            return $this->genero;
        }

        public function setGenero($genero) {
            $this->genero = $genero;
        }

        public function getNascimento() {
            return $this->nascimento;
        }

        public function setNascimento($nascimento) {
            $this->nascimento = $nascimento;
        }

        public function getEndereco() {
            return $this->enderecoid;
        }

        public function setEndereco($endereco) {
            $this->enderecoid = $endereco;
        }

        public function getContacto() {
            return $this->contacto;
        }

        public function setContacto($contacto) {
            $this->contacto = $contacto;
        }
        
        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getEstado() {
            return $this->estado;
        }

        public function setEstado($estado) {
            $this->estado = $estado;
        }

        public function getRegisto() {
            return $this->registo;
        }

        public function setRegisto($registo) {
            $this->registo = $registo;
        }
    }
?>