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

use \FormObject\Types\Type;

class TestFactory extends \PHPUnit_Framework_TestCase {

    /**
     * @var array
     */
    private $_dados;

    /**
     * @var \Models\Pessoa
     */
    private $_pessoa;

    /**
     * @var FormObject\Form
     */
    private $_form;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp() {
        $this->_dados = \Models\FactoryModels::getDados();
        $this->_pessoa = \Models\FactoryModels::createPessoa();
        
        $this->_form = new \Mock\FormPessoa('Models\Pessoa');
        $this->_form->render();
        $this->_form->isValid($this->_dados);
    }

    public function testConvertFormToObject_new() {
        $actual = Factory::convertFormToObject($this->_form, null);
        $this->assertTrue($this->_pessoa == $actual);
    }

    public function testConvertFormToObject_alter() { 
        $em = \Zend_Registry::get('em');

        $pessoa = \Models\FactoryModels::createPessoa();
        $data = Type::getType('date')->convertToPHPValue('02/07/1990');
        $pessoa->setDataNascimento($data);
        $em->persist($pessoa);
        $em->flush();
        
        $dados = $this->_dados;
        $dados['id'] = $pessoa->getId();
        
        if (! $this->_form->isValid($dados)) {
            $this->fail('Falha Form->isValid(????)!');
        }
        
        $pessoaExpected = \Models\FactoryModels::createPessoa();
        $pessoaActual = $this->_form->getObject();

        $this->assertTrue($pessoaExpected == $pessoaActual);
        
        $em->flush();
    }
}