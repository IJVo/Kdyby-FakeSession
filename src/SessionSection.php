<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */
declare(strict_types=1);

namespace Kdyby\FakeSession;

//use ArrayIterator;
//use Iterator;
use Kdyby;
use Nette\Http\Session as NetteSession;

class SessionSection extends \Nette\Http\SessionSection
{
	/** @var mixed[] */
	private $data = [];


	public function __construct(NetteSession $session, string $name)
	{
		parent::__construct($session, $name);
	}


	public function getIterator(): \Iterator
	{
		return new \ArrayIterator($this->data);
	}


	/**
	 * Removes a variable or whole section.
	 * @param  string|string[]|null  $name
	 */
	public function remove(string|array|null $name = null): void
	{
		$this->data = [];
	}


	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set(string $name, $value): void
	{
		$this->data[$name] = $value;
	}


	/**
	 * @param string $name
	 * @return mixed
	 */
	public function &__get(string $name): mixed
	{
		if ($this->warnOnUndefined && !array_key_exists($name, $this->data)) {
			trigger_error(sprintf("The variable '%s' does not exist in session section", $name), E_USER_NOTICE);
		}

		return $this->data[$name];
	}


	public function __isset(string $name): bool
	{
		return isset($this->data[$name]);
	}


	public function __unset(string $name): void
	{
		unset($this->data[$name]);
	}


	/**
	 * @param string|int|\DateTimeInterface $time
	 * @param string|string[] $variables list of variables / single variable to expire
	 * @return static
	 */
	public function setExpiration(?string $expire, string|array|null $variables = null): static
	{
		return $this;
	}


	/**
	 * @param string|string[] $variables list of variables / single variable to expire
	 */
	public function removeExpiration(string|array|null $variables = null): void
	{
		
	}


	/**
	 * Sets a variable in this session section.
	 */
	public function set(string $name, mixed $value, ?string $expire = null): void
	{

		\Testbench\IJVoLog::log('Kdyby-fake-session: SessionSection.php - set() - $name', $name);
		\Testbench\IJVoLog::log('Kdyby-fake-session: SessionSection.php - set() - $value', $value);

		$this->data[$name] = $value;
	}


	/**
	 * Gets a variable from this session section.
	 */
	public function get(string $name): mixed
	{
		if (func_num_args() > 1) {
			throw new \ArgumentCountError(__METHOD__ . '() expects 1 arguments, given more.');
		}

		if ($this->warnOnUndefined && !array_key_exists($name, $this->data)) {
			trigger_error(sprintf("The variable '%s' does not exist in session section", $name), E_USER_NOTICE);
		}

		if (!array_key_exists($name, $this->data)) {
			$result = null;
		} else {
			$result = $this->data[$name];
		}

		\Testbench\IJVoLog::log('Kdyby-fake-session: SessionSection.php - get() - $name', $name);
		\Testbench\IJVoLog::log('Kdyby-fake-session: SessionSection.php - get() - $result', $result);

		return $result;
	}
}
