<?php
require 'contract.class.php';





$db = new DB();
$contract = new Contract($db->getDb());



if(empty($_POST['id_contract'])){

}else {

    $data = $contract->query($_POST['id_contract'], $_POST['work'],
        $_POST['connecting'], $_POST['disconnected']);
    if(!isset($data)){
        $ajax = json_encode($data = ['msg' => 'Нет клиента']);
    }else {
        $services_name = explode(',', $data[0]['services_name']);
        $ajax = json_encode($data[0]);
    }
    echo $ajax;die;
}

include('form.html');
include('view.html');
?>
