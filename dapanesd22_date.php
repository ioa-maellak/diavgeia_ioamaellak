<?php
require_once 'opendata.php';

	if ($_POST) {
	  $org = (int) $_POST['org'];
	}	
	
	else {
		print "<h2 style=\"color:red;\">ΠΡΕΠΕΙ ΝΑ ΟΡΙΣΕΤΕ ΕΝΑΝ ΟΡΓΑΝΙΣΜΟ</h2>";
		exit;
	}

	// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
	$client = new OpendataClient();
	$client->setAuth('apiuser_1', 'ApiUser@1');
	
	$pages = 0;
	$sum = 0.0;
	$counter = 1;
	$string = "/search?org=". $org . "&type=Δ.2.2&size=500&from_date=2011-01-01&page=". $pages;
	$response = $client->getResource($string);
	//$myfile = fopen("diavgeia.txt", "w") or die("Unable to open file!");
	if ($response->code === 200) { 

		$unitData = $response->data;
		$actual_size = 1;// $unitData['info']['actualSize'];
		
		while ($actual_size != 0) {    
		//echo $actual_size;
		foreach ($unitData['decisions'] as $unit) {
			echo $counter . "|". $unit['subject'] . "|" . $unit['ada'] . "|" . $unit['decisionTypeId'] . "|". gmdate("Y-m-d", $unit['submissionTimestamp']/1000). "|".  $unit['documentUrl'] . "\n<br>";
			$kaeData = $unit['extraFieldValues'];
			//print_r($kaeData);
			//print_r($kaeData);
			echo $kaeData['person'][0]['afm'] . "|" . $kaeData['person'][0]['name'] . "|" . $kaeData['awardAmount']['amount']. "\n<br>";			
			$sum += $kaeData['awardAmount']['amount'];
		
			$counter++;
		}

		 /*   
			print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Υπογράφοντες:<br>\n";
			foreach ($orgData['signers'] as $signer) {
				print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $signer['uid'] . ": " . $signer['lastName'] . " " . $signer['firstName'] . "<br>\n";
			}
		  */  
		  $pages++;
		  $string = "/search?org=". $org . "&type=Δ.2.2&size=500&from_date=2011-01-01&page=". $pages;
		  $response = $client->getResource($string);
		  $unitData = $response->data;
		  //echo "---" . $unitData['info']['actualSize'];
		  $actual_size = $unitData['info']['actualSize'];  
		  if ($actual_size == NULL)
			$actualSize = 1;
		   else if ($actual_size == 0)
			break;
		}

		print "<h2> ΣΥΝΟΛΙΚΟ ΠΟΣΟ : " . $sum . "€ </h2>";
	 /*   
		print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Υπογράφοντες:<br>\n";
		foreach ($orgData['signers'] as $signer) {
			print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $signer['uid'] . ": " . $signer['lastName'] . " " . $signer['firstName'] . "<br>\n";
		}
	  */  
	} else {
		echo "Error " . $response->code;
	}

