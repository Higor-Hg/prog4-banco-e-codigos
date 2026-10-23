<?php
include'../../conectabanco.php';

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idled = $_POST["id"] ?? "";
    $nome = $_POST["nome"] ?? "";
    $pinor = $_POST["pinor"] ?? "";
    $pinog = $_POST["pinog"] ?? "";
    $pinob = $_POST["pinob"] ?? "";
    if (!empty($nome)) {
        $sql = "INSERT INTO ledhigor (idledhigor, nome, pinor, pinog, pinob)
                VALUES (:id, :nome, :pinor, :pinog, :pinob)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $idled);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":pinor", $pinor);
        $stmt->bindParam(":pinog", $pinog);
        $stmt->bindParam(":pinob", $pinob);
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
      <h3>Leds</h3>
    <!-- Formulário -->
<form method="post" action="">

    <label>Nome:</label>
    <input type="text" name="nome" required><br><br>

    <label for="pinor">PinoR:</label>
    <input type="number" name="pinor"><br><br>

    <label for="pinog">PinoG:</label>
    <input type="number" name="pinog"><br><br>

    <label for="pinob">PinoB:</label>
    <input type="number" name="pinob"><br><br>
    
    <button type="submit">Salvar</button>
</form>
<table border="1">
<tr>
</tr>

<?php

// DELETE
if (isset($_GET["delete"])) {
    $idled = $_GET["delete"];
    $sql = "DELETE FROM ledhigor WHERE idledhigor = :idled";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idled", $idled);
    $stmt->execute();
}

// UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) &&
$_POST["acao"] === "update") {
    $idled = $_POST["idled"];
    $novoNome = $_POST["novoNome"];

    $sql = "UPDATE ledhigor SET nome=:novoNome WHERE idledhigor = :idled";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idled", $idled);
    $stmt->bindParam(":novoNome", $novoNome);
    $stmt->execute();
}
$sql = 'SELECT idledhigor, nome, pinor, pinog, pinob FROM ledhigor';
$resultado = $conn->query($sql);
foreach ($resultado as $row) {
    echo "<tr>";

    echo "<td>
            <!-- Formulário UPDATE -->
            <form method='post' action='' style='display:inline;'>
                <input type='hidden' name='acao' value='update'>
                <input type='hidden' name='idled' value='$row[0]'>
                <label>Nome:<input type='text' name='novoNome' value='$row[1]'>
                <label>pinor:<input type='number' name='novoPinor' value='$row[2]'>
                <label>pinog<input type='number' name='novoPinog' value='$row[3]'>
                <label>pinob:<input type='number' name='novoPinob' value='$row[4]'>
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
 