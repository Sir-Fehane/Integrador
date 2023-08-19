<?php 
session_start();
$_SESSION['SUCURSALCHIDA']='';
function getDistance($addressFrom, $addressTo, $unit = ''){

    // Google API key
    $apiKey = 'AIzaSyCvYK11OxRL0uj95s71kCdtjlLwMxO84G4';
    try{
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }
    
    // Get latitude and longitude from the geodata
    if (isset($outputFrom->results[0]->geometry->location->lat) && isset($outputFrom->results[0]->geometry->location->lng)) {
    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
    }else {return "Error";}
    if (isset($outputFrom->results[0]->geometry->location->lat) && isset($outputFrom->results[0]->geometry->location->lng)) {
    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
    }else {return "Error";}
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    
    // Convert unit and return distance
    $unit = strtoupper($unit);
    if($unit == "K"){
        return round($miles * 1.609344, 2);
    }elseif($unit == "M"){
        return round($miles * 1609.344, 2);
    }else{
        return round($miles, 2);
    }
  }
  catch(Exception $e)
  {
    return "Ocurrió un error al procesar la solicitud: " . $e->getMessage();
  }
}

include "../class/database.php";
$db=New Database();
$db->conectarDB();
//Sucursales
$Bebebonita=$db->seleccionar("SELECT * FROM SUCURSALES WHERE ESTADO='ACTIVO'");
$direccion=$db->seleccionar("SELECT USUARIOS.DIRECCION FROM USUARIOS WHERE ID_USUARIO=".$_SESSION['IDUSU']."");
foreach($direccion as $di)
{
    $dom=$di->DIRECCION;
    $cp=$di->cp;
}
$dirusu=$dom+$cp;
$addressFrom = "".$dirusu." Torreón, Coah.";
$KMT=0;
foreach ($Bebebonita as $X)
{
    $addressTo=$X->DIRECCION;
    $distance = getDistance($addressFrom, $addressTo, "K");
    if($KMT === 0 || $distance < $KMT)
    {
        $KMT=$distance;
        $_SESSION['SUCURSALCHIDA']=$X->NOMBRE;
    }
}
echo"Sucursal: ".$_SESSION['SUCURSALCHIDA']." <br>";
echo"Km: ".$KMT."";
?>