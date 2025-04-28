<?php
    session_start();
    include("../adm/config_master.php");


    //verifica se alguma resposta foi digitada
    if (isset($_POST['resposta']) && ($_POST['resposta']!='')){
        $sql =strtolower($_POST['resposta']);

       //verifica se a sessao id_usuario existe, se existir, atribui seu valor à $id_usuario
        if(isset($_SESSION['id_usuario_login'])){
            $id_usuario = $_SESSION['id_usuario_login'];}

        if (isset($_POST['banco'])){
            $bancoTemp = $id_usuario."_".$_POST['banco'];
        }

        $comandoInformado = explode(" ", $sql.' ');
        $msgSucesso = "Comando executado com Sucesso!";
        $msgErro = 'Comando SQL inválido para a Questão ou Existe erro de Sintaxe!';

        $tira_espacos = strtoupper(str_replace(' ','',$sql));
        $tiraEspaco = strtoupper(str_replace(' ','', $sql));

        //pega apenas o nome do banco de dados que será criado
        $nomeBanco =trim(str_replace('CREATEDATABASE',' ',$tiraEspaco));
        $nomeBancoDrop =trim(str_replace('DROPDATABASE',' ',$tiraEspaco));

        //pega as 15 primeiras letras do comando digitado - SHOWCOLUMNSFROM
        $SHOWCOLUMNSFROM = strtoupper(substr($tira_espacos, 0, 15));
          //pega as 10 primeiras letras do comando digitado - SHOWTABLES
        $showTables = strtoupper(substr($tira_espacos, 0, 10));
        //pega as 6 primeiras letras do comando digitado - SELECT
        $select = strtoupper(substr($tira_espacos, 0, 6));
        //pega as 13 primeiras letras do comando digitado - SHOWDATABASES
        $showDatabases = strtoupper(substr($tira_espacos, 0, 13));
         //pega as 3 primeiras letras do comando digitado - USE
        $use = strtoupper(substr($tira_espacos, 0, 3));
         //pega as 14 primeiras letras do comando digitado - CREATEDATABASE
        $createDatabase = strtoupper(substr($tira_espacos, 0, 14));
        //pega as 11 primeiras letras do comando digitado - CREATETABLE
        $createTable = strtoupper(substr($tira_espacos, 0, 11));
        //pega as 10 primeiras letras do comando digitado - ALTERTABLE
        $alterTable = strtoupper(substr($tira_espacos, 0, 10));
        //pega as 6 primeiras letras do comando digitado - INSERTINTO
        $insertInto = strtoupper(substr($tira_espacos, 0, 10));
        //pega as 6 primeiras letras do comando digitado - UPDATE
        $update = strtoupper(substr($tira_espacos, 0, 6));
        //pega as 6 primeiras letras do comando digitado - DELETEFROM
        $deleteFrom = strtoupper(substr($tira_espacos, 0, 10));
        //pega as 6 primeiras letras do comando digitado - SELECT
        $select = strtoupper(substr($tira_espacos, 0, 6));
        //pega as 4 primeiras letras do comando digitado - DROPTABLE
        $dropTable = strtoupper(substr($tira_espacos, 0, 9));
         //pega as 15 primeiras letras do comando digitado - SHOWCOLUMNSFROM
        $showColumnsFrom = strtoupper(substr($tira_espacos, 0, 15));
        //pega as 15 primeiras letras do comando digitado - TRUNCATETABLE
        $truncateTable = strtoupper(substr($tira_espacos, 0, 13));
        //pega as 15 primeiras letras do comando digitado - DROPDATABASE
        $dropDatabase = strtoupper(substr($tira_espacos, 0, 12));


        if ($showDatabases == 'SHOWDATABASES') {
            if($showColumnsTables = $pdo_Aux -> query($sql)){
                $row = $showColumnsTables -> fetchAll(PDO::FETCH_ASSOC);
                function array2Html($array, $table = true){
                    $out = '';
                   // $tableHeader='';
                    foreach ($array as $key => $value) {
                        if (is_array($value)) {
                            if (!isset($tableHeader)) {
                                $tableHeader =
                                    '<th class="active">' .
                                    implode('</th><th class="active">', array_keys($value)).
                                    '</th>';
                            }
                            array_keys($value);
                            $out .= '<tr>';
                            $out .= array2Html($value, false);
                            $out .= '</tr>';
                        }else{
                            if(isset($_SESSION['id_usuario_login'])){$id_usuario = $_SESSION['id_usuario_login'];}
                            // exibe apenas os bancos criados pelo usuario logado
                            if(strstr($value, '_', true) == $id_usuario){
                                $value = str_replace($id_usuario.'_','',$value);
                                $out .= "<td >$value</td>";
                            }
                        }
                    }
                    if ($table){
                        return '<table class="table table-bordered table-condensed">' . $tableHeader . $out . '</table>';
                    }else{
                        return $out;
                    }
                }
                if (empty($row)){
                    $resultado[0] = "Comando não retornou nenhum registro.";
                }else{
                  $resultado[0] = html_entity_decode(array2Html($row));
                }
            }else{
              $resultado[0] = $pdo_Aux -> errorInfo()[2];
              //tira o id do usuario da mensagem
              $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
            }
        }else  if ($showTables == 'SHOWTABLES') {
                  $pdo_Aux->query('use '.$bancoTemp);
                  if($showColumnsTables = $pdo_Aux -> query($sql)){
                      $row = $showColumnsTables -> fetchAll(PDO::FETCH_ASSOC);
                      function array2Html($array, $table = true){
                          $out = '';
                         // $tableHeader='';
                          foreach ($array as $key => $value) {
                              if (is_array($value)) {
                                  if (!isset($tableHeader)) {
                                      if(isset($_SESSION['id_usuario_login'])){$id_usuario = $_SESSION['id_usuario_login'];}
                                      $tableHeader =
                                          '<th class="active">'.
                                          str_replace($id_usuario.'_','',implode(array_keys($value))).
                                          '</th>';
                                  }
                                  array_keys($value);
                                  $out .= '<tr>';
                                  $out .= array2Html($value, false);
                                  $out .= '</tr>';
                              }else{
                                  $out .= "<td >$value</td>";
                              }
                          }
                          if ($table){
                              return '<table class="table table-bordered table-condensed">' . $tableHeader . $out . '</table>';
                          }else{
                              return $out;
                          }
                      }
                      if (empty($row)){
                          $resultado[0] = $msgSucesso;
                          $resultado[3] ="SHOWTABLES";
                          $resultado[2] ="Comando não retornou nenhum registro.";
                     }else{$resultado[0] = html_entity_decode(array2Html($row));}
                  }
                  else{
                      $resultado[0] = $pdo_Aux -> errorInfo()[2];
                       //tira o id do usuario da mensagem
                      $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                  }

              }else if($alterTable == 'ALTERTABLE'){
                        $pdo_Aux->query('use '.$bancoTemp);
                        if ($pdo_Aux ->query($sql)){
                            $resultado[0] = $msgSucesso;
                        }else{
                            $resultado[0] = $pdo_Aux -> errorInfo()[2];
                            //tira o id do usuario da mensagem
                            $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                        }
                    }else if($insertInto == 'INSERTINTO'){
                              $pdo_Aux->query('use '.$bancoTemp);
                              if ($pdo_Aux ->query($sql)){
                                $resultado[0] = $msgSucesso;
                              }else{
                                  $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                 //tira o id do usuario da mensagem
                                  $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                              }
                          }else if($update == 'UPDATE'){
                                    $pdo_Aux->query('use '.$bancoTemp);
                                    if ($pdo_Aux ->query($sql)){
                                        $resultado[0] = $msgSucesso;
                                    }else{
                                        $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                        //tira o id do usuario da mensagem
                                        $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                    }
                                }else  if($deleteFrom == 'DELETEFROM'){
                                          $pdo_Aux->query('use '.$bancoTemp);
                                          if ($pdo_Aux ->query($sql)){
                                              $resultado[0] = $msgSucesso;
                                          }else{
                                              $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                 //tira o id do usuario da mensagem
                                              $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                          }
                                      }else if($select == 'SELECT'){
                                                $pdo_Aux->query('use '.$bancoTemp);
                                                if($showColumnsTables = $pdo_Aux -> query($sql)){
                                                    $row = $showColumnsTables -> fetchAll(PDO::FETCH_ASSOC);
                                                    function array2Html($array, $table = true){
                                                        $out = '';
                                                       // $tableHeader='';
                                                        foreach ($array as $key => $value) {
                                                            if (is_array($value)) {
                                                                if (!isset($tableHeader)) {
                                                                      $tableHeader =
                                                                     '<th class="active">' .
                                                                        implode('</th><th class="active">', array_keys($value)) .
                                                                        '</th>';
                                                                }
                                                                array_keys($value);
                                                                $out .= '<tr>';
                                                                $out .= array2Html($value, false);
                                                                $out .= '</tr>';
                                                            }else{
                                                                $out .= "<td >$value</td>";
                                                            }
                                                        }
                                                        if ($table) {
                                                            return '<table class="table table-bordered table-condensed">' . $tableHeader . $out . '</table>';
                                                        }else{
                                                            return $out;
                                                        }
                                                    }
                                                       if (empty($row)){
                                                        $resultado[0] = $msgSucesso;
                                                        $resultado[3] ="SELECT";
                                                        $resultado[2] ="Comando não retornou nenhum registro.";
                                                     }else{
                                                           $resultado[0] = html_entity_decode(array2Html($row));
                                                            //tira o id do usuario da mensagem
                                                        $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                                       }
                                                }
                                                else{
                                                    $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                     //tira o id do usuario da mensagem
                                                    $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                                }
                                      }else   if($dropTable == 'DROPTABLE'){
                                                  $pdo_Aux->query('use '.$bancoTemp);
                                                  if ($pdo_Aux ->query($sql)){
                                                      $resultado[0] = $msgSucesso;
                                                  }else{
                                                      $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                      //tira o id do usuario da mensagem
                                                      $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                                  }
                                      }else if($showColumnsFrom == 'SHOWCOLUMNSFROM') {
                                           $pdo_Aux->query('use '.$bancoTemp);
                                           if($showColumnsTables = $pdo_Aux -> query($sql)){
                                              $row = $showColumnsTables -> fetchAll(PDO::FETCH_ASSOC);
                                              function array2Html($array, $table = true){
                                                  $out = '';
                                                 // $tableHeader='';
                                                  foreach ($array as $key => $value) {
                                                      if (is_array($value)) {
                                                          if (!isset($tableHeader)) {
                                                                $tableHeader =
                                                               '<th class="active">' .
                                                                  implode('</th><th class="active">', array_keys($value)) .
                                                                  '</th>';
                                                          }
                                                          array_keys($value);
                                                          $out .= '<tr>';
                                                          $out .= array2Html($value, false);
                                                          $out .= '</tr>';
                                                      }else{
                                                          $out .= "<td >$value</td>";
                                                      }
                                                  }

                                                  if ($table) {
                                                      return '<table class="table table-bordered table-condensed">' . $tableHeader . $out . '</table>';
                                                  }else{
                                                      return $out;
                                                  }
                                              }
                                               //envia o resultado do comando
                                               $resultado[0] = html_entity_decode(array2Html($row));
                                          }

                                          else{
                                              $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                              //tira o id do usuario da mensagem
                                              $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                          }
                                      }else   if($truncateTable == 'TRUNCATETABLE'){

                                            $pdo_Aux->query('use '.$bancoTemp);

                                            if ($pdo_Aux ->query($sql)){
                                              $resultado[0] = $msgSucesso;
                                          }else{
                                              $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                 //tira o id do usuario da mensagem
                                              $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                               }
                                      }else

                          if($dropDatabase == 'DROPDATABASE'){

                                          $sql =strtolower("drop database ".$id_usuario."_".$nomeBancoDrop);
                                          if ($pdo_Aux ->query($sql)){
                                               $resultado[0] = $msgSucesso;
                                              $resultado[3] = 'DROPDATABASE';
                                          }else{
                                               $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                              //tira o id do usuario da mensagem
                                              $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                          }

                                      }else if ($use == 'USE') {
                              //retira excessos de espaços em branco
                                          $tiraEspaco = str_replace(' ','', strtolower($sql));
                                          //pega apenas o nome do banco de dados que será criado
                                          $nomeBanco =trim(str_replace('use',' ',$tiraEspaco));

                                          if (!$pdo_Aux ->query($sql)){
                                              //recebe o codigo da msg de erro
                                             $resultado[2] = $pdo_Aux -> errorInfo()[1];
                                              //se o codigo for igula a 1049 banco desconhecido
                                              if($resultado[2]==1049){
                                                 // se for igual a comparação executa esse bloco
                                                  $sql1 = "use ".$id_usuario."_".$nomeBanco;
                                                  if($pdo_Aux ->query($sql1)){
                                                      $resultado[0] = $msgSucesso;
                                                      $resultado[1] = $nomeBanco;
                                                      $resultado[3] = 'USE';
                                                  }else{
                                                      $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                      //tira o id do usuario da mensagem
                                                      $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                                  }
                                              //senao for igual a comparação executa esse
                                              }else{
                                                $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                //tira o id do usuario da mensagem
                                                $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                              }
                                          }

                         }else
                              if($createTable == 'CREATETABLE'){
                                  $pdo_Aux->query('use '.$bancoTemp);
                                  $sql = str_replace(';','',$sql).'ENGINE=InnoDB DEFAULT CHARSET=utf8';
                                  if ($pdo_Aux ->query($sql)){
                                      $resultado[0] = $msgSucesso;//}
                                      }else{
                                            $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                           //tira o id do usuario da mensagem
                                            $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                      }

                              }else
                                  if($createDatabase == 'CREATEDATABASE'){
                                      if ($pdo_Aux ->query($sql)){
                                          //apaga o banco criado sem o id do aluno
                                          $pdo_Aux ->query(strtolower("drop database $nomeBanco"));
                                          //cria o banco com o id do aluno
                                          $sql =strtolower("create database ".$id_usuario."_".$nomeBanco);
                                          if ($pdo_Aux ->query($sql)){
                                              $resultado[0] = $msgSucesso;
                                              $resultado[1] = strtolower($id_usuario."_".$nomeBanco);
                                              $resultado[3] = "CREATEDATABASE";
                                              }else{
                                                    $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                    //tira o id do usuario da mensagem
                                                    $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                              }
                                      }else{
                                            $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                            //tira o id do usuario da mensagem
                                            $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                      }
                                }else{
                                      if ($pdo_Aux ->query($sql)){
                                          $resultado[0] = $msgSucesso;//}
                                          //$resultado[3] = "CREATEDATABASE";
                                          }else{
                                                $resultado[0] = $pdo_Aux -> errorInfo()[2];
                                                //tira o id do usuario da mensagem
                                                $resultado[0] = str_replace($id_usuario.'_','',(($resultado[0])));
                                          }

                                }

                                echo json_encode($resultado);
    }else{
          $resultado[0]='Nenhum comando foi digitado!';
          echo json_encode($resultado);
    }
?>



        
   