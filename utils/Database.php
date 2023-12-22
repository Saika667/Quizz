<?php

/*
class permettant de faire la connection à la base de données
les propriétés de classe sont tous en "private" car il n'y a pas besoin qu'ils soient accessible en dehors de la classe (il existe aussi public et protected)
$charset correspond à l'encodage et $pdo correspond à l'instance de la class PDO qui sert à faire des requêtes avec la base de données

Les fonctions construct et destruct sont précédés de deux underscores car se sont des fonctions prévues par PHP, il ne peut pas y avoir de type de retour sur ce type de fonction

Pour utiliser une propriété de classe on utilise le "$this->" avant de nom de la propriété sauf lorsque la propriété est static
*/
class Database {
    private string $host;
    private string $user;
    private string $password;
    private string $dbName;
    private string $charset;
    private ?PDO $pdo;
    /*
    Dans la fonction __construct, on lui passe un tableau config qui va nous servir à remplir les propriétés de class
    */
    public function __construct(array $config) {
        $this->host = $config["host"];
        $this->user = $config["user"];
        $this->password = $config["password"];
        $this->dbName = $config["dbName"];
        $this->charset = $config["charset"];

        $this->connect();
    }
    /*
    Cette fonction sert à faire la connection à la base de données, elle est mise en "private" car elle ne doit être accessible que dans la classe
    le ": void" indique le retour de la fonction, void indique que la fonction ne retourne rien
    $dsn (data source name) contient les informations requises pour se connecter à la base (le chemin, le nom de la base et l'encodage)
    */
    private function connect(): void {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset};";
        /*
        dans une variable pdo, on instancie un objet PDO avec entre parenthèse les paramètres qui seront passé au __construct de la classe PDO
        setAttribute est une méthode (ou fonction) de la classe PDO qui sert à configurer des attributs du gestionnaire de base de données 
            1er argument : valeur à modifier, 2eme argument : attribut à lui donner
        pour utiliser un attribut de la classe PDO on utilise "PDO::" avant le nom de l'attribut car il s'agit d'une const
        ATTR_ERRMODE c'est le mode pour reporter les erreurs et ERRMODE_EXCEPTION sert à remonter les erreurs en tant qu'exception
        PDOException c'est une classe. $e c'est l'erreur, une instance de la classe PDOException.
        $this->pdo =  null signifie que le destruct va être appelé en cas d'erreur. 
        die veut dire fin du script.
        getMessage est une méthode de la class PDOException (on trouvera cette méthode dans la classe exception, car PDOException étend la classe runtimeexception qui elle même étend la classe exception)
        une classe A étendu à une classe B veut dire que la classe A à accès aux méthodes de la classe B (si celle-ci ne sont pas en privée)
        */
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo 'Connecté à la base de données';
        } catch (PDOException $e) {
            $this->pdo = null;
            die("Echec de la connexion : " . $e->getMessage());
        }
    }
    /*
    cette fonction sert à préparer une query (une requête SQL) et à l'executer, elle prend en paramètre la query sous forme de string et un tableau de paramètre (si le tableau n'existe pas on
    l'initialise à tableau vide), cette fonction retourne un objet PDOStatement. Cette fonction sert à faire des insertions ou des mises à jour de la base de données
    dans le $stmt on enregistre le resultat de la méthode prepare de la classe PDO, ca prepare une requête SQL à être executer par la méthode PDOStatement::execute()
    puis on execute la requête avec $stmt->execute en ajoutant un tableau params avec les variables à l'intérieur
    */
    public function query(string $query, array $params = []): PDOStatement {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    /*
    cette fonction permet de récupérer toutes les lignes de la base de données qui correspondent à la requête, cette fonction retourne un tableau, pour cela :
    on utilise la fonction précédente query puis à partir du résultat de celle-ci, on utilise la méthode fetchAll de la classe PDOStatement, on passe en paramètre PDO::FETCH_ASSOC
    PDO::FETCH_ASSOC => il s'agit d'un attribut (const) de la classe PDO et signifie qu'on veut en retour un tableau associatif
    */
    public function fetchAll(string $query, array $params = []): array {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
    cette fonction permet de recupérer une seule ligne de la base de données, elle prend en paramètre la même chose que pour fetchAll et retourne un tableau
    on utilise le résultat de la fonction précédente query et on réalise un fetch (méthode de la classe PDOStatement), on lui passe en paramètre PDO::FETCH_ASSOC pour avoir en retour un 
    tableau associatif
    en valeur de retour on ajoute "false" dans le cas ou l'utilisateur n'existe pas
    */
    public function fetch(string $query, array $params = []): array|false {
        $stmt = $this->query($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*
    Cette fonction sert à récupérer l'id du dernier objet insérer dans la base de données, en valeur de retour elle retourne soit un booléen, soit une string, il est possible depuis seulement
    PHP 8 de mettre en type de retour deux possibilités pour cela il suffit de séparer les types par "|"
    on utilise la méthode lastInsertId de la classe PDO, si la méthode ne trouve rien elle retourne false sinon elle retourne le résultat sous forme de string
    */
    public function lastInsertId(): bool|string {
        return $this->pdo->lastInsertId();
    }
    /*
    cette fonction est prévue par PHP, elle sert à détruire la connection.
    comme dans cette fonction nous avons mis pdo = null, lorsque l'on déclare les attributs au début de la classe on doit mettre "private ?PDO $pdo;" et non pas "private PDO $pdo;", on
    ajoute un "?"
    */
    public function __destruct() {
        $this->pdo = null;
    }
}
