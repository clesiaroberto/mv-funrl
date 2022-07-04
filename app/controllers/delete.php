<?php
    header("Content-type: application/json; charset=utf-8");
    include "../../vendor/autoload.php";
    session_start();
    $con = new \funeraria\config\config();
    $object = new \funeraria\controllers\config($con->open());

    switch (isset($_POST['key'])) {
        case !empty($_POST['key'] == "cotacao"):
            $data = $object->delete("rec_cotacao", "ref_compraid='".$_SESSION['ref_compra']."' AND codigo='".$_POST['code']."'");
            echo json_encode($data);
            break;

        case !empty($_POST['key'] == "endereco"):
            $data = $object->delete("endereco", "id='".$_POST['id']."'");
            echo json_encode($data);
            break;
        
        default:
            echo json_encode("Injection pattern error in key selection");
            break;
    }

?>