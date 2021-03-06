<?php

include_once("../includes/config.php");

/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
$Work = new Work();

switch($method) {
    case 'GET':
        //Skickar en "HTTP response status code"
        http_response_code(200); //Ok - The request has succeeded

        if(isset($id)) {
            //if id in GET, get specific Work, else get all Works
            $response = $Work -> getWork($id);
        } else {
            $response = $Work -> getWorks();
        }

        if(count($response) == 0) {
            //Lagrar ett meddelande som sedan skickas tillbaka till anroparen
            $response = array("message" => "There is nothing to get yet");
        }


        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));
        
            //checks if any value is empty
        if($data->company == "" || $data->startDate == "" || $data->endDate == "" || $data->title == "") {
            $response = array("message" => "Please send company name, start date, end date and title");

            http_response_code(400);//error
        } else {
            if($Work->addWork($data->company, $data->startDate, $data->endDate, $data->title)) {
                $response = array("message" => "Created");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Error adding Work");
                http_response_code(500); //Server error
            }
            
        }
        
        break;
    case 'PUT':
        //Om ingen ID är medskickat, skicka felmeddelande
        if(!isset($id)) {
            http_response_code(400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No Work ID is sent");
        //Om ID är skickad   
        } else {
            $data = json_decode(file_get_contents("php://input"));
            //checks if any value is empty
            if($data->company == "" || $data->startDate == "" || $data->endDate == "" || $data->title == "") {
                $response = array("message" => "Please send company name, start date, end date and title");
            } else {
                $Work->updateWork($data->company, $data->startDate, $data->endDate, $data->title, $id);
                http_response_code(200);
                $response = array("message" => "Post with Work ID: $id is updated");
            }
            
        }
        break;

    case 'DELETE':
        if(!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No Work ID is sent");  
        } else {

            $Work->deleteWork($id);
            http_response_code(200);
            $response = array("message" => "Post with Work ID $id is deleted");
        }
        break;
        
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);