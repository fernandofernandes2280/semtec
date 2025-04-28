<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA Login
$obRouter->get('/admin/login',[
		'middlewares' => [
				'require-admin-logout'
		],
		
		
		function ($request){
			return new Response(200, Admin\Login::getLogin($request));
		}
		]);


//ROTA Login POst
$obRouter->post('/admin/login',[
		'middlewares' => [
				'require-admin-logout'
		],
		
		function ($request){
			
			return new Response(200, Admin\Login::setLogin($request));
		}
		]);

//ROTA Logout
$obRouter->get('/admin/logout',[
		'middlewares' => [
				'require-admin-login'
		],
		
		function ($request){
			return new Response(200, Admin\Login::setLogout($request));
		}
		]);
