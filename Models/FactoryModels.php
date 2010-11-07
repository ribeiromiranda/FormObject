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

namespace Models;
use \FormObject\Types\Type;

final class FactoryModels {

    /**
     * @var array
     */
    private static $_dados = array (
    	'ModelsPessoa' => array (
        	'nome' => 'André Ribeiro de Miranda',
        	'dataNascimento' => '02/07/2000',
        	'ativo' => '1',
    		'ModelsTipoPessoa' => array (
        		'nome' => 'CPF',
        		'documento' => '111111111-11'
            )
        )
    );

    /**
     * @return array
     */
    public static function getDados() {
        return self::$_dados;
    }

    /**
     * @param array $dados
     * @return \Models\Pessoa
     */
    public static function createPessoa_TipoPessoa(array $dados = array()) {
        if ($dados === array()) {
            $dados = self::getDados();
        }
        $pessoa = self::createPessoa($dados);
        $pessoa->setTipoPessoa(self::createTipoPessoa($dados));
        
        return $pessoa;
    }

    public static function createPessoa(array $dados = array()) {
        if ($dados === array()) {
            $dados = self::getDados();
            
        }
        $dados = $dados['ModelsPessoa'];

        $pessoa = new Pessoa();
        $pessoa->setNome($dados['nome']);
        $data = Type::getType('date')->convertToPHPValue($dados['dataNascimento']);
        $pessoa->setDataNascimento($data);
        $pessoa->setAtivo($dados['ativo']);
        
        return $pessoa;
    }

    public static function createTipoPessoa(array $dados = array()) {
        if ($dados === array()) {
            $dados = self::getDados();
        }
        $dados = $dados['ModelsPessoa']['ModelsTipoPessoa'];
        
        $tipoPessoa = new TipoPessoa();
        $tipoPessoa->setNome($dados['nome']);
        $tipoPessoa->setDocumento($dados['documento']);
        
        return $tipoPessoa;
    }
}