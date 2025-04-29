<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\CargoFuncao as EntityCargoFuncao;
use App\Utils\Funcoes;
use \WilliamCosta\DatabaseManager\Pagination;

class CargoFuncao extends Page{
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
    private static function getCargoFuncaoItems($request, &$obPagination){

		$itens = '';
		
		//Quantidade total de registros
		$quantidadetotal =  EntityCargoFuncao::getCargosFuncao(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityCargoFuncao::getCargosFuncao(null, 'nome',null);
		
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityCargoFuncao::class)) {
							//View de listagem
			$itens.= View::render('pages/cargoFuncao/item',[
			         'id' => $ob->id,
					'nome' => $ob->nome,
					'permissoesDelete'=> Funcoes::permissoesDelete()
					
			]);
		
		}
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem CargoFuncao
	public static function getCargoFuncao($request){
		
		//Conteúdo da Home
		$content = View::render('pages/cargoFuncao/index',[
		    'title' => 'Cargo / Função',
		    'itens' => self::getCargoFuncaoItems($request, $obPagination),
		    //'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Cargo / Função', $content,'cargoFuncao');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro CargoFuncao
	public static function getCargoFuncaoNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/cargoFuncao/form',[
				'title' => 'Cargo / Função > Novo',
				'nome' => '',
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Cargo / Função > Novo', $content,'cargoFuncao');
		
	}
	
	
	//Metodo responsávelpor por cadastrar CargoFuncao no banco
	public static function setCargoFuncaoNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$nome = strtolower($postVars['nome']);
		
		//verifica se a Lotacao já está cadastrada
		$ob = EntityCargoFuncao::getCargoFuncaoByNome($nome);
		if($ob instanceof EntityCargoFuncao){
		    $request->getRouter()->redirect('/cargoFuncao/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityCargoFuncao();
		
		$ob->nome = $nome;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/cargoFuncao?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição CargoFuncao
	public static function getCargoFuncaoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityCargoFuncao::getCargoFuncaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityCargoFuncao){
			$request->getRouter()->redirect('/cargoFuncao');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/cargoFuncao/form',[
				'title' => 'Cargo / Função > Editar',
				'nome' => $ob->nome,
				
		]);
		
		//Retorna a página completa
		return parent::getPanel(' SEMTEC > Cargo / Função > Editar', $content,'cargoFuncao');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um CargoFuncao
	public static function setCargoFuncaoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityCargoFuncao::getCargoFuncaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityCargoFuncao){
			$request->getRouter()->redirect('/cargoFuncao');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/cargoFuncao/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão CargoFuncao
	public static function getCargoFuncaoDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityCargoFuncao::getCargoFuncaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityCargoFuncao){
			$request->getRouter()->redirect('/cargoFuncao');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/cargoFuncao/delete',[
		        'title' => 'Cargo / Função > Excluir',
				'nome' => $ob->nome,
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Cargo / Função > Excluir', $content,'cargoFuncao');
		
	}
	
	//Metodo responsável por Excluir CargoFuncao
	public static function setCargoFuncaoDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityCargoFuncao::getCargoFuncaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityCargoFuncao){
			$request->getRouter()->redirect('/vinculo');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/cargoFuncao?statusMessage=deleted');
		
		
	}
	
	
}