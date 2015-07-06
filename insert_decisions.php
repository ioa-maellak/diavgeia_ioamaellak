<?php
require_once 'opendata.php';
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$servername = "localhost";
$username = "admina52mVy5";
$password = "7j-fKsQtMaki";
$dbname = "diavgeia";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

			if (mysqli_query($conn, "set names utf8")) {
    			echo "LANGUAGE";
			} else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

	$client = new OpendataClient();
	$client->setAuth('apiuser_1', 'ApiUser@1');
	$string = "/search?org=99206915&type=Β.2.1&size=500&from_date=2014-01-01&page=0";
	$response = $client->getResource($string);
	if ($response->code === 200) {    
		$unitData = $response->data;
		$sum = 0.0;
		$counter = 1;
		
		foreach ($unitData['decisions'] as $unit) {
		
			$ada = $unit['ada'];
			$protocol = $unit['protocolNumber']; 
			$subject = $unit['subject']; 
			$issueDate = $unit['issueDate'];
			$decisionTypeId = $unit['decisionTypeId'];
			$orgId = $unit['organizationId'];
			$status =  $unit['status'];
			$checksum = $unit['documentChecksum'];

			$sql = "INSERT INTO apofaseis (ada, protocolNumber, subject, issueDate, decisionTypeId, organizationId, status, documentChecksum)
				VALUES ('$ada', '$protocolNumber', '$subject', $issueDate, '$decisionTypeId', $orgId, '$status', '$checksum')";
//VALUES ($unit['ada'], $unit['protocolNumber'], $unit['subject'], $unit['issueDate'], $unit['decisionTypeId'], $unit['organizationId'], $unit['status'], $unit['documentChecksum'])";

			if (mysqli_query($conn, $sql)) {
    			echo "New record created successfully";
			} else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			
			$kaeData = $unit['extraFieldValues']['sponsor'];
			//print_r($kaeData);
			foreach ($kaeData as $kae) {
				$afm = $kae['sponsorAFMName']['afm'];
				$name = $kae['sponsorAFMName']['name'];
				$amount = $kae['expenseAmount']['amount'];
				
				$sql = "INSERT INTO apofaseisb21 (ada, amount, sponsorAfm, sponsorName)
				VALUES ('$ada', $amount, '$afm', '$name')";
//VALUES ($unit['ada'], $unit['protocolNumber'], $unit['subject'], $unit['issueDate'], $unit['decisionTypeId'], $unit['organizationId'], $unit['status'], $unit['documentChecksum'])";

			if (mysqli_query($conn, $sql)) {
    			echo "B21 created successfully";
			} else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			}
				
			$counter++;
		}


	} else {
		echo "Error " . $response->code;
	}

mysqli_close($conn);
?>