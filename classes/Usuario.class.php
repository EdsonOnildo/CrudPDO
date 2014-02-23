<?php

# Classe responsavel pela tabela usuario do Banco de Dados ...
# ... PS: Toda tabela deve ter uma classe

class Usuario extends Base {

	// Metodos

	function __construct( $array = array() ) {

		# Chama a conecxao com o banco de dados
		Banco::instancia();
		
		# Define o nome da tabela
		$this->tabela = "usuario";

		# Define o campo de chave primaria
		$this->campopk = "id";

		# Atribue campos padroes ao array_campo_valores
		if (sizeof($array) <= 0) {

			$this->array_campo_valores = array(

			"nome" => NULL,
			"sobrenome" => NULL,
			"email" => NULL,
			"senha" => NULL,

			);

		} // if

	} // __construct

} // Usuario