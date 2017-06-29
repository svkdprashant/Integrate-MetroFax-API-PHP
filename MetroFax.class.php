<?php

/*
    Created By : Prashant Jethwa
    Date       : 15th June, 2017
    Email      : codebucket.co@gmail.com
    Website    : http://code-bucket.co/
 *  
 *
 *  -> Created MetroFax class.
 *
 *      This class will content below functions
            1. Constructor
            2. uploadAttachment
            3. sendFaxMessage
            4. getGetFaxMessagesFromTrackingNumber
            5. curlPost
            6. getTransmissionStatus
 *          7. convertXMLtoArray
            8. convertXMLtoArray
            9. listInboundFax
            10. getFaxImageData
 * 
 *
 *  1. Constructor: Store LoginId, Password and SoapClient object in variable.
 *
 *  2. uploadAttachment function
 *
 *      ARGUMENT: File Path.
 *
 *      2.1 Store loginId, Password, File Path, and Base64 encode string in $arrUploadAttachment array.
 *
 *      2.2 Call UploadAttachment method and store response in $objResponseUpload
 *
 *      2.3 Store Result code in $intResultCode
 *
 *          2.3.1 If result code is 0 then get File Reference Id and return it.
 *
 *      RESPONSE OBJECT PATTERN:
 *
 *          stdClass Object
 *           (
 *               [UploadAttachmentResult] => stdClass Object
 *                   (
 *                       [ResultString] => 47f53dde-ca06-4465-8395-ab60dd25965d
 *                       [ResultCode] => 0
 *                   )
 *
 *           )
 *
 *  3. sendFaxMessage function
 *
 *      ARGUMENT: Fax Number, File Reference Id, Billing Code, Subject
 *
 *      3.1 Store FaxNumber, Name, Company and VoiceNumber in $arrFaxDetails
 *
 *      3.2 Store FaxRecipient in $arrFaxRecipient.
 *
 *      3.3 Store Id in $arrFileRefereId and store FileRef in $arrAttachment
 *
 *      3.4 Store loginId, password, subject, message, recipients, attachment, coverPageInfo and billingCode in $arrSendFax array.
 *
 *      3.5 Call sendFaxMessage method and return response.
 *
 *      RESPONSE OBJECT PATTERN:
 *
 *          stdClass Object
 *           (
 *               [SendFaxMessageResult] => stdClass Object
 *                   (
 *                       [ResultCode] => 0
 *                       [TotalRecords] => 1
 *                       [Count] => 1
 *                       [Items] => stdClass Object
 *                           (
 *                               [FaxMessage] => stdClass Object
 *                                   (
 *                                       [FaxID] => -1
 *                                       [TrackingNumber] => 2993688430
 *                                       [FaxType] => 2
 *                                       [FaxStatus] => 4
 *                                       [TransmitDate] => 0001-01-01T00:00:00
 *                                       [Viewed] =>
 *                                       [PageCount] => 0
 *                                       [CostPerUnit] => 0.03
 *                                       [FaxNumber] => 15105868243
 *                                       [EmailAddress] => codebucket.co@gmail.com
 *                                       [SenderOrRecipient] =>
 *                                       [Subject] =>
 *                                       [RemoteNumber] =>
 *                                       [RemoteCSID] =>
 *                                       [RemoteANI] =>
 *                                       [Destination] => 15105868243
 *                                       [ToName] =>
 *                                       [ToCompany] =>
 *                                       [ScheduledDate] => 1753-01-01T00:00:00
 *                                       [BillingCode] =>
 *                                       [TransactStatus] => 0
 *                                       [IsSpam] =>
 *                                   )
 *
 *                           )
 *
 *                   )
 *
 *           )
 *
 *  4. getGetFaxMessagesFromTrackingNumber function
 *
 *      ARGUMENT: Tracking Number
 *
 *      4.1 Store loginId, password and tracking number in $arrTrackFax array.
 *
 *      4.2 Build query. By Building a query we will get array in string with '&' seperated
 *
 *      4.3 Store URL and call curlPost function to post $arrTrackFax array. Store response in $strXMLResponse
 *
 *      4.4 Call convertXMLtoArray function to convert XML response in array and return it.
 *
 *      RESPONSE OBJECT PATTERN:
 *
 *              stdClass Object
 *               (
 *                   [SearchMessageResults] => stdClass Object
 *                       (
 *                           [ResultCode] => 0
 *                           [TotalRecords] => 0
 *                           [Count] => 1
 *                           [Items] => stdClass Object
 *                               (
 *                                   [FaxMessage] => stdClass Object
 *                                       (
 *                                           [FaxID] => 208260364283
 *                                           [TrackingNumber] => 2993688430
 *                                           [FaxType] => 1
 *                                           [FaxStatus] => 0
 *                                           [TransmitDate] => 2012-12-25T10:34:49.787
 *                                           [Viewed] => true
 *                                           [PageCount] => 1
 *                                           [CostPerUnit] => 0.03
 *                                           [FaxNumber] => 15105868243
 *                                           [EmailAddress] => codebucket.co@gmail.com
 *                                           [SenderOrRecipient] => 1234567891
 *                                           [Subject] => stdClass Object
 *                                               (
 *                                              )
 *
 *                                           [RemoteNumber] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [RemoteCSID] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [RemoteANI] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [Destination] => 15105868243
 *                                           [ToName] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [ToCompany] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [ScheduledDate] => 0001-01-01T00:00:00
 *                                           [BillingCode] => stdClass Object
 *                                               (
 *                                               )
 *
 *                                           [TransactStatus] => 0
 *                                           [IsSpam] => false
 *                                       )
 *
 *                               )
 *
 *                       )
 *               )
 *
 *
 *  5. curlPost function
 *
 *      ARGUMENT: Buide query, post URL
 *
 *      5.1 Init Curl and Set required variable for Curl.
 *
 *      5.2 Execute Curl and close it.
 *
 *      5.3 return result
 *
 *  6. getTransmissionStatus function
 *
 *      ARGUMENT: Fax Id
 *
 *      6.1 Store loginId, password and fax id in $arrGetTransmissionStatus array.
 *
 *      6.2 Build a query and set post URL
 *
 *      6.3 Call curlPost function. Store response in $strXMLResponse
 *
 *      6.4 Call convertXMLtoArray function to convert response from XML to array. Return it.
 *
 *  7. reSendFax function
 *
 *      ARGUMENT: Fax Id
 *
 *      7.1 Store login Id. password and fax id in $arrReSend
 *
 *      7.2 Build a query and set post URL.
 *
 *      7.3 Ca;; curlpost function. Store request in $strXMLResponse
 *
 *      7.4 Call convertXMLtoArray function to convert response from XML to array. Return it.
 *
 *
 *  8. convertXMLtoArray function
 *
 *      ARGUMENT: Content, attributs, priority\

    9. listInboundFax function
 
        ARGUMENT: Inbound Fax Number

    10. getFaxImageData function

 *      ARGUMENT: FaxId, FilePath
 * 
 */


