<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }
        .imagen{
            background-image: url("../image/file_not_found.webp");
            background-size: cover;
            width: 350px;
            height:  350px;
            
        }
        .container {
            max-width: 800px;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        a {
            color: #4a90e2;
            text-decoration: none;
            font-size: 1em;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="imagen">
        </div>
        <h1>404</h1>
        <p>Lo sentimos, la página que buscas no existe.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</body>
</html>