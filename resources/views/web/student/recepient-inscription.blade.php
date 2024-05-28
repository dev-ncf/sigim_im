<!DOCTYPE html>
<html>
	<head>
		<title>Comprovativo de Preinscicao</title>
		<style type="text/css">
			*{
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: sans-serif;
				font-weight: 400;
				font-size: 12pt;
			}
			.recepient-header{
				width: 100%;
				height: 200px;
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: column;
			}

			.recepient-header h1, h2{
				font-size: 15pt;
				font-weight: 600;
			}

			.recepient-header h1{
				line-height: 35px;
			}

			.recepient-body{
				width: 100%;
				display: flex;
				justify-content: space-between;
				align-items: centers;
				margin-bottom: 10px;
				flex-wrap: wrap;
			}

			.recepient-body h4{
				font-size: 10pt;
				line-height: 23px;
			}

			/* Estilizando a tabela */
			table, th, td{
				border: 1px solid #000000;
				text-align: center;
				font-size: 10pt;
				padding: 5px;
			}

			th{
				font-weight: 600;
			}

		</style>
	</head>
	<body style="padding: 0 150px;">
		<div class="recepient-header">
			<img src="{{ asset('img/logo.png') }}" style="width: 80px;">
			<h1>Universidade Rovuma</h1>
			<h2>Direcção do Registo Académico</h2>
		</div>
		<div class="recepient-body">
			<div style="width: 75%;">
				<h4>Numero de inscrição: </h4>
				<h4>Código do estudante: </h4>
				<h4>Nome do estudante: </h4>
				<h4>Faculdade: </h4>
				<h4>Local de estudo: </h4>
			</div>
			<div style="width: 25%;">
				<h4>Data de inscrição: 25/11/2023 16:14:00</h4>
			</div>
			<div style="width: 100%; margin-top: 15px;">
				<h4 style="font-weight: 700 !important;">Informação adcional</h4>
				<table style="width: 100%;">
					<tr>
						<th>Curso</th>
						<th>Linha de pesquisa</th>
						<th>Estado</th>
					</tr>
					<tr>
						<td>Mestrado em Gestao de Recurso Humanos</td>
						<td>
							Pesguisa em Gestao de Empresas no nosso codtidiano
						</td>
						<td>
							Pendente
						</td>
					</tr>
				</table>
				<div style="margin-top: 15px;">
					<p style="font-size: 9pt; text-align: justify;"><span style="font-weight: 500;">Nota:</span> Para que a sua inscrição seja aprovada, dirija-se à Direcção do Registo Académico onde pretende frequentar o curso de pós-graduação, com o talão de depósito, documentos autenticados e 2 fotos tipo passe para obter o comprovativo de matrícula.</p>
				</div>
			</div>
			<div style="width: 100%; margin-top: 50px">
				<span style="font-style: italic; font-size: 8pt; font-weight: 400;">Documento processado por: SIGIM<sub style="font-size: 8pt;">v1.0.0-beta</sub> aos 22/11/2023 15:10:03</span>
			</div>
		</div>

	</body>
</html>