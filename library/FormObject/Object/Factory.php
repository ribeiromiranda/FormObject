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
use Doctrine\Common\Collections\ArrayCollection;
use FormObject\Form;

final class Factory {

    public static function convertFormToObject(Form $form, $object) {
        $removedElements = self::cleanForm($form);
        
        $alterar = true;
        if (! is_object($object)) {
            $object = self::find($form);
            if (! is_object($object)) {
                $alterar = false;
            }
        }
        
        if ($alterar) {
            require_once 'FormObject/Object/Alter.php';
            $factory = new Alter($form, $object);
        } else {
            require_once 'FormObject/Object/Create.php';
            $factory = new Create($form);
        }
        
        $object = $factory->getObject();
        $form->addElements($removedElements);
        $form->setObject($object);
        
        if (! $alterar && !($object instanceof ArrayCollection)) {
            $form->getEntityManager()->persist($object);
        }
        
        return $object;
    }

    public static function convertElementToObject(Form $form,\Zend_Form_Element $element, $class = null) {
        $convertElement = new ConvertElement($form);
        
        if (is_null($class) && $convertElement->isConvertable($element)) {
            return $convertElement->convertToPHP($element);
        
        } else if (! is_null($class)) {
            return $convertElement->findObject($class, $element);
        }
        
        return $element->getValue();
    }

    private static function find($form) {
        $classMetadata = $form->getClassMetadata();
        $identifierFieldNames = $classMetadata->getIdentifierFieldNames();
        $where = array ();
        foreach ($identifierFieldNames as $fieldName) {
        	$element = $form->getElement($fieldName);
        	if ($element instanceof \Zend_Form_Element) {
            	$where[$fieldName] =  $element->getValue();
        	}
        }
        if (empty($where)) {
            return null;
        }

        return $form->getEntityManager()
            ->find($classMetadata->name, $where);
    }
    
    private static function findElement() {
        
    }

    private static function cleanForm(Form $form) {
        $removedElements = array();
        foreach ($form->getElements() as $element) {
            if ($element instanceof \Zend_Form_Element_Submit) {
                $removedElements[] = $element;
                $form->removeElement($element->getName());
            }
        }
        return $removedElements;
    }
}

?>