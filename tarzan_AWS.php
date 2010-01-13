<?php
//API reference is @ 	http://tarzan-aws.com/docs/2.0/files/aaws-class-php.html
//								http://tarzan-aws.com/docs/2.0/files/aaws-class-php.html#AmazonAAWS.__construct
//public function item_search
//( 
//	$keywords,     
//	$opt  =  null, 
//	$locale  =  AAWS_LOCALE_US 
//) 


// Include the main Tarzan class
require_once('tarzan/tarzan.class.php');
 
// Set the headers to plain text with a UTF-8 character set (so that we can read the output more easily).
header('Content-type: text/html; charset=utf-8');
 
// Instantiate a new AmazonAAWS object.
 $aws = new AmazonAAWS(); 

 // reference: http://tarzan-aws.com/docs/2.0/files/aaws-class-php.html#AmazonAAWS.item_search
$result = $aws->item_search("Cocoa Programming"); 
 
// Check that the last request was successful. (HTTP status code 200 means everything was okay.)
if ($result->isOK())
{
	print_r($result); 
}
// If not, explode horribly.
else
{
	print_r($create);
	exit('Ka-BOOM!');
}
 
?>