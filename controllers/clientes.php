<?php
function getPropietarios($db, $params){
  $query = "SELECT c.id, 
                    c.apellido, 
                    c.nombre, 
                    c.tipo_doc, 
                    c.nro_doc, 
                    c.direccion, 
                    c.localidad, 
                    c.cod_postal, 
                    c.provincia, 
                    c.pais, 
                    c.tel_fijo, 
                    c.tel_movil,
                    c.email, 
                    c.fecha_alta, 
                    c.fecha_ultima_op, 
                    c.observaciones, 
                    c.problematico, 
                    c.iva,
                    p.cuit,
                    p.metodo_pago,
                    p.cbu,
                    p.banco,
                    p.sucursal,
                    p.mailing,
                    p.carpeta
            FROM cliente AS c
                INNER JOIN `cliente.propietario` p ON p.id_cliente = c.id";
    if (isset($params)){
      //Agregar condiciones
    }
    $result = get($db, $query);
    return $result;
}
function addPropietario($db, $data){
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
function editPropietario($db, $data){
    try {
        // First of all, let's begin a transaction
        $db->begin_transaction();
        // A set of queries; if one fails, an exception should be thrown
        $query1 = sprintf ("UPDATE `cliente`
            SET apellido = '%s', 
                nombre = '%s', 
                tipo_doc = '%s', 
                nro_doc = '%s', 
                direccion = '%s', 
                localidad = '%s', 
                cod_postal = '%s', 
                provincia = '%s', 
                pais = '%s', 
                tel_fijo = '%s', 
                tel_movil = '%s', 
                email = '%s', 
                observaciones = '%s', 
                iva = '%s'
            WHERE id = '%s'",
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
              $db->real_escape_string($data->iva),
              $db->real_escape_string($data->id));
        $db->query($query1);
        $query2 = sprintf ("UPDATE `cliente.propietario`
            SET cuit = '%s', 
                metodo_pago = '%s', 
                cbu = '%s', 
                banco = '%s', 
                sucursal = '%s', 
                mailing = '%s', 
                carpeta = '%s', 
            WHERE id_cliente = '%s'",
              $db->real_escape_string($data->cuit),
              $db->real_escape_string($data->metodo_pago),
              $db->real_escape_string($data->cbu),
              $db->real_escape_string($data->banco),
              $db->real_escape_string($data->sucursal),
              $db->real_escape_string($data->mailing),
              $db->real_escape_string($data->carpeta),
              $db->real_escape_string($data->id));
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