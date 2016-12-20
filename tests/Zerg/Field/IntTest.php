<?php

namespace Zerg\Field;

use PhpBio\Endian;
use Zerg\StringStream;

class IntTest extends \PHPUnit_Framework_TestCase
{
    public function testConfiguration()
    {
        $int = new IntType(1, ['signed' => true]);
        $this->assertTrue($int->getSigned());
        $int->setSigned(false);
        $this->assertFalse($int->getSigned());
        $int->setSigned(true);
        $this->assertTrue($int->getSigned());
    }

    public function testRead()
    {
        $stream = new StringStream("\x03\x80\x80");
        $int = new IntType('byte', ['signed' => true]);
        $this->assertSame(3, $int->read($stream));
        $this->assertSame(-128, $int->read($stream));
        $int->setSigned(false);
        $this->assertSame(128, $int->read($stream));
    }

    public function testReadBits()
    {
        $stream = new StringStream("\x73\xda\xf4\xdc\0");
        $int = new IntType('nibble');
        $values = [7, 3, 13, 10, 15, 4];
        foreach ($values as $expected) {
            $this->assertSame($expected, $int->read($stream));
        }

        $this->assertSame(0xdc, (new IntType('byte'))->read($stream));

        $int->setSize('semi_nibble');
        $stream->getBuffer()->setPosition(0);

        $values = [1,3,0,3,3,1,2,2,3,3,1,0];
        foreach ($values as $expected) {
            $this->assertSame($expected, $int->read($stream));
        }
    }

    /**
     * @expectedException \OutOfBoundsException
     * */
    public function testOutOfBoundary()
    {
        $int = new IntType('nibble');
        $newStream = new StringStream("\x31");
        $int->read($newStream);
        $this->assertSame(1, $int->read($newStream));
        $int->read($newStream);
    }

    /**
     * @expectedException \Zerg\Field\ConfigurationException
     * @dataProvider invalidValues
     * */
    public function testInvalidOptionSize($invalidValue)
    {
        $int = new IntType($invalidValue);
        $int->getSize();
    }


    /**
     * @expectedException \LengthException
     * */
    public function testLargeIntException()
    {
        $int = new IntType(65);
        $int->read(new StringStream('foo'));
    }

    public function invalidValues()
    {
        return [
            [-1],
            ['/foo/bar']
        ];
    }

    public function testAssertion()
    {
        $int = new IntType(8, ['assert' => 49]);
        $this->assertTrue($int->validate(49));
    }

    /**
     * @expectedException \Zerg\Field\AssertException
     * */
    public function testAssertionException()
    {
        (new IntType(8, ['assert' => 50]))->parse(new StringStream('1'));
    }

    /**
     * @expectedException \Zerg\Field\AssertException
     * */
    public function testCallbackAssertionException()
    {
        (new IntType(8, ['assert' => function ($val, IntType $field) {
            return $val !== 49;
        }]))->parse(new StringStream('1'));
    }

    public function testEndian()
    {
        $field = new IntType('byte', ['endian' => Endian::ENDIAN_BIG]);
        $this->assertEquals(Endian::ENDIAN_BIG, $field->getEndian());
        $this->assertEquals(Endian::ENDIAN_LITTLE, $field->setEndian(Endian::ENDIAN_LITTLE)->getEndian());
    }


    /**
     * @expectedException \Zerg\Field\ConfigurationException
     * */
    public function testEndianException()
    {
        $field = new IntType('byte', ['endian' => 'little']);
    }

    public function testMassConfig()
    {
        $int1 = new IntType(32, ['assert' => 10, 'signed' => true, 'endian' => Endian::ENDIAN_BIG]);
        $int2 = new IntType([
            'size' => 32,
            'assert' => 10,
            'signed' => true,
            'endian' => Endian::ENDIAN_BIG
        ]);
        $this->assertEquals($int1, $int2);
    }

} 