<?php
    header("Content-type: application/json; charset=utf-8");
    include "../../vendor/autoload.php";
    session_start();
    $con = new \funeraria\config\config();
    $object = new \funeraria\controllers\config($con->open());
    $generator = new \funeraria\hooks\generator();
    use \funeraria\hooks\demo;
    
    $timezone = new DateTimeZone ("Africa/Maputo");
    $date = new DateTime ();
    $date -> setTimezone ( $timezone );

    switch (isset($_POST['key'])) {
        case !empty($_POST['key'] == 'cliente'):
            $result = mysqli_num_rows($object->select('email', 'cliente', "email = '".$_POST['email']."'"));
            if($result == 0) {
                // [PT] Regista cliente
                $clienteid = $object->insert("cliente", array('nome' => $_POST['nome'], 'apelido' => $_POST['apelido'], 'nascimento' => $_POST['nascimento'], 'genero' => $_POST['genero'], 'nacionalidadeid' => $_POST['nacionalidade'], 'contacto_1' => $_POST['contacto'], 'contacto_2' => $_POST['contacto_alt'], 'email' => $_POST['email'], 'registo' => $generator->gen_date_time()));
                // [PT] Regista endereço
                $enderecoid = $object->insert("endereco", array('av_bairro' => $_POST['av_bairro'], 'rua' => $_POST['rua'],  'nr_casa' => $_POST['casa'], 'clienteid' => $clienteid, 'activo' => '1'));
                // [PT] Regista usuario
                $usuarioid = $object->insert("usuario", array('usuarioid' => $clienteid, 'senha' => $_POST['senha']));

                // -> Retorna dados registados <- //
                $data = $clienteid.'.'.$enderecoid.'.'.$usuarioid;
                if($clienteid > 0 && $enderecoid > 0 && $usuarioid > 0) {
                    $_SESSION['loggin'] = true;
                    $_SESSION['id'] = $clienteid;
                    $_SESSION['apelido'] = $_POST['apelido'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['estado'] = '1';
                    $_SESSION['genero'] = $_POST['genero'];
                    echo json_encode(array('logar' => 'next'));
                }
            } else {
                echo json_encode(array('err' => 'Este endereço electrônico existe!'));
            }
            break;

        case !empty($_POST['key'] == 'cotacao'):
            $data = "";
            // -> Verifica a referencia <- //
            if(!empty($_SESSION['loggin'])) {

                // -> Verifica referencia da compra
                $referencia = $object->select("ref_compra, clienteid", "cotacao", "clienteid = '".$_SESSION['id']."' AND estado = 0");
                if(mysqli_num_rows($referencia) > 0) {
                    foreach($referencia as $value){
                        // -> Seleciona atributos do produto
                        $codigo = $object->select("codigo, qtd, preco_un, dias_trans, taxa_trans", "rec_cotacao", "ref_compraid = '".$_SESSION['ref_compra']."' AND email = '".$_SESSION['email']."' AND codigo = '".$_POST['produto_id']."'");
                        if(mysqli_num_rows($codigo) > 0) {
                            foreach ($codigo as $key => $row) {$key++;
                                if(isset($_POST['type']) && $_POST['type'] == "transporte") {
                                    $preco_venda = ($row['qtd'] * $row['preco_un']) + ($_POST['dias'] * $_POST['preco']);
                                    $operador = array('dias_trans' => $_POST['dias'], 'taxa_trans' => $_POST['preco'], 'preco_venda' => $preco_venda);
                                }

                                if(isset($_POST['type']) && $_POST['type'] == "menos") {
                                    $qtd = $row['qtd'] - 1; // -> Actualiza a quantidade
                                    $preco_venda = ($row['taxa_trans'] == 0) ? $qtd * $row['preco_un'] : ($qtd * $row['preco_un']) + ($row['dias_trans'] * $row['taxa_trans']); // -> Actualiza o preco por unidade
                                    $operador = array('qtd' => $qtd, 'preco_venda' => $preco_venda);
                                } elseif(isset($_POST['type']) && $_POST['type'] == "mais") {
                                    $qtd = $key + $row['qtd']; // -> Actualiza a quantidade
                                    $preco_venda = ($row['taxa_trans'] == 0) ? $qtd * $row['preco_un'] : ($qtd * $row['preco_un']) + ($row['dias_trans'] * $row['taxa_trans']); // -> Actualiza o preco por unidade
                                    $operador = array('qtd' => $qtd, 'preco_venda' => $preco_venda);
                                }
                                
                                // -> Apôs a verifiçäo do produto, actualiza os atributos do mesmo <- //
                                $data = $object->update("rec_cotacao", $operador, "codigo = '".$row['codigo']."' AND ref_compraid = '".$_SESSION['ref_compra']."' AND email = '".$_SESSION['email']."' AND estado = 0");
                            }
                        }else{
                            // -> Busca a tabela correspondente
                            $tabela = $object->select_table("codigo = '".$_POST['produto_id']."'");

                            // -> Verifica e diga o operador para o passo seguinte
                            $operador = ($tabela == 'servico') ? "nome, descricao, preco" : (($tabela == 'produto') ? "nome, modelo, descricao, preco" : "modelo, preco, marcaid");

                            foreach ($object->select($operador, $tabela, "codigo = '".$_POST['produto_id']."'") as $row) {
                                // -> Regista na cotacao do cliente <- //
                                if($tabela == 'transporte') {
                                    $taxa = $generator->taxa();
                                    $dias = '1';
                                    $veiculo = mysqli_fetch_assoc($object->select("nome_marca", "marca", "id = '".$row['marcaid']."' LIMIT 1"));
                                }else {
                                    $taxa = '0';
                                    $dias = '-';
                                }

                                // -> Registar produto no carrinho <- //
                                $data = $object->insert("rec_cotacao", array('ref_compraid' => $_SESSION['ref_compra'], 'codigo' => $_POST['produto_id'], 'email' => $_SESSION['email'], 'item' => ((!empty($row['nome'])) ? $row['nome'] : $veiculo['nome_marca'].' '.$row['modelo']), 'fornecedorid' => ((!empty($_POST['provider'])) ? $_POST['provider'] : 0 ), 'descricao' => ((!empty($row['descricao'])) ? $row['descricao'] : '-' ), 'qtd' => '1', 'preco_un' => $row['preco'], 'preco_venda' => $row['preco'], 'dias_trans' => $dias, 'taxa_trans' => $taxa, 'dataHora' => $generator->gen_date_time()));
                            }
                        }
                    }
                } else {
                    foreach ($object->select("MAX(ref_compra)", "cotacao") as $value) {
                        // -> Verifica referencia ultima dando a geraçäo do codigo da compra/factura <- //
                        $_SESSION['ref_compra'] = $generator->gen_cotacao(explode('.', $value['MAX(ref_compra)'])[3], explode('.', $value['MAX(ref_compra)'])[4]);

                        // -> Registar o item / produto / transporte e retorna id da cotacao
                        $data = $object->insert("cotacao", array("ref_compra" => $generator->gen_cotacao(explode('.', $value['MAX(ref_compra)'])[3], explode('.', $value['MAX(ref_compra)'])[4]), "clienteid" => $_SESSION['id'], "subtotal" => '0', "preco_total" => '0', "dia_processamento" => $generator->gen_date(), "hora_processamento" => $generator->gen_time(), "taxa_envio" => '0', "modo_pagamento" => '')); 

                        // -> Busca a tabela correspondente
                        $tabela = $object->select_table("codigo = '".$_POST['produto_id']."'");  

                        // -> Verifica e diga o operador para o passo seguinte
                        $operador = ($tabela == 'servico') ? "nome, descricao, preco" : (($tabela == 'produto') ? "nome, modelo, descricao, preco" : "modelo, preco, marcaid");

                        foreach ($object->select($operador, $tabela, "codigo='".$_POST['produto_id']."'") as $row) {
                            // -> Regista pela primeira vez a compra e cotacao do cliente <- //
                            if($tabela == 'transporte') {
                                $taxa = $generator->taxa();
                                $dias = '1';
                                $veiculo = mysqli_fetch_assoc($object->select("nome_marca", "marca", "id = '".$row['marcaid']."' LIMIT 1"));
                            }else {
                                $taxa = '0';
                                $dias = '-';
                            }

                            // -> Registar produto no carrinho <- //
                            $data = $object->insert("rec_cotacao", array('ref_compraid' => $generator->gen_cotacao(explode('.', $value['MAX(ref_compra)'])[3], explode('.', $value['MAX(ref_compra)'])[4]), 'codigo' => $_POST['produto_id'], 'email' => $_SESSION['email'], 'item' => ((!empty($row['nome'])) ? $row['nome'] : $veiculo['nome_marca'].' '.$row['modelo']), 'fornecedorid' => ((!empty($_POST['provider'])) ? $_POST['provider'] : 0 ), 'descricao' => ((!empty($row['descricao'])) ? $row['descricao'] : '-' ), 'qtd' => '1', 'preco_un' => $row['preco'], 'preco_venda' => $row['preco'], 'dias_trans' => $dias, 'taxa_trans' => $taxa, 'dataHora' => $generator->gen_date_time()));
                        }
                    }
                }
            } else {
                // -> Chave de endereço de login
                $data = 'logar';
            }
            echo json_encode($data);
            break;

        case !empty($_POST['key'] == 'finalizar'):
            if(isset($_POST['enderecoid']) && $_POST['enderecoid'] == "on") {
                $address = array('casa', 'bairro', 'endereco', 'rua');
                if($object->update("endereco", array("activo" => '0'), "clienteid='".$_SESSION['id']."'")){
                    $bairro = $_POST['av_bairro'];
                    $rua = $_POST['rua'];
                    $casa = $_POST['casa'];
                    $endereco = $object->insert("endereco", array("av_bairro" => $bairro, "rua" => $rua, "nr_casa" => $casa, "clienteid" => $_SESSION['id'], "activo" => '1'));
                }
            } else {
                if($object->update("endereco", array("activo" => '0'), "clienteid = '".$_SESSION['id']."'")){
                    if($object->update("endereco", array("activo" => '1'), "clienteid = '".$_SESSION['id']."' AND id = '".$_POST['enderecoid']."'")) {
                        # Endereço do Cliente
                        $endereco = mysqli_fetch_assoc($object->select("*", "endereco", "clienteid = '".$_SESSION['id']."' AND id = '".$_POST['enderecoid']."' AND activo = '1' LIMIT 1"));
                        $bairro = $endereco['av_bairro'];
                        $rua = $endereco['rua'];
                        $casa = $endereco['nr_casa'];
                    }
                }
            }

            $pagamento = $_POST["pagamento"];
            $numero_conta = empty($_POST['numero_conta']) ? "" : $_POST['numero_conta'];
            $desconto = $desconto_promo = $soma = $subtotal = $total = 0;
            $state = 1;

            # Obter dados do cliente
            foreach ($con->open()->query("SELECT nome, apelido, contacto_1, contacto_2 FROM cliente WHERE id = '".$_SESSION['id']."'") as $key => $value) {
                $nome_completo = $value['nome'].' '.$_SESSION['apelido'];
                $contacto = implode(' / ', array($value['contacto_1'], $value['contacto_2']));
            }

            

            # Actualizar record cotacao
            if($object->update("rec_cotacao", array("estado" => "'{$state}'"), "ref_compraid='".$_SESSION['ref_compra']."' AND email = '".$_SESSION['email']."'") > 0){
                // Get Sum price of buy
                $subtotal = $con->open()->query("SELECT SUM(preco_venda) AS total FROM rec_cotacao WHERE ref_compraid = '".$_SESSION['ref_compra']."' AND email = '".$_SESSION['email']."' AND estado = $state")->fetch_assoc()['total'];

                $total = $subtotal - $desconto - $desconto_promo;

                if($object->update("cotacao", array("subtotal" => "'{$subtotal}'", "desconto" => "'{$desconto}'", "desconto_promo" => "'{$desconto_promo}'", "preco_total" => "'{$total}'", "modo_pagamento" => "'{$pagamento}'", "numero_conta" => "'{$contacto}'", "estado" => "'{$state}'"), "ref_compra='".$_SESSION['ref_compra']."'")) {
                    // # Obter a referencia do documento
                    $doc = explode (".", $_SESSION['ref_compra']);
                    end($doc);

                    # Gerar o numero do documento
                    $nrdoc = str_pad($doc[2].'.'.$doc[3].'.'.$doc[4], 6, 0, STR_PAD_LEFT);

                    # Inicializaçäo da classe e funçoes
                    $pdf = new demo(array('doc' => $nrdoc, 'nome' => $nome_completo, 'endereco' => implode(', ', array($bairro, 'Rua da(o) '.$rua, 'Casa Nr. '.$casa)),'cell' => $contacto), $generator->gen_date(), $generator->moeda('m'), $pagamento);

                    $pdf->AliasNbPages();
                    $pdf->AddPage();
                    $pdf->Rowdata($con->open()->query("SELECT * FROM rec_cotacao WHERE ref_compraid = '".$_SESSION['ref_compra']."' AND email = '".$_SESSION['email']."' AND estado = '$state'"));
                    $pdf->Output(utf8_decode('Cotação')."-".$nrdoc.'.pdf', 'D');

                    $pdf->SetAutoPageBreak(false);
                    $height_of_cell = 60; // mm
                    $page_height = 270.93; // mm (portrait letter)
                    $bottom_margin = 0; // mm
                    for($i = 0; $i <= 100; $i++) :
                        $block = floor($i/6);
                        $space_left = $page_height - ($pdf->GetY() + $bottom_margin); // space left on page
                        if ($i/6 == floor($i/6) && $height_of_cell > $space_left) {
                            $pdf->AddPage(); // page break
                        }
                    endfor;    
                }
            }          
            break;
        
        default:
            echo json_encode("Injection pattern error in key selection");
            break;
    }
?>