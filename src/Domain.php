<?php

namespace Benjafield\Enom;

use Benjafield\Enom\Request;
use Benjafield\Enom\Resource;

class Domain {

	protected $enom;
	protected $request;

	public function __construct(Enom $enom)
	{
		$this->enom = $enom;
		$this->request = new Request($enom);
	}

	public function check(string $sld, string $tld, array $domainList = [], array $tldList = [])
	{
		$params = [
			'SLD' => $sld,
			'TLD' => $tld,
		];

		if(count($domainList)) $params['DomainList'] = implode(',', $domainList);
		if(count($tldList)) $params['TLDList'] = implode(',', $tldList);

		$response = $this->command('Check', $params);

		return new Resource([
			'domain' => $response->DomainName,
			'status' => $this->translateRRPCode((int) $response->RRPCode, $response->RRPText),
			'rrptext' => $response->RRPText,
			'rrpcode' => (int) $response->RRPCode
		]);
	}

	protected function translateRRPCode($code, $default = null)
	{
		$codes = [
			210 => 'available',
			211 => 'unavailable'
		];
		return (in_array($code, array_keys($codes)) ? $codes[$code] : (empty($default) ? $code : $default));
	}

	protected function convertValuesToString(array $array)
	{
		$result = [];
		foreach($array as $key => $value)
		{
			if(is_array($value)) $result[$key] = implode(',', $value);
			elseif(is_bool($value)) $result[$key] = $value ? 'true' : 'false';
			else $result[$key] = (string) $value;
		}
		return $result;
	}

	protected function command(string $name, array $params = [], bool $simpleXml = false)
	{
		$response = $this->request->get($name, $params);
		$response = $this->request->parseXml($response, $simpleXml);
		if($response->ErrCount > 0) throw new Exceptions\EnomApiException($response->errors);

		return $response;
	}

	public function suggestions(string $searchTerm, array $options = [])
	{
		$params = array_merge([
			'SearchTerm' => $searchTerm
		], $options);

		$params = array_filter($this->convertValuesToString($params));

		$response = $this->command('GetNameSuggestions', $params, true);
		$result = json_decode(json_encode($response));
		unset($result->DomainSuggestions);

		$result->suggestions = [];

		foreach($response->DomainSuggestions->Domain as $key => $domain)
		{
			$attributes = (array) $domain->attributes();

			$result->suggestions[] = (object) [
				'domain' => strtolower($domain),
				'attributes' => (object) $attributes['@attributes']
			];
		}

		return $result;
	}

}