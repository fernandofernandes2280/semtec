<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;
use App\Utils\View;
use App\Utils\Funcoes;

class Servidor extends Pessoa{
    
    //matricula do servidor
    public $matricula;
    
    //vínculo do servidor
    public $vinculo;
    
    //cargo ou funcao do servidor
    public $cargoFuncao;
    
    //local de trabalho do servidor
    public $localTrabalho;
    
    //local de trabalho do servidor
    public $lotacao;
    
    //data de nascimento
    public $dataNasc;
    
    //data de cadastro
    public $dataCad;
    
    //cpf do servidor
    public $cpf;

   

	//Método responsavel por cadastrar o aluno no Banco de Dados
	public function cadastrar(){

		//Insere usuário no Banco de Dados
		$this->id=(new Database('servidor'))->insert([
		    'nome' 		=>strtoupper(Funcoes::removerAcentos($this->nome)),
		    'matricula' 	=> $this->matricula,
				'vinculo' 	=> $this->vinculo,
				'cargoFuncao' 	=> $this->cargoFuncao,
				'lotacao' 	=> $this->lotacao,
		    'localTrabalho' 	=> $this->localTrabalho,
		    'email' => strtoupper(Funcoes::removerAcentos($this->email)),
		        'telefone' => $this->telefone,
		        'dataNasc' => $this->dataNasc,
		        'dataCad' => $this->dataCad,
		        'cpf' => $this->cpf,
		        'gestor' => $this->gestor,
		      
		]);
		//Sucesso
		return true;
	}
	
	//Método responsavel por atualizar os dados no banco
	public function atualizar(){
		return (new Database('servidor'))->update('id = '.$this->id,[
		    'nome' 		=> strtoupper(Funcoes::removerAcentos($this->nome)),
		    'matricula' 	=> $this->matricula,
		    'vinculo' 	=> $this->vinculo,
		    'cargoFuncao' 	=> $this->cargoFuncao,
		    'lotacao' 	=> $this->lotacao,
		    'localTrabalho' 	=> $this->localTrabalho,
		    'email' => strtoupper(Funcoes::removerAcentos($this->email)),
		    'telefone' => $this->telefone,
		    'dataNasc' => $this->dataNasc,
		    'dataCad' => $this->dataCad,
		    
		]);
		
		
	}
	
	//Método responsavel por excluir usuário do banco
	public function excluir(){
		return (new Database('servidor'))->delete('id = '.$this->id);
		
		//Sucesso
		return true;
	}
	
	//Método responsavel por retornar uma instancia com base no id
	public static  function getServidorById($id){
	    return self::getServidores('id = '.$id)->fetchObject(self::class);
		
	}
	
	//Método responsavel por retornar uma instancia com base no id
	public static  function getServidorByCpf($cpf){
	    return self::getServidores('cpf = "'.$cpf.'"')->fetchObject(self::class);
	    
	}
	
	//Método responsavel por retornar um usuario com base em seu e-mail
	public static function getServidorByEmail($email){
	    return self::getServidores('email = "'.$email.'"')->fetchObject(self::class);
				
		//Sucesso
		return true;
	}
	
	//Método responsavel por retornar Servidores
	public static function getServidores($where = null, $order = null, $limit = null, $fields = '*') {
		return (new Database('servidor'))->select($where,$order,$limit,$fields);
	}
	
	//Método responsavel por listar os Servidores  no select option
	public static function getSelectServidor($id){
	    $resultados = '';
	    $results =  self::getServidores(Funcoes::condicao(),'nome asc',null);
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