<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;
use \App\Utils\Funcoes;

class Feriado extends Pessoa{
    
    //data do feriado
    public $data;
    
    //descricao do feriado
    public $descricao;
    
   
	
	//Método responsavel por cadastrar o aluno no Banco de Dados
	public function cadastrar(){

		//Insere usuário no Banco de Dados
		$this->id=(new Database('feriados'))->insert([
		    	'nome' 		=> strtoupper($this->nome),
				'data' 	=> $this->data,
		    	'descricao' 	=>Funcoes::removerAcentos(strtoupper($this->descricao)),
				
		]);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por atualizar os dados no banco
	public function atualizar(){
		return (new Database('feriados'))->update('id = '.$this->id,[
		          'nome' 		=> strtoupper($this->nome),
		          'data' 	=> $this->data,
		          'descricao' 	=> Funcoes::removerAcentos(strtoupper($this->descricao)),
				
		]);
		
		
	}
	
	//Método responsavel por excluir usuário do banco
	public function excluir(){
		return (new Database('feriados'))->delete('id = '.$this->id);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por retornar uma instancia com base na data
	public static  function getFeriadoByData($data){
	   return self::getFeriados('data = '."'".$data."'")->fetchObject(self::class);
	}
	
	//Método responsavel por retornar uma instancia com base no ID
	public static  function getFeriadoById($id){
	    return self::getFeriados('id = '.$id)->fetchObject(self::class);
	}
	
	
	
	//Método responsavel por retornar Servidores
	public static function getFeriados($where = null, $order = null, $limit = null, $fields = '*') {
		return (new Database('feriados'))->select($where,$order,$limit,$fields);
	}
	
}