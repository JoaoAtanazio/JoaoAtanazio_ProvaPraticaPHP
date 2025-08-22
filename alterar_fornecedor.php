<?php
session_start();
require_once 'conexao.php';
require_once 'permissoes.php';
require_once 'dropdown.php';

//VERIFICA SE O fornecedor TEM PERMISSOA DE ADM
if ($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2 && $_SESSION['perfil'] !=3){
    echo "<script>alert('Acesso Negado!');windows.location.href = 'principal.php';</script>";
    exit();
}

//INICIALIZA VARIÁVEIS

$fornecedor = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_fornecedor'])){
        $busca = trim($_POST['busca_fornecedor']);

        // VERIFICA SE A BUSCA É UM NUMERO (id) OU UM nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        } else{
            $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }

        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        //SE O fornecedor NÃO FOR ENCONTRANDO, EXIBE UM ALERTA
        if(!$fornecedor){
            echo "<script>alert('Fornecedor não encontrado!');</script>";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <!-- CERTIFIQUE-SE DE QUE O JAVASCIPRT ESTÁ SENDO CARREGADO CORRETAMENTE -->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Fornecedor</h2>
    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o id ou nome do Fornecedor</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">

    <!-- DIV PARA EXIBIR SUGESTÕES DE fornecedores -->
     <div id="sugestoes"></div>
    <button type="submit">Buscar</button>
    </form>

    <?php if($fornecedor): ?>
        <!-- FORMULARIO PARA ALTERAR fornecedor -->
        <form action="processa_alteracao_fornecedor.php" method="POST" id="formCadastro">
            <input type="hidden" name="id_fornecedor" value="<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">
            <label for="nome">Nome:</label> 
            <input type="text" id="nome" name="nome" onkeypress="validanome()" value="<?=htmlspecialchars($fornecedor['nome_fornecedor'])?>" required>

            <label for="endereco">Endereço:</label> 
            <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($fornecedor['endereco'])?>" required>

            <label for="telefone">Telefone:</label> 
            <input type="tel" id="telefone" name="telefone" oninput = "mascaratelefone(this)" maxlength="15" value="<?=htmlspecialchars($fornecedor['telefone'])?>" required>

            <label for="email">Email:</label> 
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($fornecedor['email'])?>" required>

            <label for="contato">Contato:</label> 
            <input type="text" id="contato" name="contato" onkeypress="validacontato()" value="<?=htmlspecialchars($fornecedor['contato'])?>" required>
        
            <button type="submit" onclick="validarFornecedor()">Alterar</button>
            <button type="reset" onclick="window.location.href='alterar_fornecedor.php'">Cancelar</button>
        </form>
            <?php endif;?>
            <a href="principal.php" class="btn-voltar">Voltar</a>
            <script src="validacoes.js"></script>
</body>
</html>