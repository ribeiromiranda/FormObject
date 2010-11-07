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

namespace FormObject;

class TestForm extends \PHPUnit_Framework_TestCase
{
	/**
 	 * @var Mock\FormPessoa
	 */
	protected $_form;

	/**
	 * @var array
	 */
	protected $_dados = array();

	public function setUp() {
		$this->_dados = array (
			'nome' 		 => 'André Ribeiro de Miranda',
			'dataNascimento' => '02/07/1989',
			'ativo' => '1'
		);

		$pessoa = new \Models\Pessoa();
		$pessoa->setNome($this->_dados['nome']);
		$data = Types\Type::getType('date')->convertToPHPValue($this->_dados['dataNascimento']);
		
		$pessoa->setDataNascimento($data);
		$pessoa->setAtivo($this->_dados['ativo']);
		$this->_pessoa = $pessoa;
		
		$this->_form = new \Mock\FormPessoa('Models\Pessoa');
	}

	public function testConstruct_sem_argumento() {
		try {
			$form = new \Mock\FormPessoa();

		} catch (\Exception $e) {
			return ;
		}

		$this->fail('Erá esperado uma excessão \'Exception\'');
	}

	public function testConstruct_argumento_invalido() {
		try {
			$form = new \Mock\FormPessoa(123);

		} catch (\InvalidArgumentException $e) {
			return ;
		}
		$this->fail('Erá esperado uma excessão \'InvalidArgumentException\'');
	}

	public function testConstruct_class_inexistente() {
		try {
			$form = new \Mock\FormPessoa('ClassInexistente');

		} catch (\Exception $e) {
			return ;
		}
		$this->fail('Erá esperado uma excessão \'InvalidArgumentException\'');		
	}

	public function testConstruct() {
		$form = new \Mock\FormPessoa('\Models\Pessoa');
		$classMetaData = $this->_form->getEntityManager()
			->getClassMetadata('\Models\Pessoa');
		
		$this->assertAttributeEquals($classMetaData, '_classMetadata', $form);
		$this->assertAttributeEquals('Models\Pessoa', '_class', $form);
		
		$identifierFieldNames = $this->_form->getClassMetadata()->getIdentifierFieldNames();

		ob_start();
		$this->_form->render();
		ob_clean();

		foreach ($identifierFieldNames as $fieldName) {
			$this->assertEquals($fieldName, $this->_form->getProperty($fieldName)->getName());
		}
	}
	
	public function testAddElement_adicionar_propriedade_valida() {
		$element = new \Zend_Form_Element_Text('dataNascimento');
		$this->_form->addProperty($element);
		
		$this->assertEquals('dataNascimento', $this->_form->getProperty('dataNascimento')->getName());
	}

	public function testAddElement_adicionar_propriedade_invalida() {
		$element = new \Zend_Form_Element_Text('nome_errado');
		try {
			$this->_form->addProperty($element);
		} catch (\Exception $e) {
			return ;
		}

		$this->fail('Erá esperado uma \'Exception\'');
	}

	public function testGetObject() {
		$this->_form->addElement(new \Zend_Form_Element_Text('nome'));
		$this->_form->addElement(new \Zend_Form_Element_Text('dataNascimento'));
		
		$this->_form->isValid($this->_dados);
		$this->assertInstanceOf('\Models\Pessoa', $this->_form->getObject());
	}
	
	public function testSetObject_invalido() {
		try {
			$this->_form->setObject(123);
		} catch (\Exception $e) {
			return ;
		}
		$this->fail('Erá esperado uma \'\\Exception\'');
	}

	public function testSetObject() {
		$pessoa = new \Models\Pessoa();
		$this->_form->setObject($pessoa);
		$this->assertAttributeEquals($pessoa, '_object', $this->_form);
	}
	
	public function testLoadValuesObject() {
	    $dados = $this->_dados;
	    $form = $this->_form;

	    $em = \Zend_Registry::get('em');
	    $em->persist($this->_pessoa);
        $em->flush();
        
	    $dados['id'] = $this->_pessoa->getId();

	    $form->setObject($this->_pessoa);
	    $form->render();
	    foreach ($form->getProperties() as $element) {
	        $this->assertEquals($dados[$element->getName()], $element->getValue()); 
	    }
	}
}