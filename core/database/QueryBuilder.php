<?php

class QueryBuilder {

    protected $pdo;

    public function __construct ( PDO $pdo ) {

        $this->pdo = $pdo;

    }

    public function selectAll ( $table ) {

        $stmt = $this->pdo->prepare("SELECT * FROM {$table};");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    public function insert ( $table, $parameters ) {

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s);',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters)),
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
        } catch ( Exception $e ) {
            die('Ups! Midagi läks valesti!');
        }

    }

}