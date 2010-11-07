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

namespace FormObject\Types;

abstract class Type {

    const TARRAY = 'array';

    const BIGINT = 'bigint';

    const BOOLEAN = 'boolean';

    const DATETIME = 'datetime';

    const DATETIMETZ = 'datetimetz';

    const DATE = 'date';

    const TIME = 'time';

    const DECIMAL = 'decimal';

    const INTEGER = 'integer';

    const OBJECT = 'object';

    const SMALLINT = 'smallint';

    const STRING = 'string';

    const TEXT = 'text';

    private static $_typeObjects = array ();

    private static $_typesMap = array (
        self::TARRAY => 'FormObject\Types\ArrayType', 
    self::OBJECT => 'FormObject\Types\ObjectType', self::BOOLEAN => 'FormObject\Types\BooleanType', 
    self::INTEGER => 'FormObject\Types\IntegerType', 
    self::SMALLINT => 'FormObject\Types\SmallIntType', self::BIGINT => 'FormObject\Types\BigIntType', 
    self::STRING => 'FormObject\Types\StringType', self::TEXT => 'FormObject\Types\TextType', 
    self::DATETIME => 'FormObject\Types\DateTimeType', 
    self::DATETIMETZ => 'FormObject\Types\DateTimeTzType', self::DATE => 'FormObject\Types\DateType', 
    self::TIME => 'FormObject\Types\TimeType', self::DECIMAL => 'FormObject\Types\DecimalType'
    );

    private static $_formatDefault = null;

    /* Prevent instantiation and force use of the factory method. */
    final private function __construct() {
    }

    public function convertToViewValue($value) {
        return $value;
    }

    public function convertToPHPValue($value) {
        return $value;
    }

    abstract public function getName();

    public static function getType($name) {
        if (! isset(self::$_typeObjects[$name])) {
            if (! isset(self::$_typesMap[$name])) {
                throw new \Exception("Tipo '{$name}' não existe");
            }
            self::$_typeObjects[$name] = new self::$_typesMap[$name]();
        }
        
        return self::$_typeObjects[$name];
    }

    public static function addType($name, $className) {
        if (isset(self::$_typesMap[$name])) {
            throw new \Exception("Tipo '{$name}' já existe");
        }
        
        self::$_typesMap[$name] = $className;
    }

    public static function hasType($name) {
        return isset(self::$_typesMap[$name]);
    }

    public static function overrideType($name, $className) {
        if (! isset(self::$_typesMap[$name])) {
            throw new \Exception("Tipo '{$name}' não existe");
        }
        
        self::$_typesMap[$name] = $className;
    }

    public static function getTypesMap() {
        return self::$_typesMap;
    }

    public static function getFormatDefault() {
        if (is_null(self::$_formatDefault)) {
            self::setFormatDefault(new View\FormatDefault());
        }
        return self::$_formatDefault;
    }

    public static function setFormatDefault(View\Format $format) {
        self::$_formatDefault = $format;
    }

    public function __toString() {
        $e = explode('\\', get_class($this));
        return str_replace('Type', '', end($e));
    }
}