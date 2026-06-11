<?php 

    require_once "conexao.php";

    if(isset($_REQUEST['enviar'])){

    $nome =($_REQUEST['nome']);
    $salarioB = ($_REQUEST['salarioB']);
    $numeroHE = ($_REQUEST['numeroHE']);
    $valorHE = ($_REQUEST['valorHE']);
    $numeroD = ($_REQUEST['numeroD']);
    $bruto = ($salarioB + ($numeroHE * $valorHE) + ($numeroD * 45));
    $inss = 0;
    $ir = 0;
    if ($bruto < 1659.38){
        $inss = $salarioB * (0.08);
    } else if ($bruto >= 1659.38 && $bruto < 2765.66) {
        $inss = $salarioB * (0.09);
    } else if ($bruto >= 2765.67 && $bruto <= 5531.31) {
        $inss = $salarioB * (0.11);
    } else if ($bruto = 5531.31) {
        $inss = 608.44;
    }

    if ($bruto < 1903.98) {
     $ir = 0;
    } else if ($bruto >= 1903.99 && $bruto < 2826.65) {
        $ir = $salarioB * (0.075);
    } else if ($bruto >= 2826.65 && $bruto < 3751.05) {
        $ir = $salarioB * (0.15);
    } else if ($bruto >= 3751.06 && $bruto < 4664.68) {
        $ir = $salarioB * (0.225);
    } else if ($bruto > 4664.68){
        $ir = $salarioB * (0.275);
    };
    

    catch (PDOException $erro){
    echo $erro->getMessage();
}
    $salarioL = $bruto - $inss - $ir;
    echo "Olá $nome, seu salário base é $salarioB, seu número de horas extras é $numeroHE, o valor delas é $valorHE, o número de dependentes é 
    $numeroD, seu salário bruto é $bruto, o INSS é $inss, o imposto de renda é $ir, e o salário líquido é $salarioL";
    };


try {
    $sqlInsert =  $conn->prepare("insert into folhapag(idFuncionario,nome,salarioB,numeroHE,numeroD,bruto,salarioL,inss,ir)values(:idFuncionario:nome:salarioB:numeroHE:numeroD:bruto:salarioL:inss:ir)");

    $sqlInsert->bindValue(':cod',null);
    $sqlInsert->bindValue(':nome',$nome);
    $sqlInsert->bindValue(':salarioB',$salarioB);
    $sqlInsert->bindValue(':numeroHE',$numeroHE);
    $sqlInsert->bindValue(':numeroD',$valorD);
    $sqlInsert->bindValue(':bruto',$bruto);
    $sqlInsert->bindValue(':salarioL',$salarioL);

    $sqlInsert -> execute();

    //echo"Dados gravados com sucesso!!!";

    echo"<script language=javascript>
    alert('Dados gravados com sucesso!!!');
    location.href = 'home.php';
    </script>;
}
    ?>

<?php