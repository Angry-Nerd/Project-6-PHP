<?php
$to  = "atulsagotra774@gmail.com";
$subject = "Request of the Medical Camp";
$headers = "From: esicare6@gmail.com";
function mailAllUsers($array){
	foreach($array as $a){
		$message = 'This request is from organistaionname from organisationaddress  with noofemployees. 
They have requested for a medical
camp in their organisation. We hospitalname from hospitaladdress 
have approved the request and selected the following doctors and staff members:- 

for loop list of all the doctors 
and  ESI Dispensary pharmaaddress will provide the medical
 support
Please confirm the medical camp by approving the confirmation.</p>';

$headers = "From: esicare6@gmail.com";
		mail($a['email'],$subject,$body,$headers);
	}
}

?> 