<?php
namespace Simple;
class FormPessoa extends \FormObject\Form
{
	public function __construct() {
		parent::__construct('Models\Pessoa');
	}
	
	public function _init() {
		$nome = new \Zend_Form_Element_Text('nome');
		$nome->setLabel('Nome');
		$nome->setRequired(true);
		$this->addProperty($nome);

		$nascimento = new \Zend_Form_Element_Text('dataNascimento');
		$nascimento->setLabel('Data Nascimento');
		$this->addProperty($nascimento);
		
		$ativo = new \Zend_Form_Element_Checkbox('ativo');
		$ativo->setLabel('Ativo');
		$this->addProperty($ativo);

		$submit = new \Zend_Form_Element_Submit('Salvar');
		$this->addElement($submit);
	}	
}