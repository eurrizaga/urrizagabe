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
                    c.documento,
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
    return 0;
}
function editUnidad($db, $data){
    return 0;
}
