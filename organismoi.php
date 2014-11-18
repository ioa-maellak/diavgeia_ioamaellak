<?php
require_once 'opendata.php';

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$response = $client->getResource('/organizations/30/details');
if ($response->code === 200) {    
    $orgData = $response->data;
    
    print $orgData['uid'] . ": " . $orgData['label'] . ": ". $orgData['category'] . "<br> \n";
    
    print "&nbsp;&nbsp;&nbsp;&nbsp;Μονάδες:<br>\n";
    foreach ($orgData['units'] as $unit) {
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $unit['uid'] . ": " . $unit['label'] . ": " . $unit['category'] . "<br>\n";
    }
    
    print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Υπογράφοντες:<br>\n";
    foreach ($orgData['signers'] as $signer) {
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $signer['uid'] . ": " . $signer['lastName'] . " " . $signer['firstName'] . "<br>\n";
    }
    
} else {
    echo "Error " . $response->code;
}
