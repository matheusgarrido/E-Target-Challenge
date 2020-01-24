<?php
    require_once 'database.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CRUD Teste</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">
        <script src="jquery-1.11.1.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <button onclick="botaoAdicionar()" id="adicionar">Cadastrar um novo perfil</button>
        <?php
            $pessoas = sqlSelect("select * from pessoa order by nome asc");
            if (count($pessoas)==0){
                ?>
                <p id='db-nulo'>Não há nenhum cadastro no sistema</p>
                <?php
            }
            else{
                ?>
                <table id='db-tabela'>
                    <tr>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Sexo</th>
                        <th colspan="2">Opções</th>
                    </tr>
                    <?php
                    foreach ($pessoas as $p){
                        ?>
                        <tr id='id<?php echo $p['id']; ?>'>
                            <td><?php echo $p['nome']; ?></td>
                            <td><?php echo $p['idade']; ?></td>
                            <td><?php echo descricaoSexo($p['sexo']); ?></td>
                            <td><button onclick="editar(<?php echo $p['id']; ?>)">Editar</button></td>
                            <td><button onclick="excluir(<?php echo $p['id']; ?>)">Excluir</button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        ?>
    </body>
</html>

<?php
function descricaoSexo($codSexo){
    ?>
    <p>
        <?php
        switch ($codSexo){
            case 0:
                echo "Não informado";
                break;
            case 1:
                echo "Feminino";
                break;
            case 2:
                echo "Masculino";
                break;
        }
        ?>
    </p>
    <?php
}