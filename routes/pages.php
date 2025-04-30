<?php


use \App\Http\Response;
use \App\Controller\Pages;

//ROTA Login
$obRouter->get('/login',[
    'middlewares' => [
            'require-admin-logout'
    ],
    
    
    function ($request){
        return new Response(200, Pages\Login::getLogin($request));
    }
    ]);


//ROTA Login POst
$obRouter->post('/login',[
    'middlewares' => [
            'require-admin-logout'
    ],
    
    function ($request){
        
        return new Response(200, Pages\Login::setLogin($request));
    }
    ]);

//ROTA Logout
$obRouter->get('/logout',[
    'middlewares' => [
            'require-admin-login'
    ],
    
    function ($request){
        return new Response(200, Pages\Login::setLogout($request));
    }
    ]);




//ROTA HOME
$obRouter->get('',[
    'middlewares' => [
        'require-admin-login'
   ],
		
		function (){
			return new Response(200, Pages\Home::getHome());
		}
		]);

  

//ROTAS DE FOLHA DE PONTO INICIO

//Rota de Ponto
$obRouter->get('/ponto',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPonto());
    }
    ]);


//Rota GET de Ponto por Servidor
$obRouter->get('/ponto/porServidor',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPontoPorServidor());
    }
    ]);

//Rota POST de Ponto por Servidor
$obRouter->post('/ponto/porServidor',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//Rota GET de Ponto por Cargo Funcao
$obRouter->get('/ponto/porCargoFuncao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPontoPorCargoFuncao());
    }
    ]);

//Rota POST de Ponto por Cargo Funcao
$obRouter->post('/ponto/porCargoFuncao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//Rota GET de Ponto por Lotacao
$obRouter->get('/ponto/porLotacao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPontoPorLotacao());
    }
    ]);

//Rota POST de Ponto por Lotacao
$obRouter->post('/ponto/porLotacao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//Rota GET de Ponto por porLocalTrabalho
$obRouter->get('/ponto/porLocalTrabalho',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPontoPorLocalTrabalho());
    }
    ]);

//Rota POST de Ponto por porLocalTrabalho
$obRouter->post('/ponto/porLocalTrabalho',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//Rota GET de Ponto por porVinculo
$obRouter->get('/ponto/porVinculo',[
    'middlewares' => [
        'require-admin-login'
   ],
    function (){
        return new Response(200, Pages\Ponto::getPontoPorVinculo());
    }
    ]);

//Rota POST de Ponto por porVinculo
$obRouter->post('/ponto/porVinculo',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//Rota POST de Ponto de Todos os Funcionarios
$obRouter->get('/ponto/todos',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Ponto::setPonto($request));
    }
    ]);

//ROTAS DE FOLHA DE PONTO FIM






//ROTAS DE FERIADOS INÍCIO

//Rota de Feriados
$obRouter->get('/feriados',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Feriado::getFeriados($request));
    }
    ]);
//Rota de Novo Feriado
$obRouter->get('/feriados/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Feriado::getFeriadoNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo Feriado(POST)
$obRouter->post('/feriados/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Feriado::setFeriadoNew($request));
    }
    ]);

//ROTA de Edição de um de Feriado
$obRouter->get('/feriados/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Feriado::getFeriadoEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de Disciplina (POST)
$obRouter->post('/feriados/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Feriado::setFeriadoEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de Feriado
$obRouter->get('/feriados/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Feriado::getFeriadoDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de Feriado
$obRouter->post('/feriados/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Feriado::setFeriadoDelete($request,$id));
    }
    ]);

//ROTAS DE FERIADOS FIM


//ROTAS DE SERVIDORES INÍCIO

//Rota de Feriados
$obRouter->get('/servidores',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Servidor::getServidores($request));
    }
    ]);

//Rota de Novo Servidor
$obRouter->get('/servidores/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Servidor::getServidorNew($request));
    }
    ]);

//Rota validacao de CPF Get
$obRouter->get('/servidores/new/validaCpf',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Servidor::getValidaCPF($request));
    }
    ]);

//Rota validacao de CPF Post
$obRouter->post('/servidores/new/validaCpf',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Servidor::setValidaCPF($request));
    }
    ]);

//ROTA de Cadastro de um Novo Servidor(POST)
$obRouter->post('/servidores/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Servidor::setServidorNew($request));
    }
    ]);

//ROTA de Edição de um de Servidor
$obRouter->get('/servidores/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Servidor::getServidorEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de servidores (POST)
$obRouter->post('/servidores/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Servidor::setServidorEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de Feriado
$obRouter->get('/servidores/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Servidor::getServidorDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de Feriado
$obRouter->post('/servidores/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Servidor::setServidorDelete($request,$id));
    }
    ]);

//ROTAS DE SERVIDORES FIM


//ROTAS DE LOTACAO INÍCIO

//Rota de lotacao
$obRouter->get('/lotacao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Lotacao::getLotacao($request));
    }
    ]);
//Rota de Novo lotacao
$obRouter->get('/lotacao/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Lotacao::getLotacaoNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo lotacao(POST)
$obRouter->post('/lotacao/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Lotacao::setLotacaoNew($request));
    }
    ]);

