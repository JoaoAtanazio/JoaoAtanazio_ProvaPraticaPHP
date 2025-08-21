<?php
session_start();
require_once 'conexao.php';
require_once 'permissoes.php';
require_once 'dropdown.php';

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3){
    echo "Acesso Negado!";
}
if ($_SERVER['REQUEST_METHOD']=="POST"){
    $nome = $_POST['nome'];
    $email= $_POST['email'];
    $telefone= $_POST['telefone'];
    $contato = $_POST['contato'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO fornecedor (nome_fornecedor,endereco,telefone,email,contato) VALUES (:nome,:endereco,:telefone,:email,:contato)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":email",$email);
    $stmt->bindParam(":telefone",$telefone);
    $stmt->bindParam(":contato",$contato);
    $stmt->bindParam(":endereco",$endereco);

    if($stmt->execute() ){
        echo "<script>alert ('Fornecedor cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert ('Erro ao cadastrar fornecedor!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Cadastrar Fornecedor</title>
</head>
<body>
    <h2>Cadastrar Fornecedor</h2>
    <form action="cadastro_fornecedor.php" method="POST" id="formCadastro">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="number" id="telefone" name="telefone" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato" required>
        
        <button type="submit" onclick="validarFornecedor()">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php" class="btn-voltar">Voltar</a>
    <script src="validacoes.js"></script>
</body>
</html>