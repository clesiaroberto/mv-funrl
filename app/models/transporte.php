<?php
    namespace funeraria\models;

    class transporte {

        private $id;
        private $img;
        private $codigo;
        private $categoriaid;
        private $subcategoriaid;
        private $preco;
        private $marcaid;
        private $modelo;
        private $matricula;
        private $corid;
        private $lugar;
        private $tara;
        private $presoBruto;
        private $estado;

        protected $trans;

        /**
         * Get the value of id
         */ 
        public function getId() {
            return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id) {
            $this->id = $id;
            return $this;
        }

        /**
         * Get the value of img
         */ 
        public function getImg() {
            return $this->img;
        }

        /**
         * Set the value of img
         *
         * @return  self
         */ 
        public function setImg($img) {
            $this->img = $img;
            return $this;
        }

        /**
         * Get the value of codigo
         */ 
        public function getCodigo() {
            return $this->codigo;
        }

        /**
         * Set the value of codigo
         *
         * @return  self
         */ 
        public function setCodigo($codigo) {
            $this->codigo = $codigo;
            return $this;
        }

        /**
         * Get the value of trans
         */ 
        public function getTrans() {
            return $this->trans;
        }

        /**
         * Set the value of trans
         *
         * @return  self
         */ 
        public function setTrans($trans) {
            $this->trans = $trans;
            return $this;
        }
    }
?>