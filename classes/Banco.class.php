<?php

# Classe responsável por todas as ligações com o Banco de Dados
class Banco {

	// Propriedades

	# Credenciais para conecxao com o Banco de Dados
	private $hostname = HOST;
	private $username = USER;
	private $password = PASS;
	private $database = BASE;

	# Tipo de Banco de Dados
	private $drive = DRIVE;

	# Armazena a conecxao com o Banco de Dados
	private static $conecxao = NULL;

	# Armazena a instancia da classe
	private static $instancia = NULL;

	# Armazena a ação junto ao Banco de Dados
	private static $dataset = NULL;

	// Metodos

	## Metodo Singleton para conecxao unica com o Banco de Dados ##

	# Metodo Construct onde é realizada a conecxao com o Banco de Dados
	private function __construct() {

		# Recupera as credenciais do conecxao
		$hostname = $this->hostname;
		$username = $this->username;
		$password = $this->password;
		$database = $this->database;

		# Recupera o tipo de Banco de Dados a ser utilizado
		$drive = $this->drive;

		# Cria o DSN para conecxao
		$dsn = "$drive:host=$hostname;dbname=$database";

		try {

			# Realiza a conecxao usando a função nativa PDO
			$conecxao = new PDO($dsn, $username, $password);
			$conecxao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			# Passa a conecxao a propriedade "conecxao"
			self::$conecxao = $conecxao;

		} catch (PDOException $e) {

			# Exibe erro em caso de falha
			echo $e->getMessage();

		}

	} // __construct

	# Metodo utilizado para instanciar a classe
	public static function instancia() {

		if (!isset(self::$instancia) && is_null(self::$instancia)) {

			# Armazena a propria classe
			$classe = __CLASS__;

			# Atribue a propriedade "instancia" a CLASSE
			self::$instancia = new $classe;

		}

		return self::$instancia;

	} // instancia

	## Fim do Metodo Singleton ##

	# Metodo responsavel pela execuxao da SQL
	private function executaSQL($sql) {

		# Prepara a SQL
		$executaSql = self::$conecxao->prepare($sql);

		# Checa de qual metodo a sql veio
		$string = strtolower(substr($sql, 0, 6));

		# Coloca o ponteiro do array_campo_valores ao inicio
		reset($this->array_campo_valores);

		# Recupera os campos do array_campo_valores
		for ($i = 0; $i < count($this->array_campo_valores); $i++) {

			# BindValue
			switch ($string) {
				case "insert":
					$executaSql->bindValue(":" . key($this->array_campo_valores), $this->array_campo_valores[key($this->array_campo_valores)]);
					break;
				case "update":
					$executaSql->bindValue(":" . key($this->array_campo_valores), $this->array_campo_valores[key($this->array_campo_valores)]);
					$executaSql->bindValue(":" . $this->campopk, $this->valorpk);
					break;
				case "delete":
					$executaSql->bindValue(":" . $this->campopk, $this->valorpk);
					break;
				case "select":
					$executaSql->bindValue(":" . key($this->array_campo_valores), $this->array_campo_valores[key($this->array_campo_valores)]);
					break;
			}

			# Avanca o ponteiro do array_campo_valores em uma casa
			next($this->array_campo_valores);

		}

		if ($executaSql->execute()) {
				
			$this->linhasAfetadas = +1;
			self::$dataset = $executaSql;
				
			echo "<br />Realizado!<br /><br />";
				
		}

	}

