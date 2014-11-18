<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)

$client = new OpendataClient();
//$response = $client->getResource('/organizations/54321/details');
$response = $client->getResource('/types');
if ($response->code === 200) {    
    $orgData = $response->data;
    
    print $orgData['uid'] . ": " . $orgData['label'] . "\n";
    
    print "\nTYPOI DEDOMENON:\n";
    foreach ($orgData['decisionTypes'] as $unit) {
        print $unit['uid'] . ": " . $unit['label'] . "<br>\n";
    }
    
} else {
    echo "Error " . $response->code;
}

?>
