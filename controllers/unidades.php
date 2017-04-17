<?php
function getUnidades($db, $params){
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
                    c.apellido AS propietario_apellido,
                    c.nombre AS propietario_nombre,
                    c.nro_doc,
                    e.nombre AS nombre_edificio
            FROM unidad AS u
                INNER JOIN `cliente` c ON u.id_propietario = c.id
                INNER JOIN `edificio` e ON e.id = u.id_edificio";
    if (isset($params)){
      
    }
    
    $result = get($db, $query);
    return $result;
}
function getUnidadInfo($db, $params){
    if (isset($params)){
      switch ($params->tipo_unidad){
        case 'c': 
          $query = "SELECT u.id AS id_cochera, 
                          u.numero, 
                          u.categoria, 
                          u.dist_ascensor, 
                          u.dist_esc_caracol, 
                          u.dist_esc_bristol,
                          u.dist_esc_izq,
                          u.dist_esc_der, 
                          u.ancho, 
                          u.largo, 
                          u.subsuelo  
                  FROM `unidad.cochera` AS u
                  WHERE u.id_unidad = '$params->id'";
        break;
        case 'd': 
          $query = "SELECT u.id AS id_departamento, 
                          u.ambientes,
                          u.piso,
                          u.letra  
                  FROM `unidad.departamento` AS u
                  WHERE u.id_unidad = '$params->id'";
        break;
        case 'k': break;
        case 't': break;
      }
      $result = get($db, $query);
      return $result;
    }
    else{
      return 'no params';
    }
      
    
}
function addUnidad($db, $data){
     try {
        // First of all, let's begin a transaction
        $db->begin_transaction();

        // A set of queries; if one fails, an exception should be thrown
        $query1 = sprintf ("INSERT INTO `unidad`
          ( id_edificio, 
            id_propietario, 
            hab_venta, 
            hab_alquiler, 
            codigo, 
            carpeta, 
            detalles, 
            tipo_unidad) 
            VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
              $db->real_escape_string($data->id_edificio),
              $db->real_escape_string($data->id_propietario),
              $db->real_escape_string($data->hab_venta),
              $db->real_escape_string($data->hab_alquiler),
              $db->real_escape_string($data->codigo),
              $db->real_escape_string($data->carpeta),
              $db->real_escape_string($data->detalles),
              $db->real_escape_string($data->tipo_unidad));
        $db->query($query1);
        if ($data->tipo_unidad == 'c'){
            $query2 = sprintf ("INSERT INTO `unidad.cochera`
              ( id_unidad,
                numero, 
                categoria, 
                dist_ascensor, 
                dist_esc_caracol, 
                dist_esc_bristol, 
                dist_esc_izq, 
                dist_esc_der, 
                ancho,
                largo,
                subsuelo) 
                VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                  $db->real_escape_string($db->insert_id),
                  $db->real_escape_string($data->numero),
                  $db->real_escape_string($data->categoria),
                  $db->real_escape_string($data->dist_ascensor),
                  $db->real_escape_string($data->dist_esc_caracol),
                  $db->real_escape_string($data->dist_esc_bristol),
                  $db->real_escape_string($data->dist_esc_izq),
                  $db->real_escape_string($data->dist_esc_der),
                  $db->real_escape_string($data->ancho),
                  $db->real_escape_string($data->largo),
                  $db->real_escape_string($data->subsuelo));
            $db->query($query2);
        }
        else{
          if ($data->tipo_unidad == 'd'){
              $query2 = sprintf ("INSERT INTO `unidad.departamento`
                ( id_unidad,
                  ambientes,
                  piso,
                  letra ) 
                  VALUES ('%s', '%s', '%s', '%s')",
                    $db->real_escape_string($db->insert_id),
                    $db->real_escape_string($data->ambientes),
                    $db->real_escape_string($data->piso),
                    $db->real_escape_string($data->letra));
              $db->query($query2);
              echo $query2;
          }
        }
        $db->commit();
        $result = "Query succesful";
    } catch (Exception $e) {
        // An exception has been thrown
        // We must rollback the transaction
        $db->rollback();
        $result = "Table query failed: (" . $db->errno . ") " . $db->error. '(' . $query. ')';
    }
    return $result;
}
function editUnidad($db, $data){
    try {
        // First of all, let's begin a transaction
        $db->begin_transaction();
        // A set of queries; if one fails, an exception should be thrown
        $query1 = sprintf ("UPDATE `unidad`
            SET id_edificio = '%s', 
                id_propietario = '%s', 
                hab_venta = '%s', 
                hab_alquiler = '%s', 
                codigo = '%s', 
                carpeta = '%s', 
                detalles = '%s'
            WHERE id = '%s'",
              $db->real_escape_string($data->id_edificio),
              $db->real_escape_string($data->id_propietario),
              $db->real_escape_string($data->hab_venta),
              $db->real_escape_string($data->hab_alquiler),
              $db->real_escape_string($data->codigo),
              $db->real_escape_string($data->carpeta),
              $db->real_escape_string($data->detalles),
              $db->real_escape_string($data->id));

        $db->query($query1);
        switch ($data->tipo_unidad){
          case 'c': 
            $query2 = sprintf ("UPDATE `unidad.cochera`
                SET numero = '%s', 
                    categoria = '%s', 
                    dist_ascensor = '%s', 
                    dist_esc_caracol = '%s', 
                    dist_esc_bristol = '%s', 
                    dist_esc_izq = '%s', 
                    dist_esc_der = '%s',
                    ancho = '%s',
                    largo = '%s',
                    subsuelo = '%s' 
                WHERE id_unidad = '%s'",
                  $db->real_escape_string($data->numero),
                  $db->real_escape_string($data->categoria),
                  $db->real_escape_string($data->dist_ascensor),
                  $db->real_escape_string($data->dist_esc_caracol),
                  $db->real_escape_string($data->dist_esc_bristol),
                  $db->real_escape_string($data->dist_esc_izq),
                  $db->real_escape_string($data->dist_esc_der),
                  $db->real_escape_string($data->ancho),
                  $db->real_escape_string($data->largo),
                  $db->real_escape_string($data->subsuelo),
                  $db->real_escape_string($data->id));
          break;
          case 'd': 
            $query2 = sprintf ("UPDATE `unidad.departamento`
                SET ambientes = '%s',
                    piso = '%s',
                    letra = '%s'
                WHERE id_unidad = '%s'",
                  $db->real_escape_string($data->ambientes),
                  $db->real_escape_string($data->piso),
                  $db->real_escape_string($data->letra),
                  $db->real_escape_string($data->id));
            echo $query2;
          break;
          case 'k': break;
          case 't': break;
        }
            
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

function getEdificios($db, $params){
    $query = "SELECT id, 
            nombre, 
            direccion, 
            contiene_cochera, 
            contiene_depto, 
            observaciones 
            FROM edificio";
    if (isset($params)){
      //Agregar condiciones
      $cond = " WHERE ";
      $i = 0;
      foreach($params as $p){
        $cond.="(" . $p->field . " = " . $p->value . ")";
        $i++;
        if ($i < count($params)){
          $cond.= " AND ";
        }
      }
      $query.= $cond;
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
