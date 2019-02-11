<?php

namespace Data\Generator;

class XmlGenerator extends Generator
{
	protected $dataType = 'xml';

	protected $xmlWriter;

	public function __construct($xmlWriter)
	{
		$this->xmlWriter = $xmlWriter;
	}


	public function getResult($data)
	{
		$result = $this->createXml($data);
		return [
			self::DATA_TYPE_KEY => $this->getDataType(),
			self::DATA_KEY => $result
		];
	}

	protected function createXml($data)
	{
		$xmlWriter = $this->xmlWriter;
		$xmlWriter->openMemory();
		$xmlWriter->startDocument( '1.0', 'utf-8' );
		$xmlWriter->startElement( 'data') ;

		$this->generateXml($xmlWriter, $data);

		$xmlWriter->endElement();
		return $xmlWriter->outputMemory(TRUE);
	}

	protected function generateXml(\XMLWriter $xmlWriter, $data) {
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$xmlWriter->startElement($key);
				$this->generateXml($xmlWriter, $value);
				$xmlWriter->endElement();
				continue;
			}
			$xmlWriter->writeElement($key, $value);
		}
	}
}