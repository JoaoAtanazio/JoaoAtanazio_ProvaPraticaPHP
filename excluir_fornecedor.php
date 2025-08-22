<?php
session_start();
require_once 'conexao.php';
require_once 'permissoes.php';
require_once 'dropdown.php';

// VERIFICA SE O fornecedor TEM PERMISSAO DE ADM
if($_SESSION['perfil']!=1 ){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR fornecedores
$fornecedores = [];

// BUSCA TODOS OS fornecedores CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * from fornecedor ORDER BY nome_fornecedor ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// SE UM id FOR PASSADO VIA get EXCLUI O fornecedor
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_fornecedor = $_GET['id'];

    // EXCLUI O fornecedor DO BANCO DE DADOS
    $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_fornecedor,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('fornecedor excluido com Sucesso!');window.location.href='excluir_fornecedor.php'</script>";
    } else{
        echo "<script>alert('Erro ao excluir o fornecedor!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
    <h2> Excluir fornecedor</h2>
    <?php if(!empty($fornecedores)): ?>
        <table border="1" class="table">
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
                    <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor??')">Excluir</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    <?php else:; ?>
        <p> Nenhum fornecedor encontrado
    <?php endif;?>
    
    <a href="principal.php" class="btn-voltar">Voltar</a>
    <center>
                <br>
            <tag>João Vitor Atanazio | Estudante técnico | Desenvolvimento de Sistemas</tag>
    </center>
</body>
</html>