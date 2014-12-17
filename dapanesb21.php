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
	$string = "/search?org=". $org . "&type=Β.2.1&size=500&from_date=2014-01-01&page=0";
	$response = $client->getResource($string);
	if ($response->code === 200) {    
		$unitData = $response->data;
		$sum = 0.0;
		$counter = 1;
		
		foreach ($unitData['decisions'] as $unit) {
			print $counter . ") ". $unit['subject'] . ": " . $unit['ada'] . " TYPE : " . $unit['decisionTypeId'] . ": ΗΜΕΡΟΜΗΝΙΑ : ". gmdate("Y-m-d", $unit['submissionTimestamp']/1000). " <a href=\"".  $unit['documentUrl'] . "\">Link</a> <br> \n";
			$kaeData = $unit['extraFieldValues']['sponsor'];
			//print_r($kaeData);
			foreach ($kaeData as $kae) {
				print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp ΠΡΟΜΗΘΕΥΤΗΣ : ".  $kae['sponsorAFMName']['afm'] . " - " . $kae['sponsorAFMName']['name'] . "<br> \n";
				print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp ΚΑΕ : " . $kae['cpv'] . " ΠΟΣΟ : " . $kae['expenseAmount']['amount'] . "<br> \n";
				$sum += $kae['expenseAmount']['amount'];
			}	
			$counter++;
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

