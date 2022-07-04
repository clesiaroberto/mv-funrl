<?php
    include "vendor/autoload.php";
    session_start();
    $con = new \funeraria\config\config();
    $object = new \funeraria\controllers\config($con->open());
    $generator = new \funeraria\hooks\generator();
    $block = new \funeraria\head\blockHeader();
    $router =  new \funeraria\router\config();
    //

    $url = $router->_getUrl('url');

    $object::$url = $url;
    $vw = (count($router->_getUrl()) > 1) ? $router->_getUrl()[array_key_last($router->_getUrl())] : "";

    if(in_array($router->_getUrl("1"), array("logar", "registar", "recuperar"))) {
        echo $block->head($url, $vw);
    }else {
        echo $block->head($url, $vw);
        require_once "app/include/sidebar.php";
    }

    // [EN] Get all categories for link
    // [PT] Obter todas categorias para rota de link
    foreach ($object->select("id, nome", "categoria") as $value) {
        $_DEFAULT_CATEGORY [$value['id']] = $con->to_remove_accents($value['nome']);
    }
    
    $exe = explode('=', $router->_getUrl("1"));
    echo '<body class="bg-white" id="'.base64_encode($url).'">';
    switch ($router->_getUrl("1")) {
        case '':
            require_once "app/public/index.php";
            break;

        case in_array($router->_getUrl("1"), array('logar', 'registar', 'recuperar')):
            require_once 'app/public/cliente/'.$router->_getUrl("1").'.php';
            break;

        case $exe[0] == 'procurar?q':
            $_ROL = base64_encode($exe[1]);
            $_VAL = $router->_getUrl("1");
            $_TYPE = "categoria";
            require_once "app/public/categoria.php";
            break;

        case in_array($router->_getUrl("1"), $_DEFAULT_CATEGORY):
            $_ROL = (!empty($router->_getDefault()[2])) ? $router->_getRouter("2") : $router->_getRouter("1");
            $_VAL = (!empty($router->_getDefault()[3])) ? base64_decode($router->_getRouter("3")) : array_search($router->_getRouter("1"), $_DEFAULT_CATEGORY);
            $_TYPE = (!empty($router->_getDefault()[2]) && !empty($router->_getDefault()[3])) ? "subcategoria" : "categoria";
            require_once "app/public/categoria.php";
            break;
        
        case in_array($router->_getUrl("1"), array('carrinho', 'check-out')):
            require_once 'app/public/'.$router->_getUrl("1").'.php';
            break;
        
        default:
            require_once "app/public/index.php";
            break;
    }
?>

<?php
    ((in_array($router->_getUrl("1"), ["logar", "registar", "recuperar"])) ? "" : require_once "app/include/footer.php");
    
    echo '<script src="'.$url.'assets/plugin/jquery/jquery.min.js"></script>
          <script src="'.$url.'assets/plugin/jquery.lazy/jquery.lazy.js"></script>
          <script src="'.$url.'assets/plugin/popperjs/popper.min.js"></script>
          <script src="'.$url.'assets/plugin/bootstrap/js/bootstrap.min.js"></script>
          <script src="'.$url.'assets/plugin/bootsnav/js/bootsnav.js"></script>
          <script src="'.$url.'assets/plugin/jquery-ui/js/jquery-ui.min.js"></script>
          <script src="'.$url.'assets/plugin/owl/js/owl.carousel.min.js"></script>';

    if(in_array($router->_getUrl("1"), [''])) {
        echo '<script src="'.$url.'assets/js/cc.carousel.js"></script>';
    }

    if(in_array($router->_getUrl("1"), ["logar", "registar", "recuperar", "check-out"])) {
        echo '<script src="'.$url.'assets/plugin/jquery-validation/jquery.validate.js"></script>';
    }

    if($router->_getUrl("1") == 'registar') {
        echo '<script src="'.$url.'assets/plugin/jquery-steps/jquery-steps.js"></script>';
    }

    if(!in_array($router->_getUrl("1"), ["logar", "registar", "recuperar"]) AND !empty($router->_getUrl("1"))) {
        echo '<script src="'.$url.'assets/js/cc.page.js"></script>';
    }

    if($router->_getUrl("1") == 'Flores') {
        echo '<script src="'.$url.'assets/plugin/context-loader/context.loader.min.js"></script>
              <script src="'.$url.'assets/js/cc.modal.js"></script>';
    } 
        
    if(in_array($router->_getUrl("1"), ["logar", "registar", "recuperar", "check-out"])) {
        echo '<script src="'.$url.'assets/js/cc.auth.js"></script>';
    }
        
    echo '<script src="'.$url.'assets/js/cc.setting.js"></script>';

    echo '</body>';
?>