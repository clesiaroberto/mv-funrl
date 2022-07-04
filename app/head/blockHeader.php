<?php
    namespace funeraria\head;

    class blockHeader {

        private $public;

        function head($url, $view = "") {
            $this->public = '
            <head>
                <title>Ag&ecirc;ncia funer&aacute;ria de Mo&ccedil;ambique</title>
                <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,300i,400,400i,700,700i" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Noto+Sans+JP&family=Open+Sans:ital,wght@0,300;0,400;1,300&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/bootsnav/css/bootsnav.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/animate/animate.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/font-awesome-4.7.0/css/font-awesome.min.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/css.gg/all.css">';

            if(in_array($view, [''])) {
                $this->public .= '<link rel="stylesheet" type="text/css" href="'.$url.'assets/css/cc.carousel.css">';
            }

            if(in_array($view, ['Flores', 'Artificiais'])) {
                $this->public .= '<link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/context-loader/context.loader.min.css">';
            }
            
            $this->public .= '<link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/jquery-ui/css/jquery-ui.min.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/plugin/owl/css/owl.carousel.min.css">';

            if(in_array($view, array("logar", "registar", "recuperar", "check-out"))) {
                $this->public .= '<link rel="stylesheet" type="text/css" href='.$url.'assets/css/cc.auth.css>';
            }
            
            $this->public .= '<link rel="stylesheet" type="text/css" href="'.$url.'assets/css/cc.setting.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/css/cc.navbar.css">
                <link rel="stylesheet" type="text/css" href="'.$url.'assets/css/cc.main.css">
            </head>';

            return $this->public;
        }
    }
?>