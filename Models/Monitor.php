<?php
namespace Models;

/**
 * @Entity
 * @Table(name="monitor")
 */
class Monitor {
	
	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(name="id", type="integer")
	 */
	protected $id;
	
	/**
	 * @Column(name="marca", type="string")
	 */
	protected $marca;
	
	/**
	 * @Column(name="quantidade_cores", type="integer")
	 */
	protected $quantidadeCores;
	
	public function getQuantidadeCores() {
		return $this->quantidadeCores;
	}
	
	public function getMarca() {
		return $this->marca;
	}
	
	public function setQuantidadeCores($quantidadeCores) {
		$this->quantidadeCores = $quantidadeCores;
	}
	
	public function setMarca($marca) {
		$this->marca = $marca;
	}
}