<?php

// By: Edson Onildo Junior

// Testando o Crud com PDO

# Carrega todas as Classes
require_once 'classes/autoload.php';

# Instancia a class Usuario
$usuario = new Usuario();

# Atribue campos e seus valores ao array_campos_valores
$usuario->addCampo("sexo", "masculino");

# Remove campos e seus valores do array_campo_valores
$usuario->delCampo("sexo");

# Atualiza valores do array_campo_valores em campos ja existentes
$usuario->setValor("nome", "Edson");
$usuario->setValor("sobrenome", "Onildo");
$usuario->setValor("email", "edsononildo@live.com");
$usuario->setValor("senha", md5("12345"));

# Recupera o valor array_campo_valores apratir de seu campo
echo $usuario->getValor("nome") . " " . $usuario->getValor("sobrenome") . "<br />";

# Insere as informações contidas em array_campo_valores no Banco de Dados
//$usuario->insert();

# Atualiza o valor do valorpk
$usuario->valorpk = 9;

# Remove as informações contidas em array_campo_valores no Banco de Dados
//$usuario->delete();

# Atualiza o valor do valorpk
$usuario->valorpk = 6;

# Atualiza valores do array_campo_valores em campos ja existentes
$usuario->setValor("nome", "Maria");
$usuario->setValor("sobrenome", "Joaquina");
$usuario->setValor("email", "mariajoaquina@gmail.com");

# Atualiza as informações contidas em array_campo_valores no Banco de Dados
//$usuario->update();

# Remove campos e seus valores do array_campo_valores
$usuario->delCampo("email");
$usuario->delCampo("senha");
$usuario->delCampo("sobrenome");

# Atribue um recurso extra para selecao
$usuario->extrasSelect = "WHERE nome = :nome";

# Recupera as informações do Banco de Dados
//$usuario->select();

# Recupera o numero de linhas afetadas pela selecao
//echo 'O numero de linhas afetadas pela selecao foi "' . $usuario->rows() . '".';

echo "<br /><br />";

# Realiza um loop mostrando os resultados encontrados pela selecao .. Modo1
/**
while ($fetch = $usuario->fetch()) {
	
	echo "Nome: " . $fetch->nome . " " . $fetch->sobrenome . "<br />" . "Email: " . $fetch->email;
	
}
*/

# Realiza um loop mostrando os resultados encontrados pela selecao .. Modo2
/**
foreach ($usuario->fetchAll() as $fetch) {

	echo "Nome: " . $fetch->nome . " " . $fetch->sobrenome . "<br />" . "Email: " . $fetch->email;

}
*/

echo "<br />";

# Imprime o objeto Usuario
var_dump($usuario);