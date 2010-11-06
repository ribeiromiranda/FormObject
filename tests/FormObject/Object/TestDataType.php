<?php

namespace FormObject\Object;

class TestDataType extends \PHPUnit_Framework_TestCase {

	public function testCreate() {
		$actual = DataType::create('date', '02/07/1989');
		$this->assertEquals(new \DateTime('02/07/1989'), $actual);
		$this->assertType('\DateTime', $actual);
		
		$actual = DataType::create('dateTime', '02/07/1989 10:00');
		$this->assertEquals(new \DateTime('02/07/1989 10:00'), $actual);
		$this->assertType('\DateTime', $actual);
		
		$actual = DataType::create('integer', '123');
		$this->assertEquals(123, $actual);
		$this->assertInternalType('integer', $actual);

		$actual = DataType::create('string', 'teste');
		$this->assertEquals('teste', $actual);
		$this->assertInternalType('string', $actual);		

		$actual = DataType::create('boolean', 1);
		$this->assertEquals(true, $actual);
		$this->assertInternalType('boolean', $actual);
		
		$actual = DataType::create('boolean', 'asf');
		$this->assertEquals(true, $actual);
		$this->assertInternalType('boolean', $actual);
		
		$actual = DataType::create('boolean', '');
		$this->assertEquals(false, $actual);
		$this->assertInternalType('boolean', $actual);
		
		$actual = DataType::create('date', null);
		$this->assertEquals(null, $actual);
		$this->assertInternalType('null', $actual);
	}
}