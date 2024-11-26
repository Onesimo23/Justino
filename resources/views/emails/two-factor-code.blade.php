<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Autenticação</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            line-height: 1.6;
            color: #2d3748;
        }

        .container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: scale(1.02);
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background-color: #3b82f6;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        h1 {
            color: #1a202c;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
        }

        .auth-code {
            background-color: #e6f2ff;
            border: 2px solid #3b82f6;
            color: #1a365d;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 10px;
            padding: 15px;
            border-radius: 10px;
            margin: 25px 0;
            display: inline-block;
        }

        .expiry {
            color: #718096;
            font-size: 14px;
            margin-top: 15px;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <h1>Código de Autenticação em Dois Fatores</h1>
        
        <p>Use o seguinte código para completar seu login:</p>
        
        <div class="auth-code">
            {{ $code }}
        </div>

        <p class="expiry">
            Este código expira em 10 minutos. 
            Por razões de segurança, não compartilhe este código.
        </p>

        <div class="footer">
            Se você não solicitou este código, ignore este e-mail.
        </div>
    </div>
</body>
</html>