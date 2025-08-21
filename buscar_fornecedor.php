<?php
session_start();
require_once 'conexao.php';
require_once 'permissoes.php';
require_once 'dropdown.php';


// VERIFICA SE O fornecedor TEM PERMISSAO DE adm OU secretaria
if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=3){
    echo "<script> alert ('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

$fornecedor = []; // INICIALIZA A VARIAVEL PARA EVITAR ERROS

// SE O FORMULARIO FOR ENVIADO, BUSCA O fornecedor PELO ID OU NOME
if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    // VERIFICA SE A BUSCA É UM numero OU UM nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else{
    $sql="SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$fornecedores = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Buscar Fornecedor</title>
</head>
<body>
    <h2> Lista de Fornecedores </h2>

    <form action="buscar_fornecedor.php" Method="POST">
        <label for="busca"> Digite o ID ou NOME(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($fornecedores)):?>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Contato</th>
            </tr>
        <?php foreach($fornecedores as $fornecedor): ?>
            <tr>
                <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                <td><?=htmlspecialchars($fornecedor['email'])?></td>
                <td><?=htmlspecialchars($fornecedor['contato'])?></td>
                <td>
                    <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">Alterar</a>  

                    <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>"onclick="return confirm('Tem certeza que você quer excluir?')">Excluir</a>                 
                </td>
            </tr>
        <?php endforeach;?>    
        </table>
    <?php else:?>
        <p> Nenhum fornecedor encontrado.</p>
    <?php endif;?>
    
    <a href="principal.php" class="btn-voltar"> VOLTAR</a>
</body>
</html>