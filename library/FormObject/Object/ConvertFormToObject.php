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

abstract class ConvertFormToObject {

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
    public function __construct(FormObject\Form $form) {
        if (! property_exists($this, '_nameMethodFormFactory')) {
            throw new \Exception('Propriedade \'nameMethodFormFactory\ não foi definida\'');
        }
        
        $this->_form = $form;
        $this->_classMetadata = $form->getClassMetadata();
        $this->_class = $this->_classMetadata->name;
    }

    public function getObject() {
        if (method_exists($this->_form, $this->_nameMethodFormFactory)) {
            return $this->_form->createObject($this->_form);
        }
        
        $form = $this->_form;
        $object = $this->_doGetObject();
        
        foreach ($form->getElements() as $element) {
            $fieldName = $element->getName();
            $typeOfField = $this->_classMetadata->getTypeOfField($fieldName);
            $value = $element->getValue();
            $value = \FormObject\Types\Type::getType($typeOfField)->convertToPHPValue($value);
            
            $this->_classMetadata->setFieldValue($object, $fieldName, $value);
        }
        
        foreach ($form->getSubForms() as $subForm) {
            $fieldName = $subForm->getName();
            $value = $subForm->getObject();
            $this->_classMetadata->setFieldValue($object, $fieldName, $value);
        }
        
        return $object;
    }

    abstract protected function _doGetObject();
}

?>