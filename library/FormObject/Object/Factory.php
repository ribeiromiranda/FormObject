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

final class Factory {

    private static $create = array ();

    private static $alter = array ();

    public static function convertFormToObject (FormObject\Form $form, $object) {
        self::cleanForm($form);
        
        if (is_null($object)) {
            $factory = self::getCreate($form);
        } else {
            $factory = self::getAlter($form);
        }
        return $factory->getObject();
    }

    private static function getCreate (FormObject\Form $form) {
        $name = $form->getName();
        if (empty(self::$create[$name])) {
            self::$create[$name] = new Create($form);
        }
        return self::$create[$name];
    }

    private static function getAlter (FormObject\Form $form) {
        $name = $form->getName();
        if (empty(self::$alter[$name])) {
            self::$alter[$name] = new Alter($form);
        }
        return self::$alter[$name];
    }

    private static function cleanForm (FormObject\Form $form) {
        foreach ($form->getElements() as $element) {
            if ($element instanceof \Zend_Form_Element_Submit) {
                $form->removeElement($element->getName());
            }
        }
    }

    private static function normalizeNames () {
    
    }
}

?>