// Create MetroFax class.
class MetroFax
{
    public $LoginId;            // LoginId Public Variable
    public $Password;           // Password Public Variable
    public $SoapClientObj;      // SoapClientObj Public Variable

    public $StartDateForInboundFax;
    public $EndDateForInboundFax;
    public $StartRecordForInboundFax;
    public $MaxRecordForInboundFax;
    public $FileType;


    /*
     *  1. Constructor: Store LoginId, Password and SoapClient object in variable.
     */
    public function  __construct($strLoginIdMetrofax, $strLoginPasswordMetrofax)
    {

        if($strLoginIdMetrofax != "" && $strLoginPasswordMetrofax != "")
        {
            $this->LoginId = $strLoginIdMetrofax;
            $this->Password = $strLoginPasswordMetrofax;
        }
        else
        {
            echo "Please enter login id and password for fax.";
            die;
        }
        
        $this->StartDateForInboundFax = date("m-d-Y", strtotime(date("m/d/Y") .' -1 day'));
        $this->EndDateForInboundFax = date("m-d-Y");
        $this->StartRecordForInboundFax = 1;
        $this->MaxRecordForInboundFax = 1000;
        $this->FileType = "TIFF";
        
        $this->SoapClientObj = new SoapClient("https://wsf.metrofax.com/webservice.asmx?wsdl");
    }


