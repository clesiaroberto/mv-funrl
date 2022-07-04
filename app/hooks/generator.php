<?php
    namespace funeraria\hooks;

    class generator extends \DateTime {

        private $prefixo = "PH";
        private $digitoPrimario = "0000";
        private $digitoSecundario = "1";
        private $taxa;
        private $moeda;
        
        function __construct($time = "NOW", $timezone = "Africa/Maputo") {
            parent::__construct($time);
            // $this->setTimeZone(new DateTimeZone($timezone));
        }

        function gen_date_time() {
            return $this->format('Y-m-d H:i:s');
        }

        function gen_date() {
            return $this->format('Y-m-d');
        }

        function gen_time(){
            return $this->format('H:i:s');
        }

        function gen_cotacao($primario = null, $secundario = null) {
            // PH.idcliente.ano.mes.total.[{contador primario}.{contador secundario}]
            if ($secundario == 9) {
                $this->digitoPrimario = sprintf('%04d', $primario + 1);
                $this->digitoSecundario = 1;
            } elseif(!empty($secundario)) {
                $this->digitoPrimario = $primario;
                $this->digitoSecundario = sprintf('%1d', $secundario + 1);
            } elseif(empty($this->digitoPrimario) && empty($this->digitoSecundario)) {
                $this->digitoPrimario;
                $this->digitoSecundario;
            }
            return $this->prefixo.'.'.$this->format('Y').'.'.$this->format('m').'.'.$this->digitoPrimario.'.'.$this->digitoSecundario;
        }

        function moeda($tipo = "") {
            $m = array(
                'm' => "MZN", 
                'd' => "$",
                'r' => 'R',
                'sa' => 'ZAR'
            );

            foreach ($m as $key => $value) {
                if($key == $tipo) {
                    return $this->moeda = $value;
                }
            }
        }

        function taxa() {
            return $this->taxa = '1800';
        }
    }
?>