<?php

use \App\Http\Response;
use \App\Controller\Admin;


//ROTA de Listage de Usuários
$obRouter->get('/admin/users',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request){
			return new Response(200, Admin\User::getUsers($request));
		}
		]);


//ROTA de Cadastro de um Novo de Usuário
$obRouter->get('/admin/users/new',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request){
			return new Response(200, Admin\User::getNewUser($request));
		}
		]);

//ROTA de Cadastro de um Novo de Usuário (POST)
$obRouter->post('/admin/users/new',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request){
			return new Response(200, Admin\User::setNewUser($request));
		}
		]);

//ROTA de Edição de um de Usuário
$obRouter->get('/admin/users/{id}/edit',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request,$id){
			return new Response(200, Admin\User::getEditUser($request,$id));
		}
		]);

//ROTA de Edição de um de Usuário (POST)
$obRouter->post('/admin/users/{id}/edit',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request,$id){
			return new Response(200, Admin\User::setEditUser($request,$id));
		}
		]);

//ROTA de Exclusão de um de Usuário
$obRouter->get('/admin/users/{id}/delete',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request,$id){
			return new Response(200, Admin\User::getDeleteUser($request,$id));
		}
		]);
//ROTA de Exclusão de um de Usuário (POST)
$obRouter->post('/admin/users/{id}/delete',[
		'middlewares' => [
				'require-admin-login'
		],
		
		
		function ($request,$id){
			return new Response(200, Admin\User::setDeleteUser($request,$id));
		}
		]);

