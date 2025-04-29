<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Funcoes;
use \App\Model\Entity\Feriado as EntityFeriado;
use \WilliamCosta\DatabaseManager\Pagination;

class Feriado extends Page{
	
	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getFeriadoItems($request, &$obPagination){

		$itens = '';
		
		//Quantidade total de registros
		$quantidadetotal =  EntityFeriado::getFeriados(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityFeriado::getFeriados(null, 'data',null);
		
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityFeriado::class)) {
							//View de listagem
			$itens.= View::render('pages/feriados/item',[
			         'id' => $ob->id,
			         'data' => date('d/m/Y', strtotime($ob->data)),
					'nome' => $ob->nome,
					'descricao' => $ob->descricao,
					'permissoesDelete'=> Funcoes::permissoesDelete()
					
			]);
		
		}
		
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getFeriados($request){
		
		//Conteúdo da Home
		$content = View::render('pages/feriados/index',[
		    'title' => 'Feriados',
		    'itens' => self::getFeriadoItems($request, $obPagination),
		   // 'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('Feriados', $content,'feriados', self::$hidden);
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getFeriadoNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/feriados/form',[
				'title' => 'Feriados > Novo',
				'data' => '',
				'descricao' => '',

				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Feriados > Novo', $content,'feriados', self::$hidden);
		
	}
	
	
	//Metodo responsávelpor por cadastrar feriado no banco
	public static function setFeriadoNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$data = $postVars['data'];
		$nome = strtoupper($postVars['nome']);
		$descricao = strtoupper($postVars['descricao']);
		
		//busca feriado pelo id sem a maskara
		$ob = EntityFeriado::getFeriadoByData($data);
		//verifica se o feriado já está cadastrado
		if($ob instanceof EntityFeriado){
		    $request->getRouter()->redirect('/feriados/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityFeriado();
		
		$ob->data = $data;
		$ob->nome = $nome;
		$ob->descricao = $descricao;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/feriados?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getFeriadoEdit($request,$id){
		//obtém o usuário do banco de dados
		$ob = EntityFeriado::getFeriadoById($id);
		
		//Valida a instancia
		if(!$ob instanceof EntityFeriado){
			$request->getRouter()->redirect('/feriados');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/feriados/form',[
				'title' => 'Feriados > Editar',
		        $ob->nome == "FERIADO" ? $selectedFeriado = 'selected' : '',
		        $ob->nome == "FACULTADO" ? $selectedFacultado = 'selected' : '',
				'selectedFeriado' => $selectedFeriado,
				'selectedFacultado' => $selectedFacultado,
		          'data' => $ob->data,
		          'descricao' => $ob->descricao,
				
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Feriados > Editar', $content,'feriados');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setFeriadoEdit($request,$id){

		//Post Vars
		$postVars = $request->getPostVars();
		$nome = strtoupper($postVars['nome']);
		$data = $postVars['data'];
		$descricao = strtoupper($postVars['descricao']);

		//obtém o usuário do banco de dados
		$ob = EntityFeriado::getFeriadoById($id);
		
		//Valida a instancia
		if(!$ob instanceof EntityFeriado){
			$request->getRouter()->redirect('/feriados');
		}
		
		//busca feriado pelo id sem a maskara
		$obData = EntityFeriado::getFeriadoByData($data);
		//verifica se o feriado já está cadastrado
		if($obData instanceof EntityFeriado){
		    $request->getRouter()->redirect('/feriados/'.$ob->id.'/edit?statusMessage=duplicated');
		}
		
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->data = $data;
		$ob->descricao = $descricao;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/feriados/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getFeriadoDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityFeriado::getFeriadoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityFeriado){
			$request->getRouter()->redirect('/feriados');
		}
		
		
		
		//Conteúdo do Formulário
		$content = View::render('pages/feriados/delete',[
		        'title' => 'Feriados > Excluir',
				'nome' => $ob->nome,
				'descricao'=>$ob->descricao,
				'data'=>date('d/m/Y', strtotime($ob->data)),
			
				
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Feriados > Excluir', $content,'feriados');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setFeriadoDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityFeriado::getFeriadoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityFeriado){
			$request->getRouter()->redirect('/feriados');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/feriados?statusMessage=deleted');
		
		
	}
	
	
}