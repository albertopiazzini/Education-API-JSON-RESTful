<?php

class SubjectController 
{


    function read () {
          
        $this->setHeaders('GET');

        $req=$this->startDb();
        
        
        $subject= $req['subject'];
        
        

        $recordset = $subject->selectAll();
        

        if ($recordset !== false) {
            http_response_code(201);
            echo json_encode($recordset);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No subjects found."));
        }
    }

    function create() {
        $this->setHeaders('POST');

        $req=$this->startDb();
        $subject= $req['subject'];
        $data= $req['data'];

        if (
            !empty($data['name']) 
        ) {
            if ($subject->create($data)) {
                http_response_code(201);
                echo json_encode(array("message" => "A new subject has been added."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Subject was not added."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Error: Data is missing."));
        }
    }

    function update() {

        $this->setHeaders('PUT');

        $req = $this->startDb();

        $subject= $req['subject'];
        $data= $req['data'];
        $id = $_GET['id'];

        if (!$id) {
            http_response_code(400);
            echo json_encode(array("message" => "Error: ID is missing."));
            exit;
        }

        if (!$subject->exists($id)) {

            http_response_code(404);
            echo json_encode(array("message" => "Error: subject not found."));
            exit;   
        }

        if ($subject->update($id,$data))  {
            http_response_code(200);
            echo json_encode(array("message" => "Subject has been updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Subject was not updated."));
        }
        
    }

    function delete () {

        $this->setHeaders('DELETE');

        $req = $this->startDb();

        $subject= $req['subject'];
        $data= $req['data'];
        $id = $_GET['id'];

        if (!$id) {
            http_response_code(400);
            echo json_encode(array("message" => "Error: ID is missing."));
            exit;
        }

        if (!$subject->exists($id)) {

            http_response_code(404);
            echo json_encode(array("message" => "Error: subject not found."));
            exit;   
        }

        if ($subject->delete($id))  {
            http_response_code(200);
            echo json_encode(array("message" => "Subject has been deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Subject was not deleted."));
        }


    }








    protected function setHeaders($method)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: {$method}");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    

    protected function startDb() 
    {
        include_once 'core/bootstrap.php';
        
        $request = new Request;
        $data = $request->getBody();
        
          

        $db = new Database();
       

        $pdo = $db->getConnection($config);
       

        $subject= new Subject($pdo);

        return ['subject' => $subject, 'data' => $data];
    }
}