<?php
class Category
{
    //db
    private $conn;
    private $table = 'categories';
    //post properties
    public $id;
    public $name;
    public $created_at;

    //constructor with db
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function read()
    {
        //create query
        $query = 'SELECT 
        id , name  FROM ' . $this->table . '
        ORDER BY created_at DESC ';
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }
    public function read_single_category()
    {
        //create query
        $query = 'SELECT 
        id , name  FROM ' . $this->table . '
        WHERE id= :id ';

        //prapare query
        $stm = $this->conn->prepare($query);
        //bind id 
        $stm->bindParam(":id", $this->id);
        $stm->execute();

        $row = $stm->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->name = $row['name'];
        $this->id = $row['id'];
    }
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET 
            name=:name';
        //prapare query
        $stm = $this->conn->prepare($query);

        //clean data


        $this->name = htmlspecialchars(strip_tags(trim($this->name)));
        //bind data 

        $stm->bindParam(':name', $this->name);

        //for execute
        if ($stm->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stm->error);
        return false;
    }
    public function Update()
    {
        $query = 'UPDATE ' . $this->table . ' SET name=:name WHERE id=:id';
        // Prepare the query
        $stm = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags(trim($this->name)));
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));

        // Bind data 
        $stm->bindParam(":id", $this->id);
        $stm->bindParam(':name', $this->name);

        // Execute
        if ($stm->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stm->error);
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id =:id";
        //prapare query
        $stm = $this->conn->prepare($query);
        //clean id
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));
        //bind id
        $stm->bindParam(":id", $this->id);

        if ($stm->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stm->error);
        return false;
    }
}
