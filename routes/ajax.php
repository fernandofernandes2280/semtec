<?php

use \App\Http\Response;
use \App\Controller\Tutorial;
use App\Http\Request;


//ROTA de Listage de Cid10
$obRouter->post('/tutorial/treinesql',[
		
		
		
		function ($request){
			return new Response(200, Tutorial\Ajax::create($request));
		}
		]);

