<?php


use \App\Http\Response;
use \App\Controller\Tutorial;


//ROTA Tutorial
$obRouter->get('/tutorial',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getTutorial($request));
    }
    ]);

//ROTA Tutorial Antes de Começar
$obRouter->get('/tutorial/antesdecomecar',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getAntesdeComecar($request));
    }
    ]);

//ROTA Tutorial O que é SQL
$obRouter->get('/tutorial/oqueesql',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getOqueeSql($request));
    }
    ]);

//ROTA Tutorial Introdução a Banco de Dados
$obRouter->get('/tutorial/introducaoabancodedados',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getIntroducaoaBancodeDados($request));
    }
    ]);

//ROTA Tutorial Create Database
$obRouter->get('/tutorial/createdatabase',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getCreateDatabase($request));
    }
    ]);

//ROTA Tutorial Show Databases
$obRouter->get('/tutorial/showdatabases',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getShowDatabases($request));
    }
    ]);


//ROTA Tutorial USE Database
$obRouter->get('/tutorial/usedatabase',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getUseDatabase($request));
    }
    ]);


//ROTA Tutorial Create Table
$obRouter->get('/tutorial/createtable',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getCreateTable($request));
    }
    ]);


//ROTA Tutorial showtables
$obRouter->get('/tutorial/showtables',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getShowTables($request));
    }
    ]);

//ROTA Tutorial showcolumns
$obRouter->get('/tutorial/showcolumns',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getShowColumns($request));
    }
    ]);


//ROTA Tutorial Alter Table
$obRouter->get('/tutorial/altertable',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getAlterTable($request));
    }
    ]);
//ROTA Tutorial restricoes
$obRouter->get('/tutorial/restricoes',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getRestricoes($request));
    }
    ]);
//ROTA Tutorial Insert
$obRouter->get('/tutorial/insert',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getInsert($request));
    }
    ]);
//ROTA Tutorial select
$obRouter->get('/tutorial/select',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getSelect($request));
    }
    ]);

//ROTA Tutorial orderby
$obRouter->get('/tutorial/orderby',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getOrderby($request));
    }
    ]);

//ROTA Tutorial update
$obRouter->get('/tutorial/update',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getUpdate($request));
    }
    ]);
//ROTA Tutorial delete
$obRouter->get('/tutorial/delete',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getDelete($request));
    }
    ]);

//ROTA Tutorial droptable
$obRouter->get('/tutorial/droptable',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getDropTable($request));
    }
    ]);

//ROTA Tutorial Truncate Table
$obRouter->get('/tutorial/truncatetable',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getTruncateTable($request));
    }
    ]);
//ROTA Tutorial dropdatabase
$obRouter->get('/tutorial/dropdatabase',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getDropDatabase($request));
    }
    ]);

//ROTA Tutorial join
$obRouter->get('/tutorial/join',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getJoin($request));
    }
    ]);
//ROTA Tutorial innerjoin
$obRouter->get('/tutorial/innerjoin',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getInnerJoin($request));
    }
    ]);

//ROTA Tutorial leftjoin
$obRouter->get('/tutorial/leftjoin',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getLeftJoin($request));
    }
    ]);

//ROTA Tutorial rightjoin
$obRouter->get('/tutorial/rightjoin',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getRightJoin($request));
    }
    ]);

//ROTA Tutorial union
$obRouter->get('/tutorial/union',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getUnion($request));
    }
    ]);

//ROTA Tutorial referencias
$obRouter->get('/tutorial/referencias',[
    function ($request){
        return new Response(200, Tutorial\Tutorial::getReferencias($request));
    }
    ]);


