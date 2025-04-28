<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\LocalTrabalho as EntityLocalTrabalho;
use App\Utils\Funcoes;
use \WilliamCosta\DatabaseManager\Pagination;

class LocalTrabalho extends Page{
	
	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getLocalTrabalhoItems($request, &$obPagination){

		$itens = '';
		
		
		//Quantidade total de registros
		$quantidadetotal =  EntityLocalTrabalho::getLocalTrabalho(Funcoes::condicao(), null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityLocalTrabalho::getLocalTrabalho(Funcoes::condicao(), 'nome',null);
		
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityLocalTrabalho::class)) {
							//View de listagem
			$itens.= View::render('pages/localTrabalho/item',[
			         'id' => $ob->id,
					'nome' => $ob->nome,
					
			]);
		
		}
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getLocalTrabalho($request){
		
		//Conteúdo da Home
		$content = View::render('pages/localTrabalho/index',[
		    'title' => 'Local de Trabalho',
		    'itens' => self::getLocalTrabalhoItems($request, $obPagination),
		   // 'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Local de Trabalho', $content,'localTrabalho');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getLocalTrabalhoNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/localTrabalho/form',[
				'title' => 'Local de Trabalho > Novo',
				'nome' => '',
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Local de Trabalho > Novo', $content,'localTrabalho');
		
	}
	
	
	//Metodo responsávelpor por cadastrar feriado no banco
	public static function setLocalTrabalhoNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$nome = strtoupper($postVars['nome']);
		$gestor = $_SESSION['usuario']['id'];
		
		//verifica se a Lotacao já está cadastrada
		$ob = EntityLocalTrabalho::getLocalTrabalhoByNome($nome);
		if($ob instanceof EntityLocalTrabalho){
		    $request->getRouter()->redirect('/localTrabalho/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityLocalTrabalho();
		
		$ob->nome = $nome;
		$ob->gestor = $gestor;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/localTrabalho?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getLocalTrabalhoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLocalTrabalho::getLocalTrabalhoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLocalTrabalho){
			$request->getRouter()->redirect('/localTrabalho');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/localTrabalho/form',[
				'title' => 'Local de Trabalho > Editar',
				'nome' => $ob->nome,
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Local de Trabalho > Editar', $content,'localTrabalho');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setLocalTrabalhoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLocalTrabalho::getLocalTrabalhoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLocalTrabalho){
			$request->getRouter()->redirect('/localTrabalho');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/localTrabalho/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getLocalTrabalhoDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityLocalTrabalho::getLocalTrabalhoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLocalTrabalho){
			$request->getRouter()->redirect('/localTrabalho');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/localTrabalho/delete',[
		        'title' => 'Local de Trabalho > Excluir',
				'nome' => $ob->nome,
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('Local de Trabalho > Excluir', $content,'localTrabalho');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setLocalTrabalhoDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLocalTrabalho::getLocalTrabalhoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLocalTrabalho){
			$request->getRouter()->redirect('/localTrabalho');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/localTrabalho?statusMessage=deleted');
		
		
	}
	
	
}