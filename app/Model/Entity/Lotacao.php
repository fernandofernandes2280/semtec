<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;
use App\Utils\View;
use App\Utils\Funcoes;

class Lotacao extends Pessoa{
       
   //Método responsavel por cadastrar o aluno no Banco de Dados
	public function cadastrar(){

		//Insere usuário no Banco de Dados
		$this->id=(new Database('lotacao'))->insert([
		    'nome' 		=> strtoupper(Funcoes::removerAcentos($this->nome)),
			'gestor' => $this->gestor
		]);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por atualizar os dados no banco
	public function atualizar(){
		return (new Database('lotacao'))->update('id = '.$this->id,[
		    'nome' 		=> strtoupper(Funcoes::removerAcentos($this->nome)),
				
		]);
		
		
	}
	
	//Método responsavel por excluir usuário do banco
	public function excluir(){
		return (new Database('lotacao'))->delete('id = '.$this->id);
		
		//Sucesso
		return true;
	}
	
	
	
	//Método responsavel por retornar uma instancia com base no ID
	public static  function getLotacaoById($id){
	    return self::getLotacao('id = '.$id)->fetchObject(self::class);
	}
	
	//Método responsavel por retornar uma instancia com base na data
	public static  function getLotacaoByNome($nome){
	    return self::getLotacao('nome = '."'".$nome."'")->fetchObject(self::class);
	}
	
	//Método responsavel por retornar Servidores
	public static function getLotacao($where = null, $order = null, $limit = null, $fields = '*') {
		return (new Database('lotacao'))->select($where,$order,$limit,$fields);
	}
	
	//Método responsavel por listar As Turmas no select option, selecionando o do Aluno
	public static function getSelectLotacao($id){
	    $resultados = '';
	    $results =  self::getLotacao(Funcoes::condicao(),'nome asc',null);
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