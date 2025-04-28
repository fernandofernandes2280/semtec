<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Utils\Funcoes;


class Page{

	//Módulos disponíveis no painel de Cadastro
	private static $modulesAdmin = [
		'usuarios' =>[
					'label' => 'Usuários',
					'link' => URL.'/user'
		],
		'servidores' =>[
				'label' => 'Servidores',
				'link' => URL.'/servidores'
		],
		
		'feriados' =>[
				'label' => 'Feriados',
				'link' => URL.'/feriados'
		],
	    'lotacao' =>[
	        'label' => 'Lotação',
	        'link' => URL.'/lotacao'
	    ],
	    'localTrabalho' =>[
	        'label' => 'Local de Trabalho',
	        'link' => URL.'/localTrabalho'
	    ],
	    'vinculo' =>[
	        'label' => 'Vínculo',
	        'link' => URL.'/vinculo'
	    
	    ],
	    'cargoFuncao' =>[
	        'label' => 'Cargo / Função',
	        'link' => URL.'/cargoFuncao'
	    ],
			
	];
	//Módulos disponíveis no painel de Cadastro
	private static $modulesGestor = [
		
		'servidores' =>[
				'label' => 'Servidores',
				'link' => URL.'/servidores'
		],
		
		'feriados' =>[
				'label' => 'Feriados',
				'link' => URL.'/feriados'
		],
	    'lotacao' =>[
	        'label' => 'Lotação',
	        'link' => URL.'/lotacao'
	    ],
	    'localTrabalho' =>[
	        'label' => 'Local de Trabalho',
	        'link' => URL.'/localTrabalho'
	    ],
	    'vinculo' =>[
	        'label' => 'Vínculo',
	        'link' => URL.'/vinculo'
	    
	    ],
	    'cargoFuncao' =>[
	        'label' => 'Cargo / Função',
	        'link' => URL.'/cargoFuncao'
	    ],
			
	];
	//Módulos disponíveis no painel de Folha de Ponto
	private static $modulesPonto = [
		'porServidor' =>[
				'label' => 'Por Servidor',
				'link' => URL.'/ponto/porServidor'
		],
		'porLotacao' =>[
				'label' => 'Por Lotação',
				'link' => URL.'/ponto/porLotacao'
		],
		'porLocalTrabalho' =>[
				'label' => 'Por Local de Trabalho',
				'link' => URL.'/ponto/porLocalTrabalho'
		],
		'porVinculo' =>[
				'label' => 'Por Vínculo',
				'link' => URL.'/ponto/porVinculo'
		],
		'porCargoFuncao' =>[
				'label' => 'Por Cargo/Função',
				'link' => URL.'/ponto/porCargoFuncao'
		],
		'todos' =>[
				'label' => 'Todos',
				'link' => URL.'/ponto/todos'
		],
			
	];
	
	//Método responsavel por retornar o conteudo (view) da estrutura generica de página do painel
	public static function getPage($title, $content, $menuCadastro, $menuPonto){
		
		//print_r($_SESSION['user']['tipo']->nome);exit;
		return View::render('pages/page',[
				'menuCadastro' => $menuCadastro,
				'menuPonto' => $menuPonto,
				'title' => $title,
				'content' => $content,
				'user' => $_SESSION['usuario']['nome'].' ('.$_SESSION['usuario']['tipo'].')',
				'UrlUser' => 'perfil/'.$_SESSION['usuario']['id'],

				

		]);
	}

		//Método responsavel por retornar o conteudo (view) da estrutura generica de página do painel de Login
		public static function getPageLogin($title, $content){
			return View::render('pages/pageLogin',[
					'title' => $title,
					'content' => $content
			]);
		}
	
	//Método responsável por renderizar a view do menu de Cadastro do painel ADMIN
	private static function getMenuCadastroAdmin($currentModule){
		//Links do Menu de Cadastro
		$linksCadastro ='';
		//Itera os módulos
		foreach (self::$modulesAdmin as $hash=>$module){
			$linksCadastro .= View::render('pages/menu/link',[
					'label' => $module['label'],
					'link' => $module['link'],
					'current' => $hash == $currentModule ? 'text-danger' : ''
			]);
		}
		//Retorna a renderização do menu de Cadastro
		return View::render('pages/menu/boxCadastro',[
				//menu de cadastro
				'linksCadastro' => $linksCadastro,
		]);
	}
	//Método responsável por renderizar a view do menu de Cadastro do painel do GESTOR
	private static function getMenuCadastroGestor($currentModule){
		//Links do Menu de Cadastro
		$linksCadastro ='';
		//Itera os módulos
		foreach (self::$modulesGestor as $hash=>$module){
			$linksCadastro .= View::render('pages/menu/link',[
					'label' => $module['label'],
					'link' => $module['link'],
					'current' => $hash == $currentModule ? 'text-danger' : ''
			]);
		}
		//Retorna a renderização do menu de Cadastro
		return View::render('pages/menu/boxCadastro',[
				//menu de cadastro
				'linksCadastro' => $linksCadastro,
		]);
	}

	//Método responsável por renderizar a view do menu de Folha de Ponto do painel
	private static function getMenuPonto($currentModule){
		//Links do Menu de Folha de Ponto
		$linksPonto ='';
		//Itera os módulos
		foreach (self::$modulesPonto as $hash=>$module){
			$linksPonto .= View::render('pages/menu/link',[
					'label' => $module['label'],
					'link' => $module['link'],
					'current' => $hash == $currentModule ? 'text-danger' : ''
			]);
		}
		//Retorna a renderização do menu de Folha de Ponto
		return View::render('pages/menu/boxPonto',[
				//menu de Folha de Ponto
				'linksPonto' => $linksPonto
		]);
	}
	
	
	//Método resposanvel por renderizar a view do painel com conteúdos dinâmicos
	public static function getPanel($title, $content, $currentModule){
		
		//Renderiza a view do painel
		$contentPanel = View::render('pages/panel',[
				//'menu' => self::getMenu($currentModule),
				
				'content' => $content
		]);

		//Rendereiza menus de Cadastro
		if($_SESSION['usuario']['tipo'] == 'ADMIN'){
			$menuCadastro = self::getMenuCadastroAdmin($currentModule); 
		}else{
			$menuCadastro = self::getMenuCadastroGestor($currentModule);
		}
		
		//Rendereiza menus de Folha de Ponto
		$menuPonto = self::getMenuPonto($currentModule);
		//Retorna a página renderizada
		return self::getPage($title, $contentPanel, $menuCadastro, $menuPonto);
		
	}
	
	//Método responsvel por renderizar o layout de paginação
	public static function getPagination($request,$obPagination){
		//Páginas
		$pages = $obPagination->getPages();
		
		//Verifica a quantidade de páginas
		if(count($pages) <=1) return '';
		
		//Links
		$links = '';
		
		//url atual (sem gets)
		$url = $request->getRouter()->getCurrentUrl();
		
		//GET
		$queryParams = $request->getQueryParams();
		
		//Renderiza os Links
		foreach ($pages as $page){
			
			//Altera a página
			$queryParams['page'] = $page['page'];
			
			//Link
			$link = $url.'?'.http_build_query($queryParams);
			
			//view
			$links .= View::render('admin/pagination/link',[
					'page' => $page['page'],
					'link' => $link,
					'active' => $page['current'] ? 'active' : ''
			]);
		}
		
		//Renderiza box de paginação
		return View::render('admin/pagination/box',[
				'links' => $links
				
		]);
		
		
		
		
	}
	
	
}