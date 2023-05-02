<?php

class Course 
{
    private $pdo;


    function __construct($pdo)
    {
        $this->pdo= $pdo;
    }


    //// READ COURSES
        
        function select($params) {

            $query = "SELECT *,
        (SELECT JSON_ARRAYAGG(s.name) FROM Subjects s WHERE s.id_subject IN
            (SELECT cs.id_subject FROM CourseSubject cs WHERE cs.id_course = Courses.id)
        ) AS subjects
        FROM Courses";

        $query_params = array();
    
        if (!empty($params)) {
            $query .= " WHERE ";
    
            $conditions = array();
            $query_params_temp = array();
            foreach ($params as $key => $value) {
                if ($key === 'name') {
                    $conditions[] = "name LIKE ?";
                    $query_params_temp[] = "%$value%";
                } elseif ($key === 'id') {
                    $conditions[] = "id LIKE ?";
                    $query_params_temp[] = "%$value%";
                } elseif ($key === 'places_available') {
                    $conditions[] = "places_available >= ?";
                    $query_params_temp[] = $value;
                } elseif ($key === 'subjects') {
                    $subQuery = "SELECT id_course FROM CourseSubject WHERE id_subject IN (" . implode(',', array_fill(0, count($value), '?')) . ")";
                    $conditions[] = "id IN ($subQuery)";
                    $query_params_temp = array_merge($query_params_temp, $value);
                }
            }
    
            $query .= implode(" AND ", $conditions);
            $query_params = array_merge($query_params, $query_params_temp);
        }
    
      
    
        $stmt= $this->pdo->prepare($query);
    
        if (!empty($query_params)) {
            $stmt->execute($query_params);
        } else {
            $stmt->execute();
        }
    
        $results =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 0) {
            return "No courses found with these parameters";
        } else {
            foreach($results as &$result) {
                $result['subjects'] = json_decode($result['subjects']);
            
            }
            return $results;
        }
    }


        // CREATE NEW COURSE (USE id for subjects array)

    function create(array $data) {

        // new course into table Courses
        $query = "INSERT INTO Courses (name, places_available) 
        VALUES (:name, :places_available)
        ";
        $stmt= $this->pdo-> prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":places_available", $data['places_available'] );
        if ($stmt->execute()) {
            $course_id = $this->pdo->lastInsertId();
        } else {
            return false;
        }

        // add subjects into Subjects table and CourseSubject table

        foreach ($data['subjects'] as $value) {
            $id_subject= $value;

            // search subject into db 

            $stmt=$this->pdo->prepare('SELECT id_subject FROM Subjects
            WHERE id_subject=?');
            $stmt->execute([$id_subject]);
            $row= $stmt -> fetch(PDO::FETCH_ASSOC);

            // DOES SUBJECT  EXIST ?
            if(!$row){
               echo "No subject with this id: {$id_subject}";
            }
            

        
            /// ADD THE RELATION INTO THE TABLE
            $stmt=$this->pdo->prepare('INSERT INTO CourseSubject
            (id_course, id_subject) VALUES (?,?)');
            $stmt->execute([$course_id, $id_subject]);
            
            
        }

        return true;
        
    }


    function update($id, array $data) {



        $query = ' UPDATE Courses SET 
        name = :newname, places_available = :new_places_available
        WHERE id = :id
        ';

        $stmt =  $this->pdo->prepare($query);

        $stmt->bindParam(':newname', $data['name']);
        $stmt->bindParam(':new_places_available', $data['places_available']);
        $stmt->bindParam(':id', $id);
        $stmt-> execute();

        /// UPDATE SUBJECTS ASSOCIETED WITH THE COURSE

        $stmt= $this->pdo->prepare('DELETE FROM CourseSubject 
        WHERE id_course = :id');
        $stmt->bindParam(':id', $id);
        $stmt-> execute();


        $stmt=$this->pdo->prepare('INSERT INTO CourseSubject 
        (id_course, id_subject) VALUES (:id_course, :id_subject)');

        foreach($data['subjects'] as $value) {
          $stmt->execute([':id_course' => $id, ':id_subject' => $value]);

        }

        return true;


    }


    function delete($id) {
        $query = ' DELETE from Courses WHERE id = :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }


        
    }

    function exists ($id) {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM Courses 
        WHERE id = ?');
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }



}



/*


function select($params) {
    $query = "SELECT *,
        (SELECT JSON_ARRAYAGG(s.name) FROM Subject s WHERE s.subject_id IN
            (SELECT cs.id_subject FROM CourseSubject cs WHERE cs.id_course = Courses.id)
        ) AS subjects
        FROM Courses";

    $query_params = array();

    if (!empty($params)) {
        $query .= " WHERE ";

        $conditions = array();
        $query_params_temp = array();
        foreach ($params as $key => $value) {
            if ($key === 'name') {
                $conditions[] = "name LIKE ?";
                $query_params_temp[] = "%$value%";
            } elseif ($key === 'id') {
                $conditions[] = "id LIKE ?";
                $query_params_temp[] = "%$value%";
            } elseif ($key === 'places_available') {
                $conditions[] = "places_available >= ?";
                $query_params_temp[] = $value;
            } elseif ($key === 'subjects') {
                $subQuery = "SELECT id_course FROM CourseSubject WHERE id_subject IN (" . implode(',', array_fill(0, count($value), '?')) . ")";
                $conditions[] = "id IN ($subQuery)";
                $query_params_temp = array_merge($query_params_temp, $value);
            }
        }

        $query .= implode(" AND ", $conditions);
        $query_params = array_merge($query_params, $query_params_temp);
    }

    $stmt = $this->pdo->prepare($query);

    if (!empty($query_params)) {
        $stmt->execute($query_params);
    } else {
        $stmt->execute();
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        return "No courses found with these parameters";
    } else {
        return $results;
    }
}



*/ 