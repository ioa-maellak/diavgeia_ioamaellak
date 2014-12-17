<?php
require_once 'opendata.php';

	if ($_POST) {
	  $afm = (int) $_POST['afm'];
	}	
	
	else {
		print "<h2 style=\"color:red;\">ΠΡΕΠΕΙ ΝΑ ΟΡΙΣΕΤΕ ΕΝΑΝ ΑΦΜ</h2>";
		exit;
	}

// ΕΚΤΥΠΩΣΗ ΠΛΗΡΟΦΟΡΙΩΝ ΦΟΡΕΑ (UID, ΕΠΩΝΥΜΙΑ, ΜΟΝΑΔΕΣ, ΥΠΟΓΡΑΦΟΝΤΕΣ)
$client = new OpendataClient();
$client->setAuth('apiuser_1', 'ApiUser@1');
$pages = 0;
$sum = 0.0;
$response = $client->getResource('/search?org=99206915&type=Β.2.1&size=250&from_date=2014-01-01&page=' .$pages);
$unitData = $response->data;
$actual_size = 1;// $unitData['info']['actualSize'];
$counter = 1;
while ($actual_size != 0) {    
//echo $actual_size;
	foreach ($unitData['decisions'] as $unit) {
		$kaeData = $unit['extraFieldValues']['sponsor'];
		//print_r($kaeData);
		foreach ($kaeData as $kae) {
			if (strcmp($kae['sponsorAFMName']['afm'], $afm) == 0) {
				print $counter . ") ". $unit['subject'] . ": " . $unit['ada'] . " TYPE : " . $unit['decisionTypeId'] . ": ΗΜΕΡΟΜΗΝΙΑ : ". gmdate("Y-m-d", $unit['submissionTimestamp']/1000). " <a href=\"".  $unit['documentUrl'] . "\">Link</a> <br> \n";
				print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp ΠΡΟΜΗΘΕΥΤΗΣ : '".  $kae['sponsorAFMName']['afm'] . "' - " . $kae['sponsorAFMName']['name'] . "<br> \n";
				print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp ΚΑΕ : " . $kae['cpv'] . " ΠΟΣΟ : " . $kae['expenseAmount']['amount'] . "<br> \n";
				$sum += $kae['expenseAmount']['amount'];
				$counter++;
			}
		}	
	}

 /*   
    print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Υπογράφοντες:<br>\n";
    foreach ($orgData['signers'] as $signer) {
        print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $signer['uid'] . ": " . $signer['lastName'] . " " . $signer['firstName'] . "<br>\n";
    }
  */  
  $pages++;
  $response = $client->getResource('/search?org=99206915&type=Β.2.1&size=250&from_date=2014-01-01&page=' .$pages);
  $unitData = $response->data;
  //echo "---" . $unitData['info']['actualSize'];
  $actual_size = $unitData['info']['actualSize'];  
  if ($actual_size == NULL)
	$actualSize = 1;
   else if ($actual_size == 0)
	break;
}
print "<h2> ΣΥΝΟΛΙΚΟ ΠΟΣΟ : " . $sum . "€ </h2>";
// else {
//    echo "Error " . $response->code;
//}
