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

namespace FormObject\Types;

use FormObject\Types\View\FormatDefault;

class TestFormat extends \PHPUnit_Framework_TestCase {

    /**
     * @var FormObject\Types\View\FormtDefault
     */
    protected $_format;

    public function setUp() {
        $this->_format = new FormatDefault();
    }

    public function testFormats() {
        $this->assertEquals('1', $this->_format->convertBooleans(true));
        $this->assertInternalType('string', $this->_format->convertBooleans(true));
        $this->assertEquals('0', $this->_format->convertBooleans(false));
        $this->assertInternalType('string', $this->_format->convertBooleans(false));
        $this->assertEquals('d/m/Y H:i', $this->_format->getDateTimeFormatString());
        $this->assertEquals('d-m-Y H:i:s', $this->_format->getDateTimeTzFormatString());
        $this->assertEquals('d/m/Y', $this->_format->getDateFormatString());
    }
}