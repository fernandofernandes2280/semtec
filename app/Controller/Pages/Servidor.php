<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Servidor as EntityServidor;
use \App\Model\Entity\Vinculo as EntityVinculo;
use \App\Model\Entity\Lotacao as EntityLotacao;
use \App\Model\Entity\LocalTrabalho as EntityLocalTrabalho;
use \App\Model\Entity\CargoFuncao as EntityCargoFuncao;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Utils\Funcoes;


class Servidor extends Page{
	
	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getServidorItems($request, &$obPagination){

		$itens = '';

		//Quantidade total de registros
		$quantidadetotal =  EntityServidor::getServidores(Funcoes::condicao(), null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual

		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		
		
		//Resultados da Página com paginacao
		//$results = EntityServidor::getServidores(Funcoes::condicao(), 'nome',$obPagination->getLimit());
		
		//Resultados da Página sem  paginaçao
		$results = EntityServidor::getServidores(Funcoes::condicao(), 'nome',null);
		

		//Renderiza o item
		while ($ob = $results->fetchObject(EntityServidor::class)) {
							//View de listagem
			$itens.= View::render('pages/servidores/item',[
                        'id' => $ob->id,
                        'nome' => $ob->nome,
                        'matricula' => $ob->matricula,
                        'vinculo' =>EntityVinculo::getVinculoById($ob->vinculo)->nome,
                        'cargoFuncao' =>EntityCargoFuncao::getCargoFuncaoById($ob->cargoFuncao)->nome,
                        'lotacao' =>EntityLotacao::getLotacaoById($ob->lotacao)->nome,
                        'localTrabalho' =>EntityLocalTrabalho::getLocalTrabalhoById($ob->localTrabalho)->nome,
                        'email' => $ob->email,
                        'telefone' => $ob->telefone,
                        'dataNasc' => date('d/m/Y', strtotime($ob->dataNasc)),
                        'dataCad' => date('d/m/Y', strtotime($ob->dataCad)),
                        'cpf' => $ob->cpf
					
			]);
		
		}
				//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getServidores($request){
		
		//Conteúdo da Home
		$content = View::render('pages/servidores/index',[
		    'title' => 'Servidores',
		    'itens' => self::getServidorItems($request, $obPagination),
		    //'pagination' => parent::getPagination($request, $obPagination),
		    
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('Servidores', $content,'servidores');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getServidorNew($request){
		
	    //Post Vars
	
	    $queryParams = $request->getQueryParams();
	    $cpf = $queryParams['cpf'];
	   
	    //Verifica se o CPF é válido
	    if(!$validaCpf = Funcoes::validaCPF($cpf)){
	        $request->getRouter()->redirect('/servidores/new/validaCpf?statusMessage=invalidCpf');
	    }
	    
	    //verifica se o CPF já está cadastrado
	    $ob = EntityServidor::getServidorByCpf($cpf);
	    if($ob instanceof EntityServidor){
	        //redireciona caso cpf já esteja cadastrado
	        $request->getRouter()->redirect('/servidores/new/validaCpf?statusMessage=alertDuplicatedCpf');
	    }
	    $hoje = date("Y-m-d");
	   
		//Conteúdo do Formulário
		$content = View::render('pages/servidores/form',[
				'title' => 'Servidores > Novo',
				'matricula' => '',
				'optionVinculo' => EntityVinculo::getSelectVinculo(null),
				'optionCargoFuncao' => EntityCargoFuncao::getSelectCargoFuncao(null),
				'optionLotacao' => EntityLotacao::getSelectLotacao(null),
				'optionLocalTrabalho' => EntityLocalTrabalho::getSelectLocalTrabalho(null),
				'localTrabalho' => '',
				'email' => '',
				'telefone' => '',
		        'dataCad' => $hoje,
				'dataNasc' => '',
				'nome' => '',
				'cpf' => $cpf,

				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Servidores > Novo', $content,'servidores');
		
	}
	
	
	//Método resposnsável por validar o cpf e verificar se o servidor já está cadastrado
	public static function getValidaCPF($request){
	    
	    
	    //Conteúdo do Formulário para validacao do cpf
	    $content = View::render('pages/servidores/formValidaCpf',[
	        'title' => 'Servidores > Novo',
	        'cpf' => '',
	        
	    ]);
	    
	    //Retorna a página completa
	    return parent::getPanel('Servidores > Novo', $content,'servidores');
	    
	    
	}
	
	//Método resposnsável por validar o cpf e verificar se o servidor já está cadastrado
	public static function setValidaCPF($request){
	    
	    //Post Vars
	    $postVars = $request->getPostVars();
	    
	    //Verifica se o CPF é válido
	    if(!$validaCpf = Funcoes::validaCPF($postVars['cpf'])){
	        $request->getRouter()->redirect('/servidores/new/validaCpf?statusMessage=invalidCpf');
	    }
	  
	    //verifica se o CPF já está cadastrado
	    $ob = EntityServidor::getServidorByCpf($postVars['cpf']);
	    if($ob instanceof EntityServidor){
	        //redireciona caso cpf já esteja cadastrado
	        $request->getRouter()->redirect('/servidores/new/validaCpf?statusMessage=alertDuplicatedCpf');
	    }
	    
        //prosseque com o Cadastro de novo CPF
	    $request->getRouter()->redirect('/servidores/new?cpf='.$postVars['cpf'].'');
	    
	    
	}
	
	
	//Metodo responsávelpor por cadastrar Servidor no banco
	public static function setServidorNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		
		$cpf = strtolower($postVars['cpf']);
		
		//busca usuário pelo CPF sem a maskara
		$ob = EntityServidor::getServidorByCpf($cpf);
		//verifica se o cpf já está cadastrado
		if($ob instanceof EntityServidor){
		    $request->getRouter()->redirect('/servidores/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityServidor();
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'];
		$matricula = $postVars['matricula'];
		$vinculo = $postVars['vinculo'];
		$cargoFuncao = $postVars['cargoFuncao'];
		$lotacao = $postVars['lotacao'];
		$localTrabalho = $postVars['localTrabalho'];
		$email = $postVars['email'];
		$telefone = $postVars['telefone'];
		$dataNasc = $postVars['dataNasc'];
		$dataCad = $postVars['dataCad'];
		$cpf = $postVars['cpf'];
		$gestor = $_SESSION['usuario']['id'] ?? 0;
		
	
		
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->matricula = $matricula;
		$ob->vinculo = $vinculo;
		$ob->cargoFuncao = $cargoFuncao;
		$ob->lotacao = $lotacao;
		$ob->localTrabalho = $localTrabalho;
		$ob->email = $email;
		$ob->telefone = $telefone;
		$ob->dataCad = $dataCad;
		$ob->dataNasc = $dataNasc;
		$ob->cpf = $cpf;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/servidores?statusMessage=created');
		
	}
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getServidorEdit($request,$id){
		//obtém o usuário do banco de dados
		$ob = EntityServidor::getServidorById($id);
		
		//Valida a instancia
		if(!$ob instanceof EntityServidor){
			$request->getRouter()->redirect('/servidores');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/servidores/form',[
			'title' => 'Servidores > Editar',
			'cpf' => $ob->cpf ?? '',
			'nome' => $ob->nome ?? '',
		    'matricula' => $ob->matricula ?? '',
		    'optionVinculo' => EntityVinculo::getSelectVinculo($ob->vinculo),
		    'optionCargoFuncao' => EntityCargoFuncao::getSelectCargoFuncao($ob->cargoFuncao),
		    'optionLotacao' => EntityLotacao::getSelectLotacao($ob->lotacao),
		    'optionLocalTrabalho' => EntityLocalTrabalho::getSelectLocalTrabalho($ob->localTrabalho),
		    'cargoFuncao' => $ob->cargoFuncao ?? '',
		    'lotacao' => $ob->lotacao ?? '',
		    'localTrabalho' => $ob->localTrabalho ?? '',
		    'email' => $ob->email ?? '',
		    'telefone' => $ob->telefone ?? '',
		    'dataCad' => $ob->dataCad ?? '',
		    'dataNasc' => $ob->dataNasc ?? '',
				
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Servidores > Editar', $content,'servidores');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setServidorEdit($request,$id){
		//obtém o usuário do banco de dados
		$ob = EntityServidor::getServidorById($id);
		
		//Valida a instancia
		if(!$ob instanceof EntityServidor){
			$request->getRouter()->redirect('/servidores');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		$matricula = $postVars['matricula'] ?? '';
		$vinculo = $postVars['vinculo'] ?? '';
		$cargoFuncao = $postVars['cargoFuncao'] ?? '';
		$lotacao = $postVars['lotacao'] ?? '';
		$localTrabalho = $postVars['localTrabalho'] ?? '';
		$email = $postVars['email'] ?? '';
		$telefone = $postVars['telefone'] ?? '';
		$dataNasc = $postVars['dataNasc'] ?? '';
		$dataCad = $postVars['dataCad'] ?? '';
		
		
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->matricula = $matricula;
		$ob->vinculo = $vinculo;
		$ob->cargoFuncao = $cargoFuncao;
		$ob->lotacao = $lotacao;
		$ob->localTrabalho = $localTrabalho;
		$ob->email = $email;
		$ob->telefone = $telefone;
		$ob->dataCad = $dataCad;
		$ob->dataNasc = $dataNasc;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/servidores/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getServidorDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityServidor::getServidorById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityServidor){
			$request->getRouter()->redirect('/servidores');
		}
		
		
		
		//Conteúdo do Formulário
		$content = View::render('pages/servidores/delete',[
		        'title' => 'Servidores > Excluir',
				'nome' => $ob->nome,
			
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Servidores > Excluir', $content,'servidores');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setServidorDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityServidor::getServidorById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityServidor){
			$request->getRouter()->redirect('/servidores');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/servidores?statusMessage=deleted');
		
		
	}
	
	
}