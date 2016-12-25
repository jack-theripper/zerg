<?php

namespace Zerg\Stream;

use Zerg\StringStream;

/**
 * Class StringStreamTest
 *
 * @package Zerg\Stream
 */
class StringStreamTest extends \PHPUnit_Framework_TestCase
{
    
	/**
     * @expectedException \OutOfBoundsException
     */
    public function testRead()
    {
        $stream = new StringStream('123abcdefg');
        
        $this->assertEquals('1', $stream->readString(1));
        $stream->skip(2);
        $this->assertEquals('a', $stream->readString(1));
        $stream->skip(1);
        $this->assertEquals('c', $stream->readString(1));
        $this->assertEquals('d', $stream->readString(1));
        $stream->readString(200);
    }
} 