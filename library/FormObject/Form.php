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

namespace FormObject;

use Doctrine\ORM\EntityManager;

abstract class Form extends \Zend_Form {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    private static $_entityManager;

    /**
     * @param Doctrine\ORM\EntityManager $em
     */
    public static function setEntityManager (EntityManager $em) {
        self::$_entityManager = $em;
    }

    /**
     * @var string
     */
    protected $_class;

    /**
     * @var Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $_classMetadata;

    /**
     * @var FormObject\FactoryObject
     */
    private $_factoryObject = null;

    /**
     * @var mixed
     */
    protected $_object = null;

    /**
     * @param string $class
     * @throws \InvalidArgumentException
     */
    public function __construct ($class) {
        parent::__construct();
        if (! is_string($class)) {
            throw new \InvalidArgumentException();
        }
        
        $this->_classMetadata = $this->getEntityManager()
            ->getClassMetadata($class);
        $this->_class = trim($class, '\\');
        
        $this->_initIdentifierProperty();
        
        $this->_init();
    }

    private function _initIdentifierProperty () {
        $identifierFieldNames = $this->_classMetadata->getIdentifierFieldNames();
        foreach ($identifierFieldNames as $fieldName) {
            $this->addProperty(new \Zend_Form_Element_Hidden($fieldName));
        }
    }

    public function setObject ($object) {
        if (! is_object($object)) {
            throw new \InvalidArgumentException('Parametro $object não é um object!');
        }
        $this->_object = $object;
    }

    /**
     * 
     */
    abstract protected function _init ();

    /**
     * @param \Zend_Form_Element $element
     */
    public function addProperty (\Zend_Form_Element $property) {
        $this->isFieldClassMetaData($property->getName());
        parent::addElement($property);
    }

    /**
     * @param string $property
     */
    public function getProperty ($property) {
        return $this->getElement($property);
    }

    /**
     * @param string $property
     * @throws \Exception
     */
    private function isFieldClassMetaData ($property) {
        if (! array_search($property, $this->_classMetadata->fieldNames)) {
            throw new \Exception("A propriedade {$property} não existe na class {$this->_class}");
        }
        return true;
    }

    /**
     * (non-PHPdoc)
     * @see Zend_Form::addSubForm()
     * @throws \Exception
     */
    public function addSubForm (\Zend_Form $form, $property, $order = null) {
        if (! $form instanceof Form) {
            throw new \InvalidArgumentException('Parametro $form');
        }
        $this->_classMetadata->getAssociationMapping($property);
        parent::addSubForm($form, $property, $order);
    }

    /**
     * @return mixed
     */
    public function getObject () {
        return Object\Factory::convertFormToObject($this, $this->_object);
    }

    /**
     * (non-PHPdoc)
     * @see FormObject.Form::getEntityManager()
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager () {
        return self::$_entityManager;
    }

    /**
     * @return Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getClassMetadata () {
        return $this->_classMetadata;
    }
}