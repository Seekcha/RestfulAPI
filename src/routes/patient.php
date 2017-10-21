<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;


// Update patient
$app->put('/api/patients/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $FirstName = $request->getParam('FirstName');
    $LastName = $request->getParam('LastName');
    $Gender = $request->getParam('Gender');
    $sql = "UPDATE patient SET
				FirstName 	= :FirstName,
				LastName 	= :LastName,
                Gender		= :Gender
			WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':FirstName', $FirstName);
        $stmt->bindParam(':LastName',  $LastName);
        $stmt->bindParam(':Gender',      $Gender);
        $stmt->execute();
        echo '{"notice": {"text": "Patient Updated"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add patient
$app->post('/api/patients/add', function(Request $request, Response $response){
	$id = $request->getParam('id');
    $firstName = $request->getParam('FirstName');
    $lastName = $request->getParam('LastName');
    $gender = $request->getParam('Gender');
   
    $sql = "INSERT INTO patient (id, firstName,lastName,Gender) VALUES
    (:id, :FirstName,:LastName,:Gender)";
   try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);
        $query->bindParam(':FirstName', $firstName);
        $query->bindParam(':LastName',  $lastName);
        $query->bindParam(':Gender',  $gender);

        $query->execute();
        echo '{"notice": {"text": "Data Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Delete patient
$app->delete('/api/patients/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM patient WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $query = $db->prepare($sql);
        $query->execute();
        $db = null;
        echo '{"notice": {"text": "patient Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// view all patients
$app->get('/api/patient', function(Request $request, Response $response){
	$sql = "SELECT * FROM patient";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $query = $db->query($sql);
        $patient = $query->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($patient);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Get search Patient
$app->get('/api/patients/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM patient WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        $query = $db->query($sql);
        $patient = $query->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($patient);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});