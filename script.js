caixasAdicionar = 0;
idEditar = 0;

function botaoAdicionar(){
//    db_tabela = $("#db-tabela").html();
    $("#db-nulo").remove();
    
    rows = $('tr').length;
    if (rows===0){
        $("body").append("<table id='db-tabela'><tr><th>Nome</th><th>Idade</th><th>Sexo</th><th colspan='2'>Opções</th></tr></table>");
    }

    if (caixasAdicionar === 0){
        //TD Nome
        td1 = "<td width='300px'><input type='text' id='txtNome'></td>";
        //TD Idade
        td2 = "<td width='300px'><input type='number' min='1' max='130' id='txtIdade'></td>";
        //TD Sexo
        td3 = "<td width='300px'><select id='slSexo'><option value='-1' selected></option><option value='1'>Feminino</option><option value='2'>Masculino</option><option value='0'>Não informar</option></select></td>";
        //TD opções
        tdOpcoes = "<td width='300px'><button onclick='cadastrar()'>Cadastrar</button></td><td width='300px'><button onclick='cancelarAdicionar()'>Cancelar</button></td>";
        //Inserir campos no final da tabela
        tr = "<tr id='idnovo'>"+td1+td2+td3+tdOpcoes+"</tr>";
        $("#db-tabela").append(tr);
        //Focar na caixa do nome
        $("#txtNome").focus();
        //Bloquear repetição de linha de adição
        caixasAdicionar = 1;
        cancelarEditar(idEditar);
    }
}

function remover(idRow){
    $(idRow).remove();
    rows = $('tr').length;
//    alert(rows);
    if(rows<2){
        $("table").remove();
        $("body").append("<p id='db-nulo'>Não há nenhum cadastro no sistema</p>");
    }
}

function cancelarAdicionar(){
    remover("#idnovo");
    caixasAdicionar=0;
}

function editar(id){
    //Bloquear repetição de linha de adição
    alert(idEditar);
    if (idEditar>0) cancelarEditar(idEditar);
    cancelarAdicionar();
    idEditar = id;
    
    //Permitir somente 1 edição por vez
    idRow = "#id" + id; 
    idTd = idRow + " td";
    vetorRow = [];
    
    //TD Nome
    td1 = "<td width='300px'><input type='text' id='txtNome'></td>";
    //TD Idade
    td2 = "<td width='300px'><input type='number' min='1' max='130' id='txtIdade'></td>";
    //TD Sexo
    td3 = "<td width='300px'><select id='slSexo'><option value='-1'></option><option value='1'>Feminino</option><option value='2'>Masculino</option><option value='0'>Não informar</option></select></td>";
    //TD opções
    tdOpcoes = "<td width='300px'><button onclick='atualizar("+id+")'>Atualizar</button></td><td width='300px'><button onclick='cancelarEditar("+id+")'>Cancelar</button></td>";
    
    $(idRow).html(td1+td2+td3+tdOpcoes);
    
    $.post("back_ajax.php", {'funcao': 'buscar', 'id': id}, function(result){
        vetor = JSON.parse(result);
        alert(idEditar);
        $("#txtNome").val(vetor[0].nome);
        $("#txtIdade").val(vetor[0].idade);
        $("#slSexo").val(vetor[0].sexo);
    });
    //Focar na caixa do nome
    $("#txtNome").focus();
}

function cancelarEditar(id){
    $.post("back_ajax.php", {'funcao': 'buscar', 'id': id}, function(result){
        vetor = JSON.parse(result);
        td1 = "<td>"+vetor[0].nome+"</td>";
        td2 = "<td>"+vetor[0].idade+"</td>";
        td3 = "<td>";
        if (vetor[0].sexo==0) td3 += "Não informado";
        else if (vetor[0].sexo==1) td3 += "Feminino";
        else if (vetor[0].sexo==2) td3 += "Masculino";
        td3 += "</td>";
        tdOpcoes = "<td><button onclick='editar("+id+")'>Editar</button></td><td><button onclick='excluir("+id+")'>Excluir</button></td>";
        idRow = "#id" + id;
        $(idRow).html(td1+td2+td3+tdOpcoes);
        idEditar = 0;
    });
}

function cadastrar(){
    nome = $("#txtNome").val();
    idade = $("#txtIdade").val();
    sexo = $("#slSexo").children("option:selected").val();
    if (nome === "" || idade < 1 || sexo < 0) {
        alert("Informe corretamente os dados");
    }
    else{
        $.post("back_ajax.php", {'funcao': 'cadastrar', 'nome': nome, 'idade': idade, 'sexo': sexo}, function(result){
            vetor = JSON.parse(result);
            td1 = "<td>"+vetor[0].nome+"</td>";
            td2 = "<td>"+vetor[0].idade+"</td>";
            td3 = "<td>";
            if (vetor[0].sexo==0) td3 += "Não informado";
            else if (vetor[0].sexo==1) td3 += "Feminino";
            else if (vetor[0].sexo==2) td3 += "Masculino";
            td3 += "</td>";
            tdOpcoes = "<td><button onclick='editar(" + vetor[0].id + ")'>Editar</button></td><td><button onclick='excluir(" + vetor[0].id + ")'>Excluir</button></td>";
            idRow = "id" + vetor[0].id;

            tr = "<tr id='"+idRow+"'>"+td1+td2+td3+tdOpcoes+"</tr>";
            $("#db-tabela").append(tr);

            $(idRow).html(td1+td2+td3+tdOpcoes);
            cancelarAdicionar();
        });
    }
}

function atualizar(id){
    nome = $("#txtNome").val();
    idade = $("#txtIdade").val();
    sexo = $("#slSexo").children("option:selected").val();
    if (nome === "" || idade < 1 || sexo < 0) {
        alert("Informe corretamente os dados");
    }
    else{
        $.post("back_ajax.php", {'funcao': 'atualizar', 'id': id, 'nome': nome, 'idade': idade, 'sexo': sexo}, function(){
            cancelarEditar(id);
        });
    }
}

function excluir(id){
    $.post("back_ajax.php", {'funcao': 'excluir', 'id': id}, function(){
        idRow = "#id" + id;
        remover(idRow);
    });
}