    // 2. uploadAttachment function
	public function uploadAttachment($strFile)
	{
        $strFileId = "";

        // 2.1 Store loginId, Password, File Path, and Base64 encode string in $arrUploadAttachment array.
		$arrUploadAttachment['loginId']     =   $this->LoginId;

        $arrUploadAttachment['password']    =   $this->Password;

        $arrUploadAttachment['fileName']    =   $strFile;
        
        $arrUploadAttachment['base64EncodedString'] = base64_encode(file_get_contents($strFile));

        // 2.2 Call UploadAttachment method and store response in $objResponseUpload
        $objResponseUpload =  $this->SoapClientObj->UploadAttachment($arrUploadAttachment);

        // 2.3 Store Result code in $intResultCode
        $intResultCode = $objResponseUpload->UploadAttachmentResult->ResultCode;

        if($intResultCode == 0)
        {
            $strFileId  =   $objResponseUpload->UploadAttachmentResult->ResultString;
            return $strFileId ;
        }
        else
        {
            return '';
        }
	}


    // 3. sendFaxMessage function
    public function sendFaxMessage($strFaxNumber,$strFileReferanceId,$strBillingCode = '',$strSubject = '')
    {

        //  3.1 Store FaxNumber, Name, Company and VoiceNumber in $arrFaxDetails
        $arrFaxDetails['FaxNumber'] = $strFaxNumber;
        $arrFaxDetails['Name']      = "";
        $arrFaxDetails['Company']   = "";
        $arrFaxDetails['VoiceNumber'] = "";

        // 3.2 Store FaxRecipient in $arrFaxRecipient.
        $arrFaxRecipient['FaxRecipient'] = $arrFaxDetails;

        /*
         *  3.3 Store Id in $arrFileRefereId and store FileRef in $arrAttachment
         */
        $arrFileRefereId['Id'] = $strFileReferanceId;

        $arrAttachment['FileRef']   =   $arrFileRefereId;


        // 3.4 Store loginId, password, subject, message, recipients, attachment, coverPageInfo and billingCode in $arrSendFax array.
        $arrSendFax['loginId'] = $this->LoginId;
        $arrSendFax['password'] = $this->Password;
        $arrSendFax['subject'] = $strSubject;
        $arrSendFax['message'] = "";
        $arrSendFax['recipients'] = $arrFaxRecipient;
        $arrSendFax['attachments'] = $arrAttachment;
        $arrSendFax['coverPageInfo'] = "";
        $arrSendFax['billingCode'] = $strBillingCode;


        /*
         *  3.5 Call sendFaxMessage method and return response.
         */
        $objSendFaxResponse = $this->SoapClientObj->sendFaxMessage($arrSendFax);
        return $objSendFaxResponse;
    }


