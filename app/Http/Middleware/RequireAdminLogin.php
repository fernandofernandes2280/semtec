<?php

namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;


class RequireAdminLogin{
	
	//Método responsavel por executar o middleware
	public function handle($request, $next){
		
		
		//Verifica se o usuario está logado
		if(!SessionAdminLogin::isLogged()){
			$request->getRouter()->redirect('/login');
		}
		
		
		//Continua a execução
		return $next($request);
		
		
	}
	
}