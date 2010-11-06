<?php

namespace Models;

/**
 * 
 * @Entity
 * @Table(name="tipos_pessoas")
 */
class TipoPessoa {
	
	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(name="id", type="integer")
	 */
	protected $id;

	/**
	 * @Column(name="nome", type="string")
	 */
	protected $nome;
	
	/**
	 * @Column(name="numero_documento", type="string")
	 */
	protected $document;

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $nome
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @return the $document
	 */
	public function getDocument() {
		return $this->document;
	}

	/**
	 * @param string $nome
	 */
	public function setNome($nome) {
		$this->nome = $nome;
	}

	/**
	 * @param string $document
	 */
	public function setDocument($document) {
		$this->document = $document;
	}


	
}