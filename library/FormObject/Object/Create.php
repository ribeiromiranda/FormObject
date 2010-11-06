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
 * @package FormObject\Object
 * @author André Ribeiro de Miranda <ardemiranda@gmail.com>
 * @copyright 2010 André Ribeiro de Miranda
 * 
 * @license http://www.gnu.org/copyleft/lesser.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @link http://belocodigo.com.br
 */

namespace FormObject\Object;

use FormObject;

class Create implements ConvertFormToObject {

    /**
     * @var FormObject\Form
     */
    protected $_form;

    /**
     * @var Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $_classMetadata;

    /**
     * @var string
     */
    protected $_class;

    /**
     * @param FormObject\Form $form
     * @param Doctrine\ORM\EntityManager
     */
    public function __construct (FormObject\Form $form) {
        $this->_form = $form;
        $this->_classMetadata = $form->getClassMetadata();
        $this->_class = $this->_classMetadata->name;
    }

    /**
     * @return mixed
     */
    public function getObject () {
        return $this->_createObect();
    }

    private function _createObect () {
        if (method_exists($this->_form, 'createObject')) {
            return $this->_form->createObject($this->_form->getElements());
        }
        
        $object = new $this->_class();
        foreach ($this->_form->getElements() as $element) {
            $fieldName = $element->getName();
            $typeOfField = $this->_classMetadata->getTypeOfField($fieldName);
            $value = DataType::create($typeOfField, $element->getValue());
            $this->_classMetadata->setFieldValue($object, $fieldName, $value);
        }
        
        return $object;
    }
}