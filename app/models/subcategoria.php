<?php
    namespace funeraria\models;

    class subcategoria {

        private $id;
        private $nome;
        private $categoriaid;
        private $estado;

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

        public function getCategoria() {
            return $this->categoriaid;
        }

        public function setCategoria($categoria) {
            $this->categoriaid = $categoria;
        }

        public function getEstado() {
            return $this->estado;
        }

        public function setEstado($estdo) {
            $this->estado = $estado;
        }
    }
?>