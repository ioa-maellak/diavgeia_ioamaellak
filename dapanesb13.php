<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$client->setAuth('apiuser_1', 'ApiUser@1');
$response = $client->getResource('/search?org=5006&type=Β.1.3&size=500&from_date=2014-01-01');
if ($response->code === 200) {    
    $unitData = $response->data;
	$sum = 0.0;
	$counter = 1;
	
    foreach ($unitData['decisions'] as $unit) {
		print $counter . ") ". $unit['subject'] . ": " . $unit['ada'] . " TYPE : " . $unit['decisionTypeId'] . ": ΠΟΣΟ : ". $unit['extraFieldValues']['amountWithVAT']['amount'] . " <a href=\"".  $unit['documentUrl'] . "\">Link</a> <br> \n";
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
