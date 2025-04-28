<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;
use App\Utils\View;
use App\Utils\Funcoes;


class CargoFuncao extends Pessoa{
       
   //Método responsavel por cadastrar o aluno no Banco de Dados
	public function cadastrar(){

		//Insere usuário no Banco de Dados
		$this->id=(new Database('cargoFuncao'))->insert([
		    'nome' 		=>strtoupper(Funcoes::removerAcentos($this->nome)),
				
		]);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por atualizar os dados no banco
	public function atualizar(){
		return (new Database('cargoFuncao'))->update('id = '.$this->id,[
		    'nome' 		=> strtoupper(Funcoes::removerAcentos($this->nome))
				
		]);
		
		
	}
	
	//Método responsavel por excluir usuário do banco
	public function excluir(){
		return (new Database('cargoFuncao'))->delete('id = '.$this->id);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por retornar uma instancia com base no nome
	public static  function getCargoFuncaoByNome($nome){
	    return self::getCargosFuncao('nome = '."'".$nome."'")->fetchObject(self::class);
	}
	
	//Método responsavel por retornar uma instancia com base no ID
	public static  function getCargoFuncaoById($id){
	    return self::getCargosFuncao('id = '.$id)->fetchObject(self::class);
	}
	
	
	
	//Método responsavel por retornar Servidores
	public static function getCargosFuncao($where = null, $order = null, $limit = null, $fields = '*') {
		return (new Database('cargoFuncao'))->select($where,$order,$limit,$fields);
	}
	
	//Método responsavel por listar As Turmas no select option, selecionando o do Aluno
	public static function getSelectCargoFuncao($id){
	    $resultados = '';
	    $results =  self::getCargosFuncao(null,'nome asc',null);
	    //verifica se o id não é nulo e obtém o Procedencia do banco de dados
	    if (!is_null($id)) {
	        $selected = '';
	        while ($ob = $results -> fetchObject(self::class)) {
	            
	            //seleciona a Turma do aluno
	            $ob->id == $id ? $selected = 'selected' : $selected = '';
	            //View de Turmas
	            $resultados .= View::render('pages/selectOption/itemSelect',[
	                'id' => $ob ->id,
	                'nome' => $ob->nome,
	                'selecionado' => $selected
	            ]);
	        }
	        //retorna
	        return $resultados;
	    }else{ //se for nulo, lista todos e seleciona um em branco
	        while ($ob = $results -> fetchObject(self::class)) {
	            $selected = '';
	            $resultados .= View::render('pages/selectOption/itemSelect',[
	                'id' => $ob ->id,
	                'nome' => $ob->nome,
	                'selecionado' => $selected
	            ]);
	        }
	        //retorna a listagem
	        return $resultados;
	    }
	}
	
	
	
}