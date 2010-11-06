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