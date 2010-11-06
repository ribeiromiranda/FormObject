<?php

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