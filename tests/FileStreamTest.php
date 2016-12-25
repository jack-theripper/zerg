<?php

namespace Zerg\Stream;

use Zerg\FileStream;

/**
 * Class FileStreamTest
 *
 * @package Zerg\Stream
 */
class FileStreamTest extends \PHPUnit_Framework_TestCase
{
	
	public function testRead()
	{
		$stream = new FileStream(__DIR__.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'test_data.txt');
		
		$this->assertEquals('1', $stream->readString(1));
		$stream->skip(2);
		$this->assertEquals('a', $stream->readString(1));
		$stream->skip(1);
		$this->assertEquals('c', $stream->readString(1));
		$this->assertEquals('d', $stream->readString(1));
	}
	
} 