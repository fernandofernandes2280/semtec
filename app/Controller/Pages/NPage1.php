<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page1{
	
	
	//metodo responsavel por renderizar o topo da pagina
	private static function getHeader(){
		
		return View::render('pages/header');
		
	}
	
	//metodo responsavel por renderizar o topo da pagina
	private static function getFooter(){
		
		return View::render('pages/footer');
		
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
			$links .= View::render('pages/pagination/link',[
					'page' => $page['page'],
					'link' => $link,
					'active' => $page['current'] ? 'active' : ''
			]);
		}
		
		//Renderiza box de paginação
		return View::render('pages/pagination/box',[
				'links' => $links
				
		]);
		
		
		
		
	}
	
	
	
	//retorna o conteudo (view) da nossa página genérica
	public static function getPage($title, $content){
		
		return View::render('pages/page',[
				'title' => $title,
				'header' => self::getHeader(),
				'content' => $content,
				'footer' => self::getFooter()
				
		]);
		
	}
	
}