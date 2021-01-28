<html>
	<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Rastreador</title>
		<link rel='shortcut icon' type='image/x-icon' href='public/favicon.ico' />
		<link rel="stylesheet" href="public/css/style.css">
	</head>
	<body>
	<div class="container">
		<div class="logo">
			<img src="https://elastic.fit/wp-content/uploads/2020/08/logo-color-small.png" alt="Elastic logo">
		</div>
		<form action="app/exibe.php" method="POST">
			<label class="codigo" for="codigo">Código de Rastreamento</label>
			<input for="codigo" name="codigo" type="text" placeholder="OA016913717BR" required>
			<label class="email" for="email">Email</label>
			<input for="email" name="email" type="email" placeholder="teste.teste@gmail.com" required>
			<button class="btn" type="submit">Rastrear</button>
		</form>
	</div>
	</body>
</html>



