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

use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\PersistentCollection;

use Doctrine\Common\Collections\ArrayCollection;
use FormObject\Elements\MultiProperties;
use FormObject;
use Doctrine\ORM;

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
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_class;
    
    protected $_conversor;

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
        $this->_em = $form->getEntityManager();
        $this->_class = $this->_classMetadata->name;
    }

    public function getObject() {
        if (method_exists($this->_form, $this->_nameMethodFormFactory)) {
            return $this->_form->createObject($this->_form);
        }
        
        $form = $this->_form;
        $object = $this->_doGetObject($element);
        $classMetaData = $this->_classMetadata;
        $convertElement = $this->_conversor = new ConvertElement($form);
<<<<<<< HEAD
        
        if ($form instanceof MultiProperties) {
        	$lastKey = null;
        	$lastRespostaUsuario = null;
        	$newValues = new ArrayCollection();
        	foreach ($form->getElements() as $element) {
				$newKey = MultiProperties::splitName($element->getName());
	        	if ($lastKey != $newKey[0]) {
	        		$lastKey = $newKey[0];
	        		$element->setName($newKey[1]);

					$newValues->add($object); 
        		} else {
        			$element->setName($newKey[1]);
        		}
        		var_dump($element->getName(), $element->getValue());
        		$this->convertElement($element, $object);
        	}
        	
        	return $newValues;
        	
        } else {
	        foreach ($form->getSubForms() as $subForm) {
	            $fieldName = $subForm->getName();
	            $value = $subForm->getObject();
	            
	            if ($classMetaData->isCollectionValuedAssociation($fieldName)) {
	            	$metaFactory = $this->_em->getMetadataFactory();
	            	
	            	foreach ($value as $v) {
	            		$this->_populeInversedBy($classMetaData, $object, $fieldName, $v);
	            	}
	            }
	            
	            
	            $this->_classMetadata->setFieldValue($object, $fieldName, $value);
	            
	            $this->_populeInversedBy($classMetaData, $object, $fieldName, $value);
				if (!empty($classMetaData->associationMappings[$fieldName]['inversedBy']) 
	                	&&  is_object($value)
	                	&& $metaDataFactory->hasMetadataFor(get_class($value))) {
	            	$this->_populeInversedBy($metaDataFactory, $value, $classMetaData->associationMappings[$fieldName]['inversedBy'], $object);
	            }
	        }

        }
        
		foreach ($form->getElements() as $element) {
	    	if ($element instanceof \Zend_Form_Element) {
				$this->convertElement($element, $object);
			}
		}
		
        return $object;
    }
    
    private function convertElement($element, $object) {
    	$convertElement = $this->_conversor;
		if (! $convertElement->isConvertable($element)) {
			return false;
		}
		
		$classMetadata = $this->_classMetadata;
		$fieldName = $element->getName();
        $metaDataFactory = $this->_em->getMetadataFactory();

        
        $value = $convertElement->convertToPHP($element);
        if ($value === null) {
        	$value = $classMetadata->getFieldValue($object, $fieldName);
        }
        
        if ($classMetadata->isCollectionValuedAssociation($fieldName) 
        		&& !($value instanceof Collection)) {
			if (!is_array($value) ) {
				$value = array($value);
			}
			$value =  new ArrayCollection($value);
		}
		
        $classMetadata->setFieldValue($object, $fieldName, $value);
        
        $this->_populeInversedBy($classMetadata, $object, $fieldName, $value);
    }
    
