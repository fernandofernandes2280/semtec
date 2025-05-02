<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Pagination;
use \App\Model\Entity\Servidor as EntityServidor;
use \App\Model\Entity\LocalTrabalho as EntityLocalTrabalho;
use \App\Model\Entity\Lotacao as EntityLotacao;
use \App\Model\Entity\Vinculo as EntityVinculo;
use \App\Model\Entity\CargoFuncao as EntityCargoFuncao;
use \App\Model\Entity\Feriado as EntityFeriado;
use App\Utils\Funcoes;

class Ponto extends Page{
	
    
    //retorna o dia da semana
    public static function diaSemana($data){
       
        $data = explode("/",$data);
        $data = mktime(0,0,0,$data[1],$data[0],$data[2]);
        
        switch( date("w",$data) ){
            case '0': $aux = "Domingo"; break;
            case '1': $aux = "Segunda-feira"; break;
            case '2': $aux = "Terça-feira"; break;
            case '3': $aux = "Quarta-feira"; break;
            case '4': $aux = "Quinta-feira"; break;
            case '5': $aux = "Sexta-feira"; break;
            case '6': $aux = "Sábado"; break;
        }
        return $aux;
        
    }
    
    //retorna XXXXX nos campos de assinatura de sábado e domingo
    public static function colocaX($data){
        
        $feriado = EntityFeriado::getFeriadoByData(date('Y-m-d',strtotime(strtr($data, '/', '-'))));
        
        
      
        if(self::diaSemana($data) == "Sábado" || self::diaSemana($data) == "Domingo" || $feriado instanceof EntityFeriado ){
            $aux = "xxxx";
        }else{
            $aux = "";
        }
        return $aux;
        
    }
    
    //retorna os feriados e pontos facultativos do mes
    public static function feriados($data){
        

      $feriado = EntityFeriado::getFeriadoByData(date('Y-m-d',strtotime(strtr($data, '/', '-'))))->nome ?? '';
        
        if(self::diaSemana($data) == "Sábado"){
            
            return 'SÁBADO';
        }else if(self::diaSemana($data) == "Domingo" ){
                return 'DOMINGO';
            }else{
                
                return $feriado;}
        
    }
    
    //Método respopnsavel por retornar a data atual baseado nas informacoces locais
    public static function dataAtual(){
        //Define informações locais 
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $timezone = new \DateTimeZone('America/Sao_Paulo');
        $agora = new \DateTime('now', $timezone);

        return $agora;
    }

    public static function dataSeparada($mes){

        $dataAtual = self::dataAtual()->format('d/m/Y');
        $mesAtual = $mes ?? self::dataAtual()->format('m');
        $anoAtual = self::dataAtual()->format('Y'); 

       // $mesExtensoUS = date("F", strtotime($dataUS));
        switch ($mesAtual) {
            case "1":
                $mesExtensoBr = "janeiro"; break;
            case "2":
                $mesExtensoBr = "fevereiro";break;
            case "3":
                $mesExtensoBr = "março"; break;
            case "4":
                $mesExtensoBr = "abril";break;
            case "5":
                $mesExtensoBr = "maio"; break;
            case "6":
                $mesExtensoBr = "junho";break;
            case "7":
                $mesExtensoBr = "julho"; break;
            case "8":
                $mesExtensoBr = "agosto";break;
            case "9":
                $mesExtensoBr = "setembro"; break;
            case "10":
                $mesExtensoBr = "outubro";break;
            case "11":
                $mesExtensoBr = "novembro"; break;
            case "12":
                $mesExtensoBr = "dezembro";break;
        }

        return array("dataAtual" => $dataAtual, "mesAtual" => $mesAtual, "anoAtual" => $anoAtual, "mesExtenso" => $mesExtensoBr );
    }

