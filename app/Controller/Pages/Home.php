<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page{
	
	//retorna o conteudo (view) da nossa home
	public static function getHome(){
	    
	    //View da Home
	    $content = View::render('pages/home',[
	        
	        
	    ]);
	    
	    //Retorna a página completa
	    return parent::getPanel('Folha de Ponto > Home', $content,'home', '');
		
	}
	
}