<?php

# Classe de Base para todos as outras, auxilia a class Banco

class Base extends Banco {

	// Propriedades
	
	# Tabela a ser utilizada
	protected $tabela = NULL;

	# Array com os campos e valores da tabela citada acima
	protected $array_campo_valores = array();
	
	# Campo de chave primaria
	protected $campopk = NULl;
	
	# Valor da chave primaria
	public $valorpk = NULL;
	
	# Numero de Linhas Afetadas
	public $linhasAfetadas = -1;
	
	# Utilizado para seleções extras. Ex.: WHERE, LIKE, ORDER BY, etc
	public $extrasSelect = NULL;
	
	// Metodos
	
	# Adiciona um campo e seu valor ao array_campo_valores
	public function addCampo($campo = NULL, $valor = NULL) {
		
		if (!is_null($campo) && !is_null($valor)) {
			
			$this->array_campo_valores[$campo] = $valor;
			
		}
		
	} // addCampo
	
	# Remove um campo e seu valor do array_campo_valores
	public function delCampo($campo = NULL) {
		
		if (!is_null($campo)) {
			
			unset($this->array_campo_valores[$campo]);
			
		}
		
	} // delCampo
	
	# Atualiza um valor de um campo ja existente no array_campo_valores
	public function setValor($campo = NULL, $valor = NULL) {
		
		if (!is_null($campo) && !is_null($valor) && array_key_exists($campo, $this->array_campo_valores)) {
			
			$this->array_campo_valores[$campo] = $valor;
			
		}
		
	} // setValor
	
	# Recupera um valor do array_campo_valores de acordo com seu campo
	public function getValor($campo = NULL) {
		
		if (!is_null($campo) && array_key_exists($campo, $this->array_campo_valores)) {
			
			return $this->array_campo_valores[$campo];
			
		}
		
	} // getValor
	
}