<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\Aluno as EntityAluno;
use \WilliamCosta\DatabaseManager\Pagination;

class Aluno extends Page{
	
	
	//Método responsavel por obter a renderização dos itens de usuários para a página
	private static function getAlunoItems($request, &$obPagination){
		//Usuários
		$itens = '';
		
		//Quantidade total de registros
		$quantidadetotal =  EntityAluno::getAlunos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
		
		//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityAluno::getAlunos(null, 'id DESC',$obPagination->getLimit());
		
		//Renderiza o item
		while ($obUser = $results->fetchObject(EntityAluno::class)) {
		
			//View de depoimentos
			$itens.= View::render('admin/modules/alunos/item',[
					'id' => $obUser->id,
					'nome' => $obUser->nome,
					'email' => $obUser->email,
					'instituicao' => $obUser->insituicao,
					'senha' => $obUser->senha,
			]);
		}
		
		
		//Retorna os depoimentos
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem de USuários
	public static function getAlunos($request){
		
		//Conteúdo da Home
		$content = View::render('admin/modules/alunos/index',[
				'itens' => self::getAlunoItems($request, $obPagination),
				'pagination' => parent::getPagination($request, $obPagination),
				'status' => self::getStatus($request)
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Usuários > WDEV', $content,'users');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro de um novo usuário
	public static function getNewAluno($request){
		
		//Conteúdo do Formulário
		$content = View::render('admin/modules/alunos/form',[
				'title' => 'Cadastrar Aluno',
				'nome' => '',
				'email' => '',
				'instituicao' => '',
				'status' => self::getStatus($request)
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Cadastrar Usuário > WDEV', $content,'users');
		
	}
	
	
	//Metodo responsávelpor por cadastrar um usuário no banco
	public static function setNewUser($request){
		//Post vars
		$postVars = $request->getPostVars();
		
		$nome = $postVars['nome'] ?? '';
		$email = $postVars['email'] ?? '';
		$senha = $postVars['senha'] ?? '';
		
		//Valida o email do usuário
		$obUser = EntityUser::getUserByEmail($email);
		
		if($obUser instanceof EntityUser){
			$request->getRouter()->redirect('/admin/users/new?status=duplicated');
		}
		
				
		//Nova instancia de Usuário
		$obUser = new EntityUser;
		$obUser->nome = $nome;
		$obUser->email = $email;
		$obUser->senha = password_hash($senha,PASSWORD_DEFAULT);
		$obUser->cadastrar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=created');
		
	}
	
	//Método responsavel por retornar a mensagem de status
	private static function getStatus($request){
		//Query PArams
		$queryParams = $request->getQueryParams();
		
		//Status
		if(!isset($queryParams['status'])) return '';
		
		//Mensagens de status
		switch ($queryParams['status']) {
			case 'created':
				return Alert::getSuccess('Usuário criado com sucesso!');
			break;
			case 'updated':
				return Alert::getSuccess('Usuário atualizado com sucesso!');
				break;
			case 'deleted':
				return Alert::getSuccess('Usuário excluído com sucesso!');
				break;
			case 'duplicated':
				return Alert::getError('O e-mail digitado já está sendo utilizado por outro usuário!');
				break;
		}
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição de um Usuário
	public static function getEditUser($request,$id){
		//obtém o usuário do banco de dados
		$obUser = EntityUser::getUserById($id);
		
		//Valida a instancia
		if(!$obUser instanceof EntityUser){
			$request->getRouter()->redirect('/admin/users');
		}
		
	
		
		//Conteúdo do Formulário
		$content = View::render('admin/modules/users/form',[
				'title' => 'Editar usuário',
				'nome' => $obUser->nome,
				'email' => $obUser->email,
				'status' => self::getStatus($request)
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Editar Usuário > WDEV', $content,'users');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um usuário
	public static function setEditUser($request,$id){
		//obtém o usuário do banco de dados
		$obUser = EntityUser::getUserById($id);
		
		//Valida a instancia
		if(!$obUser instanceof EntityUser){
			$request->getRouter()->redirect('/admin/users');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		$email = $postVars['email'] ?? '';
		$senha = $postVars['senha'] ?? '';
		
		//Valida o email do usuário
		$obUserEmail = EntityUser::getUserByEmail($email);
		
		if($obUserEmail instanceof EntityUser && $obUserEmail->id != $id){
			$request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
		}
		
		
		
		//Atualiza a instância
		$obUser->nome = $nome;
		$obUser->email = $email;
		$obUser->senha = password_hash($senha,PASSWORD_DEFAULT);
		$obUser->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão de um usuário
	public static function getDeleteUser($request,$id){
		//obtém o usuário do banco de dados
		$obUser = EntityUser::getUserById($id);
		
		//Valida a instancia
		if(!$obUser instanceof EntityUser){
			$request->getRouter()->redirect('/admin/users');
		}
		
		
		
		//Conteúdo do Formulário
		$content = View::render('admin/modules/users/delete',[
				'nome' => $obUser->nome,
				'email' => $obUser->email
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Excluir Usuário > WDEV', $content,'users');
		
	}
	
	//Metodo responsável por Excluir um usuário
	public static function setDeleteUser($request,$id){
		//obtém o usuário do banco de dados
		$obUser = EntityUser::getUserById($id);
		
		//Valida a instancia
		if(!$obUser instanceof EntityUser){
			$request->getRouter()->redirect('/admin/users');
		}
		
			
		//Exclui o usuário
		$obUser->excluir();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/admin/users?status=deleted');
		
		
	}
	
	
}