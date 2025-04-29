<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Lotacao as EntityLotacao;
use App\Utils\Funcoes;
use \WilliamCosta\DatabaseManager\Pagination;

class Lotacao extends Page{
	
	//esconde busca rápida de prontuário no navBar
	private static $hidden = 'hidden';
	
	//Método responsavel por obter a renderização da listagem dos registros do banco
	private static function getLotacaoItems($request, &$obPagination){

		$itens = '';

		
		//Quantidade total de registros
		$quantidadetotal =  EntityLotacao::getLotacao(Funcoes::condicao(), null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
				//Página atual
		$queryParams = $request->getQueryParams();
		$paginaAtual = $queryParams['page'] ?? 1;
		//Instancia de paginacao
		$obPagination = new Pagination($quantidadetotal,$paginaAtual,5);
		
		//Resultados da Página
		$results = EntityLotacao::getLotacao(Funcoes::condicao(), 'nome',null);
		
		//Renderiza o item
		while ($ob = $results->fetchObject(EntityLotacao::class)) {
							//View de listagem
			$itens.= View::render('pages/lotacao/item',[
			         'id' => $ob->id,
					'nome' => $ob->nome,
					'permissoesDelete'=> Funcoes::permissoesDelete()
			]);
		
		}
		//Retorna a listagem
		return $itens;
		
	}
	
	
	//Método responsavel por renderizar a view de Listagem
	public static function getLotacao($request){
		
		//Conteúdo da Home
		$content = View::render('pages/lotacao/index',[
		    'title' => 'Lotação',
		    'itens' => self::getLotacaoItems($request, $obPagination),
		    //'pagination' => parent::getPagination($request, $obPagination),
		       

		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Lotação', $content,'lotacao');
		
	}
	
	//Metodo responsávelpor retornar o formulário de cadastro 
	public static function getLotacaoNew($request){
		
		//Conteúdo do Formulário
		$content = View::render('pages/lotacao/form',[
				'title' => 'Lotação > Novo',
				'nome' => '',
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('SEMTEC > Lotação > Novo', $content,'lotacao');
		
	}
	
	
	//Metodo responsávelpor por cadastrar feriado no banco
	public static function setLotacaoNew($request){
		//Post vars
		$postVars = $request->getPostVars();
		$nome = strtoupper($postVars['nome']);
		$gestor = $_SESSION['usuario']['id'];
		//verifica se a Lotacao já está cadastrada
		$ob = EntityLotacao::getLotacaoByNome($nome);
		if($ob instanceof EntityLotacao){
		    $request->getRouter()->redirect('/lotacao/new?statusMessage=duplicated');
		}
		
		
		//Nova instancia
		$ob = new EntityLotacao();
		
		$ob->nome = $nome;
		$ob->gestor = $gestor;
		
		$ob->cadastrar();
		
		//Redireciona o usuário com mensagem de sucesso
		$request->getRouter()->redirect('/lotacao?statusMessage=created');
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Edição 
	public static function getLotacaoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLotacao::getLotacaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLotacao){
			$request->getRouter()->redirect('/lotacao');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/lotacao/form',[
				'title' => 'Lotação > Editar',
				'nome' => $ob->nome,
				
		]);
		
		//Retorna a página completa
		return parent::getPanel('Lotação > Editar', $content,'lotacao');
		
	}
	
	//Metodo responsável por gravar a atualizacao de um Feriado
	public static function setLotacaoEdit($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLotacao::getLotacaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLotacao){
			$request->getRouter()->redirect('/lotacao');
		}
		
		
		//Post Vars
		$postVars = $request->getPostVars();
		$nome = $postVars['nome'] ?? '';
		//Atualiza a instância
		$ob->nome = $nome;
		$ob->atualizar();
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/lotacao/'.$ob->id.'/edit?statusMessage=updated');
		
		
	}
	
	
	//Metodo responsávelpor retornar o formulário de Exclusão 
	public static function getLotacaoDelete($request,$id){
		//obtém o registro do banco de dados
	    $ob = EntityLotacao::getLotacaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLotacao){
			$request->getRouter()->redirect('/lotacao');
		}
		
		//Conteúdo do Formulário
		$content = View::render('pages/lotacao/delete',[
		        'title' => 'Lotação > Excluir',
				'nome' => $ob->nome,
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('Lotação > Excluir', $content,'lotacao');
		
	}
	
	//Metodo responsável por Excluir 
	public static function setLotacaoDelete($request,$id){
		//obtém o usuário do banco de dados
	    $ob = EntityLotacao::getLotacaoById($id);
		
		//Valida a instancia
	    if(!$ob instanceof EntityLotacao){
			$request->getRouter()->redirect('/lotacao');
		}
		
		//Exclui 
		$ob->excluir($id);
		
		//Redireciona o usuário
		$request->getRouter()->redirect('/lotacao?statusMessage=deleted');
		
		
	}
	
	
}