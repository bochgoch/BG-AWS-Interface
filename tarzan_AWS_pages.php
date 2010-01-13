<?php
//orginal on http://pastie.org/603909

// include '../cloudfusion.class.php'; // If you're using the trunk build
include '../tarzan.class.php'; // If you're using the latest official release


/**
 * Uncomment these ONLY if you're using the trunk build.
 * Maps old class names to new ones in the trunk.
 */
// class AmazonAAWS extends AmazonPAS {}
//
// class TarzanHTTPRequest extends RequestCore
// {
// 	public function sendMultiRequest($param)
//	{
// 		return $this->send_multi_request($param);
// 	}
// }


/**
 * Extend the AmazonAAWS class with a new method.
 */
class AmazonAAWSProducts extends AmazonAAWS
{
	/**
	 * Get products
	 *
	 * Access:
	 * 	public
	 *
	 * Parameters:
	 * 	node_id - _string_ (Required) The Browse Node ID to use. For nodes see: http://www.browsenodes.co.uk/node-11052591.html
	 * 	index - _string_ (Required) The Search Index to use.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
	 * Keys for the $opt parameter:
	 * 	start - _integer_ (Optional) The page number to start on.
	 * 	pages - _integer_ (Optional) The maximum number of pages to return.
	 * 	min_price - _integer_ (Optional) The minimum possible item price.
	 * 	max_price - _integer_ (Optional) The maximum possible item price.
	 *
	 * Returns:
	 * 	<Array>
	 */
	public function get_products($node_id, $index, $opt = null)
	{
		// Set default values
		if (!isset($opt['start'])) $opt['start'] = 1;
		if (!isset($opt['pages'])) $opt['pages'] = 10;
		if (!isset($opt['min_price'])) $opt['min_price'] = 0;
		if (!isset($opt['max_price'])) $opt['max_price'] = 1000000000;

		// Initialize some variables.
		$request = new TarzanHTTPRequest(null);
		$handles = array();

		// Search for the items
		for ($page = $opt['start']; $page <= $opt['pages']; $page++)
		{
			$handles[] = $this->item_search('', array(
				'returnCurlHandle' => true,
				'ItemPage' => $page,
				'BrowseNode' => $node_id,
				'SearchIndex' => $index,
				'MerchantId' => 'All',
				'MinimumPrice' => $opt['min_price'],
				'MaximumPrice' => $opt['max_price'],
				'ResponseGroup' => 'OfferFull,ItemAttributes,MerchantItemAttributes,EditorialReview'
			));
		}

		// Fetch the responses
		$responses = $request->sendMultiRequest($handles);

		// Are SimpleXMLElements getting returned? (Only check the first, since they'll all be the same.)
		if (get_class($responses[0]->body) !== 'SimpleXMLElement')
		{
			// Loop through the responses...
			foreach ($responses as $response)
			{
				// And convert the (assumed) raw XML responses to SimpleXML.
				$response->body = new SimpleXMLElement($response->body);
			}
		}

		// Return an indexed array of responses.
		return $responses;
	}
}


/**
 * Use the new functionality.
 */
$pas = new AmazonAAWSProducts();
$response = $pas->get_products('173429', 'Music', array('pages' => 5));

header('Content-type: text/plain; charset=utf-8');
print_r($response);
