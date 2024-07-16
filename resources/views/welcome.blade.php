Página de Erro Personalizada para API - Laravel Sanctum
Introdução:

Com base na sua sugestão, criei um rascunho de página estática HTML para informar ao usuário que ele está acessando uma
API e precisa definir o cabeçalho "Accept: application/json" para obter a resposta correta.

Importante:

Esta é apenas uma página de exemplo. Você precisará personalizá-la de acordo com o design e a identidade visual do seu
projeto.
Certifique-se de ajustar o código HTML e CSS para atender às suas necessidades específicas.
Código HTML:

HTML
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Erro de Cabeçalho Accept</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>API - Erro de Cabeçalho Accept</h1>
        <p>
            Parece que você está tentando acessar uma API, mas esqueceu de definir o cabeçalho "Accept:
            application/json" em sua solicitação.
        </p>
        <p>
            Para obter a resposta correta da API, adicione o seguinte cabeçalho à sua solicitação:
        </p>
        <pre>Accept: application/json</pre>
        <p>
            Com esse cabeçalho, a API retornará os dados em formato JSON, que você poderá processar em seu aplicativo.
        </p>
        <p>
            Se precisar de mais ajuda, consulte a documentação da API ou entre em contato com o desenvolvedor.
        </p>
    </div>
</body>

</html>