    // 4. getGetFaxMessagesFromTrackingNumber function
    public function getGetFaxMessagesFromTrackingNumber($strTrackingNumber)
    {
        // 4.1 Store loginId, password and tracking number in $arrTrackFax array.
        $arrTrackFax['loginId'] = $this->LoginId;
        $arrTrackFax['password'] = $this->Password;
        $arrTrackFax['trackingNumber'] = $strTrackingNumber;


        // 4.2 Build query. By Building a query we will get array in string with '&' seperated
 
        $strTrackFaxHttpBuildQuery = http_build_query($arrTrackFax,'','&');

        // 4.3 Store URL and call curlPost function to post $arrTrackFax array. Store response in $strXMLResponse
        $strURL = "https://wsf.metrofax.com/webservice.asmx/GetFaxMessagesFmTrkNbr";

        $strXMLResponse = $this->curlPost($strTrackFaxHttpBuildQuery,$strURL);

        // 4.4 Call convertXMLtoArray function to convert XML response in array and return it.
        return $this->convertXMLtoArray($strXMLResponse, 1,  'tag');
        
    }

    
    // 5. curlPost function
    public function curlPost($arrBuildQuery, $strURL)
    {
        // 5.1 Init Curl and Set required variable for Curl.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strURL); // set url to post to

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrBuildQuery);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        // 5.2 Execute Curl and close it.
        $result = curl_exec($ch); // run the whole process
        curl_close($ch);

