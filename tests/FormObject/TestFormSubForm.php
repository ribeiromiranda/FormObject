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

class TestFormSubForm extends \PHPUnit_Framework_TestCase {

    /**
     * @var Mock\FormPessoa
     */
    protected $_form;

    /**
     * @var array
     */
    protected $_dados = array ();

    public function setUp() {
        $this->_dados = \Models\FactoryModels::getDados();
        $this->_pessoa = \Models\FactoryModels::createPessoa_TipoPessoa();
        
        $this->_form = new \Mock\FormPessoaSubForm('Models\Pessoa');
        $this->_form->render();
    }

    public function testAddSubform_adicionar_Form_valido() {
        $formPessoa = new \Mock\FormPessoa('Models\Pessoa');
        $formTipoPessoa = new \Mock\FormTipoPessoa('Models\TipoPessoa');
        $formPessoa->addSubForm($formTipoPessoa, 'tipoPessoa');
        
        $actual = $formPessoa->getSubForm('tipoPessoa')->getName();
        $this->assertEquals('tipoPessoa', $actual);
    }

    public function testAddSubform_adicionar_form_invalido() {
        $form = new \Mock\FormMonitor('\Models\Monitor');
        try {
            $this->_form->addSubForm($form, 'monitor');
        } catch (\Exception $e) {
            return;
        }
        
        $this->fail('Erá esperado uma \'Exception\'');
    }

    public function testAddSubForm_adicionar_zend_form() {
        $form = new \Zend_Form();
        try {
            $this->_form->addSubForm($form);
        } catch (\Exception $e) {
            return;
        }
        
        $this->fail('Erá esperado uma \'Exception\'');
    }

    public function testGetObject() {
        if (!$this->_form->isValid($this->_dados)) {
            $this->fail('Falha Form::isValid(???)');
        }

        $actual = $this->_form->getObject();

        $this->assertInstanceOf('\Models\Pessoa', $actual);
        $this->assertTrue($this->_pessoa == $actual);
    }

    public function testLoadValuesObject() {
        $dados = $this->_dados;
        $form = $this->_form;
        $subForm = $form->getSubForm('tipoPessoa');
        
        $em = \Zend_Registry::get('em');
        $em->persist($this->_pessoa);
        $em->flush();
        
        $dados['ModelsPessoa']['id'] = $this->_pessoa->getId();
        $dados['ModelsPessoa']['ModelsTipoPessoa']['id'] = $this->_pessoa->getTipoPessoa()->getId();
        
        $form->setObject($this->_pessoa);
        $form->render();

        $this->equalValues($form, $dados['ModelsPessoa']);
        $this->equalValues($subForm, $dados['ModelsPessoa']['ModelsTipoPessoa']);
    }
    
    private function equalValues($form, $dados) {
        foreach ($form->getProperties() as $element) {
            $expected = $dados[$element->getName()];
            $actual = $element->getValue();
            $this->assertEquals($expected, $actual);
        }
    }
}