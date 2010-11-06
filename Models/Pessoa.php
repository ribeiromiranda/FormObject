<?php
namespace Models;

use Doctrine\DBAL\Types\IntegerType;

/**
 * 
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
     * @OneToOne(targetEntity="Models\TipoPessoa")
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
	 * @param field_type $_nome
	 */
	public function setNome($_nome) {
		$this->nome = $_nome;
	}

	/**
	 * @param field_type $_dataNascimento
	 */
	public function setDataNascimento($dataNascimento) {
		$this->dataNascimento = $dataNascimento;
	}

	/**
	 * @param field_type $_ativo
	 */
	public function setAtivo($_ativo) {
		$this->ativo = $_ativo;
	}

	
	
}