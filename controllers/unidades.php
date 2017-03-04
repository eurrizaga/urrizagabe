<?php
function getUnidades($db, $params){
    if (isset($params)){
      //Agregar condiciones
    }
    $query = "SELECT u.id, 
                    u.id_edificio, 
                    u.id_propietario, 
                    u.hab_venta, 
                    u.hab_alquiler, 
                    u.codigo, 
                    u.carpeta, 
                    u.detalles, 
                    u.fecha_ultima_op, 
                    u.tipo_unidad, 
                    c.apellido,
                    c.nombre,
                    c.nro_doc,
                    e.nombre
            FROM unidad AS u
                INNER JOIN `cliente` c ON u.id_propietario = c.id
                INNER JOIN `edificio` e ON e.id = u.id_edificio";
    if (isset($params)){
      //Agregar condiciones
    }
    $result = get($db, $query);
    return $result;
}
function addUnidad($db, $data){
     try {
        // First of all, let's begin a transaction
        $db->begin_transaction();

        // A set of queries; if one fails, an exception should be thrown
        $query1 = sprintf ("INSERT INTO `cliente`
          ( apellido, 
            nombre, 
            tipo_doc, 
            nro_doc, 
            direccion, 
            localidad, 
            cod_postal, 
            provincia, 
            pais, 
            tel_fijo, 
            tel_movil, 
            email, 
            fecha_alta, 
            observaciones, 
            iva) 
            VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW(),'%s','%s')",
              $db->real_escape_string($data->apellido),
              $db->real_escape_string($data->nombre),
              $db->real_escape_string($data->tipo_doc),
              $db->real_escape_string($data->nro_doc),
              $db->real_escape_string($data->direccion),
              $db->real_escape_string($data->localidad),
              $db->real_escape_string($data->cod_postal),
              $db->real_escape_string($data->provincia),
              $db->real_escape_string($data->pais),
              $db->real_escape_string($data->tel_fijo),
              $db->real_escape_string($data->tel_movil),
              $db->real_escape_string($data->email),
              $db->real_escape_string($data->observaciones),
              $db->real_escape_string($data->iva));
        $db->query($query1);
        $query2 = sprintf ("INSERT INTO `cliente.propietario`
          ( cuit, 
            metodo_pago, 
            cbu, 
            banco, 
            sucursal, 
            mailing, 
            carpeta, 
            id_cliente) 
            VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
              $db->real_escape_string($data->cuit),
              $db->real_escape_string($data->metodo_pago),
              $db->real_escape_string($data->cbu),
              $db->real_escape_string($data->banco),
              $db->real_escape_string($data->sucursal),
              $db->real_escape_string($data->mailing),
              $db->real_escape_string($data->carpeta),
              $db->real_escape_string($db->insert_id));
        $db->query($query2);
        // If we arrive here, it means that no exception was thrown
        // i.e. no query has failed, and we can commit the transaction
        $db->commit();
        $result = "Result saved correctly";
    } catch (Exception $e) {
        // An exception has been thrown
        // We must rollback the transaction
        $db->rollback();
        $result = "Table query failed: (" . $db->errno . ") " . $db->error. '(' . $query. ')';
    }
    return $result;
}
function editUnidad($db, $data){
    return 'no implementado';
        
}

function getEdificios($db, $params){
    if (isset($params)){
      //Agregar condiciones
    }
    $query = "SELECT id, 
            nombre, 
            direccion, 
            contiene_cochera, 
            contiene_depto, 
            observaciones 
            FROM edificio";
    if (isset($params)){
      //Agregar condiciones
    }
    $result = get($db, $query);
    return $result;
}
function addEdificio($db, $data){
    $query = sprintf ("INSERT INTO `edificio`
      ( nombre, 
        direccion, 
        contiene_cochera, 
        contiene_depto, 
        observaciones) 
        VALUES ('%s','%s','%s','%s','%s')",
          $db->real_escape_string($data->nombre),
          $db->real_escape_string($data->direccion),
          $data->contiene_cochera,
          $data->contiene_depto,
          $db->real_escape_string($data->observaciones));
    if (!$db->query($query))
      $result = "Table query failed: (" . $db->errno . ") " . $db->error. '(' . $query. ')';
    else{
      $result = "Result saved correctly";
    }
    return $result;
}
function editEdificio($db, $data){
    $query = sprintf ("UPDATE `edificio`
        SET nombre = '%s', 
            direccion = '%s', 
            contiene_cochera = '%s', 
            contiene_depto = '%s', 
            observaciones = '%s' 
        WHERE id = '%s'",
          $db->real_escape_string($data->nombre),
          $db->real_escape_string($data->direccion),
          $db->real_escape_string($data->contiene_cochera),
          $db->real_escape_string($data->contiene_depto),
          $db->real_escape_string($data->observaciones),
          $db->real_escape_string($data->id));
    if (!$db->query($query))
      $result = "Table query failed: (" . $db->errno . ") " . $db->error. '(' . $query. ')';
    else{
      $result = "Result saved correctly";
    }
    return $result;
}