//ROTA de Edição de um de lotacao
$obRouter->get('/lotacao/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Lotacao::getLotacaoEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de lotacao (POST)
$obRouter->post('/lotacao/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Lotacao::setLotacaoEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de lotacao
$obRouter->get('/lotacao/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Lotacao::getLotacaoDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de lotacao
$obRouter->post('/lotacao/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Lotacao::setLotacaoDelete($request,$id));
    }
    ]);

//ROTAS DE lotacao FIM


//ROTAS DE CARGO FUNÇAO INÍCIO

//Rota de cargoFuncao
$obRouter->get('/cargoFuncao',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\CargoFuncao::getCargoFuncao($request));
    }
    ]);
//Rota de Novo cargoFuncao
$obRouter->get('/cargoFuncao/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\CargoFuncao::getCargoFuncaoNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo cargoFuncao(POST)
$obRouter->post('/cargoFuncao/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\CargoFuncao::setCargoFuncaoNew($request));
    }
    ]);

//ROTA de Edição de um de cargoFuncao
$obRouter->get('/cargoFuncao/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\CargoFuncao::getCargoFuncaoEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de cargoFuncao (POST)
$obRouter->post('/cargoFuncao/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\CargoFuncao::setCargoFuncaoEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de cargoFuncao
$obRouter->get('/cargoFuncao/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\CargoFuncao::getCargoFuncaoDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de cargoFuncao
$obRouter->post('/cargoFuncao/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\CargoFuncao::setCargoFuncaoDelete($request,$id));
    }
    ]);

//ROTAS DE cargoFuncao FIM


//ROTAS DE LOCAL DE TRABALHO INÍCIO

//Rota de lotacao
$obRouter->get('/localTrabalho',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\LocalTrabalho::getLocalTrabalho($request));
    }
    ]);
//Rota de Novo LOCAL DE TRABALHO
$obRouter->get('/localTrabalho/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\LocalTrabalho::getLocalTrabalhoNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo LOCAL DE TRABALHO(POST)
$obRouter->post('/localTrabalho/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\LocalTrabalho::setLocalTrabalhoNew($request));
    }
    ]);

//ROTA de Edição de um de LOCAL DE TRABALHO
$obRouter->get('/localTrabalho/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\LocalTrabalho::getLocalTrabalhoEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de LOCAL DE TRABALHO (POST)
$obRouter->post('/localTrabalho/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\LocalTrabalho::setLocalTrabalhoEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de LOCAL DE TRABALHO
$obRouter->get('/localTrabalho/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\LocalTrabalho::getLocalTrabalhoDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de LOCAL DE TRABALHO
$obRouter->post('/localTrabalho/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\LocalTrabalho::setLocalTrabalhoDelete($request,$id));
    }
    ]);

//ROTAS DE LOCAL DE TRABALHO FIM


//ROTAS DE VÍNCULO INÍCIO

//Rota de lotacao
$obRouter->get('/vinculo',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Vinculo::getVinculo($request));
    }
    ]);
//Rota de Novo VÍNCULO
$obRouter->get('/vinculo/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Vinculo::getVinculoNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo VÍNCULO(POST)
$obRouter->post('/vinculo/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\Vinculo::setVinculoNew($request));
    }
    ]);

//ROTA de Edição de um de VÍNCULO
$obRouter->get('/vinculo/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Vinculo::getVinculoEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de VÍNCULO (POST)
$obRouter->post('/vinculo/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Vinculo::setVinculoEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de VÍNCULO
$obRouter->get('/vinculo/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\Vinculo::getVinculoDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de VÍNCULO
$obRouter->post('/vinculo/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ],
    
    function ($request,$id){
        return new Response(200, Pages\Vinculo::setVinculoDelete($request,$id));
    }
    ]);

//ROTAS DE Vinculo FIM

//ROTAS DE USER INÍCIO

//Rota de USer
$obRouter->get('/user',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\User::getUser($request));
    }
    ]);
//Rota de Novo user
$obRouter->get('/user/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\User::getUserNew($request));
    }
    ]);

//ROTA de Cadastro de um Novo user(POST)
$obRouter->post('/user/new',[
    'middlewares' => [
        'require-admin-login'
   ],
    function ($request){
        return new Response(200, Pages\User::setUserNew($request));
    }
    ]);

//ROTA de Edição de um de user
$obRouter->get('/user/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::getUserEdit($request,$id));
    }
    ]);

//ROTA de Edição de um de user (POST)
$obRouter->post('/user/{id}/edit',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::setUserEdit($request,$id));
    }
    ]);

//ROTA Get de Exclusão de um de user
$obRouter->get('/user/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::getUserDelete($request,$id));
    }
    ]);

//ROTA Post de Exclusão de um de user
$obRouter->post('/user/{id}/delete',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::setUserDelete($request,$id));
    }
    ]);

//ROTAS DE User FIM

//ROTA de Edição de um de user
$obRouter->get('/perfil/{id}',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::getUserEdit($request,$id));
    }
    ]);
$obRouter->post('/perfil/{id}',[
    'middlewares' => [
        'require-admin-login'
   ], 
    
    function ($request,$id){
        return new Response(200, Pages\User::setUserEdit($request,$id));
    }
    ]);