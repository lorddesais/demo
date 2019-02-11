<?php

namespace Data\Generator;

abstract class Generator
{
	const DATA_TYPE_KEY = 'data_type';
	const DATA_KEY = 'data';

	protected $dataType;

	public function getDataType()
	{
		return $this->dataType;
	}

	abstract protected function getResult($data);
}