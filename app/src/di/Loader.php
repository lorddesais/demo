<?php

namespace Di;

use Cli\Parser;
use Api\Fetcher;
use Data\Writer;
use Data\Generator\HtmlGenerator;
use Data\Generator\JsonGenerator;
use Data\Generator\XmlGenerator;


class Loader
{

	/**
	 * @var Parser
	 */
	protected $cliParser;

	/**
	 * @var Fetcher
	 */
	protected $apiFetcher;

	/**
	 * @var Writer
	 */
	protected $dataWriter;

	public function __construct($argv) {
		$this->cliParser = new Parser($argv);
		$this->apiFetcher = new Fetcher();
		$htmlGenerator = new HtmlGenerator();
		$jsonGenerator = new JsonGenerator();
		$xmlWriter = new \XMLWriter();
		$xmlGenerator = new XmlGenerator($xmlWriter);
		$this->dataWriter = new Writer($htmlGenerator, $jsonGenerator, $xmlGenerator);
	}

	public function getCliParser()
	{
		return $this->cliParser;
	}

	public function getApiFetcher()
	{
		return $this->apiFetcher;
	}

	public function getDataWriter()
	{
		return $this->dataWriter;
	}

}