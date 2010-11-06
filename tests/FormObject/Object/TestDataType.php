<?php
/*
 * This file is part of FormObject.
 *
 * Foobar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Foobar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @package FormObject
 * @author André Ribeiro de Miranda <ardemiranda@gmail.com>
 * @copyright 2010 André Ribeiro de Miranda
 * 
 * @license http://www.gnu.org/copyleft/lesser.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @link http://belocodigo.com.br
 */

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