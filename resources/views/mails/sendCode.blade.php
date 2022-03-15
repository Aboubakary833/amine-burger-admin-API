<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code de confirmation</title>
</head>
<body>
    <h1>Bienvenue sur AmineBurger</h1>
    <p>Bonjour et bienvenue à vous {{ $user }}! Pour poursuivre votre inscription sur notre site, veuillez entrez ce code: </p>
    <h3>
        <i>{{ $code }}</i>
    </h3>
</body>
</html>