<?php
class User{
    protected $db;
    protected $parentPath;
    public function __construct($database)
    {
        $this->db = $database;
        $this->parentPath = dirname(__DIR__)."\\Uploads\\";
    }
    /**
     * Get all records
     */
   
    public function getAllUsers()
    {
        $link = $this->db->openDbConnection();

        $result = $link->query('SELECT * FROM users ORDER BY id');
        
        $users = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
        $this->db->closeDbConnection($link);

		return $users;
    }

    /**
     * Get Single Record 
     * @param $id
     */
    public function getUserById($id)
    {
        $link = $this->db->openDbConnection();
        $query = 'SELECT users.*, files.file_name
        FROM users
        INNER JOIN files
        ON users.id=files.UserId
        WHERE users.id=:id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->db->closeDbConnection($link);
        return $row;

    }
	/**
     * Create Record
     */
    public function insert()
    {
        $link = $this->db->openDbConnection();
        $query = 'INSERT INTO users (name, email) VALUES (:name, :email)';
        $statement = $link->prepare($query);
        $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $statement->execute();
        $q = 'SELECT MAX(id) AS userId FROM users;';
        $statement = $link->prepare($q);
        $statement->execute();
        $userId = $statement->fetch(PDO::FETCH_ASSOC);
        $file_name =$this->uploadFile($_FILES["file_name"]);
        $query2 = 'INSERT INTO files (UserId, file_name) VALUES (:UserId, :file_name)';
        $statement2 = $link->prepare($query2);
        $statement2->bindValue(':UserId', $userId['userId'], PDO::PARAM_STR);
        $statement2->bindValue(':file_name', $file_name, PDO::PARAM_STR);
        $statement2->execute();
        $this->db->closeDbConnection($link);
    }

    /**
     * Update Record
     * @param $id
     */
    public function update($id)
    {
        $link = $this->db->openDbConnection();
        $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        // delete file
        $this->deleteFile($id);
        $file_name =$this->uploadFile($_FILES["file_name"]);
        $query2 = 'INSERT INTO files (UserId, file_name) VALUES (:UserId, :file_name)';
        $statement2 = $link->prepare($query2);
        $statement2->bindValue(':UserId', $id, PDO::PARAM_STR);
        $statement2->bindValue(':file_name', $file_name, PDO::PARAM_STR);
        $statement2->execute();
        $this->db->closeDbConnection($link);
    }

    /**
    * Delete Record
    * @param $id 
    */
    public function delete($id)
    {
        // delete file
        $this->deleteFile($id);
        $link = $this->db->openDbConnection();
        $query = "DELETE FROM users WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $this->db->closeDbConnection($link);
    }

    /**
     * upload File 
     * @param $file
     */
    private function uploadFile($file)
    {
        $target_file = $this->parentPath .basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename($file["name"])). " has been uploaded.";
            return $file["name"];
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
    }

    /**
     * delete File 
     * @param $file
     */
    private function deleteFile($id)
    {
        $link = $this->db->openDbConnection();
        $q = 'SELECT * FROM files WHERE UserId=:id';
        $statement = $link->prepare($q);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        unlink($this->parentPath.$row['file_name']);
        $query2 = "DELETE FROM files WHERE UserId = :id";
        $statement = $link->prepare($query2);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $this->db->closeDbConnection($link);
    }

}