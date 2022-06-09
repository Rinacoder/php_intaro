<?php
$api_token=file_get_contents('key.txt');
echo 1;
$url='https://geocode-maps.yandex.ru/1.x/?';
$address=$_GET['adress'];
$parameters = array(
    'apikey' => $api_token,
    'geocode' => $address,
    'format' => 'json'
  );
$response = file_get_contents($url. http_build_query($parameters));
$my_loc= json_decode($response, true);
$metro="Not found in ur area";

if($my_loc['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found']>=1){
    $cord = str_replace(" ", ",", $my_loc['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
    $parameters = array(
    'apikey' => $api_token,
    'geocode' => $cord,
    'kind' => 'metro',
    'format' => 'json'
    );
    $response = file_get_contents($url. http_build_query($parameters));
    $obj = json_decode($response, true);
    // var_dump($obj);
    if($obj['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found']>=1){
        $metro = "Метро: ".$obj['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'];
    }
}
$coordinates =$my_loc['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
$my_loc=$my_loc['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
// echo $metro;
$datas=array($my_loc, $coordinates, $metro);

$response =[
    "status" =>true,
    "datas" =>$datas
];
echo json_encode($response);
