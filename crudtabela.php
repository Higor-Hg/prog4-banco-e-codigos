<?php
include'../../conectabanco.php';


//carrega PAINEL do banco
$sqlpainel = "SELECT idpainelhigor, nome FROM painelhigor ORDER BY nome";
$stmtpainel = $conn->query($sqlpainel);
$listapainel = $stmtpainel->fetchAll(PDO::FETCH_ASSOC);


//carrega LED do banco
$sqlled = "SELECT idledhigor, nome FROM ledhigor ORDER BY nome";
$stmtled = $conn->query($sqlled);
$listaled = $stmtled->fetchAll(PDO::FETCH_ASSOC);


//carrega MAC do banco
$sqlmac = "SELECT idmachigor, nome FROM machigor ORDER BY nome";


$stmtmac = $conn->query($sqlmac);
$listamac = $stmtmac->fetchAll(PDO::FETCH_ASSOC);


// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $painel_idpainel = $_POST["painel_idpainel"] ?? "";
    $led_idled = $_POST["led_idled"] ?? "";
    $mac_idmac = $_POST["mac_idmac"] ?? "";
    $ledr = $_POST["ledr"] ?? "";
    $ledg = $_POST["ledg"] ?? "";
    $ledb = $_POST["ledb"] ?? "";


    if (!empty($painel_idpainel) && !empty($led_idled) && !empty($mac_idmac)) {
        $sql = "INSERT INTO combinahigor (painelhigor_idpainelhigor, ledhigor_idledhigor, machigor_idmachigor, ledr, ledg, ledb)
                VALUES (:painelhigor_idpainelhigor, :ledhigor_idledhigor, :machigor_idmachigor, :ledr, :ledg, :ledb)";
       
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":painelhigor_idpainelhigor", $painel_idpainel);
        $stmt->bindParam(":ledhigor_idledhigor", $led_idled);
        $stmt->bindParam(":machigor_idmachigor", $mac_idmac);
        $stmt->bindParam(":ledr", $ledr);
        $stmt->bindParam(":ledg", $ledg);
        $stmt->bindParam(":ledb", $ledb);
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
    <div class='container'>
        <form method="post" action="">
        <label>Painel:</label>
        <select name="painel_idpainel" required>
            <option value="">Selecione...</option>
            <?php foreach ($listapainel as $pai): ?>
            <option value="<?= $pai['idpainelhigor'] ?>">
                <?= htmlspecialchars($pai['nome']) ?>
            </option>
            <?php endforeach; ?>
        </select><br>

        <label>Led:</label>
        <select name="led_idled" required>
            <option value="">Selecione...</option>
            <?php foreach ($listaled as $led): ?>
            <option value="<?= $led['idledhigor'] ?>">
                <?= htmlspecialchars($led['nome']) ?>
            </option>
            <?php endforeach; ?>
        </select><br>

        <label>Mac:</label>
        <select name="mac_idmac" required>
            <option value="">Selecione...</option>
            <?php foreach ($listamac as $mac): ?>
            <option value="<?= $mac['idmachigor'] ?>">
                <?= htmlspecialchars($mac['nome']) ?>
            </option>
            <?php endforeach; ?>
        </select><br>

        <label>Led R:</label>
        <input type="number" name="ledr"  style='width: 50px' required><br>
        <label>Led G:</label>
        <input type="number" name="ledg"  style='width: 50px' required><br>
        <label>Led B:</label>
        <input type="number" name="ledb"  style='width: 50px' required><br>
       
        <button type="submit">Salvar</button>
</form>
</div>


<div class='containerlista'>
<h3>Lista CRUD Tabela</h3>
<table border="1">
<tr>
</tr>


<?php


// DELETE
if (isset($_GET["delete"])) {
    $idtabela = $_GET["delete"];
    $sql = "DELETE FROM combinahigor WHERE idcombinahigor = :idcombinahigor";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idcombinahigor", $idtabela);
    $stmt->execute();
}


// UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) &&
$_POST["acao"] === "update") {
    $idtabela = $_POST["idaltera"];
    $novoLedr = $_POST["novoLedr"];
    $novoLedg = $_POST["novoLedg"];
    $novoLedb = $_POST["novoLedb"];


    $sql = "UPDATE combinahigor SET ledr=:novoLedr, ledg=:novoLedg, ledb=:novoLedb WHERE idcombinahigor = :idaltera";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":idaltera", $idtabela);
    $stmt->bindParam(":novoledr", $novoLedr);
    $stmt->bindParam(":novoledg", $novoLedg);
    $stmt->bindParam(":novoledb", $novoLedb);
    $stmt->execute();
}
$sql = 'SELECT idcombinahigor, ledr, ledg, ledb,
        painelhigor.nome, painelhigor.datainicio, painelhigor.datafim,
        machigor.nome,
        ledhigor.nome

        FROM    combinahigor, painelhigor, machigor, ledhigor

        WHERE   combinahigor.painelhigor_idpainelhigor=painelhigor.idpainelhigor
        and     combinahigor.machigor_idmachigor=machigor.idmachigor
        and     combinahigor.ledhigor_idledhigor=ledhigor.idledhigor
        ';
        
$resultado = $conn->query($sql);
foreach ($resultado as $row) {
    echo "<tr>";
    echo "<td>
            <!-- Formulário UPDATE -->
            <form method='post' action='' style='display:inline;'>
                <input type='hidden' name='acao' value='update'>
                <input type='hidden' name='idaltera' value='$row[0]'>
                <label>Painel:<input type='text' name='' style='width: 130px' value='$row[4]'><br><br>
                <label>Data Início:<input type='text' name='' style='width: 150px' value='$row[5]'>
                <label>Data Fim:<input type='text' name='' style='width: 150px' value='$row[6]'><br><br>
                <label>MAC:<input type='text' name='' value='$row[7]'>
                <label>Led:<input type='text' name='' value='$row[8]'><br><br>
                <label>Led R:<input type='number' name='novoLedr' style='width: 50px' value='$row[1]'>
                <label>Led G:<input type='number' name='novoLedg' style='width: 50px' value='$row[2]'>
                <label>Led B:<input type='number' name='novoLedb' style='width: 50px' value='$row[3]'><br><br>
                <button type='submit'>Atualizar</button>
            </form>
            <!-- Link DELETE -->
            <a  href='?delete=$row[0]' onclick=\"return confirm('Deseja excluir?')\">Excluir</a>
          </td>
          </tr>";
}
?>
</table></div></html>



