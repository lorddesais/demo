<?php

namespace Cli;

use Exception\CliParserException;

class Parser
{
	const ARG_SCRIPT_NAME = 'script_name';

	const ARG_ENTITY_TYPE = 'entity_type';
	const ARG_ENTITY_TYPE_POST = 'post';
	const ARG_ENTITY_TYPE_USER = 'user';
	const ARG_ENTITY_TYPE_COMMENT = 'comment';

	const ARG_ENTITY_ID = 'entity_id';

	const ARG_ENTITY_RELATION = 'entity_relation';

	const ARG_VALID_COUNT = 4;

	protected $argMap =
		[
			0 => self::ARG_SCRIPT_NAME,
			1 => self::ARG_ENTITY_TYPE,
			2 => self::ARG_ENTITY_ID,
			3 => self::ARG_ENTITY_RELATION
		];

	protected $entityTypes =
		[
			self::ARG_ENTITY_TYPE_POST,
			self::ARG_ENTITY_TYPE_USER,
			self::ARG_ENTITY_TYPE_COMMENT
		];

	protected $arguments = [];

	public function __construct($argv)
	{
		foreach ($argv as $argIndex => $argValue)
		{
			$this->arguments[$this->argMap[$argIndex]] = $argValue;
		}
		$this->validateArguments();
	}

	public function getArgument($argName) : ?string
	{
		$arguments = $this->arguments;
		if (isset($arguments[$argName]))
		{
			return $arguments[$argName];
		}
		return NULL;
	}


	/**
	 * @throws CliParserException
	 */
	protected function validateArguments()
	{
		$arguments = $this->arguments;
		if (count($arguments) != self::ARG_VALID_COUNT)
		{
			throw new CliParserException('Wrong count of arguments');
		}
		if (
			!in_array($arguments[self::ARG_ENTITY_TYPE], $this->entityTypes) ||
			!in_array($arguments[self::ARG_ENTITY_RELATION], $this->entityTypes)
		)
		{
			throw new CliParserException('Wrong entity type \''.$arguments[self::ARG_ENTITY_TYPE].'\'');
		}
	}
}