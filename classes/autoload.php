<?php

# Carrega as defini��es
require_once 'definicoes.php';

# Fun��o responsavel por carregar todas as classes
function __autoload($classe = NULL) {
	
	$classe = str_replace("..", "", $classe);
	
	require_once "$classe.class.php";
	
}