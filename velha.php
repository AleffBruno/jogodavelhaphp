<?php

if(!function_exists("readline_aleff")) {
	function readline_aleff($prompt = null){
		if($prompt){
			echo $prompt;
		}
		$fp = fopen("php://stdin","r");
		$line = rtrim(fgets($fp, 1024));
		return $line;
	}
}

$arrays = array
(
	array(NULL,NULL,NULL),
	array(NULL,NULL,NULL),
	array(NULL,NULL,NULL)
);

$j1 = readline_aleff("Jogador 1 digite seu nome: ");
$simbP1 = null;
$simbP2 = null;
$loop = 1;
$vitoria = false;
//$draw = null;
$jogadorDaVez = null;

while($loop == 1)
{
	$simboloDigitado = readline_aleff($j1. " digite 'x' or 'o' ");
	if($simboloDigitado == "x")
	{
		$simbP1 = "x";
		$simbP2 = "o";
		$loop = 0;
	}
	if($simboloDigitado == "o")
	{
		$simbP1 = "o";
		$simbP2 = "x";
		$loop = 0;
	}
}
$j2 = readline_aleff("Jogador 2 digite seu nome ");
echo "Jogador: ".$j1." esta com o simbolo: ".$simbP1."\n";
echo "Jogador: ".$j2." esta com o simbolo: ".$simbP2."\n";
desenhaVelha($arrays);

while($vitoria == false)
{	
	$vezDoJogador2 = false;
	$vezDoJogador1 = false;
	$validaValorDigitadoJ1 = false;
	$validaValorDigitadoJ2 = false;
	
	if(drawGame($arrays) == false)
	{
		while($vezDoJogador2 == false)
		{
			$jogadorDaVez = $j1;
			while ($validaValorDigitadoJ1 == false)
			{
				$LinhaColunaSeparadosPorVirgula = readline_aleff("Jogador ".$j1." Digite a linha e a coluna que deseja marcar separados por virgula: ");
				
				if(preg_match("/[012],[012]?/", $LinhaColunaSeparadosPorVirgula)) {
					$validaValorDigitadoJ1 = true;
				}else{
					readline_aleff("Somente sao aceitos valores de 0 a 2 separados por ','(virgula) , porfavor tente novamente");
				}
				
			}
			
			$arrayLinhaColunaSeparadosPorVirgula =  explode(",",$LinhaColunaSeparadosPorVirgula);
			$linha = trim($arrayLinhaColunaSeparadosPorVirgula[0]);
			$coluna = trim($arrayLinhaColunaSeparadosPorVirgula[1]);
			//$linha = readline_aleff("Jogador ".$j1." Digite a linha que deseja marcar ");
			//$coluna = readline_aleff("Jogador ".$j1." Digite a coluna que deseja marcar ");
			$valor = $simbP1;
			
			if($linha <= count($arrays)-1 && $coluna <= count($arrays[0])-1)
			{
				if($arrays[$linha][$coluna] == null || $arrays[$linha][$coluna] == "")
				{
					$arrays[$linha][$coluna] = $valor;
					$vezDoJogador2 = true;
				}else{
					readline_aleff("A posicao ".$linha.",".$coluna." ja esta ocupada, porfavor escolha outra");
					$vezDoJogador2 = false;
					$validaValorDigitadoJ1 = false;
				}
			}else{
				readline_aleff("As posições nao existe, porfavor reescreva");
			}
			
			
		}
	}else{
		$vitoria = true;
	}
	
	
	desenhaVelha($arrays);
	
	if(verifyColumn($arrays) == true || verifyLine($arrays) == true || verifyMainDiagonal($arrays) == true || verifySecondaryDiagonal($arrays) == true)
	{
		$vitoria = true;
	}else{
		if(drawGame($arrays) == false)
		{
			while($vezDoJogador1 == false)
			{
				$jogadorDaVez = $j2;
				while ($validaValorDigitadoJ2 == false)
				{
					$LinhaColunaSeparadosPorVirgula = readline_aleff("Jogador ".$j2." Digite a linha e a coluna que deseja marcar separados por virgula: ");
					
					if(preg_match("/[012],[012]?/", $LinhaColunaSeparadosPorVirgula)) {
						$validaValorDigitadoJ2 = true;
					}else{
						readline_aleff("Somente sao aceitos valores de 0 a 2 separados por ','(virgula) , porfavor tente novamente");
					}
					
				}
				$arrayLinhaColunaSeparadosPorVirgula =  explode(",",$LinhaColunaSeparadosPorVirgula);
				$linha = trim($arrayLinhaColunaSeparadosPorVirgula[0]);
				$coluna = trim($arrayLinhaColunaSeparadosPorVirgula[1]);
				//$linha = readline_aleff("Jogador ".$j2." Digite a linha que deseja marcar ");
				//$coluna = readline_aleff("Jogador ".$j2." Digite a coluna que deseja marcar ");
				$valor = $simbP2;
				
				if($linha <= count($arrays)-1 && $coluna <= count($arrays[0])-1)
				{
					if($arrays[$linha][$coluna] == null || $arrays[$linha][$coluna] == "")
					{
						$arrays[$linha][$coluna] = $valor;
						$vezDoJogador1 = true;
					}else{
						readline_aleff("A posicao ".$linha.",".$coluna." ja esta ocupada, porfavor escolha outra");
						$vezDoJogador1 = false;
						$validaValorDigitadoJ2 = false;
					}
				}else{
					readline_aleff("As posições nao existe, porfavor reescreva");
				}
				
			}
		}
		

		//print_r($arrays);
		desenhaVelha($arrays);
		
		if(verifyColumn($arrays) == true || verifyLine($arrays) == true || verifyMainDiagonal($arrays) == true || verifySecondaryDiagonal($arrays) == true)
		{
			$vitoria = true;
		}

	}	
}


