<?php

class ApiController{
    private $url = 'https://geocode-maps.yandex.ru/1.x/?';             // урл для получения информации geocode
    private $underground = "Возле указанного адреса нет станции метро";// сообщение по умолчанию о ближайшем метро. Если поблизости введенного 
                                                                       // адреса есть метро, название станции будет указано в данном поле
    private $token;                                                    // токен для доступа к geocode
    private $address;                                                  // адресс, по которому будет произведен поиск координат и метро
    private $response;                                                 // полученный из geocode responce
    private $parameters;                                               // параметры последнего запроса на получение данных geocode
    private $position;                                                 // координаты искомого адреса

    public function __construct(){
        $this->token = file_get_contents('config.txt');
        $this->address = $_GET['adress'];
        $this->parameters = array(
          'apikey' => $this->token,
          'geocode' => $this->address,
          'format' => 'json'
        );
        $buffer = file_get_contents($this->url . http_build_query($this->parameters));
        $this->responce = json_decode($buffer, true);
    }

    // Отправка данных на фронт
    // Получение информации о координатах адреса и адреса в отформатированном виде
    public function sendResponce(){
        $this->prepareData();
        $this->position = $this->responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        $prepare_data = $this->responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
        $data = array($prepare_data, $this->position, $this->underground);
        $status = true;
        if(is_null($prepare_data)) $status = false;
        $this->response = [
            "status" => $status,
            "data" => $data
        ];
        echo json_encode($this->response, JSON_UNESCAPED_UNICODE);
    }

    // Поиск ближайшего метро по введенным пользователем координатам. Сохранение информации о метро в поля класса
    // Выходные данные:
    // true - данные о ближайшем метро получены
    // false - входные данные (информация из YandexApi по введенному пользователем адресу) не корректны
    private function prepareData(){
        $is_found = $this->responce['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'];
        $positions = $this->responce['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        if($is_found >= 1){
            $position = str_replace(" ", ",", $positions);
            $this->parameters = array(
                'apikey' => $this->token,
                'geocode' => $positions,
                'kind' => 'metro',
                'format' => 'json'
            );
        } else {
            return false;
        }
        $buffer = file_get_contents($this->url . http_build_query($this->parameters));
        $underground_request = json_decode($buffer, true);
        $is_found = $underground_request['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'];
        if($is_found >= 1){
            $this->underground = "Ближайшее к указанному адресу метро: " . $underground_request['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'];
        }
        return true;
    }
}

$apiController = new ApiController();
$apiController->sendResponce();