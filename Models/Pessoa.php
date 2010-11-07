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

use Doctrine\DBAL\Types\IntegerType;

/**
 * @Entity
 * @Table(name="pessoas")
 */
class Pessoa {

    /**
     * @Id
     * @GeneratedValue
     * @Column(name="id", type="integer")
     */
    protected $id;

    /**
     * 
     * @Column(name="nome", type="string")
     */
    protected $nome;

    /**
     * 
     * @Column(name="data_nascimento", type="date")
     */
    protected $dataNascimento;

    /**
     * 
     * @OneToOne(targetEntity="Models\TipoPessoa", cascade={"persist", "remove"})
     * @JoinColumn(name="tipo_pessoa_id", referencedColumnName="id")
     */
    protected $tipoPessoa;

    /**
     * 
     * @Column(name="ativo", type="boolean")
     */
    protected $ativo;

    public function getId() {
        return $this->id;
    }

    /**
     * @return the $_nome
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * @return the $_dataNascimento
     */
    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    /**
     * @return the $_ativo
     */
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * @param string $_nome
     */
    public function setNome($_nome) {
        $this->nome = $_nome;
    }

    /**
     * @param \DateTime $_dataNascimento
     */
    public function setDataNascimento(\DateTime $dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @param bool $_ativo
     */
    public function setAtivo($_ativo) {
        $this->ativo = $_ativo;
    }

    /**
     * @param \Models\TipoPessoa $tipoPessoa
     */
    public function setTipoPessoa(TipoPessoa $tipoPessoa) {
        $this->tipoPessoa = $tipoPessoa;
    }

    /**
     * @return \Models\TipoPessoa
     */
    public function getTipoPessoa() {
        return $this->tipoPessoa;
    }
}