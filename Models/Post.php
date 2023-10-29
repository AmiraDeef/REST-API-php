<?php
class Post
{
    //db
    private $conn;
    private $table = 'posts';

    //post properties
    public $id;
    public $category_id;
    public $category_name; //join query
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor with db
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get all posts
    public function read()
    {
        //create query
        $query = 'SELECT 
              c.name as category_name, 
              p.id,
              p.category_id, 
              p.title,
              p.body,
              p.author,
              p.created_at
          FROM ' . $this->table . ' AS p  
          LEFT JOIN categories c ON p.category_id = c.id
          ORDER BY p.created_at desc';


        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }
    //get single post
    public function read_single_post()
    {
        $query = 'SELECT 
              c.name as category_name, 
              p.id,
              p.category_id, 
              p.title,
              p.body,
              p.author,
              p.created_at
          FROM ' . $this->table . ' AS p  
         LEFT JOIN categories c ON p.category_id = c.id 
         WHERE 
            p.id = ?
         LIMIT 0,1';
        //prapare query
        $stm = $this->conn->prepare($query);
        //bind id 
        $stm->bindParam(1, $this->id);
        $stm->execute();

        $row = $stm->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    //create post 
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET 
            title=:title
            ,body=:body,
            author=:author,
            category_id= :category_id';
        //prapare query
        $stm = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags(trim($this->title)));
        $this->body = htmlspecialchars(strip_tags(trim($this->body)));
        $this->author = htmlspecialchars(strip_tags(trim($this->author)));
        $this->category_id = htmlspecialchars(strip_tags(trim($this->category_id)));

        //bind data 
        $stm->bindParam(':title', $this->title);
        $stm->bindParam(':body', $this->body);
        $stm->bindParam(':author', $this->author);
        $stm->bindParam(':category_id', $this->category_id);

        //for execute
        if ($stm->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stm->error);
        return false;
    }
    public function Update()
    {
        $query = 'UPDATE ' . $this->table . '
        SET 
            title=:title
            ,body=:body,
            author=:author,
            category_id= :category_id
        WHERE 
            id=:id';
        //prapare query
        $stm = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags(trim($this->title)));
        $this->body = htmlspecialchars(strip_tags(trim($this->body)));
        $this->author = htmlspecialchars(strip_tags(trim($this->author)));
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));

        //bind data 
        $stm->bindParam(":id", $this->id);
        $stm->bindParam(':title', $this->title);
        $stm->bindParam(':body', $this->body);
        $stm->bindParam(':author', $this->author);
        $stm->bindParam(':category_id', $this->category_id);

        //for execute
        if ($stm->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stm->error);
        return false;
    }
    //Delete post
    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
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
