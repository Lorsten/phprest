<?php
//Settings for header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

require_once('mainClass.php');
require('validate_input.php');
$db = new mainClass();

$method = $_SERVER['REQUEST_METHOD'];
$validate = new validateData();


// Using a switch method for GET,POST,PUT and DELETE
switch ($method) {
    case 'GET':
        //Get only one row from the table with a id
        if ($_GET['ID']) { {
                if (count($db->getSingleData($_GET['ID'])) > 0) {
                    echo $db->getSingleData($_GET['ID']);
                } else {
                    http_response_code(500);
                    echo json_encode(
                        array("message" => "No products found.")
                    );
                }
            }
        }
        // Else display all data from the db
        else {
            http_response_code(200);
            echo $db->getData();
        }
        break;
    case 'POST':
        // Set all the data from the url with validate class
        $data = json_decode(file_get_contents("php://input"));
        $validate->set_courseID($data->courseID);
        $validate->set_coursename($data->coursename);
        $validate->set_progression($data->progression);
        $validate->set_syllabus($data->courseSyllabus);

        // Check if the method insertData return true
        if ($db->insertData(
            $validate->get_courseID(),
            $validate->get_coursename(),
            $validate->get_progression(),
            $validate->get_courseSyllabus()
        )) {
            // Send code 200 and tell the course was added
            http_response_code(200);
            echo json_encode(array("message" => "Course added."));
        } else {
            // DIsplay error
            http_response_code(400);
            echo json_encode(array("message" => "Unable to add course."));
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $validate->set_courseID($data->courseID);
        $validate->set_coursename($data->coursename);
        $validate->set_progression($data->progression);
        $validate->set_syllabus($data->courseSyllabus);

        // Check if any value is null
        if($validate->checkforNull()){
        
        if($db->updateData($data->ID,
           $validate->get_courseID(),
           $validate->get_coursename(),
           $validate->get_progression(),
           $validate->get_courseSyllabus()
        )){
            http_response_code(200);
            echo json_encode(array("message" => "Course ".$validate->get_coursename()." updated"));
        }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to add course."));
        }
    }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to add course."));
        }

        break;
    case 'DELETE':
        // Validate courseID 
        $validate->set_courseID($_GET['courseID']);
        if ($db->deleteData($validate->get_courseID())) {
            http_response_code(200);
            echo json_encode(array("message" => "Course deleted."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to remove the course."));
        }
        break;
}
