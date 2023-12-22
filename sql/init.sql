-- création de la base de données
CREATE DATABASE IF NOT EXISTS quizz;

-- création des tables
/*
les tables se composent de champs, qui sont composés d'un nom, puis du type, d'une clé (s'il y a) et des caractérisations
les noms des champs sont mis entre backquote (mais se n'est pas obligatoire) => utilisation car en cas de migration de version si le mot devenait un mot réservé par PHP, celui-ci est capable
de faire la différence entre le mot réservé et le nom des champs*
les types : INT (entier), 
            DECIMAL (nombre décimal), 
            VACHAR (chaine de charactère, ce type est suivi de parenthèse dans lequel on indique la longueur maximale de la chaine), 
            DATETIME (date + heure),
            ENUM (suivi de parenthèse dans lequel on énumère les propositions des valeurs, on les mets entre guillemets simples ou double et non entre backquote car ce n'est pas des noms de champs)
AUTO_INCREMENT => incrémente une valeur numérique par défaut
NOT NULL => le champs ne peut pas être vide
DEFAULT 'zzz' => met une valeur (ici 'zzz') par defaut dans le champ
UNIQUE => la valeur doit être unique dans la table
PRIMARY KEY => qui est une clé unique
FOREIGN KEY => clé étrangère permet de récupérer une valeur d'une autre table, FOREIGN KEY est suivi du nom du champ entre parenthèse dans lequel il doit inscrire la valeur de l'autre table puis
            du mot clé REFERENCES suivi du nom de la table, puis du champs de la table (`nom_de_la_table`(`nom_du_champ`), les backquotes ne sont pas obligatoires)
USE => permet d'indiquer la base de données dans laquelle faire les requêtes qui suivent (ici la création de table)
*/
USE quizz;

CREATE TABLE users
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `image` VARCHAR(100) NOT NULL,
    `session_token` VARCHAR(100)
);

CREATE TABLE theme 
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `alt` VARCHAR(255) NOT NULL
);

CREATE TABLE quizz
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `creator_id` INT NOT NULL,
    `theme_id` INT NOT NULL,
    FOREIGN KEY (`creator_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`theme_id`) REFERENCES `theme`(`id`)
);

CREATE TABLE questions
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `text` VARCHAR(1000) NOT NULL,
    `quizz_id` INT NOT NULL,
    FOREIGN KEY (`quizz_id`) REFERENCES `quizz`(`id`)
);

CREATE TABLE question_answers
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `question_id` INT NOT NULL,
    `text` VARCHAR(255) NOT NULL,
    `is_correct` BOOLEAN,
    FOREIGN KEY (`question_id`) REFERENCES `questions`(`id`)
);

CREATE TABLE participations
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `quizz_id` INT NOT NULL,
    `participation_dt` DATETIME NOT NULL,
    `score` INT DEFAULT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`quizz_id`) REFERENCES `quizz`(`id`)
);

CREATE TABLE user_question_answers
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `answer_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `participation_id` INT NOT NULL,
    FOREIGN KEY (`answer_id`) REFERENCES `question_answers`(`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`participation_id`) REFERENCES `participations`(`id`)
);
