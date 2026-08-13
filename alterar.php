<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Funcionários</title>
</head>
<?php
    require_once "conexao.php";

    try{
        if(isset($_REQUEST["al"])){
            $id_funcionario = $_REQUEST["al"];

            $sqlSelect = $conn->prepare("select * from folhapag where id_funcionario = :id_funcionario");
            $sqlSelect->bindValue(":id_funcionario",$id_funcionario);
            $sqlSelect->execute();

            $row = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        }
    }
    catch(PDOException $erro){
		echo $erro->getMessage();
	}
?>
<?php
    if(isset($_REQUEST["Alterar"])){
        $id_funcionario = $_REQUEST["id_funcionario"];
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

        $sqlUpdate = $conn->prepare("update folhapag set nome = :nome, salariobase = :salariobase, horasextras = :horasextras, 
		valorhoras = :valorhoras, 
		dependentes = :dependentes, salbruto = :salbruto, salliquido = :salliquido,
		 inss = :inss, Irenda = :Irenda where id_funcionario = :id_funcionario");
		$sqlUpdate->bindValue('id_funcionario',$id_funcionario);
		$sqlUpdate->bindValue('nome',$nome);
		$sqlUpdate->bindValue('salariobase',$salariobase);
		$sqlUpdate->bindValue('horasextras',$horasextras);
		$sqlUpdate->bindValue('valorhoras',$valorhoras);
		$sqlUpdate->bindValue('dependentes',$dependentes);
		$sqlUpdate->bindValue('salbruto',$salbruto);
		$sqlUpdate->bindValue('salliquido',$salliquido);
		$sqlUpdate->bindValue('inss',$inss);
		$sqlUpdate->bindValue('Irenda',$Irenda);
	}
?>
<body>
    
</body>
</html>