<?php
include'../../conectabanco.php';

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idmac = $_POST["id"] ?? "";
    $nome = $_POST["nome"] ?? "";
    $ativo = $_POST["ativo"] ?? "";
    if (!empty($idmac) && !empty($nome)) {
        $sql = "INSERT INTO machigor (idmachigor, nome, ativo)
                VALUES (:id, :nome, :ativo)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $idmac);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->execute();
        // Redireciona para evitar reinclusão com F5
            header("Location: ".$_SERVER['PHP_SELF']."?status=sucesso");
            exit();        
    } else {
        echo "<p>Preencha todos os campos.</p>";
    }
}
?>
<html>
      <link rel="stylesheet" href="stylehigor.css">
    <!-- Formulário -->
<form method="post" action="">
    <label>IdMAC:</label>
    <input type="text" name="id" required><br><br>

    <label>Nome:</label>
    <input type="text" name="nome" required><br><br>

    <label for="ativo">Ativo:</label>
    <input type="checkbox" id="ativo" name="ativo" value="1"><br><br>
    
    <button type="submit">Salvar</button>
</form>

<h3>Placas MAC</h3>
<table border="1">
<tr>
</tr>

<?php

// DELETE
if (isset($_GET["delete"])) {
    $idmac = $_GET["delete"];
    $sql = "DELETE FROM machigor WHERE idmachigor = :idmac";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idmac", $idmac);
    $stmt->execute();
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) &&
$_POST["acao"] === "update") {
    $idmac = $_POST["idmac"];
    $novoNome = $_POST["novoNome"];

    $sql = "UPDATE machigor SET nome=:novoNome WHERE idmachigor = :idmac";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idmac", $idmac);
    $stmt->bindParam(":novoNome", $novoNome);
    $stmt->execute();
}
$sql = 'SELECT idmachigor, nome, ativo FROM machigor';
$resultado = $conn->query($sql);
foreach ($resultado as $row) {
    echo "<tr>";

    echo "<td>
            <!-- Formulário UPDATE -->
            <form method='post' action='' style='display:inline;'>
                <input type='hidden' name='acao' value='update'>
                <input type='hidden' name='idmac' value='$row[0]'>
                <label>Nome:<input type='text' name='novoNome' value='$row[1]'>
                <label>Ativo:<input type='number' style = 'width: 50px;' name='novoAtivo' value='$row[2]'>
                <button type='submit'>Atualizar</button>
            </form>
            <!-- Link DELETE -->
            <a  href='?delete=$row[0]' onclick=\"return confirm('Deseja excluir?')\">Excluir</a>
          </td>
          </tr>";
}
?>
</table>
</html>
