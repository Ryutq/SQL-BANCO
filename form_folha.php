	<html>
	<head>
	<title>Exercicio 2 de PHP</title>
	</head>


	<body>
	<form name="Enviar" method="post" action="form_folha.php">

	<fieldset>
	<p>Nome do Funcionário</p>
	<input type="text" name="nome">


	<p>Salário Base</p>
	<input type="text" name="salariobase">


	<p>Número de horas extras</p>
	<input type="text" name="horasextras">


	<p>Valor horas extras</p>
	<input type="text" name="valorhoras">


	<p>Número de Dependentes</p>
	<input type="text" name="dependentes">

	<input type="submit" name="Enviar" value="Enviar">

	</fieldset>	



	<?php

		require_once "conexao.php";

		if(isset($_REQUEST["Enviar"])) //ação executada apenas quando clicar no botão	
		{

		$nome= $_POST["nome"];
		$salariobase= $_POST["salariobase"];
		$horasextras= $_POST["horasextras"];
		$valorhoras= $_POST["valorhoras"];
		$dependentes= $_POST["dependentes"];

		$salbruto= $salariobase + ($horasextras * $valorhoras) + ($dependentes * 45.00);

		//echo"<p> $salbruto";

		if ($salbruto <= 1658.38)
		{
			$inss= $salbruto * (0.08);
		}

		if ($salbruto >= 1658.39 and $salbruto <= 2765.66)
		{
			$inss= $salbruto * (0.09);
		}

		if ($salbruto >= 2765.67 and $salbruto <= 5531.31)
		{
			$inss= $salbruto * (0.11);
		}


		if ($salbruto > 5531.31)
		{
			$inss= 608.44;
		
		}


		//--------------PULANDO LINHA ------------------//


		if ($salbruto <= 1093.98)
		{
			$Irenda= 0;
		}


		if ($salbruto >= 1093.99 and $salbruto <= 2826.65)
		{

			$Irenda= ($salbruto - 142.80) * 0.07 ;
		
		}

		
		if ($salbruto >= 2826.66 and $salbruto <= 3751.05)
		{
			$Irenda= ($salbruto - 354.80) * 0.15 ;
		}


		if ($salbruto >= 3751.06 and $salbruto <=4664.68)
		{
			$Irenda= ($salbruto - 636.13) * 0.225 ;
		
		}


		if ($salbruto > 4664.69)
		{
			$Irenda= ($salbruto - 869.36) * 0.275 ;
		
		}


		$salliquido= $salbruto - $inss - $Irenda;

		try{
			$sqlInsert = $conn->prepare("insert into folhapag (id_funcionario,nome, salariobase, horasextras, valorhoras, dependentes, salbruto, salliquido, inss, Irenda ) values (:id_funcionario,:nome, :salariobase, :horasextras, :valorhoras, :dependentes, :salbruto, :salliquido, :inss, :Irenda)");

			$sqlInsert->bindValue(':id_funcionario',null);
			$sqlInsert->bindValue(':nome',$nome);
			$sqlInsert->bindValue(':salariobase',$salariobase);
			$sqlInsert->bindValue(':horasextras',$horasextras);
			$sqlInsert->bindValue(':valorhoras',$valorhoras);
			$sqlInsert->bindValue(':dependentes',$dependentes);
			$sqlInsert->bindValue(':salbruto',$salbruto);
			$sqlInsert->bindValue(':salliquido',$salliquido);
			$sqlInsert->bindValue(':inss',$inss);
			$sqlInsert->bindValue(':Irenda',$Irenda);

			$sqlInsert->execute();
			echo "<script language=javascript>
                alert('Dados gravados com sucesso!!');
                location.href = 'form_folha.php';
			  </script>";
			  
			 // header("location:form_folha.php");
		}	
		catch(PDOException $erro){
			echo $erro->getMessage();
		}
	}
	?>
	<h1>Consulta de Funcionários</h1>
	<table border="1">
		<tr>
			<th scope="col">ID</th>
			<th scope="col">Nome</th>
			<th scope="col">Salário Base</th>
			<th scope="col">Horas Extras</th>
			<th scope="col">Valor Horas</th>
			<th scope="col">Dependentes</th>
			<th scope="col">Salário Bruto</th>
			<th scope="col">Salário Líquido</th>
			<th scope="col">INSS</th>
			<th scope="col">Imposto de Renda</th>
			<th scope="col">Opções</th>
		</tr>
		<?php
			try{
				$sqlSelect = $conn->prepare("select * from folhapag");
				$sqlSelect->execute();

				while($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)){
		?>
		<tr>
			<td><?php echo $row["id_funcionario"]?></td>
			<td><?php echo $row["nome"]?></td>	
			<td><?php echo $row["salariobase"]?></td>	
			<td><?php echo $row["horasextras"]?></td>	
			<td><?php echo $row["valorhoras"]?></td>	
			<td><?php echo $row["dependentes"]?></td>	
			<td><?php echo $row["salbruto"]?></td>	
			<td><?php echo $row["salliquido"]?></td>	
			<td><?php echo $row["inss"]?></td>	
			<td><?php echo $row["Irenda"]?></td>
			<td>
				<a href="form_folha.php?ex=<?php echo $row["id_funcionario"]?>">Excluir</a>
				<a href="alterar.php?al=<?php echo $row["id_funcionario"]?>">Alterar</a>
			</td>
		</tr>
		<?php
				}
			}
			catch(PDOException $erro){
				echo $erro->getMessage();
			}
			try{
				if(isset($_REQUEST["ex"])){
					$id_funcionario = $_REQUEST["ex"];
					$sqlDelete = $conn->prepare("delete from folhapag where id_funcionario = :id_funcionario");
					$sqlDelete->bindValue(":id_funcionario",$id_funcionario);
					$sqlDelete->execute();

					header("location:form_folha.php");

				}
			}
			catch(PDOException $erro){
				echo $erro->getMessage();
			}
			//$conn=null;
		?>
	</html>