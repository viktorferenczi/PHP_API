<?php
namespace Src\TableGateways;

class ContactsGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, name, email, phone, address
            FROM
                contacts;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
                id, name, email, phone, address
            FROM
                contacts
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO contacts 
                (name, email, phone, address)
            VALUES
                (:name, :email, :phone, :address);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'email'  => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE contacts
            SET 
                email  = :email
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'email'  => $input['email'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}