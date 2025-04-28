<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Funcoes;
use \App\Model\Entity\User as EntityUser;
use \App\Model\Entity\UserTipo as EntityUserTipo;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page{
	
	

	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getUserItems($request, &$obPagination){

		$itens = '';
		
		//Quantidade total de registros
		$quantidadetotal =  EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityUser::getUsers(null, 'nome',$obPagination->getLimit());
		Funcoes::init();
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityUser::class)) {
							//View de listagem
			$itens.= View::render('pages/user/item',[
			         'id' => $ob->id,
					'nome' => $ob->nome,
					'email' => $ob->email,
					//'senha' => $ob->senha,
					'tipo' => EntityUserTipo::getTipoUserById($ob->tipo)->nome
					
			]);
		
		}
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getUser($request){
		
		//Conteúdo da Home
		$content = View::render('pages/user/index',[
		    'title' => 'Usuários',
		    'itens' => self::getUserItems($request, $obPagination),
		    'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('User', $content,'user');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getUserNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/user/form',[
				'title' => 'Usuários > Novo',
				'nome' => '',
				'email' => '',
				'senha' => '',
				'optionTipoUser' => EntityUserTipo::getSelectTipoUser(null),
					
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('User > Novo', $content,'user');
		
	}
	
	
	//Metodo responsávelpor por cadastrar feriado no banco
	public static function setUserNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$nome = strtoupper($postVars['nome']);
		$email = strtoupper($postVars['email']);
		$senha = password_hash($postVars['senha'], PASSWORD_DEFAULT);
		$tipo = $postVars['tipo'];
		//verifica se a Lotacao já está cadastrada
		$ob = EntityUser::getUserByNome($nome);
		if($ob instanceof EntityUser){
		    $request->getRouter()->redirect('/user/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityUser();
		
		$ob->nome = $nome;
		$ob->email = $email;
		$ob->senha = $senha;
		$ob->tipo = $tipo;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/user?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getUserEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityUser::getUserById($id);
		
		if($_SESSION['usuario']['tipo'] != 'ADMIN'){
			$readOnly = 'style="background: #eee; pointer-events: none; touch-action: none;';
			$title = 'Atualizar Dados';
			$requerido = 'required';
		}else{
			$readOnly = '';
			$title = 'Usuários > Editar';
			$requerido = '';
		}

		//Valida a instancia
	    if(!$ob instanceof EntityUser){
			$request->getRouter()->redirect('/user');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/user/form',[
				'title' => $title,
				'nome' => $ob->nome,
				'email' => $ob->email,
				'senha' => '',
				'readOnly' => $readOnly,
				'optionTipoUser' => EntityUserTipo::getSelectTipoUser($ob->tipo),
				'requerido' => $requerido
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('User > Editar', $content,'user');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setUserEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityUser::getUserById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityUser){
			$request->getRouter()->redirect('/user');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = strtoupper($postVars['nome']) ?? '';
		$email = strtoupper($postVars['email']);
		if(!empty($postVars['senha'])){
			$senha = password_hash($postVars['senha'], PASSWORD_DEFAULT);
			$ob->senha = $senha;
		}
		$tipo = $postVars['tipo'];
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->email = $email;
		
		$ob->tipo = $tipo;
		$ob->atualizar();
		$_SESSION['usuario']['nome'] = $ob->nome;
		//Redireciona o usuário
		$request->getRouter()->redirect('/user/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getUserDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityUser::getUserById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityUser){
			$request->getRouter()->redirect('/user');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/user/delete',[
		        'title' => 'User > Excluir',
				'nome' => $ob->nome,
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('User > Excluir', $content,'user');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setUserDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityUser::getUserById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityUser){
			$request->getRouter()->redirect('/user');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/user?statusMessage=deleted');
		
		
	}
	
	
}