<?php
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