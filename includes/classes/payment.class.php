<?
class Payment{
    function __construct(){
        global $db;
        $this->db = $db;		//database constructor
    }

	function inittransaction($param){		
		// Initiate Step One: Now that we've collected the non-sensitive customer information, 
		// we can combine other customer information and build the XML format.
		$xmlRequest = new DOMDocument('1.0','UTF-8');

		$xmlRequest->formatOutput = true;
		$xmlSale = $xmlRequest->createElement('sale');

		// Authentication, Redirect-URL  are typically the bare minimum.
		$this->appendXmlNode($xmlRequest, $xmlSale, 'api-key', APIKey);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'redirect-url', $_SERVER['HTTP_REFERER']);
		
		if($param['selfie'] == 1)
			$this->appendXmlNode($xmlRequest, $xmlSale, 'amount', selfieAmount);
		else
			$this->appendXmlNode($xmlRequest, $xmlSale, 'amount', transAmount);

		// Some additonal fields may have been previously decided by user
		//$this->appendXmlNode($xmlRequest, $xmlSale, 'merchant-defined-field-1', md5($param['password']));
		//appendXmlNode($xmlRequest, $xmlSale, 'merchant-defined-field-2', 'Medium');
		
		// Set the Billing & Shipping from what was collected on initial shopping cart form
		$xmlBillingAddress = $xmlRequest->createElement('billing');
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'first-name', $param['firstname']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'last-name', $param['lastname']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'address1', $param['address1']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'city', $param['city']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'state', $param['state']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'postal', $param['zipcode']);
		//billing-address-email
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'country', $param['billing-address-country']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'email', $param['emailaddress']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'phone', $param['billing-address-phone']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'company', $param['billing-address-company']);
		$xmlSale->appendChild($xmlBillingAddress);

		$xmlShippingAddress = $xmlRequest->createElement('shipping');
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'first-name', $param['firstname']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'last-name', $param['lastname']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'address1', $param['address1']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'city', $param['city']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'state', $param['state']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'postal', $param['zipcode']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'country', $param['shipping-address-country']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'address2', $param['shipping-address-address2']);
		$xmlSale->appendChild($xmlShippingAddress);
		
		$xmladdcustomer = $xmlRequest->createElement('add-customer');
		$this->appendXmlNode($xmlRequest, $xmladdcustomer, 'customer-vault-id' , $param['id']);
		$xmlSale->appendChild($xmladdcustomer);
		
		$xmlRequest->appendChild($xmlSale);

		// Process Step One: Submit all customer details to the Payment Gateway except the customer's sensitive payment information.
		// The Payment Gateway will return a variable form-url.
		$data = $this->sendXMLviaCurl($xmlRequest, gatewayURL);

		// Parse Step One's XML response
		$gwResponse = @new SimpleXMLElement($data);
		if ((string)$gwResponse->result ==1 ) {
			// The form url for used in Step Two below
			$formURL = $gwResponse->{'form-url'};
		} else {
			throw New Exception(print " Error, received " . $data);
		}	
		
		return $formURL;
	}
	
	function completetransaction($tokenId){
		// Step Three: Once the browser has been redirected, we can obtain the token-id and complete
		// the Customer Vault Add through another XML HTTPS POST including the token-id which abstracts the
		// sensitive payment information that was previously collected by the Payment Gateway.;
		$xmlRequest = new DOMDocument('1.0','UTF-8');
		$xmlRequest->formatOutput = true;
		$xmlCompleteTransaction = $xmlRequest->createElement('complete-action');
		$this->appendXmlNode($xmlRequest, $xmlCompleteTransaction, 'api-key', APIKey);
		$this->appendXmlNode($xmlRequest, $xmlCompleteTransaction, 'token-id', $tokenId);
		$xmlRequest->appendChild($xmlCompleteTransaction);

		// Process Step Three
		$data = $this->sendXMLviaCurl($xmlRequest, gatewayURL);
		$gwResponse = @new SimpleXMLElement((string)$data);			
		
		return $gwResponse;
	}
	
	function validatetransaction($vaultid){
		$xmlRequest = new DOMDocument('1.0','UTF-8');

		$xmlRequest->formatOutput = true;
		$xmlSale = $xmlRequest->createElement('update-customer');

		// Authentication, Redirect-URL  are typically the bare minimum.
		$this->appendXmlNode($xmlRequest, $xmlSale, 'api-key', APIKey);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'redirect-url', $_SERVER['HTTP_REFERER']);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'customer-vault-id', $vaultid);
		
		$xmlRequest->appendChild($xmlSale);
		$data = $this->sendXMLviaCurl($xmlRequest, gatewayURL);

		// Parse Step One's XML response
		$gwResponse = @new SimpleXMLElement($data);			
		
		// Complete the request
		$tokenid = substr((string)$gwResponse->{'form-url'}, -8 , 8);
		$data	 = $this->completetransaction($tokenid);
		return $data;
	}
	
	function edittransaction($param){		
		// Initiate Step One: Now that we've collected the non-sensitive customer information, 
		// we can combine other customer information and build the XML format.
		$xmlRequest = new DOMDocument('1.0','UTF-8');

		$xmlRequest->formatOutput = true;
		$xmlSale = $xmlRequest->createElement('validate');

		// Authentication, Redirect-URL  are typically the bare minimum.
		$this->appendXmlNode($xmlRequest, $xmlSale, 'api-key', APIKey);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'redirect-url', $_SERVER['HTTP_REFERER']);

		// Some additonal fields may have been previously decided by user
		$this->appendXmlNode($xmlRequest, $xmlSale, 'merchant-defined-field-1', md5($param['password']));
		//appendXmlNode($xmlRequest, $xmlSale, 'merchant-defined-field-2', 'Medium');
		
		// Set the Billing & Shipping from what was collected on initial shopping cart form
		$xmlBillingAddress = $xmlRequest->createElement('billing');
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'first-name', $param['firstname']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'last-name', $param['lastname']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'address1', $param['address1']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'city', $param['city']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'state', $param['state']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'postal', $param['zipcode']);
		//billing-address-email
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'country', $param['billing-address-country']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'email', $param['emailaddress']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'phone', $param['billing-address-phone']);
		$this->appendXmlNode($xmlRequest, $xmlBillingAddress,'company', $param['billing-address-company']);
		$xmlSale->appendChild($xmlBillingAddress);

		$xmlShippingAddress = $xmlRequest->createElement('shipping');
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'first-name', $param['firstname']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'last-name', $param['lastname']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'address1', $param['address1']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'city', $param['city']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'state', $param['state']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'postal', $param['zipcode']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'country', $param['shipping-address-country']);
		$this->appendXmlNode($xmlRequest, $xmlShippingAddress,'address2', $param['shipping-address-address2']);
		$xmlSale->appendChild($xmlShippingAddress);
		
		$xmladdcustomer = $xmlRequest->createElement('update-customer');
		$this->appendXmlNode($xmlRequest, $xmladdcustomer, 'customer-vault-id' , $param['vaultid']);
		$xmlSale->appendChild($xmladdcustomer);
		
		$xmlRequest->appendChild($xmlSale);

		// Process Step One: Submit all customer details to the Payment Gateway except the customer's sensitive payment information.
		// The Payment Gateway will return a variable form-url.
		$data = $this->sendXMLviaCurl($xmlRequest, gatewayURL);

		// Parse Step One's XML response
		$gwResponse = @new SimpleXMLElement($data);
		if ((string)$gwResponse->result ==1 ) {
			// The form url for used in Step Two below
			$formURL = $gwResponse->{'form-url'};
		} else {
			throw New Exception(print " Error, received " . $data);
		}	
		
		return $formURL;
	}
	
	function recurringtransaction($vaultid){		
		// Initiate Step One: Now that we've collected the non-sensitive customer information, 
		// we can combine other customer information and build the XML format.
		$xmlRequest = new DOMDocument('1.0','UTF-8');

		$xmlRequest->formatOutput = true;
		$xmlSale = $xmlRequest->createElement('sale');

		// Authentication, Redirect-URL  are typically the bare minimum.
		$this->appendXmlNode($xmlRequest, $xmlSale, 'api-key', APIKey);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'redirect-url', $_SERVER['HTTP_REFERER']);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'amount', transAmount);
		$this->appendXmlNode($xmlRequest, $xmlSale, 'customer-vault-id', $vaultid);		
		
		$xmlRequest->appendChild($xmlSale);

		// Process Step One: Submit all customer details to the Payment Gateway except the customer's sensitive payment information.
		// The Payment Gateway will return a variable form-url.
		$data = $this->sendXMLviaCurl($xmlRequest, gatewayURL);

		// Parse Step One's XML response
		$gwResponse = @new SimpleXMLElement($data);
		return $gwResponse;
	}	
	
	function executetransaction($tokenid, $amount){				
		$gwResponse = $this->completetransaction($tokenid);
		
		if ((string)$gwResponse->result == 1 ) {
			print " <p><h3> Thank you for your Purchase</h3></p>\n";
			print '<a href="/my-videos/?email='.$_GET['email'].'&id='.$_GET['id'].'" class="btn btn-info" role="button">View Your Gallery</a>';
			
			$data = array (
				"customerid"	=> intval($_GET['id']),
				"transid"		=> (string)$gwResponse->{'transaction-id'},
				"vaultid" 		=> (string)$gwResponse->{'customer-vault-id'},
				"firstname" 	=> (string)$gwResponse->billing->{'first-name'},
				"lastname" 		=> (string)$gwResponse->billing->{'last-name'},
				"emailaddress" 	=> (string)$gwResponse->billing->email,
				"address" 		=> (string)$gwResponse->billing->address1,
				"city" 			=> (string)$gwResponse->billing->city,
				"state" 		=> (string)$gwResponse->billing->state,
				"zipcode" 		=> (string)$gwResponse->billing->postal,
				"datecreation" 	=> date("Y-m-d H:i:s", time()),
				"amount"		=> $amount,
			);			
			
			$this->insert($data);
		
			$customer 	= new Customer;
			$customer->setpaid(intval($_GET['id']),1);
			$customer->setpaid_selfie(intval($_GET['id']),1);			
			
		} elseif((string)$gwResponse->result == 2)  {			
			print " <p><h3>Sorry we are unable to process your payment.</h3>\n";
			print "  Reason : " . (string)$gwResponse->{'result-text'} ." </p>";
			print '<a href="/my-videos/?email='.$_GET['email'].'&id='.$_GET['id'].'" class="btn btn-info" role="button">Back to Gallery</a>';
				
		} else {
			print " <p><h3>Sorry we are unable to process your payment.</h3>\n";
			print " Error Description: " . (string)$gwResponse->{'result-text'} ." </p>";
			print '<a href="/my-videos/?email='.$_GET['email'].'&id='.$_GET['id'].'" class="btn btn-info" role="button">Back to Gallery</a>';
		}		
	}
	
	// Helper function to make building xml dom easier
	function appendXmlNode($domDocument, $parentNode, $name, $value) {
		$childNode      = $domDocument->createElement($name);
		$childNodeValue = $domDocument->createTextNode($value);
		$childNode->appendChild($childNodeValue);
		$parentNode->appendChild($childNode);
	}

	function sendXMLviaCurl($xmlRequest,$gatewayURL) {
		// helper function demonstrating how to send the xml with curl
		$ch = curl_init(); // Initialize curl handle
		curl_setopt($ch, CURLOPT_URL, $gatewayURL); // Set POST URL

		$headers = array();
		$headers[] = "Content-type: text/xml";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 	// Add http headers to let it know we're sending XML
		$xmlString = $xmlRequest->saveXML();
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); 			// Fail on errors
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 		// Allow redirects
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 		// Return into a variable
		curl_setopt($ch, CURLOPT_PORT, 443); 				// Set the port number
		curl_setopt($ch, CURLOPT_TIMEOUT, 15); 				// Times out after 15s
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlString); 	// Add XML directly in POST
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		// This should be unset in production use. With it on, it forces the ssl cert to be valid
		// before sending info.
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		if (!($data = curl_exec($ch))) {
			print  "curl error =>" .curl_error($ch) ."\n";
			throw New Exception(" CURL ERROR :" . curl_error($ch));

		}
		curl_close($ch);
		return $data;
	}	
	
	function insert($param){
		$id = $this->db->insert('transactions', $param);
		return $id;
	}	
} 
?>