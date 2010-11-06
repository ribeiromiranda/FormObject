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

class TestFactory extends \PHPUnit_Framework_TestCase {

    /**
     * @var array
     */
    private $_dados;

    /**
     * @var FormObject\Form
     */
    private $_form;

    public function setUp () {
        $this->_dados = array (
            
        'nome' => 'André Ribeiro de Miranda', 'dataNascimento' => '02/07/1990', 'ativo' => true
        );
        $this->_form = new \Mock\FormPessoa('Models\Pessoa');
    }

    public function testConvertFormToObject_new () {
        $expected = new \Models\Pessoa();
        $actual = Factory::convertFormToObject($this->_form, null);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertFormToObject_alter () {
    }
}