	# Metodo responsavel pela insercao de dados no BD
	public function insert() {

		# Inicia a sql de Insercao
		$sql = "INSERT INTO $this->tabela ( ";

		# Coloca o ponteiro do array_campo_valores ao inicio
		reset($this->array_campo_valores);

		# Recupera os campos do array_campo_valores
		for ($i = 0; $i < count($this->array_campo_valores); $i++) {

			$sql .= key($this->array_campo_valores);

			# Insere uma virgula apos cada campo, exeto no ultimo
			if ($i < count($this->array_campo_valores) -1) {

				$sql .= ", ";

			}

			# Avanca o ponteiro do array_campo_valores em uma casa
			next($this->array_campo_valores);

		}

		# Continua a Sql de Insercao
		$sql .= " ) VALUES ( ";

		# Coloca o ponteiro do array_campo_valores ao inicio
		reset($this->array_campo_valores);

		# Recupera os campos do array_campo_valores
		for ($i = 0; $i < count($this->array_campo_valores); $i++) {

			$sql .= ":" . key($this->array_campo_valores);

			# Insere uma virgula apos cada campo, exeto no ultimo
			if ($i < count($this->array_campo_valores) -1) {

				$sql .= ", ";

			}

			# Avanca o ponteiro do array_campo_valores em uma casa
			next($this->array_campo_valores);

		}

		# Continua a Sql de Insercao
		$sql .= " )";

		return $this->executaSql($sql);

	} // insert

	# Metodo responsavel pela exclusao de dados no BD
	public function delete() {

		# Forma a SQL de exlusao
		$sql = "DELETE FROM $this->tabela WHERE $this->campopk = :$this->campopk";

		return $this->executaSql($sql);

	} // delete

	# Metodo responsavel pela atualizacao de dados no BD
	public function update() {

		# Inicia a SQL de atualizacao

		$sql = "UPDATE $this->tabela SET ";

		# Coloca o ponteiro do array_campo_valores ao inicio
		reset($this->array_campo_valores);

		# Recupera os campos do array_campo_valores
		for ($i = 0; $i < count($this->array_campo_valores); $i++) {

			$sql .= key($this->array_campo_valores) . " = :" . key($this->array_campo_valores);

			# Insere uma virgula apos cada campo, exeto no ultimo
			if ($i < count($this->array_campo_valores) -1) {

				$sql .= ", ";

			}

			# Avanca o ponteiro do array_campo_valores em uma casa
			next($this->array_campo_valores);

		}

		# Continua a SQL de atualizacao
		$sql .= " WHERE $this->campopk = :$this->campopk";

		return $this->executaSql($sql);

	} // Update

	# Metodo responsavel pela selecao de dados no BD
	public function select($especial = NULL) {

		# Inicia SQL de Selecao
		$sql = "SELECT ";

		if (is_null($especial)) :
			
		$sql .= "*";

		elseif($especial == "all") :

		# Coloca o ponteiro do array_campo_valores ao inicio
		reset($this->array_campo_valores);
			
		# Recupera os campos do array_campo_valores
		for ($i = 0; $i < count($this->array_campo_valores); $i++) {

			$sql .= key($this->array_campo_valores);

			# Insere uma virgula apos cada campo, exeto no ultimo
			if ($i < count($this->array_campo_valores) -1) {
					
				$sql .= ", ";
					
			}

			# Avanca o ponteiro do array_campo_valores em uma casa
			next($this->array_campo_valores);

		}
			
		elseif($especial == "count") :

		$sql .= "count(*)";
			
		endif;

		# Continua a SQL de selecao
		$sql .= " FROM $this->tabela";

		# Inclui selecao extra, se houver
		if (!is_null($this->extrasSelect)) {

			$sql .= " $this->extrasSelect";

		}

		return $this->executaSql($sql);

	} // insert

	# Recupera o numero de linhas afetadas pela selecao
	public function rows() {

		return self::$dataset->rowCount();

	} // rows

	public function fetch( $tipo = "OBJ" ) {

		switch ($tipo) {
			case "OBJ":
				return self::$dataset->fetch(PDO::FETCH_OBJ);
				break;
			case "ASSOC":
				return self::$dataset->fetch(PDO::FETCH_ASSOC);
				break;
			default:
				return self::$dataset->fetch(PDO::FETCH_OBJ);
				break;
		}

	} // fetch

	public function fetchAll( $tipo = "OBJ" ) {

		switch ($tipo) {
			case "OBJ":
				return self::$dataset->fetchAll(PDO::FETCH_OBJ);
				break;
			case "ASSOC":
				return self::$dataset->fetchAll(PDO::FETCH_ASSOC);
				break;
			default:
				return self::$dataset->fetchAll(PDO::FETCH_OBJ);
				break;
		}

	} // fetchAll

}