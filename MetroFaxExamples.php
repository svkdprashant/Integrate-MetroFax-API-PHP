<?php

/*
    Created By : Prashant Jethwa
    Date       : 15th June, 2017
    Email      : codebucket.co@gmail.com
    Website    : http://code-bucket.co/
	Purpose	   : This file includes all working example of sending/receiving online fax via MetroFax API.

*/

include("MetroFax.class.php");      // Include MetroFax.class.php file

/* 	
	Create an object of MetroFax. Pass Login Id and password of MetroFax API
	Argument: Login Id, Password
*/
$objMetroFax = new MetroFax('codebucket.co@gmail.com', 'code@bucket123');

/*
	To send online fax via MetroFax API we have to first upload attachment / document on MetroFax Server. Only after uploading document on MetroFax server we can send it as an online fax.

*/

/* 
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ SEND FAX STARTS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	Upload a document on MetroFax server.
	Argument: File Path
*/
$strFilePath = 'LearnwithGoogle.pdf';
$strFileAttachmentId = $objMetroFax->uploadAttachment($strFilePath);

/* 
	Send uploaded document on fax number. This will return Fax Tracking Number. 
	Store it to database if you want to check status in future for the same.
	Arguments: Fax Number, File Attachment Id (which we got from uploadAttachment), Billing Code, Subject
*/
$strFaxNumber = '1(510)586-8243'; // Fax Number with country code
$strFaxSubject = 'This is Fax Subject';
$objSendFaxMessageResponse = $objMetroFax->sendFaxMessage($strFaxNumber,$strFileAttachmentId,'',$strFaxSubject);

/* 
	To check Fax Status using Tracking Number call function as below
	Argument: Tracking Number

	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ SEND FAX ENDS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
*/

/*
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ GET FAX STATUS STARTS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/
$strTrackingNumber = '2993688430';
$arrStatus = $objMetroFax->getGetFaxMessagesFromTrackingNumber($strTrackingNumber);
$intFaxStatus = $arrStatus['SearchMessageResults']['Items']['FaxMessage']['FaxStatus'];

/* 	
 	STATUS : 0 -> Sent, 2 -> Deleted, 3 -> Transmitting, 4 -> Pending

	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ GET FAX STATUS ENDS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/

/*
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ GET INBOUND FAXES STARTS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	To get Inbound Faxes call function as below
	Argument: Inbound Fax number
*/
$strInboundFaxNumber = '5105868243';
$arrInBoundFaxes = $objMetroFax->listInboundFax($strInboundFaxNumber);

/*
	To get Inbound Fax documents and store in your drive
	Argument: Fax ID, Path (where you want to store inbound documents)
	You will get Fax ID in response of listInboundFax
*/
$strFaxId = '208260364283';
$strInBoundFaxPath = '/var/www/html/MetroFax/';
$arrDocuments = $objMetroFax->getFaxImageData($strFaxId,$strInBoundFaxPath);

file_put_contents($strInBoundFaxPath.$strFaxId.".".$objMetroFax->FileType,base64_decode($arrDocuments['ResultString']));

/*
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ GET INBOUND FAXES ENDS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/

?>
