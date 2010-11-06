<?php

namespace Mock;

class FormPessoa extends \FormObject\Form {

    protected function _init () {
        $this->setAction('/action')
            ->setMethod('post')
            ->setView(\Zend_Registry::get('view'));
        $this->addProperty(new \Zend_Form_Element_Text('nome'));
        $this->addProperty(new \Zend_Form_Element_Text('dataNascimento'));
        $this->addProperty(new \Zend_Form_Element_Checkbox('ativo'));
        $this->addElement(new \Zend_Form_Element_Submit('Salvar'));
    }
}