    //Retorna a quantidade de dias do mês
    public static function getQtdDias($mes){
        
        $data = self::dataSeparada($mes);
        
        //número de dias do mës
       return  cal_days_in_month(CAL_GREGORIAN, $mes, $data['anoAtual']);
    }
    
    
    //Retorna dias do mês
    public static function getDias($mes){
        
        //$feriado = EntityFeriado::getFeriadoByData('2025-02-04')->nome;
        
        $data = self::dataSeparada($mes);
        
        //contador de dias
        $dia = 1;
        $diasItens = '';
        while ($dia <= self::getQtdDias($mes)) {
        //Data atual para saber o dia da semana    
        //$result = $dia."/".$data['mesAtual']."/".$data['anoAtual'];
        $result = $dia."/".$mes."/".$data['anoAtual'];
        
            
            $diasItens .= " 

                	<tr>
			    	<th>".$dia."</th>
			    	<th style='font-size:14px;'>".self::diaSemana($result)."</th>
			    	<th>".self::colocaX($result)."</th>
			    	<th>".self::colocaX($result)."</th>
			    	<th>".self::colocaX($result)."</th>
			    	<th>".self::colocaX($result)."</th>
			    	<th>".self::colocaX($result)."</th>
			    	<th>0</th>
			    	<th colspan='4' >".self::feriados($result)."</th>
			    	
			    </tr>




            ";
            
            $dia++;
        }
        
        return $diasItens;
      
    }
    
    private static function getPontoItems($request, &$obPagination){
      
        $itens = '';
      
        $postVars = $request->getPostVars();
      
        $id = @$postVars['id'];
        $mes = $postVars['mes'] ?? self::dataAtual()->format('m');

        //extrai o ultimo texto da URL para direcionar o $id
        $url = $_SERVER['REQUEST_URI'];
        $xUrl = explode('/', $url);
        
        if($id){
            switch (end($xUrl)) {
                case "porServidor":
                    //Quantidade total de registros
                    $results =  EntityServidor::getServidores('id = '.$id.'','nome asc',null);
                    break;
                case "porCargoFuncao":
                    //Quantidade total de registros
                    $results =  EntityServidor::getServidores('cargoFuncao = '.$id.'','nome asc',null);
                    break;
                case "porLotacao":
                    //Quantidade total de registros
                    $results =  EntityServidor::getServidores('lotacao = '.$id.'','nome asc',null);
                    break;
                case "porLocalTrabalho":
                    //Quantidade total de registros
                    $results =  EntityServidor::getServidores('localTrabalho = '.$id.'','nome asc',null);
                    break;
                case "porVinculo":
                    //Quantidade total de registros
                    $results =  EntityServidor::getServidores('vinculo = '.$id.'','nome asc',null);
                    break;
               
            }
        }else{
            $results =  EntityServidor::getServidores(Funcoes::condicao(),'nome asc',null);
        }

        $data = self::dataSeparada($mes);
        
        mb_internal_encoding('UTF-8');

        //Renderiza o item
        while ($obServidor = $results->fetchObject(EntityServidor::class)) {
          
          
            //View de listagem
            $itens .=  View::render('pages/ponto/pontoItens',[
                'nome' => $obServidor->nome,
                'matricula' => $obServidor->matricula,
                'cargoFuncao' =>EntityCargoFuncao::getCargoFuncaoById($obServidor->cargoFuncao)->nome,
                'vinculo' => EntityVinculo::getVinculoById($obServidor->vinculo)->nome,
                'lotacao' => EntityLotacao::getLotacaoById($obServidor->lotacao)->nome,
                'localTrabalho' =>EntityLocalTrabalho::getLocalTrabalhoById($obServidor->localTrabalho)->nome,
                'diasItens' => self::getDias($mes),
                'dias' => self::getQtdDias($mes),
                'data' => (mb_strtoupper($data['mesExtenso'])).' '.$data['anoAtual']
            ]);
            
        }
        
        //Retorna a listagem
        return $itens;
        
    }
    
    //retorna o conteudo (view) de Opçoes da Folha de Ponto
    public static function getPonto(){
        
        $content =  View::render('pages/ponto/index',[
            
        ]);
        //Retorna a página completa
        return parent::getPanel('Folha de Ponto', $content,'ponto');
    }
    

