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
			'dataNascimento' => '02/07/1989'
		);
		$this->_form = new FormPessoa('\Models\Pessoa');
		$this->_form->setAction('/action')
					->setMethod('post')
					->setView(\Zend_Registry::get('view'));
	}

	public function testConstruct_sem_argumento() {
		try {
			$form = new FormPessoa();

		} catch (\Exception $e) {
			return ;
		}

		$this->fail('Erá esperado uma excessão \'Exception\'');
	}

	public function testConstruct_argumento_invalido() {
		try {
			$form = new FormPessoa(123);

		} catch (\InvalidArgumentException $e) {
			return ;
		}
		$this->fail('Erá esperado uma excessão \'InvalidArgumentException\'');
	}

	public function testConstruct_class_inexistente() {
		try {
			$form = new FormPessoa('ClassInexistente');

		} catch (\Exception $e) {
			return ;
		}
		$this->fail('Erá esperado uma excessão \'InvalidArgumentException\'');		
	}

	public function testConstruct() {
		$form = new FormPessoa('\Models\Pessoa');
		$classMetaData = $this->_form->getEntityManager()
			->getClassMetadata('\Models\Pessoa');
		
		$this->assertAttributeEquals($classMetaData, '_classMetadata', $form);
		$this->assertAttributeEquals('Models\Pessoa', '_class', $form);
		
		$identifierFieldNames = $this->_form->getClassMetadata()->getIdentifierFieldNames();
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

	public function testAddSubform_adicionar_Form_valido() {
		$form = new \Mock\FormTipoPessoa('Models\TipoPessoa');
		$this->_form->addSubForm($form, 'tipoPessoa');
		$this->assertEquals('tipoPessoa', $this->_form->getSubForm('tipoPessoa')->getName());
	}

	public function testAddSubform_adicionar_form_invalido() {
		$form = new \Mock\FormMonitor('\Models\Monitor');
		try {
			$this->_form->addSubForm($form, 'monitor');
		} catch (\Exception $e) {
			return ;
		}

		$this->fail('Erá esperado uma \'Exception\'');
	}

	public function testAddSubForm_adicionar_zend_form() {
		$form = new \Zend_Form();
		try {
			$this->_form->addSubForm($form);
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
}


class FormPessoa extends \FormObject\Form {
	
	protected function _init() {
	}
}