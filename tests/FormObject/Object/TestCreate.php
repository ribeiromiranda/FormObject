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

class TestCreate extends \PHPUnit_Framework_TestCase {

    /**
     * @var Mock\FormPessoa
     */
    protected $_form;

    /**
     * @var FormObject\Object\Create
     */
    protected $_create;

    /**
     * @var Models\Pessoa
     */
    protected $_pessoa;

    /**
     * @var array
     */
    protected $_dados = array ();

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp () {
        $this->_dados = array (
        	'nome' => 'André Ribeiro de Miranda', 'dataNascimento' => '02/07/1990', 'ativo' => true
        );
        $this->_form = new \Mock\FormPessoa('Models\Pessoa');
        $this->_form->removeElement('Salvar');
        $this->_form->isValid($this->_dados);
        
        $this->_create = new \FormObject\Object\Create($this->_form);
        
        $this->_pessoa = new \Models\Pessoa();
        $this->_pessoa->setNome($this->_dados['nome']);
        $this->_pessoa->setDataNascimento(new \DateTime($this->_dados['dataNascimento']));
        $this->_pessoa->setAtivo($this->_dados['ativo']);
    }

    public function testConstruct () {
        $metadata = $this->_form->getClassMetadata();
        
        try {
            $factory = new \FormObject\Object\Create($this->_form);
        } catch (\Exception $e) {
            $this->fail('Falha no construtor');
            return;
        }
        
        $this->assertInstanceOf('FormObject\Object\Create', $factory);
        $this->assertAttributeEquals($this->_form, '_form', $factory);
        $this->assertAttributeEquals($metadata, '_classMetadata', $factory);
        $this->assertAttributeEquals('Models\Pessoa', '_class', $factory);
    }

    public function testCreate () {
        $this->assertEquals($this->_pessoa, $this->_create->getObject());
    }

    public function testCreate_factoryMethod () {
        $form = new \Mock\FormPessoaCreateObject('Models\Pessoa');
        $create = new Create($this->_form);
        $this->assertEquals($this->_pessoa, $create->getObject());
    }
}