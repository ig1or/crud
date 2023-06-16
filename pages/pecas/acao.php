<?php
require_once "../../conf/Conexao.php";
    
$acao = "";
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':  $acao = isset($_GET['acao']) ? $_GET['acao'] : ""; break;
    case 'POST': $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; break;
}

switch($acao){
    case 'excluir': excluir(); break;
    case 'salvar': {
        $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : "";
        if ($codigo == 0)
            salvar(); 
        else
            editar();
        break;
    }
}

function excluir(){    
    $codigo = isset($_GET['codigo']) ? $_GET['codigo']:0;
    $conexao = Conexao::getInstance();
    $stmt = $conexao->prepare("DELETE FROM pecas WHERE codigo = :codigo");
    $stmt->bindParam('codigo', $codigo, PDO::PARAM_INT);  
    $stmt->execute();
    header("location:index.php");
}

function editar(){
    $codigo = isset($_POST['codigo']) ? $_POST['codigo']:0;
    $nome = isset($_POST['nome']) ? $_POST['nome']: "";
    $modelo = isset($_POST['modelo']) ? $_POST['modelo']: "";
    $valor = isset($_POST['valor']) ? $_POST['valor']: 0;
    $garantia = isset($_POST['garantia']) ? $_POST['garantia']: 0;

    $conexao = Conexao::getInstance();
    $conexao = $conexao->query("UPDATE pecas SET nome = '$nome',
                                modelo = '$modelo', valor = '$valor', garantia = '$garantia'
                                WHERE codigo = $codigo;");
    header("location:index.php");
}

function salvar(){

    $nome = isset($_POST['nome']) ? $_POST['nome']: "";
    $modelo = isset($_POST['modelo']) ? $_POST['modelo']: "";
    $valor = isset($_POST['valor']) ? $_POST['valor']: 0;
    $garantia = isset($_POST['garantia']) ? $_POST['garantia']: 0;

    $conexao = Conexao::getInstance();
    $conexao = $conexao->query("INSERT INTO pecas (nome, modelo, valor, garantia) VALUES ('$nome', '$modelo', '$valor', '$garantia');");
    header("location:index.php");
}

function findById($codigo){
    $conexao = Conexao::getInstance();
    $conexao = $conexao->query("SELECT * FROM pecas WHERE codigo = $codigo;");
    $result = $conexao->fetch(PDO::FETCH_ASSOC);
    return $result; 
}

?>