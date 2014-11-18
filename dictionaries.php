<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$response = $client->getResource('/dictionaries/');
if ($response->code === 200) {    
    $dictionaryData = $response->data;
	$counter = 1;
	
    foreach ($dictionaryData['dictionaries'] as $dictionary) {
		print $counter . ") ". $dictionary['uid'] . ": " . $dictionary['label'] ."<br> \n";
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
