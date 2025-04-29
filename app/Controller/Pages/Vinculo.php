<?php

namespace App\Controller\Pages;


use \App\Utils\View;
use \App\Utils\Funcoes;
use \App\Model\Entity\Vinculo as EntityVinculo;
use \WilliamCosta\DatabaseManager\Pagination;

class Vinculo extends Page{
	
	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getVinculoItems($request, &$obPagination){

		$itens = '';
		
		//Quantidade total de registros
		$quantidadetotal =  EntityVinculo::getVinculos(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityVinculo::getVinculos(null, 'nome',null);
		
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityVinculo::class)) {
							//View de listagem
			$itens.= View::render('pages/vinculo/item',[
			         'id' => $ob->id,
					'nome' => $ob->nome,
					'permissoesDelete'=> Funcoes::permissoesDelete()
					
			]);
		
		}
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getVinculo($request){
		
		//Conteúdo da Home
		$content = View::render('pages/vinculo/index',[
		    'title' => 'Vínculo',
		    'itens' => self::getVinculoItems($request, $obPagination),
		   // 'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('Vínculo', $content,'vinculo');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getVinculoNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/vinculo/form',[
				'title' => 'Novo',
				'nome' => '',
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Vínculo > Novo', $content,'vinculo');
		
	}
	
	
	//Metodo responsávelpor por cadastrar feriado no banco
	public static function setVinculoNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$nome = strtolower($postVars['nome']);
		
		//verifica se a Lotacao já está cadastrada
		$ob = EntityVinculo::getVinculoByNome($nome);
		if($ob instanceof EntityVinculo){
		    $request->getRouter()->redirect('/vinculo/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityVinculo();
		
		$ob->nome = $nome;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/vinculo?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getVinculoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityVinculo::getVinculoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityVinculo){
			$request->getRouter()->redirect('/vinculo');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/vinculo/form',[
				'title' => 'Vínculo > Editar',
				'nome' => $ob->nome,
				
		]);
		
		//Retorna a página completa
		return parent::getPanel(' Vínculo > Editar', $content,'vinculo');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setVinculoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityVinculo::getVinculoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityVinculo){
			$request->getRouter()->redirect('/vinculo');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/vinculo/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getVinculoDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityVinculo::getVinculoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityVinculo){
			$request->getRouter()->redirect('/vinculo');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/vinculo/delete',[
		        'title' => 'Vínculo > Excluir',
				'nome' => $ob->nome,
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('Vínculo > Excluir', $content,'vinculo');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setVinculoDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityVinculo::getVinculoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityVinculo){
			$request->getRouter()->redirect('/vinculo');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/vinculo?statusMessage=deleted');
		
		
	}
	
	
}