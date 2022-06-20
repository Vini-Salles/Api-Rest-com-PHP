<?php

//Criando cabeçalho http dizendo para o navegador que estamos dando um retorno do tipo json
header('Content-Type: application/json; charset: utf-8');

//Chamdando nessa página a classe Estoque
require_once 'classes/Estoque.php';

//Criando nossa classe e o nosso método open()

class Rest
{
    public static function open($requisicao)
    {
        //Vamos criar a variável $url para pegar o resultado da função explodde()
        //A função explode() vai separar os parâmetros pela barra
    
        $url = explode('/', $requisicao['url']);

        //Vamos criar agora duas variáveis, uma chamada classe e outra método
        //A classe vai receber o valor da primeira posição do array url[0]
        //E o método o valor da segunda posição do array url[1]

        $classe = ucfirst($url[0]);

        //A função array_shift() faz o valor na primeira posição do array url 
        //ser apagada ficando só a segunda posição, logo o método só pega o valor da segunda posição
        array_shift($url);

        $metodo = $url[0];

        array_shift($url);

        //E vamos passar pra variável parametro todos os parametros que tiver depois do que a variável metodo pegar
        $parametros = array();
        $parametros = $url;



        //Usar Try e Catch para filtrar os erros ao tentar pegar os dados do banco
        try
        {

            //Agora vamos verificar se o valor passado pela url e pego pela variável classe existe no sistema
            if(class_exists($classe))
            {

                //Agora vamos verificar se o valor passado pela url e pego pela variável metodo existe no sistema
                if(method_exists($classe, $metodo))
                {
                    //Se cair dentro desse if, quer dizer que o valor passado para a variável classe e metodo existem
                    //E vamos chamar a função call_user_func_array() e passar para a variável $retorno o retorno dessa função, 
                    //para conseguirmos acessar a classe Estoque e o método mostrar

                    $retorno = call_user_func_array(array(new $classe, $metodo), $parametros);

                    //E vamos retornar os valores armazenados ao acessar os dados, em $retorno como um json
                    return json_encode(array('status' => 'sucesso', 'dados' => $retorno));

                }
                //Se não existir esse valor passado pela url e pego pela variável metodo, vamos retornar um erro
                else
                {
                    return json_encode(array('status' => 'erro', 'dados' => 'Parâmetro Incorreto!'));
                }

            }
            //Se não existir esse valor passado pela url e pego pela variável classe, vamos retornar um erro
            else
            {
                return json_encode(array('status' => 'erro', 'dados' => 'Parâmetro Incorreto!'));
            } 
        }
        catch(Exception $e)
        {
            return json_encode(array('status' => 'erro', 'dados' => $e->getMessage()));
        }
    } 
}


//Lendo se há alguma requisição
//Vamos usar o request que consegue capturar as duas requisições get ou post

if(isset($_REQUEST))
{
    //Se existir uma requisição chama a classe Rest e o método open()

    echo Rest::open($_REQUEST);
}