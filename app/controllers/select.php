<?php
    header("Content-type: application/json; charset=utf-8");
    session_start();
    include "../../vendor/autoload.php";
    $con = new \funeraria\config\config();
    $object = new \funeraria\controllers\config($con->open());
    $trans = new \funeraria\models\transporte();
    $generator = new \funeraria\hooks\generator();

    switch (isset($_POST['key'])) {
        case !empty($_POST['key'] == 'cart'):
            $item = [];
            $cesto = [];
            $desconto = $descontoPromo = $subtotal = $total = 0;
            $result = $object->select("codigo, descricao, qtd, preco_un, preco_venda, dias_trans, taxa_trans", "rec_cotacao", "ref_compraid = '".((!empty($_SESSION['ref_compra'])) ? $_SESSION['ref_compra'] : 0 )."' AND email = '".((!empty($_SESSION['email'])) ? $_SESSION['email'] : "")."' AND estado = 0");
            if(mysqli_num_rows($result) > 0){
                foreach ($result as $key => $value) {
                    $tabela = $object->select_table("codigo = '".$value['codigo']."'");
                    $operador = ($tabela == 'servico') ? 'img, categoriaid, nome, preco' : 'id, img, categoriaid, modelo, marcaid, corid, preco';
                    $rows = mysqli_fetch_assoc($object->select($operador, $tabela, "codigo = '".$value['codigo']."'"));
                    if($tabela != 'servico') {
                        $cor = mysqli_fetch_assoc($object->select("nome_cor", "cor", "id='".$rows['corid']."'"));
                        $marca = mysqli_fetch_assoc($object->select("nome_marca", "marca", "id='".$rows['marcaid']."'"));
                    }
                    if(!empty($_POST['type'] == 'carrinho')) {
                        $item[] = '<tr>
                                    <td class="product-col">
                                        <img src="'.$_POST['root'].'assets/img/produtos/'.$rows['categoriaid'].'/'.$rows['img'].'.png" alt="">
                                        <div class="cc-col-details">
                                            <h4>'.(($tabela != 'servico') ? $marca['nome_marca'].' <span class="text-muted" style="font-size: 13px;">'.$rows['modelo'].'</span>' : $rows['nome'] ).'</h4>
                                            <p class="text-muted">'.number_format($value['preco_un'], 2, ".", ",").' '.$generator->moeda('m').'</p>
                                            <div class="cle-details mb-2">
                                                '.(($tabela != 'servico') ? '<label class="cs-'.$cor['nome_cor'].'" for="'.$cor['nome_cor'].'-color" style="background-color:'.$cor['nome_cor'].';border:1px solid #303030;width: 24px;height: 14px;border-radius: 25px;margin: auto;margin-left:2px;"></label>' : '' ).'
                                            </div>
                                            <div class="cc-gloom">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <span class="dec qtybtn" data-id='.$value['codigo'].' id="cc-qty">-</span>
                                                        <input type="text" value="'.$value['qtd'].'" disabled>
                                                        <span class="inc qtybtn" data-id='.$value['codigo'].' id="cc-qty"">+</span>
                                                    </div>
                                                </div>'.(($tabela == 'transporte')  ?  '<div class="days my-auto"> 
                                                                                            <input type="radio" name="options'.$rows['id'].'" class="option-days ml-2" id="'.$value['codigo'].'.1" value="1800" '.(($value['dias_trans'] == 1) ? 'checked' : '' ).'/>
                                                                                            <input type="radio" name="options'.$rows['id'].'" class="option-days ml-2" id="'.$value['codigo'].'.2" value="1800" '.(($value['dias_trans'] == 2) ? 'checked' : '' ).'/>
                                                                                            <input type="radio" name="options'.$rows['id'].'" class="option-days ml-2" id="'.$value['codigo'].'.3" value="1800" '.(($value['dias_trans'] == 3) ? 'checked' : '' ).'/>
                                                                                        </div>': '' ).'
                                                <a class="cc-gloom-del ml-2 text-right" id="cc-del" data-id="'.$value['codigo'].'">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="total-col">
                                        <h4>'.number_format(($value['qtd'] * $value['preco_un']), 2, ".", ",").' '.$generator->moeda('m').'</h4>
                                        '.(($tabela == 'transporte') ? '<h6 style="margin-right: 13px;font-weight: 200;"><span id="day">Taxa de '.((!empty($value['dias_trans'])) ? $value['dias_trans'] : '0' ).'</span> dia(s) por <span style="font-weight: bold;" id="'.$rows['id'].'">'.number_format((($value['taxa_trans'] != 0) ? ($value['dias_trans'] * $value['taxa_trans']) : '0' ), 2, ".", ",").'</span> '.$generator->moeda('m').'</h6>' : '' ).' 
                                        '.(($tabela == 'transporte') ? '<h6 style="margin-right: 13px;">'.number_format((($value['qtd'] * $value['preco_un']) +  ($value['dias_trans'] * $value['taxa_trans'])), 2, ".", ",").' '.$generator->moeda('m').'</h6>' : '' ).'
                                    </td>
                                </tr>';
                    } elseif(!empty($_POST['type'] == 'cesto')) {
                        $key++;
                        $cesto[] = '<li>
                                        <a class="photo">
                                            <img src="'.$_POST['root'].'assets/img/produtos/'.$rows['categoriaid'].'/'.$rows['img'].'.png" class="cart-thumb"/>
                                        </a>
                                        <h6><a>'.(($tabela != 'servico') ? $marca['nome_marca'] : $rows['nome'] ).'</a></h6>
                                        <p>'.$value['qtd'].'x - <span class="price">'.number_format($rows['preco'], 2, ".", ",").'</span></p>
                                    </li>';
                    }
                    $subtotal += $value['preco_venda'];
                }
                $total = $subtotal +  $descontoPromo - $desconto;
                $data = array(
                    'cesto_total' => $key,
                    'carrinho' => $item,
                    'cesto' => $cesto,
                    'subtotal' => number_format($subtotal, 2, ".", ",").' '.$generator->moeda('m'),
                    'desconto' => number_format($desconto, 2, ".", ",").' '.$generator->moeda('m'),
                    'promo' => number_format($descontoPromo, 2, ".", ",").' '.$generator->moeda('m'),
                    'total' => number_format($total, 2, ".", ",").' '.$generator->moeda('m'),
                );
            } else {
                $data = array(
                    'cesto_total' => 0,
                    'carrinho' => '<tr><td colspan="2" class="text-center py-4">Nenhum Item no carrinho!</td></tr>',
                    'cesto' => '<li class="text-center"><a>Carrinho vazio</a></li>',
                    'subtotal' => number_format(0, 2, ".", ",").' '.$generator->moeda('m'),
                    'desconto' => number_format(0, 2, ".", ",").' '.$generator->moeda('m'),
                    'promo' => number_format(0, 2, ".", ",").' '.$generator->moeda('m'),
                    'total' => number_format(0, 2, ".", ",").' '.$generator->moeda('m')
                );
            }
            echo json_encode($data);
            break;

        case !empty($_POST['key'] == "feature"):
            if(!empty($_POST['feature'] == 'cor')) {
                $operador = 'DISTINCT corid';
                $tabela = 'cor';
            } else {
                $operador = 'DISTINCT marcaid';
                $tabela = 'marca';
            }
            if(!empty($object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'"))){
                if($object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'") != 'servico'){
                    foreach ($object->select($operador, $object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'"), $_POST['type']."id='".base64_decode($_POST['val'])."'") as $key => $value) {
                        foreach ($object->select("*", $tabela, "id='".$value[$tabela.'id']."'") as $key => $row) {
                            if(!empty($_POST['feature'] == 'cor')) {
                                $data[] = '<div class="cs-item" id="cor">
                                                <input type="radio" class="cor" data-class="cc-feature" name="cs" id="'.$row['nome_cor'].'-color" value="'.$row['id'].'">
                                                <label class="cs-'.$row['nome_cor'].'" for="'.$row['nome_cor'].'-color" style="background-color:'.$row['nome_cor'].';border:1px solid #303030;"></label>
                                            </div>';
                            } else {
                                $data[] = '<li>
                                                <input type="checkbox" class="marca" data-class="cc-feature" name="marca" id="mr" value="'.$row['id'].'"/>
                                                <label>'.$row['nome_marca'].'</label>
                                            </li>';
                               
                            }
                        }
                    }
                } else {
                    $data[] = '<p class="alert-warning text-center py-1">Nenhuma '.((!empty($_POST['feature'] == 'cor')) ? 'cor' : 'marca').'</p>';
                }
            } else {
                $data[] = '<p class="alert-warning text-center py-1">Nenhuma '.((!empty($_POST['feature'] == 'cor')) ? 'cor' : 'marca').'</p>';
            }
            echo json_encode($data);
            break;

        case !empty($_POST['key'] == 'flower'):
            // $item = [];
            foreach($object->select_join("f.id AS id_img, f.fornecedor AS fornecedor, f.descricao AS info, p.categoriaid AS categoria, p.codigo AS codigo", "fornecedor f", "produto p", "f.produtoid = p.codigo", "p.codigo = '".$_POST['code']."'") as $key => $row){
                // [EN] Gets the image directory
                // [PT] Obtém o diretório da imagem
                $path = '../../assets/img/produtos/'.$row['categoria'].'/'.$row['codigo'].'/';

                // [EN] Checks if the directory exists if yes, get all files {* prefixes}, counting them from greater than 0 places them in the array
                // [PT] Verifica se o diretório existe caso sim, obter todos os ficheiros {* prefixos}, contando eles, se for maior que 0 coloca-os no array

                if(is_dir($path)) {
                    $files = glob("$path{*.jpg,*.JPG,*.png}", GLOB_BRACE);
                    // $item = $files;
                    if(count($files) != 0) {
                        $item[] = array(
                            'img' => '<div class="item"><img src="'.$_POST['url'].'assets/img/produtos/'.$row['categoria'].'/'.$row['codigo'].'/'.$row['id_img'].'.jpg" alt="IMG'.$row['codigo'].'" id="'.$key.'"></div>',
                            'info' => $row['info'],
                            'fornecedor' => $row['fornecedor']
                        );
                    }
                } else {
                    $item[] = array(
                        'img' => '<div class="item"><img src="'.$_POST['url'].'assets/img/produtos/'.$row['categoria'].'/IMG'.$row['codigo'].'.png" alt="IMG'.$row['codigo'].'" id="'.$key.'"></div>',
                        'info' => $row['info'],
                        'fornecedor' => $row['fornecedor']
                    );
                }
            }
            echo json_encode($item);
            break;
            
        // Bloco de pesquisa de produtos, servicos e transporte
        case !empty($_POST['key'] == "search"):
            foreach ($object->select('codigo, nome, modelo', 'produto', '(nome LIKE "%'.$_POST['search'].'%" OR modelo LIKE "%'.$_POST['search'].'%") AND estado="1"') as $i => $value) {
                if($i < 11) {
                    $hint[] = array('1' => $value['nome'], '2' => $value['codigo'], '3' => $value['modelo']);
                }
            }

            $retVal = (empty($hint)) ? json_encode(array('empty' => '<p class="text-dark text-center" style="margin-bottom: 2px; font-size:13px;">Item não encontrado!</p>')) : json_encode($hint);

            // $sql = "SELECT nome, modelo FROM produto";
            // $result = mysqli_query($con->open(), $sql);
            // while($fetch = mysqli_fetch_row($result)){
            //     $row[] = $fetch[0];
            // }
            echo json_encode($retVal);
            break;

        case !empty($_POST['key'] == "request"):
            $tabela = $object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'");
            $query = "SELECT * FROM ".$tabela." WHERE ".$_POST['type']."id=".base64_decode($_POST['val'])." AND estado = '1' ";
            if(isset($_POST["min"], $_POST["max"]) && !empty($_POST["min"]) && !empty($_POST["max"])){
                $query .= " AND preco BETWEEN '".$_POST["min"]."' AND '".$_POST["max"]."' ";
            }
            if(isset($_POST["cor"])) {
                $cor_filtro = implode("','", $_POST["cor"]);
                $query .= " AND corid IN('".$cor_filtro."') ";
            }
            if(isset($_POST["marca"])) {
                $marca_filtro = implode("','", $_POST["marca"]);
                $query .= " AND marcaid IN('".$marca_filtro."') ";
            }
            if(isset($_POST["codigo"])) {
                $query .= " AND codigo > '".$_POST['codigo']."' ";
            }
            if($tabela != ""){
                $description = "";
                $sql = $con->open()->query($query .= "".((!empty($_POST['limit'])) ? $_POST['limit'] : '')."");
                if(mysqli_num_rows($sql) > 0){
                    foreach ($con->open()->query($query) as $key => $value) { $key++;
                        if($value['estado'] == 1){
                            if($tabela != 'servico') {
                                $row = mysqli_fetch_assoc($object->select("nome_marca", "marca", "id='".$value['marcaid']."'"));
                            }

                            $name = (!empty($value['nome'])) ? $value['nome'] : $row['nome_marca'];
                            $model = ($tabela != 'servico') ? ((!empty($value['modelo'])) ? $value['modelo'] : '' ) : '';
                            if($tabela != 'servico') {
                                $description = "<p class='card-text text-muted' style='font-size: 14.5px'>".((empty($value['descricao'])) ? $value['lugar'].' lugares<br/>Tara: '.$value['tara'].'<br/>Peso bruto: '.$value['peso_bruto'] : $value['descricao'])."</p>";
                            }

                            if($tabela == 'produto' && $value['categoriaid'] == "3") {
                                $option = "";
                                foreach ($object->select("id, fornecedor", "fornecedor", "produtoid = '".$value['codigo']."'") as $y => $opt) {
                                    $option .= '<option value="'.$opt['id'].'">'.$opt['fornecedor'].'</option>';
                                }
                                $produto = "<select class='form-control form-control-sm form-select'>
                                                {$option}
                                            </select>";
                            } else {
                                $produto = "";
                            }

                            $item[] = '<div class="card cc-card" data-codigo = "'.$value['codigo'].'">
                                        <div class="card-header">
                                            <div class="card-img-overlay d-flex justify-content-end" style="height: 70px;">'.(($value['categoriaid'] == '3') ? '<button type="button" class="mx-2 cle-link" style="background: transparent; border: none; display: inline-block; user-select: none;" data-toggle="modal" data-whatcode="'.$value['codigo'].'" data-target="#categoriaModal" data-whatever="'.$value['nome'].'">
                                                    <i class="fa fa-ellipsis-h" id="info"></i>
                                                </button>' : "" )
                                                .'
                                            </div>
                                            <img class="card-img img-responsive" src="'.$_POST['root'].'assets/img/produtos/'.$value['categoriaid'].'/'.$value['img'].'.png" alt="funeraria">
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title">'.$name.' <span class="text-muted" style="font-size: 17.5px">'.$model.'</span></h4>
                                            '.$description.'
                                            '.$produto.'
                                        </div>
                                        <div class="card-footer">
                                            <div class="buy d-flex justify-content-between align-items-center">
                                                <div class="price text-success mt-2">
                                                    <h6 id="preco">'.number_format($value['preco'], 2, ".", ",").' '.$generator->moeda('m').'</h6>
                                                </div>
                                                <a class="btn btn-light btn-circle" id="cc-shop" data-id="'.$value['codigo'].'">
                                                    <i class="gg-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>';
                        }
                    }
                } else {
                    $item["empty"] = '<div class="col-md-12"><p class="text-center alert-warning py-3">Oops! Sem item.</p></div>';
                }
            } else {
                $item["empty"] = '<div class="col-md-12"><p class="text-center alert-warning py-3">Oops! Nenhum item encontrado.</p></div>';
            }
            echo json_encode($item);
            break;

        case !empty($_POST['key'] == "price"):
            if(!empty($object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'"))){
                $max = mysqli_fetch_row($object->select('MAX(preco) AS max', $object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'"), $_POST['type']."id='".base64_decode($_POST['val'])."'"));
                $min = mysqli_fetch_row($object->select('MIN(preco) AS min', $object->select_table($_POST['type']."id='".base64_decode($_POST['val'])."'"), $_POST['type']."id='".base64_decode($_POST['val'])."'"));
                $data = array(
                    'max' => $max[0],
                    'min' => $min[0]
                );
            } else {
                $data = array(
                    'max' => 'null',
                    'min' => 'null'
                );
            }
            echo json_encode($data);
            break;

        case !empty($_POST['key'] == 'validation'):
            $result = mysqli_num_rows($object->select('email', 'cliente', "email = '".$_POST['endereco_electronico']."'"));
            if($result == 1) {
                echo json_encode(false);
            } else {
                echo json_encode(true);
            }
            break;

        default:
            echo json_encode("Injection pattern error in key selection");
            break;
    }
?>