if($vitoria == true && drawGame($arrays) == false)
{
	echo "Jogador ".$jogadorDaVez." Venceu !";
}else{
	echo "DRAW game";
}






/*
for ($i=0; $i <= 8; $i++) {
	$line = readline_aleff("Digite a linha que deseja marcar: ");
	$column = readline_aleff("Digite a coluna que deseja marcar: ");
	$value = readline_aleff("Digite a valor que deseja marcar: ");
	$arrays[$line][$column] = $value;
}
print_r($arrays);
*/

function desenhaVelha($var)
{	
	echo "\n";
	for($i=0;$i<=count($var)-1;$i++)
	{
		for($j=0;$j<=count($var[$i])-1;$j++)
		{
			//echo $var[$i][$j];
			if($var[$i][$j] == "")
			{
				$var[$i][$j] = " ";
			}
		}
	}
	
	
	echo"  "." 0 | 1 | 2 \n\n";
	echo"0 "." ".$var[0][0]." | ".$var[0][1]." | ".$var[0][2]." \n";
	echo"  "."-----------\n";
	echo"1 "." ".$var[1][0]." | ".$var[1][1]." | ".$var[1][2]." \n";
	echo"  "."-----------\n";
	echo"2 "." ".$var[2][0]." | ".$var[2][1]." | ".$var[2][2]." \n";
}


function verifyLine($arrays)
{
	$retornoFinal = false;
	$result = array();
	for($i=0;$i<=count($arrays)-1;$i++)
	{
		$result[$i] = true;
		//print_r($arrays[$i]);
		for($j=0;$j<=count($arrays[$i])-1;$j++)
		{
			//print_r($arrays[$i][$j]);
			if($arrays[$i][$j] == $arrays[$i][0] && $arrays[$i][$j] != NULL && $arrays[$i][0] != NULL)
			{
				
			}else{
				$result[$i] = false;
			}
		}
		//print_r($arrays[$i]);
	}
	//print_r($result);
	foreach($result as $value)
	{
		if($value == true)
		{
			$retornoFinal = true;
		}
	}
	return $retornoFinal;
}

function verifyColumn($arrays)
{
	$retornoFinal = false;
	$result = array();
	for($i=0;$i<=count($arrays)-1;$i++)
	{
		$result[$i] = true;
		//print_r($arrays[$i]);
		for($j=0;$j<=count($arrays[$i])-1;$j++)
		{
			//print_r($arrays[$i][$j]);
			if($arrays[$j][$i] == $arrays[0][$i] && $arrays[$j][$i] != NULL && $arrays[0][$i] != NULL)
			{
				
			}else{
				$result[$i] = false;
			}
		}
		//print_r($arrays[$i]);
	}
	//print_r($result);
	foreach($result as $value)
	{
		if($value == true)
		{
			$retornoFinal = true;
		}
	}
	return $retornoFinal;
}

function verifyMainDiagonal($arrays)
{

	$result = true;
	$i = 0;
	$j=0;
	while($i<count($arrays)-1)
	{
		while($j<count($arrays[$i])-1)
		{
			$var = $arrays[$i][$j];
			$var_aux = $var;
			$i++;
			$j++;
			if($arrays[$i][$j] == $var_aux && $arrays[$i][$j] != NULL && $var_aux != NULL)
			{
				
			}else{
				$result = false;
			}
		}
	}
	//echo $result;
	return $result;

	
}

function verifySecondaryDiagonal($arrays)
{
	try
	{
		$result = true;
		$i = count($arrays)-1;
		$j = 0;
		while($i>0)
		{
			while($j<count($arrays[$i])-1)
			{
				$var = $arrays[$i][$j];
				$var_aux = $var;
				$i--;
				$j++;
				if($arrays[$i][$j] == $var_aux && $arrays[$i][$j]!=NULL && $var_aux != NULL)
				{
					
				}else{
					$result = false;
				}
			}
		}

		//echo $result;
		return $result;
	}catch(Exception $e)
	{
		
	}
}

function drawGame($arrays)
{
	$result= true;
	for($i=0;$i<=count($arrays)-1;$i++)
	{
		for($j=0;$j<=count($arrays)-1;$j++)
		{
			if($arrays[$i][$j] == NULL || $arrays[$i][$j] == "")
			{
				$result = false;
			}
		}
		
	}
	return $result;
}




?>

