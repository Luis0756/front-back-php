<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .calculator {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input, select, button {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        label {
            font-size: 18px;
            font-weight: bold;
        }

        .result {
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
<body>
    <h2>Calculadora</h2>
    <form method="post">
        <input type="number" name="value1" placeholder="Valor 1" required>
        <select name="operation" required>
            <option value="">Operação</option>
            <option value="add">Adição (+)</option>
            <option value="subtract">Subtração (-)</option>
            <option value="multiply">Multiplicação (*)</option>
            <option value="divide">Divisão (/)</option>
        </select>
        <input type="number" name="value2" placeholder="Valor 2" required>
        <button type="submit" name="calculate">Calcular</button>
    </form>

    <br>

    <script>
        function calcular() {
            let v1 = $('#v1').val();
            let v2 = $('#v2').val();
            let op = $('#op').val();
            let dados = {
                v1: v1,
                v2: v2,
                op: op
            }
        
            $.ajax({
                url: 'calc.php',
                type: 'POST',
                //headers: headers,
                data: dados,
                success: function (retorno) {
                    $('#resultado').html(retorno)
                }
            });
        }
    </script>
</body>
</html>
