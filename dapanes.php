<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$response = $client->getResource('/search?org=10599&type=Β.1.3&size=100');
if ($response->code === 200) {    
    $unitData = $response->data;
	$sum = 0.0;
	$counter = 1;
	
    foreach ($unitData['decisions'] as $unit) {
		print $counter . ") ". $unit['subject'] . ": " . $unit['ada'] . " TYPE : " . $unit['decisionTypeId'] . ": ΠΟΣΟ : ". $unit['extraFieldValues']['amountWithVAT']['amount'] ." <br> \n";
		$kaeData = $unit['extraFieldValues']['amountWithKae'];
		//print_r($kaeData);
		foreach ($kaeData as $kae) {
			print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp KAE ". $kae['kae'] . " : ΠΟΣΟ " . $kae['amountWithVAT'] . " ΠΡΟΜΗΘΕΥΤΗΣ : ".  $kae['sponsorAFMName']['afm'] . " - " . $kae['sponsorAFMName']['name'] . "<br> \n";
			$sum += $kae['amountWithVAT'];
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