    //Método responsavel por listar os Mes e selecionar o atual no select option
	public static function getSelectMes(){
        
        $mesAtual = self::dataAtual()->format('m');
	    $resultados = '';
	    $meses =  ['JANEIRO', 'FEVEREIRO','MARÇO','ABRIL', 'MAIO','JUNHO','JULHO', 'AGOSTO','SETEMBRO','OUTUBRO', 'NOVEMBRO','DEZEMBRO' ];
        $tamanho = count($meses);
	  
	        $selected = '';
            for ($i = 0; $i <$tamanho; $i++) {
                
                
	            //seleciona a mes atual
	            $i+1 == $mesAtual ? $selected = 'selected' : $selected = '';
	            //View de Meses
	            $resultados .= View::render('pages/selectOption/itemSelect',[
	                'id' => $i+1,
	                'nome' => $meses[$i],
	                'selecionado' => $selected
	            ]);
	        }
	        //retorna
	        return $resultados;
	  
	        //retorna a listagem
	        return $resultados;
	    }
	

    //Método GET responsavel por selecionar o servidor para folha de ponto
    public static function getPontoPorServidor(){
        
        $content =  View::render('pages/ponto/form',[
            'title' => 'Selecione o Servidor:',
            //'novoItem' => 'new/validaCpf', 
            'optionItens' => EntityServidor::getSelectServidor(null),
            'optionItensMes' => self::getSelectMes()
            
        ]);
        //Retorna a página completa
        return parent::getPanel('Folha de Ponto', $content,'ponto', '');
    }
	
	//Método SET responsavel por selecionar Por Gerar a Folha de Ponto
	public static function setPonto($request){
	    
	
	    $content =  View::render('pages/ponto/ponto',[
	        'itens' => self::getPontoItems($request, $obPagination)
	    ]);
	    //Retorna a página completa
	    return parent::getPanel('Folha de Ponto', $content,'ponto');
	        
	   
	   
	}
	
	
	//Método GET responsavel por Gerar Folha de Ponto por Cargo/Funcao
	public static function getPontoPorCargoFuncao(){
	    $content =  View::render('pages/ponto/form',[
	        'title' => 'Selecione o Cargo / Função:',
	        'novoItem' => 'cargoFuncao/new', 
	        'optionItens' => EntityCargoFuncao::getSelectCargoFuncao(null),
            'optionItensMes' => self::getSelectMes()
	        
	    ]);
	    //Retorna a página completa
	    return parent::getPanel('Folha de Ponto', $content,'ponto', '');
	}
	
	//Método GET responsavel por Gerar Folha de Ponto por Cargo/Funcao
	public static function getPontoPorLotacao(){
	    $content =  View::render('pages/ponto/form',[
	        'title' => 'Selecione a Lotação:',
	        'novoItem' => 'lotacao/new',
	        'optionItens' => EntityLotacao::getSelectLotacao(null),
            'optionItensMes' => self::getSelectMes()
	        
	    ]);
	    //Retorna a página completa
	    return parent::getPanel('Folha de Ponto', $content,'ponto', '');
	}
	
	//Método GET responsavel por Gerar Folha de Ponto por LocalTrabalho
	public static function getPontoPorLocalTrabalho(){
	    $content =  View::render('pages/ponto/form',[
	        'title' => 'Selecione o Local de Trabalho:',
	        'novoItem' => 'localTrabalho/new',
	        'optionItens' => EntityLocalTrabalho::getSelectLocalTrabalho(null),
            'optionItensMes' => self::getSelectMes()
	        
	    ]);
	    //Retorna a página completa
	    return parent::getPanel('SEMTEC > Folha de Ponto', $content,'ponto', '');
	}
	
	//Método GET responsavel por Gerar Folha de Ponto PorVinculo
	public static function getPontoPorVinculo(){
	    $content =  View::render('pages/ponto/form',[
	        'title' => 'Selecione o Vínculo:',
	        'novoItem' => 'vinculo/new',
	        'optionItens' => EntityVinculo::getSelectVinculo(null),
            'optionItensMes' => self::getSelectMes()
	        
	    ]);
	    //Retorna a página completa
	    return parent::getPanel('Folha de Ponto', $content,'ponto', '');
	}
	
	

	
}