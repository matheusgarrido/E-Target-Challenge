<?php
//error_reporting(0);

//Função para executar a query select, gerar vetor com o resultado e retornar vetor
function sqlSelect($selectQuery){
    require_once 'constantes.php';
    $connect = mysqli_connect(HOST, USER, PASS, BANCO) or die('Não foi possível conectar no banco.');
    $result = mysqli_query($connect, utf8_decode($selectQuery));
    $vetor = array();
    if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_assoc($result)){
            $vetor[]=$row;
        }
    }
    mysqli_close($connect);
    return $vetor;
}


function sqlInsert($insertQuery){
    require_once 'constantes.php';
    $connect = mysqli_connect(HOST, USER, PASS, BANCO) or die('Não foi possível conectar no banco.');
    mysqli_query($connect, utf8_decode($insertQuery));
    return mysqli_insert_id($connect);
}

//
////Query insert na tabela Material e na FK (área, disciplina, matéria)
//function insertMaterial($tipo, $nome, $descricao, $texto, $idSup){
//    $nome = utf8_decode($nome);
//    $descricao = utf8_decode($descricao);
//    $texto = utf8_decode($texto);
//    switch ($tipo){
//        case 'area':
//            insertArea($nome, $descricao, $texto);
//            break;
//        case 'disciplina':
//            insertDisc($idSup, $nome, $descricao, $texto);
//            break;
//        case 'materia':
//            insertAula($idSup, $nome, $descricao, $texto);
//    }
//}
//
////Insert área
///*
//insertMaterial('area', "Informática", "Estuda computador", "Programação, análise, hardware", null);
//insertMaterial('area', "Matemática", "Estuda números", "Números, equações, estatística", null);
//insertMaterial('area', "Física", "Estuda fenômenos naturais", "Inércia, gravidade, aceleração", null);
//insertMaterial('area', "Química", "Estuda estrutura molecular", "Átomos, elétrons", null);
//*/
//function insertArea($nome, $descricao, $texto){
//    $connect = mysqli_connect(HOST, USER, PASS);
//    $db = mysqli_select_db($connect, BANCO);
//    var_dump(mysqli_query($connect, "INSERT INTO material VALUES(null, '{$nome}', 'area');"));
//    var_dump(mysqli_query($connect, "INSERT INTO area VALUES(LAST_INSERT_ID(), '{$descricao}', '{$texto}');"));
//}
//
////Insert disciplina
///*
//insertMaterial('disciplina', 'Programação', 'Codificar software', 'Lógica, Java, PHP', 1);
//insertMaterial('disciplina', 'Análise', 'Análise de Software', 'UML, requisitos funcionais', 1);
//insertMaterial('disciplina', 'Banco de dados', 'Database', 'SQL', 1);
//insertMaterial('disciplina', 'Arquitetura', 'Sistema', 'SO', 1);
//insertMaterial('disciplina', 'Hardware', 'Parte física', 'Processador, HD', 1);
// */
//function insertDisc($idArea, $nome, $descricao, $texto){
//    $connect = mysqli_connect(HOST, USER, PASS);
//    $db = mysqli_select_db($connect, BANCO);
//    var_dump(mysqli_query($connect, "INSERT INTO material VALUES(null, '{$nome}', 'disciplina');"));
//    var_dump(mysqli_query($connect, "INSERT INTO disciplina VALUES(LAST_INSERT_ID(), {$idArea}, '{$descricao}', '{$texto}');"));
//}
//
//
////Insert aula
///*
//insertMaterial('aula', 'HTML5', 'Criar páginas web', 'Desenvolvimento web', 7);
//insertMaterial('aula', 'PHP', 'Criar página web dinâmica', 'Backend web', 7);
//*/
//function insertAula($idDisc, $nome, $descricao, $texto){
//    $connect = mysqli_connect(HOST, USER, PASS);
//    $db = mysqli_select_db($connect, BANCO);
//    var_dump(mysqli_query($connect, "INSERT INTO material VALUES(null, '{$nome}', 'aula');"));
//    var_dump(mysqli_query($connect, "INSERT INTO aula VALUES(LAST_INSERT_ID(), {$idDisc}, '{$descricao}', '{$texto}');"));
//}
//
//
