<?php

# Carrega as definiчѕes
require_once 'definicoes.php';

# Funчуo responsavel por carregar todas as classes
function __autoload($classe = NULL) {
	
	$classe = str_replace("..", "", $classe);
	
	require_once "$classe.class.php";
	
}