        // 5.3 return result
        return $result;
    }

    // 6. getTransmissionStatus function
    public function getTransmissionStatus($intFaxId)
    {

        //  6.1 Store loginId, password and fax id in $arrGetTransmissionStatus array.
        $arrGetTransmissionStatus['loginId'] = $this->LoginId;
        $arrGetTransmissionStatus['password'] = $this->Password;
        $arrGetTransmissionStatus['faxId'] = $intFaxId;

        // 6.2 Build a query and set post URL
        $strBuildQuery = http_build_query($arrGetTransmissionStatus,'','&');

        $strURL = "https://wsf.metrofax.com/webservice.asmx/GetTransmissionStatus";

        // 6.3 Call curlPost function. Store response in $strXMLResponse
        $strXMLResponse = $this->curlPost($strBuildQuery,$strURL);

        //  6.4 Call convertXMLtoArray function to convert response from XML to array. Return it.
        return $this->convertXMLtoArray($strXMLResponse, 1,  'tag');
    }

    // 7. reSendFax function
    public function reSendFax($intFaxId)
    {
        if(!empty($intFaxId))
        {
            // 7.1 Store login Id. password and fax id in $arrReSend
            $arrReSend['loginId'] = $this->LoginId;
            $arrReSend['password'] = $this->Password;
            $arrReSend['faxId'] = $intFaxId;

            // 7.2 Build a query and set post URL.
            $strReSendBuild = http_build_query($arrReSend,'','&');

            $strURL = "https://wsf.metrofax.com/webservice.asmx/ResendFax";

            // 7.3 Call curlpost function. Store request in $strXMLResponse
            $strXMLResponse = $this->curlPost($strReSendBuild,$strURL);

            // 7.4 Call convertXMLtoArray function to convert response from XML to array. Return it.
            return $this->convertXMLtoArray($strXMLResponse, 1,  'tag');
        }
    }

    // 8. convertXMLtoArray function
	function convertXMLtoArray($contents, $get_attributes=1, $priority = 'tag') 
	{
		 
		if(!$contents) return array();

		if(!function_exists('xml_parser_create')) {
			//print "'xml_parser_create()' function not found!";
			return array();
		}

		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);

		if(!$xml_values) return;//Hmm...

		//Initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();

		$current = &$xml_array; //Refference

		//Go through the tags.
		$repeated_tag_index = array();//Multiple tags with same name will be turned into an array
		foreach($xml_values as $data) {
			unset($attributes,$value);//Remove existing values, or there will be trouble

			//This command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data);//We could use the array by itself, but this cooler.

			$result = array();
			$attributes_data = array();
			
			if(isset($value)) {
				if($priority == 'tag') $result = $value;
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			}

			//Set the attributes too.
			if(isset($attributes) and $get_attributes) {
				foreach($attributes as $attr => $val) {
					if($priority == 'tag') $attributes_data[$attr] = $val;
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
				}
			}

			//See tag status and do the needed.
			if($type == "open") {//The starting of the tag '<tag>'
				$parent[$level-1] = &$current;
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
					$current[$tag] = $result;
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
					$repeated_tag_index[$tag.'_'.$level] = 1;

					$current = &$current[$tag];

				} else { //There was another element with the same tag name

					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						$repeated_tag_index[$tag.'_'.$level]++;
					} else {//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2;
						
						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr'];
							unset($current[$tag.'_attr']);
						}

					}
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
					$current = &$current[$tag][$last_item_index];
				}

			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
				//See if the key is already taken.
				if(!isset($current[$tag])) { //New Key
					$current[$tag] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 1;
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

				} else { //If taken, put all things inside a list(array)
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

						// ...push the new element into that array.
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						
						if($priority == 'tag' and $get_attributes and $attributes_data) {
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag.'_'.$level]++;

					} else { //If it is not an array...
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1;
						if($priority == 'tag' and $get_attributes) {
							if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
								
								$current[$tag]['0_attr'] = $current[$tag.'_attr'];
								unset($current[$tag.'_attr']);
							}
							
							if($attributes_data) {
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
					}
				}

			} elseif($type == 'close') { //End of tag '</tag>'
				$current = &$parent[$level-1];
			}
		}
		
		return($xml_array);
	}

    /*
     * 9. listInboundFax
     *     Argument: InBound Fax Number. (Metrofax number)
     *     -> This will list all in bound faxes. By this we will get FaxId and using it we can download InBound fax.
     *
     */
    function listInboundFax($strInboundFaxNumber)
    {
        $arrInbondFaxDetails = array();

        $arrInbondFaxDetails['loginId']     =   $this->LoginId;
        $arrInbondFaxDetails['password']    =   $this->Password;
        $arrInbondFaxDetails['faxNumber']   =   $strInboundFaxNumber;
        $arrInbondFaxDetails['startDate']   =   $this->StartDateForInboundFax;
        $arrInbondFaxDetails['endDate']     =   $this->EndDateForInboundFax;
        $arrInbondFaxDetails['startRecord'] =   $this->StartRecordForInboundFax;
        $arrInbondFaxDetails['maxRecords']  =   $this->MaxRecordForInboundFax;
        $arrInbondFaxDetails['allNumbers']  =   'false';

        $strInBoundFaxBuildQuery = http_build_query($arrInbondFaxDetails,'','&');

        $strURL = "https://wsf.metrofax.com/webservice.asmx/ListInbound";

        $strInboundXMLResponse = $this->curlPost($strInBoundFaxBuildQuery,$strURL);

        $arrInboundFaxes = $this->convertXMLtoArray($strInboundXMLResponse, 1,  'tag');
        
        return $arrInboundFaxes["SearchResults"];
    }

    /*
     * 10. getFaxImageData
     *     Argument: FaxId, FilePath
     *     -> By using this function we will get InBound fax document data.
     */
    function getFaxImageData($strFaxId,$strFilePath)
    {
        $arrDocument = array();
        $arrFileDoesNotExists = array();

        $strFileName = $strFilePath."\\".$strFaxId.".".$this->FileType;
        
        if(!file_exists($strFileName))
        {
            $arrDocument['loginId']     =   $this->LoginId;
            $arrDocument['password']    =   $this->Password;
            $arrDocument['faxId']       =   $strFaxId;
            $arrDocument['imageFormat'] =   $this->FileType;
            $arrDocument['markAsRead']  =   'true';

            $arrDocumentBuildQuery = http_build_query($arrDocument,'','&');

            $strURL = "https://wsf.metrofax.com/webservice.asmx/GetFaxImageData";

            $strDocumentResponse = $this->curlPost($arrDocumentBuildQuery,$strURL);

            $arrInboundDocument = $this->convertXMLtoArray($strDocumentResponse, 1,  'tag');

            return $arrInboundDocument["FaxImageData"];
        }
        else
        {
            $arrFileDoesNotExists["ResultCode"] = -1;
            $arrFileDoesNotExists["ErrorMessage"] = "File already exists for faxID: ".$strFaxId;
        
            return $arrFileDoesNotExists;
        }
    }

}

?>
