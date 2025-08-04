<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h1 {
            margin-bottom: 1rem;
        }

        .card a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .card a:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Bienvenue sur l'API</h1>
        <p>Cliquez sur le bouton ci-dessous pour accéder à la documentation de l'API.</p>
        <a href="{{ url('/docs/api') }}">Documentation de l'API</a>
    </div>
</body>

</html>
