<?php
    header("Content-type: application/json; charset=utf-8");
    require "../../vendor/autoload.php";
    require '../hooks/mail.php';
    session_start();
    $con = new \funeraria\config\config();
    $object = new \funeraria\controllers\config($con->open());
    $mail = new mail();
    
    switch (isset($_POST['key'])) {
        case $_POST['key'] == "login":
            $result = $object->logar('usuario', array('email' => $_POST['email'], 'senha' => $_POST['senha']));

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row['estado'] == 1) {
                        $_SESSION['loggin'] = true;
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['apelido'] = $row['apelido'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['estado'] = $row['estado'];
                        $_SESSION['genero'] = $row['genero'];
                        foreach ($object->select("ref_compra", "cotacao", "clienteid = '".$row['id']."' AND estado = 0") as $key => $value) {
                            $_SESSION['ref_compra'] = (!empty($value['ref_compra'])) ? $value['ref_compra'] : "" ;
                        }
                        echo json_encode(array('logar' => 'next'));
                    } else {
                        echo json_encode(array('acesso' => 'Usuario inactiva'));
                    }
                }
            } else {
                echo json_encode(array('acesso' => 'Email ou senha esta incorrenta'));
            }
            break;

        case $_POST['key'] == "recuperar":
            if($result = $object->select('id, email, nome', 'cliente', "email = '".$_POST['email']."'")){
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $senha = mysqli_fetch_row($object->select('senha', 'usuario', "usuarioid = '".$row['id']."'"));
                    $response = $mail->sendmail($row['nome'], $row['email'], 'Recuperar senha', $senha[0]);
                    if ($response) {
                        echo json_encode(array('acesso' => '0', 'message' => 'Verifique a sua senha na caixa de entrada do seu endereço electrônico.'));
                    } else {
                        echo json_encode(array('acesso' => '1', 'message' => 'Erro, tente novamente!'));
                    }
                } else {
                    echo json_encode(array('acesso' => '1', 'message' => 'Endereço electrônico incorrecto'));
                }
            } else {
                echo json_encode(array('acesso' => '0', 'message' => 'Error syntax!'));
            }
            break;

        case $_POST['key'] == "endereco":
        
            // [EN] Search and get customer address
            // [PT] Pesquisa e obter endereço do cliente
            foreach ($object->select('*', 'endereco', "clienteid='".((!empty($_SESSION['id'])) ? $_SESSION['id'] : '' )."'") as $key => $value) {$key++;
                if($cliente = mysqli_fetch_assoc($object->select('contacto_1, contacto_2', 'cliente', "id='".((!empty($_SESSION['id'])) ? $_SESSION['id'] : '' )."'"))){
                    $data[$key] = array(
                        'id' => $value['id'],
                        'av_bairro' => $value['av_bairro'],
                        'rua' => $value['rua'],
                        'casa' => $value['nr_casa'],
                        'contacto_1' => $cliente['contacto_1'],
                        'contacto_2' => $cliente['contacto_2'],
                        'check' => (($value['activo'] == 1) ? 'checked' : '' )
                    );
                }
            }
            echo json_encode($data);
            break;

        case $_POST['key'] == "sair":
            $result = (!empty($_SESSION['loggin']) == true) ? $object->sair() : 'Erro de saida!!!';
            echo json_encode($result);
            break;

        default:
            echo json_encode("Injection pattern error in key selection");
            break;
    }
?>