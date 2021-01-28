<?php
			$codigoRastreio =  $_GET["codigo"];
			$link = "https://www.websro.com.br/detalhes.php?P_COD_UNI=$codigoRastreio"; 
			//captura os dados do da api/site informado acima
			$a = file_get_contents($link);

			//acessa as strings capturadas em forma de html e faz a separação do texto importante
			$saida = explode("<table class=\"table table-bordered\">", $a);
			if(isset($saida[1]))
			{
				$saida = explode("</table>", $saida[1]);
				$saida = str_replace("</td>","",$saida[0]);
				$saida = str_replace("</tr>","",$saida);
				$saida = str_replace("<strong>","",$saida);
				$saida = str_replace("</strong>","",$saida);
				$saida = str_replace("<tbody>","",$saida);
				$saida = str_replace("</tbody>","",$saida);
				$saida = str_replace("<label>","",$saida);
				$saida = str_replace("</label>","",$saida);
				$saida = str_replace("&nbsp;","",$saida);
				$saida = explode("<tr>",$saida);
				$array_dados = array();


				//percorre o array e separa cada uma das informações capturadas, como data, horario e localização
				foreach($saida as $texto){
					$info   = explode("<td>",$texto);
					$dados  = explode("<br>",$info[0]);
					
					//ignora os dados errados e nulos
					if(strlen($dados[0]) == 27){
						$dados[0] = str_replace("<td valign='top'>","",$dados[0]);
						$dia = trim($dados[0]);
					}
					else{
						continue;
					}
					
					$hora  = trim(@$dados[1]);
					$local = trim(@$dados[2]);
					$dados = explode("<br>",@$info[1]);
					$acao  = trim($dados[0]);
					$exAcao   = explode($acao."<br>",@$info[1]);
					$msg  = strip_tags(trim(preg_replace('/\s\s+/', ' ',$exAcao[1])));
					
					$array_dados[] = array("date"=>$dia,"hour"=>$hora,"location"=>$local,"action"=>$acao,"message"=>$msg);
										
					}
				//retorna em formato json os dados capturados
				$jsonObcject = (object)$array_dados;
				header('Content-type: application/json');
				$json = json_encode($jsonObcject, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				echo $json;
			}else
			{
				//erro caso o codigo de rastreio esteja errado
				$jsonObcject = new stdClass();
				$jsonObcject->erro = true;
				$jsonObcject->msg = "Objeto não encontrado";
				header('Content-type: application/json');
				$json = json_encode($jsonObcject, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				echo $json;
			}

?>