<?php
define('SITE_ROOT', dirname(__FILE__));

use Di\Loader;
use Log\Logger;
use Cli\Parser;
use Api\Fetcher;
use Data\Writer;

class App {

	/**
	 * @var Loader
	 */
	protected $loader;

	/**
	 * @var Fetcher
	 */
	protected $apiFetcher;

	/**
	 * @var Writer
	 */
	protected $dataWriter;

	public function __construct($argv)
	{
		$this->loader = new Loader($argv);
	}

	public function run()
	{
		try
		{
			$cliParser = $this->loader->getCliParser();
			$entityType = $cliParser->getArgument(Parser::ARG_ENTITY_TYPE);
			$entityId = $cliParser->getArgument(Parser::ARG_ENTITY_ID);
			$entityRelation = $cliParser->getArgument(Parser::ARG_ENTITY_RELATION);
			Logger::log(
				'CLI args parsed:'.PHP_EOL.'Entity type = '.($entityType ? $entityType : '<empty>').PHP_EOL.
				'Entity ID = '.($entityId ? $entityId : '<empty>').PHP_EOL.
				'Entity relation = \''.($entityRelation ? $entityRelation : '<empty>')
			);

			$apiFetcher = $this->loader->getApiFetcher();
			$apiResult = $apiFetcher->process($entityType, $entityId, $entityRelation);
			Logger::log('API Fetcher result:'.PHP_EOL.
				'Entity info: '.implode('|', $apiResult[Fetcher::ENTITY_INFO]).PHP_EOL.
				'Entity relations count: '.$apiResult[Fetcher::ENTITY_RELATIONS_COUNT]);

			$dataWriter = $this->loader->getDataWriter();
			$dataWriter->setTargetFolder($entityType.$entityId.$entityRelation);
			$writerResult = $dataWriter->save($apiResult, $entityType, $entityId, $entityRelation);
			if ($writerResult) {
				foreach ($writerResult as $filePath) {
					Logger::log('Writer: Data successfully write to file '.$filePath);
				}
			}
			Logger::log('');
		} catch (Exception $e)
		{
			throw new Exception('App Error: '.$e->getMessage());
		}

	}

}
