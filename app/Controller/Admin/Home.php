<?php

namespace App\Controller\Admin;

use \App\Utils\View;


class Home extends Page{
	
	//retorna o conteudo (view) da nossa home de Admin
	public static function getHome(){
			
		//View da Home
		$content = View::render('pages/home',[
			
			
		]);
		
		//Retorna a página completa
		return parent::getPanel('Folha de Ponto', $content,'home', '');
		
	}

	
	
	
}