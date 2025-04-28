<?php 
namespace App\Utils;

class Funcoes{

//Método responsavel por iniciar a sessão
    public static function init(){
    //verifica se a sessao não está ativa
    if(session_status() != PHP_SESSION_ACTIVE ){
        session_start();
    }
}

// método responsável por definir a condicao do usuário logado
public static function condicao(){
        
    self::init();

		if($_SESSION['usuario']['id'] == 1){
			$where = null;
		}else{
			$where = 'gestor = "'.$_SESSION['usuario']['id'].'"';
		}
    return $where;
}


public static function validaCPF($cpf) {
    
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }
    
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    
    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
    
}

public static  function removerAcentos($string) {
    $acentos = array(
        'á', 'à', 'â', 'ã', 'ä', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï',
        'ó', 'ò', 'ô', 'õ', 'ö', 'ú', 'ù', 'û', 'ü', 'ç', 'ñ',
        'Á', 'À', 'Â', 'Ã', 'Ä', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï',
        'Ó', 'Ò', 'Ô', 'Õ', 'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'Ç', 'Ñ'
    );
    
    $semAcentos = array(
        'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'c', 'n',
        'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I',
        'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'C', 'N'
    );
    
    return str_replace($acentos, $semAcentos, $string);
}


}
?>