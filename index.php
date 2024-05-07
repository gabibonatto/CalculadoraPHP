<?php
session_start();

if (isset($_POST['submit'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];

    switch ($operator) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            $result = ($num2 != 0) ? $num1 / $num2 : 'Divisão por zero';
            break;
        case '^':
            $result = pow($num1, $num2);
            break;
        case '!':
            $result = factorial($num1);
            break;
    }

    $history = $_SESSION['history'] ?? [];
    array_push($history, "$num1 $operator $num2 = $result");
    $_SESSION['history'] = $history;

    $_SESSION['memory'] = "$num1 $operator $num2 = $result";
}

function factorial($n) {
    if ($n === 0) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

if (isset($_POST['clear_history'])) {
    unset($_SESSION['history']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calculator">
        <form action="" method="post">
            <input type="text" name="num1" placeholder="Número 1" required>
            <input type="text" name="num2" placeholder="Número 2" required>
            <select name="operator">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value=""></option>
                <option value="/">/</option>
                <option value="^">x^y</option>
                <option value="!">n!</option>
            </select>
            <input type="submit" name="submit" value="Calcular">
        </form>
        <input type="text" id="display" value="<?php echo $_SESSION['memory'] ?? ''; ?>" readonly>
        <div class="buttons">
            <button onclick="recallMemory()">M</button>
            <button onclick="clearMemory()">Pegar Valores</button>
            <button onclick="clearDisplay()">C</button>
        </div>
        <div class="history">
            <h2>Histórico</h2>
            <?php
            if (isset($_SESSION['history'])) {
                foreach ($_SESSION['history'] as $operation) {
                    echo "<p>$operation</p>";
                }
            }
            ?>
            <form action="" method="post">
                <button type="submit" name="clear_history">Limpar Histórico</button>
            </form>
        </div>
    </div>

    <script>
        function clearDisplay() {
            document.getElementById('display').value = '';
        }

        function recallMemory() {
            var memory = "<?php echo $_SESSION['memory'] ?? ''; ?>";
            document.getElementById('display').value = memory;
        }

        function clearMemory() {
            <?php unset($_SESSION['memory']); ?>
            document.getElementById('display').value = '';
        }
    </script>
</body>
</html>
