<?php



class CourseController {

    public function read() {

        
        $this->setHeaders('GET');

        $req=$this->startDb();
        
        
        $course= $req['course'];
        $params = $req['params'];

        $recordset = $course->select($params);
        

        if ($recordset !== false) {
            http_response_code(201);
            echo json_encode($recordset);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No courses found."));
        }
        
    }


    function create() {
        $this->setHeaders('POST');

        $req=$this->startDb();
        $course= $req['course'];
        $data= $req['data'];

        if (
            !empty($data['name']) && !empty($data['places_available'])
        ) {
            if ($course->create($data)) {
                http_response_code(201);
                echo json_encode(array("message" => "A new course has been added."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Course was not added."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Error: Data is missing."));
        }
    }


    function update() {

        $this->setHeaders('PUT');

        $req = $this->startDb();

        $course= $req['course'];
        $data= $req['data'];
        $id= $_GET['id'];

        if (!$id) {
            http_response_code(400);
            echo json_encode(array("message" => "Error: ID is missing."));
            exit;
        }

        if (!$course->exists($id)) {

            http_response_code(404);
            echo json_encode(array("message" => "Error: Course not found."));
            exit;   
        }

        if ($course->update($id,$data))  {
            http_response_code(200);
            echo json_encode(array("message" => "Course has been updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Course was not updated."));
        }
        
    }



    function delete() {
        $this->setHeaders('PUT');

        $req = $this->startDb();

        $course= $req['course'];
        $id= $_GET['id'];

        if (!$id) {
            http_response_code(400);
            echo json_encode(array("message" => "Error: ID is missing."));
            exit;
        }

        if (!$course->exists($id)) {

            http_response_code(404);
            echo json_encode(array("message" => "Error: Course not found."));
            exit;   
        }

        if ($course->delete($id))  {
            http_response_code(200);
            echo json_encode(array("message" => "Course has been deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Course was not deleted."));
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
        $params = $request->getQueryParams();
        
          

        $db = new Database();
       

        $pdo = $db->getConnection($config);
       

        $course= new Course($pdo);

        return ['course' => $course, 'data' => $data, 'params'=>$params];
    }


}
