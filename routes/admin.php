<?php

use \App\Http\Response;
use \App\Controller\Admin;
use \App\Controller\Pages;

//Rota de Home
$obRouter->get('/admin',[
    'middlewares' => [
        'require-admin-login'
   ],
		
    function (){
        return new Response(200, Admin\Home::getHome());
    }
    ]);

    //Rota  GET de Login
$obRouter->get('/login',[
   'middlewares' => [
        'require-admin-logout'
   ],
		
    function ($request){
        return new Response(200, Admin\Login::getLogin($request));
    }
    ]);
    //Rota de POST de Login
$obRouter->post('/login',[
    'middlewares' => [
        'require-admin-logout'
   ],
		
    function ($request){
        return new Response(200, Admin\Login::setLogin($request));
    }
    ]);

   //ROTA Logout
$obRouter->get('/logout',[
    'middlewares' => [
        'require-admin-login'
   ],
		
		function ($request){
			return new Response(200, Admin\Login::setLogout($request));
		}
		]);