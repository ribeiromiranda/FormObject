<?php

namespace Mock;

class FormPessoaCreateObject extends \FormObject\Form {

    protected function _init () {
        $this->setAction('/action')
            ->setMethod('post')
            ->setView(\Zend_Registry::get('view'));
        $this->addProperty(new \Zend_Form_Element_Text('nome'));
        $this->addProperty(new \Zend_Form_Element_Text('dataNascimento'));
        $this->addProperty(new \Zend_Form_Element_Checkbox('ativo'));
        $this->addElement(new \Zend_Form_Element_Submit('Salvar'));
    }
    
    protected function createObject($elements) {
        $object = new \Models\Pessoa();
        $object->setNome($elements[0]->getValue());
        $object->setDataNascimento(new \DateTime($elements[1]->getValue()));
        $object->setAtivo($elements[2]->getValue());

        return $object;
    }
}