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

use Doctrine\DBAL\Types\BooleanType;

final class DataType {

    public static function create ($type, $value) {
        if (is_null($value)) {
            return $value;
        }
        
        $instance = new self();
        if (! method_exists($instance, $type)) {
            throw new \Exception("Tipo '{$type}' não existe!");
        }
        
        return self::$type($value);
    }

    private static function date ($value) {
        return self::dateTime($value);
    }

    private static function dateTime ($value) {
        return new \DateTime($value);
    }

    private static function string ($value) {
        return (string) $value;
    }

    private static function integer ($value) {
        return (int) $value;
    }

    private static function boolean ($value) {
        return (bool) $value;
    }
}