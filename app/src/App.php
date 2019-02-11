<?php
define('SITE_ROOT', dirname(__FILE__));

use Di\Loader;
use Log\Logger;
use Cli\Parser;
use Api\Fetcher;

class App {

	/**
	 * @var Loader
	 */
	protected $loader;

	protected $apiFetcher;

	protected $dataWriter;

	public function __construct($argv)
	{
		$this->loader = new Loader($argv);
	}

	public function run()
	{
//		$data = [
//			"id"=>1,
//			"name"=>"Lennne Graham",
//			"username"=>"Bret",
//			"email"=>"Sincere@april.biz",
//			"address"=>
//				[
//					"street"=>"Kulas Light",
//					"suite"=>"Apt. 556",
//					"city"=>"Gwenborough",
//					"zipcode"=>"92998-3874",
//					"geo"=>
//						[
//							"lat"=>"-37.3159",
//							"lng"=>"81.1496"
//						]
//				],
//			"phone"=>"1-770-736-8031 x56442",
//			"website"=>"hildegard.org",
//			"company"=>
//				["name" =>"Romaguera-Crona",
//					"catchPhrase"=>"Multi-layered client-server neural-net",
//					"bs"=>"harness real-time e-markets"
//				]
//		];
//
//		function write_xml( XMLWriter $xml, $data ) {
//			foreach( $data as $key => $value ) {
//				if( is_array( $value )) {
//					$xml->startElement( $key );
//					write_xml( $xml, $value );
//					$xml->endElement( );
//					continue;
//				}
//				$xml->writeElement( $key, $value );
//			}
//		}
//
//		$xml = new XmlWriter();
//		$xml->openMemory();
//		$xml->startDocument( '1.0', 'utf-8' );
//		$xml->startElement( 'user') ;
//
//		write_xml( $xml, $data );
//
//		$xml->endElement();
//		echo $xml->outputMemory( true );

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
