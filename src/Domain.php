<?php

namespace Benjafield\Enom;

use Benjafield\Enom\Request;

class Domain {

	protected $enom;
	protected $request;

	public function __construct(Enom $enom)
	{
		$this->enom = $enom;
		$this->request = new Request($enom);
	}

	public function check($sld, $tld, $domainList = [], $tldList = [])
	{
		$params = [
			'SLD' => $sld,
			'TLD' => $tld,
		];

		if(count($domainList)) $params['DomainList'] = implode(',', $domainList);
		if(count($tldList)) $params['TLDList'] = implode(',', $tldList);

		// die('<pre>'.print_r($params, true).'</pre>');

		$response = $this->request->get('CHECK', $params);

		$response = $this->request->parseXml($response);

		if($response->ErrCount > 0) throw new Exceptions\EnomApiException($response->errors);

		return $response;
	}

}