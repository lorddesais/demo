<?php

namespace Data\Generator;

class JsonGenerator extends Generator
{
	protected $dataType = 'json';

	public function getResult($data)
	{
		$result = json_encode($data);
		return [
			self::DATA_TYPE_KEY => $this->getDataType(),
			self::DATA_KEY => $result
		];
	}
}