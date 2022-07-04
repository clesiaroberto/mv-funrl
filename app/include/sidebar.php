<div class="section-header py-3 bg-light">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9">
                    <form class="header-search-form">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <button class="btn dropdown-toggle cc-dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Categoria</button>
                            <div class="dropdown-menu" style="border-bottom: 2px solid rgb(104, 189, 69); border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
                                <?php
                                    foreach ($object->select("id, nome", "categoria", "estado='1'") as $key => $value) {
                                        echo '<a class="dropdown-item" href="'.$url.''.$con->to_remove_accents($value['nome']).'">'.$value['nome'].'</a>';
                                    }
                                ?>
                            </div>
                          </div>
                          <input type="text" class="form-control cc-form-search" name="procura" id="procura" placeholder="Procura o que precisa." area-label="Procura o que precisa.">
                          <div id="result-search"></div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-3 col-lg-2 m-auto">
                    <div class="user-panel">
                        <div class="up-item">
                            <div id="user-card">
                                <i class="gg-profile"></i>
                                <?php if(!empty($_SESSION['loggin']) == true && !empty($_SESSION['apelido'])){
                                    echo '<a>'.$_SESSION['apelido'].'</a>&nbsp;|&nbsp;<a id="sair">Sair</a>';
                                } else {
                                    echo '<a href="'.$url.'logar">Entrar</a>&nbsp;ou&nbsp;<a href="'.$url.'registar">Criar conta</a>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inicio Main Top -->
<header class="main-header">
    <!-- Inicio Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light cle-bg-white navbar-default bootsnav p-0">
        <div class="container">
            <!-- Inicio Header Navigation -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="<?=$url?>">
                    <img src="<?=$url.'/assets/img/administracao/logo/logo.png'?>" class="logo" alt="">
                </a>
            </div>
            <!-- Fim Header Navigation -->

            <!-- Coleccao de nav links, forms, e outro conteudos para toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav mx-auto" data-in="fadeInUp" data-out="fadeOutDown">
                    <li class="nav-item active"><a class="nav-link" href="<?=$url?>">Home</a></li>
                    <?php
                        $menu = $codigo = '';
                        foreach ($object->select("*", "categoria") as $key => $value) {
                            // -> Procura a tabela com o atributo da categoria <- //
                            if($value['nome'] == 'Serviços' || $value['nome'] == 'Transporte') {
                                $codigo = mysqli_fetch_row($object->select_join('t.img', (($value['nome'] == 'Serviços') ? 'servico t' : 'transporte t'), 'subcategoria s', 't.subcategoriaid=s.id', "t.estado='1' AND t.categoriaid='".$value['id']."' ORDER BY RAND()"));
                            }else {
                                $codigo = mysqli_fetch_row($object->select_join('t.img', 'produto t', 'subcategoria s', 't.subcategoriaid=s.id', "t.estado='1' AND t.categoriaid='".$value['id']."' ORDER BY RAND()"));
                            }
                            if($value['estado'] == 1){
                                if($key != 4) {
                                    $menu .= '<li class="dropdown megamenu-fw">
                                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">'.$value['nome'].'</a>
                                                <ul class="dropdown-menu megamenu-content" role="menu">
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-menu col-md-7">
                                                                <ul class="menu-col">';
                                    foreach ($object->select("*", "subcategoria", "categoriaid='".$value['id']."'") as $index => $row) {
                                        if($row['estado'] == 1) {
                                                            $menu .= '<li><a onclick=\'window.location=("'.$url.''.$con->to_remove_accents($value['nome']).'/'.str_replace("/", "-", $row['nome']).'/'.base64_encode($row['id']).'");return false;\'>'.str_replace("/", " - ", $row['nome']).'</a></li>';
                                        }
                                    }
                                    $menu .= '                  </ul>
                                                            </div>
                                                            <div class="col-menu col-md-5">
                                                                <img src="'.$url.'assets/img/produtos/'.((!empty($codigo[0])) ? $value['id'].'/'.$codigo[0] : 'default' ).'.png" class="responsive navbar-img" alt="funeraria"/>   
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>';
                                } else {
                                    $menu .= '<li class="nav-item"><a class="nav-link" style="padding-right: 10px!important; cursor:pointer;" onclick=\'window.location=("'.$url.''.$value['nome'].'/'.base64_encode($row['id']).'");return false;\'>'.$value['nome'].'</a></li>';
                                }
                            }
                        }
                        echo $menu;
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

            <!-- Inicio Atributo Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="side-menu">
                        <a href="#">
                            <i class="gg-shopping-cart"></i>
                            <span class="badge">0</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Fim Atributo Navigation -->
        </div>
        <!-- Inicio Side Menu -->
        <div class="side">
            <a href="#" class="close-side"><i class="gg-close"></i></a>
            <div class="cart-box">
                <ul class="cart-list">
                    <!-- Aplicar produtos -->
                </ul>
                <ul class="cart-total">
                    <li class="total">
                        <span class="float-right mb-1"><strong>Total</strong>: <span id="cesto">0 MZN</span></span>
                        <button class="btn btn-success btn-block cle-btn-rounded" id="summary" <?='onclick=\'window.location=("'.$url.'carrinho");return false;\''?> disabled>Carrinho</button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Fim Side Menu -->
    </nav>
    <!-- Fim Navigation -->
</header>
<!-- Fim Main Top -->