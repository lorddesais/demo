<?php

namespace Data;

use Data\Generator\Generator;
use Data\Generator\HtmlGenerator;
use Data\Generator\JsonGenerator;
use Data\Generator\XmlGenerator;

class Writer
{
	const OUTPUT_PATH = APP_ROOT.'/temp/output';
	const FILE_NAME = 'entity';
	const DEFAULT_FOLDER = 'default';

	protected $generators = [];

	protected $targetFolder;

	public function __construct(HtmlGenerator $htmlGenerator, JsonGenerator $jsonGenerator, XmlGenerator $xmlGenerator)
	{
		$this->generators[] = $htmlGenerator;
		$this->generators[] = $jsonGenerator;
		$this->generators[] = $xmlGenerator;
	}

	protected function checkFilePath($filePath)
	{
		if (!file_exists($filePath)) {
			mkdir($filePath, 0777, true);
		}
	}

	protected function write($data, $extension)
	{
		$folder = $this->getTargetFolder();
		$filePath = self::OUTPUT_PATH . '/' . $folder;

		$this->checkFilePath($filePath);

		$file = $filePath . '/' . self::FILE_NAME . '.' . $extension;

		file_put_contents($file, $data);
		return $file;
	}

	public function getTargetFolder()
	{
		if ($this->targetFolder)
		{
			return $this->targetFolder;
		}
		return self::DEFAULT_FOLDER;
	}

	public function setTargetFolder($folder)
	{
		$this->targetFolder = $folder;
	}

	public function save($data)
	{
		$files = [];
		foreach ($this->generators as $generator)
		{
			$result = $generator->getResult($data);
			$files[] = $this->write($result[Generator::DATA_KEY], $result[Generator::DATA_TYPE_KEY]);
		}
		return $files;
	}
}