<?php
function get($db, $query){
  $myArray = array();
  if ($result = $db->query($query)) {
    $tempArray = array();
    while($row = $result->fetch_object()) {
      $tempArray = $row;
      array_push($myArray, $tempArray);
    }
    $result = json_encode($myArray);
  }
  else{
    $result = 'Bad query: ' . $query;
  }
  return $result;
}