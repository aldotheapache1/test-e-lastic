<?php
	require 'envio.php';
    //captura os valores passados, codigo e email e obtem os dados atraves do link
    $codigoRastreio =  $_POST["codigo"];
    $email = $_POST["email"];
    $link = "http://localhost/rastreamento-objetos-correios-PHP/app/rastreamento.php?codigo=$codigoRastreio";
    $dados = file_get_contents($link);
    $objeto = json_decode($dados);

    //verifica o status da encomenda
    function statusEncomenda($objeto){
        foreach($objeto as $dado) {
            $status = "";

            if ($dado->action == "Objeto entregue ao destinatário") {
                $status = 'Encomenda entregue!';
            }
			else{
				$status = $dado->action;
			}
            return $status;
        }
    }

?>
<html >
<head>
	  <meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Rastreador</title>
		<link rel='shortcut icon' type='image/x-icon' href='../public/favicon.ico' />
        <link rel="stylesheet" href="../public/css/style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
<body>

<?php dadosObjeto($dados, $codigoRastreio); 

	function dadosObjeto($dados, $codigoRastreio)
	{
		$objeto = json_decode($dados);
		echo "<br>
		<div class='dados-rastreio'>
			
			<div class='dados-topo'>
				<h3 id='status'>
					<i class='material-icons'>info_outline</i> " . statusEncomenda($objeto) .
				"</h3>
				<p>Você pode acompanhar o envio com o código de rastreamento <a class='link-codigo' href='http://localhost/rastreamento-objetos-correios-PHP/app/rastreamento.php?codigo=$codigoRastreio'>{$codigoRastreio}</a>. </p>
			</div>"
			. imprime($objeto) .
			"</div>
			<div class='botao'>
			<br><a class='btn-voltar' href='../index.php'>Voltar</a>
			</div>";

	}
	//imprime os valores obtidos e estiliza eles
	function imprime($dados)
	{
		$texto = "";

		foreach($dados as $dado) {


			$texto .= "<div style='color: grey; display: flex; flex-direction: row; justify-content: start; border-bottom: 1px dotted black; margin: auto; height: 80px;'>
						<div style='margin-top: -10px; width: 150px;'>
							<p> {$dado->date} </br>
							{$dado->hour} </br>
							{$dado->location} </p>
						</div>
						<div class='margin-top: -10px; margin-left: 50px; text-align: left; width: 650px;'>
							<p>
								<strong> {$dado->action} </strong><br>
								{$dado->message}
							</p>
						</div>
					</div>";
		}

		return $texto;
	}

	$conteudo = "<div style='margin: auto; width: 600px;'>
					<div style=' border-bottom: 1px dotted black;'>
						<h3 style='color: rgb(40, 130, 200);'>
							<img src='https://findicons.com/files/icons/1008/quiet/256/information.png' style='width: 20px;'> " . statusEncomenda($objeto) .
						"</h3>
						<p>Você pode acompanhar o envio com o código de rastreamento <a class='link-codigo' href='http://localhost/rastreamento-objetos-correios-PHP/app/rastreamento.php?codigo=$codigoRastreio'>{$codigoRastreio}</a>. </p>
						<p>Aqui está o código do projeto no <a class='link-codigo' href='https://gitlab.com/aldotheapache1/case-correios'>Git Lab</a>. </p>
					</div>"
					. imprime($objeto) .
					"
					<div class='container'>
						<div style='width: 600px; height: 25px; border-radius: 10px; border: 2px solid #000; margin-top: 15px; background-color: #fff;'>";
							if(statusEncomenda($objeto) == 'Objeto postado após o horário limite da unidade' or statusEncomenda($objeto) == 'Objeto postado')
							{
								$conteudo = $conteudo . "<div style='border-radius: 10px; text-align: center; height: 25px; background-color: #4BB543; width: 5%; color: #000;'>Postado</div>";					
							}  
							else if(statusEncomenda($objeto) == 'Encomenda entregue!')
							{
								$conteudo = $conteudo . "<div style='border-radius: 10px; text-align: center; color: #000; height: 25px; background-color: #4BB543; width: 100%;'>Entregue</div>";					

							}
							else
							{
								$conteudo = $conteudo . "<div style='border-radius: 10px; text-align: center; height: 25px; background-color: #4BB543; width: 50%; color: #000;'>Encomenda a caminho</div>" ;

							}
						$conteudo = $conteudo ."</div>
						<h2>Dados do envio</h2>
						<h3>GIAN LUCAS DA SILVA RAMALHO</h3>
						<p>Telefone: (67)99977-0253</p>
						<p>Rua Tiradentes, Nº 123</p>
						<p>Centro, Campo Grande/MS</p>
						
						<strong>Falta pouco!</strong><br>
						<strong>Equipe da E-lastic Brasil</strong>
					</div>";
	enviarEmail(statusEncomenda($objeto), $conteudo, $email);
	
	
