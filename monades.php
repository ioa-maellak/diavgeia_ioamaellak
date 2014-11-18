<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$response = $client->getResource('/organizations/5006/units');
if ($response->code === 200) {    
    $unitData = $response->data;
	$counter = 1;
	
    foreach ($unitData['units'] as $unit) {
		print $counter . ") ". $unit['uid'] . ": " . $unit['label'] . ": ". $unit['category'] . " : ". $unit['parentId'] ."<br> \n";
		$counter++;
    }

 /*   
    print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Υπογράφοντες:<br>\n";
    foreach ($orgData['signers'] as $signer) {
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $signer['uid'] . ": " . $signer['lastName'] . " " . $signer['firstName'] . "<br>\n";
    }
  */  
} else {
    echo "Error " . $response->code;
}
