<?php

class Subject 
{
    private $pdo;


    function __construct($pdo)
    {
        $this->pdo= $pdo;
    }


    function read($routeParams)
    {
        if ($routeParams !== null) {
            $id = $routeParams['id'];
            $query = "SELECT * FROM Subjects WHERE id_subject = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $query = "SELECT * FROM Subjects";
            $stmt = $this->pdo->prepare($query);
        }
    
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return "No Subject found with id {$id}";

        } else {
            return $data;
        }
    
    }
    

    function create(array $data) {

        
        $query = "INSERT INTO Subjects (name) 
        VALUES (:name)
        ";


        $stmt= $this->pdo-> prepare($query);
        $stmt->bindParam(":name", $data['name']);
        if ($stmt->execute()) {
            return true;

        };

    }

    function update($id_subject, array $data) {

        $query = ' UPDATE Subjects SET 
        name = :newname
        WHERE id_subject = :id_subject
        ';

        $stmt =  $this->pdo->prepare($query);

        $stmt->bindParam(':newname', $data['name']);
        $stmt->bindParam(':id_subject', $id_subject);

        if ($stmt->execute()) {
            return true;
        }




    }


    function delete($id_subject) {

        $query = ' DELETE FROM Subjects WHERE id_subject = :id_subject
        ';
        $stmt= $this->pdo->prepare($query);

        $stmt->bindParam(':id_subject', $id_subject);

        if ($stmt->execute()) {
            return true;
        }


    }

function exists ($id_subject) {
    $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM Subjects 
    WHERE id_subject = ?');
    $stmt->execute([$id_subject]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

}