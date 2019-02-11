<?php

namespace Data\Generator;

class HtmlGenerator extends Generator
{
	protected $dataType = 'html';

	public function getResult($data)
	{
		$result = $this->generateHtml($data);
		return [
			self::DATA_TYPE_KEY => $this->getDataType(),
			self::DATA_KEY => $result
		];
	}

	protected function generateHtml($data, $class = 'data')
	{
		$result = '<div class=\''.$class.'\'>';

		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$result .= $this->generateHtml($value, $key);
			}
		} else
		{
			$result .= $data;
		}
		$result .= '</div>';

		return $result;
	}
}