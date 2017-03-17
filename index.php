<?php
    require('controllers/general.php');
    require('controllers/clientes.php');
    require('controllers/unidades.php');
    $mysqli = new mysqli("localhost", "system", "usuarioSistema", "urrizaga");
    if ($mysqli->connect_errno) {
      $result = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    else{
      $postdata = file_get_contents("php://input");
      if ($request = json_decode($postdata)){
        //write
        @$op = $request->operation;
        @$target = $request->target;
        //target name
        $result = "[]";
        switch($op){
          case 'get': //REQUEST
            if (isset($request->params)){
              @$params = $request->params;
            }
            else{
              $params = null;
            }
            switch($target){
              case 'edificios':  $result = getEdificios($mysqli, $params); break;
              case 'propietarios': $result = getPropietarios($mysqli, $params); break;
              case 'unidades':  $result = getUnidades($mysqli, $params); break;
              case 'unidadInfo':  $result = getUnidadInfo($mysqli, $params); break;
            }
          break;
          case 'post': //CREATE
            @$data = $request->data;
            switch($target){
              case 'edificio': $result = addEdificio($mysqli, $data); break;
              case 'propietario': $result = addPropietario($mysqli, $data); break;
              case 'unidad': $result = addUnidad($mysqli, $data); break;
            }
          break;
          case 'put': //UPDATE
            @$data = $request->data;
            switch($target){
              case 'edificio': $result = editEdificio($mysqli, $data); break;
              case 'propietario': $result = editPropietario($mysqli, $data); break;
              case 'unidad': $result = editUnidad($mysqli, $data); break;
            }
          break;
        }
        echo $result;

      }
      mysqli_close($mysqli);
    }
