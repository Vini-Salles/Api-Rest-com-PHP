<?php 
//Vamos criar aqui a classe para fazer a conexão com o banco de dados Estoque
class Estoque
{
	//E ddentro dela vai ter um método chamado mostrar(), esse método
	//Vai ser responsável por mostrar a quantidade de itens que tem no meu Estoque
	public function mostrar()
	{
		//Vamos primeiro criar a conexão com o banco de dados
		$dbname = 'mysql:host=localhost;dbname=empresa';
		$user = 'root';
		$pass = '';

		$con = new PDO($dbname, $user, $pass);
 
 		//Lendo dados do banco
		$sql = "SELECT * FROM pessoas";
		$stmt = $con->prepare($sql);
		$stmt->execute();


		$resultados = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$resultados[] = $row;
		}

		//Se não houver nada em $resultados entra nesse if
		if(!$resultados)
		{
			throw new Exception("Nenhum item no Estoque!");
		}

		//Se houver alguma coisa em $resultados irá ser retornado
		//Todos os dados vindo do banco passados para $resultados
		return $resultados; 		
	}
}