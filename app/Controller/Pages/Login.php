<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionLogin;

class Login extends Page{
	
	//Método responsável poer retornar a renderizacao da página de login
	public static function getLogin($request){
		//COnteúdo da página de login
		$content = View::render('pages/login',[
		]);
		//Retornar a página completa
		return parent::getPageLogin('Login > Folha de Ponto', $content);
	}
	
	//Método responsavel por definir o login do usuario
	public static function setLogin($request){
		//Post Vars
		$postVars = $request->getPostVars();
		//Recebe o array email. Se não existir retorna vazio
		$email = $postVars['email'] ?? '';
		$senha = $postVars['senha'] ?? '';
		
		//busca usuário pelo e-mail
		$obUser = User::getUserByEmail($email);
	
		
		if(!$obUser instanceof User){
			//return self::getLogin($request);
			$request->getRouter()->redirect('/?statusMessage=errorUser');
			
		}
		
		//Verifica a senha do usuário
		if(!password_verify($senha, $obUser->senha)){
			$request->getRouter()->redirect('/?statusMessage=errorPassword');
		}
		
		//Cria a sessão de Login
		SessionLogin::login($obUser);
		//redireciona o usuario para a home do admin
		$request->getRouter()->redirect('/');
		
	}
	
	//Método responsavel por deslogar o usuario
	public static function setLogout($request){
		//Destroi a sessão de Login
		SessionLogin::logout();
		//redireciona o usuario para a tela de login
		$request->getRouter()->redirect('/');
		
		
	}
	
	
	
	
}