=======
        
        if ($form instanceof MultiProperties) {
        	$lastKey = null;
        	$object = null;
        	$lastRespostaUsuario = null;
        	$newValues = new ArrayCollection();
        	foreach ($form->getElements() as $element) {
				$newKey = MultiProperties::splitName($element->getName());
	        	if ($lastKey != $newKey[0]) {
	        		$object = $this->_doGetObject($element);
	        		$lastKey = $newKey[0];
	        		$element->setName($newKey[1]);

					$newValues->add($object); 
        		} else {
        			$element->setName($newKey[1]);
        		}
        		$this->convertElement($element, $object);
        	}
        	return $newValues;
        	
        } else {
	        foreach ($form->getSubForms() as $subForm) {
	            $fieldName = $subForm->getName();
	            $value = $subForm->getObject();
	            
	            if ($classMetaData->isCollectionValuedAssociation($fieldName)) {
	            	$metaFactory = $this->_em->getMetadataFactory();
	            	foreach ($value as $v) {
	            		$this->_populeInversedBy($classMetaData, $object, $fieldName, $v);
	            	}
	            }
	            
	            
	            $this->_classMetadata->setFieldValue($object, $fieldName, $value);
	            
	            $this->_populeInversedBy($classMetaData, $object, $fieldName, $value);
				if (!empty($classMetaData->associationMappings[$fieldName]['inversedBy']) 
	                	&&  is_object($value)
	                	&& $metaDataFactory->hasMetadataFor(get_class($value))) {
	            	$this->_populeInversedBy($metaDataFactory, $value, $classMetaData->associationMappings[$fieldName]['inversedBy'], $object);
	            }
	        }
        }
        
		foreach ($form->getElements() as $element) {
		    
	    	if ($element instanceof \Zend_Form_Element) {
				$this->convertElement($element, $object);
			}
		}
		
        return $object;
    }
    
    private function convertElement($element, $object) {
    	$convertElement = $this->_conversor;
		if (! $convertElement->isConvertable($element)) {
			return false;
		}
		
		$classMetadata = $this->_classMetadata;
		$fieldName = $element->getName();
        $metaDataFactory = $this->_em->getMetadataFactory();

        
        $value = $convertElement->convertToPHP($element);
        if ($value === null) {
        	$value = $classMetadata->getFieldValue($object, $fieldName);
        }
        
        if ($classMetadata->isCollectionValuedAssociation($fieldName) 
        		&& !($value instanceof Collection)) {
			if (!is_array($value) ) {
				$value = array($value);
			}
			$value =  new ArrayCollection($value);
		}
		
        $classMetadata->setFieldValue($object, $fieldName, $value);
        
        $this->_populeInversedBy($classMetadata, $object, $fieldName, $value);
    }
    
>>>>>>> a351e592543acfeac79263028915f634f8469131
    private function _populeInversedBy(\Doctrine\ORM\Mapping\ClassMetadata $classMetaDataObject, $object, $fieldObject, $value, $type = null) {
    	
    	if ($type === null) { 
    		$this->_populeInversedBy($classMetaDataObject, $object, $fieldObject, $value, 'inversedBy');
    		$this->_populeInversedBy($classMetaDataObject, $object, $fieldObject, $value, 'mappedBy');
    		return ;
    	}
<<<<<<< HEAD

    	
    	$metaDataFactory = $this->_em->getMetadataFactory();
		if (!is_object($value) 
	    	|| !$metaDataFactory->hasMetadataFor(get_class($value))
	        || empty($classMetaDataObject->associationMappings[$fieldObject][$type])) {
=======
    	
    	$metaDataFactory = $this->_em->getMetadataFactory();
		if (empty($classMetaDataObject->associationMappings[$fieldObject][$type]) 
	    	||  !is_object($value)
	        || !$metaDataFactory->hasMetadataFor(get_class($value))
	        || !($value instanceof ArrayCollection)) {
>>>>>>> a351e592543acfeac79263028915f634f8469131
			return ;
		}

    	$fieldInverseValue = $classMetaDataObject->associationMappings[$fieldObject][$type];
    	$metaDataInverseValue = $metaDataFactory->getMetadataFor(get_class($value));
    	
    	$valueAtual = $metaDataInverseValue->getFieldValue($value, $fieldInverseValue);
<<<<<<< HEAD
    	
    	$valueAtual = $this->_tratarSetFieldValue($valueAtual, $object);
    		
=======
    
    	$valueAtual = $this->_tratarSetFieldValue($valueAtual, $value);
>>>>>>> a351e592543acfeac79263028915f634f8469131
    	
	    if ($metaDataInverseValue->isCollectionValuedAssociation($fieldInverseValue) && !is_array($object)) {
	        $object = new ArrayCollection(array($object));
	    }
	    
<<<<<<< HEAD
	    $metaDataInverseValue->setFieldValue($value, $fieldInverseValue, $valueAtual);
=======
	    $metaDataInverseValue->setFieldValue($valueAtual, $fieldInverseValue, $object);
>>>>>>> a351e592543acfeac79263028915f634f8469131
    }
    
    private function _tratarSetFieldValue($valueAtual, $newValue) {
    	if ($valueAtual instanceof \Doctrine\Common\Collections\Collection) {
    		if (! $valueAtual->contains($newValue)) {
				$valueAtual->add($newValue);    			
    		}
    		
    	} else if (is_array($valueAtual)) {
    		if (! in_array($newValue, $valueAtual, true)) {;
    			$valueAtual[] = $newValue;
    		}
    		
    	} else {
    		$valueAtual = $newValue;
    	}
    	return $valueAtual;
    }

    abstract protected function _doGetObject();
}

?>