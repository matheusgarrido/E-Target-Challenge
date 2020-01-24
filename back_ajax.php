<?php
require_once 'database.php';

switch ($_POST['funcao']){
    case "buscar":
        buscar();
        break;
    case "cadastrar":
        cadastrar();
        break;
    case "atualizar":
        atualizar();
        break;
    case "excluir":
        excluir();
        break;
}

function buscar(){
    $row = sqlSelect("select * from pessoa where id = " . $_POST['id']);
//    $row['nome'] = $row['nome'];
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
}

function cadastrar(){
    $id = sqlInsert("INSERT INTO pessoa (nome, idade, sexo) VALUES ('" . $_POST['nome'] . "', '" . $_POST["idade"] . "', '" . $_POST["sexo"] . "')");
//    $id = 2;
    $row = sqlSelect("select * from pessoa where id = " . $id);
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
}

function atualizar(){
    $dados['id'] = $_POST['id'];
    $dados['nome'] = $_POST['nome'];
    $dados['idade'] = $_POST['idade'];
    $dados['sexo'] = $_POST['sexo'];
    sqlSelect("UPDATE pessoa SET nome='{$dados['nome']}', idade='{$dados['idade']}', sexo='{$dados['sexo']}' WHERE id = {$dados['id']}");
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
}

function excluir(){
    sqlSelect("DELETE FROM pessoa WHERE id = " . $_POST['id']);
}