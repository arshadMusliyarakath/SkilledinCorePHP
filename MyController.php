<?php


trait DBConfig {
    protected $host = 'localhost';
    protected $port = '8889';
    protected $dbname = 'Skilledin';
    protected $username = 'root';
    protected $password = 'root';

    public function connect() {
        try {
            $db = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}


class Model {
    use DBConfig;

    public function all($table) {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM $table");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }


    public function find($table, $data) {
        $db = $this->connect();

        $where = '';

        foreach ($data as $key => $value) {
            $where = $where.$key." = '".$value."' AND ";
        }

        $where = substr($where, 0, -5);
        $query = "SELECT * FROM $table WHERE $where";

        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


    public function findSelect($table, $selectData, $whereData) {
        $db = $this->connect();

        $select = '';
        $where = '';

        foreach ($selectData as $value) {
            $select = $select.$value.", ";
        }
        foreach ($whereData as $key => $value) {
            $where = $where.$key." = '".$value."' AND ";
        }

        $select = substr($select, 0, -2);
        $where = substr($where, 0, -5);
        $query = "SELECT $select FROM $table WHERE $where";

        $stmt = $db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function create($table, $data) {
        $db = $this->connect();

        $into = '';
        $values = '';
        foreach ($data as $key => $value) {
            $into = $into.$key.", ";
            $values = $values."'".$value."', ";
        }

        $into = substr($into, 0, -2);
        $values = substr($values, 0, -2);
        $query = "INSERT INTO $table ($into) VALUES ($values)";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();

            $affectedRows = $stmt->rowCount();
            if ($affectedRows > 0) {
                return $db->lastInsertId();
            }
            else{
                return 0;
            }

            
        } catch (PDOException $e) {
            return 'error';
        }
    }

    public function update($table, $setData, $whereData) {
        $db = $this->connect();

        $set = '';
        $values = '';

        foreach ($setData as $key => $value) {
            $set = $set.$key." = '".$value."', ";
        }
        foreach ($whereData as $key => $value) {
            $values = $values.$key." = '".$value."' AND ";
        }

        $set = substr($set, 0, -2);
        $values = substr($values, 0, -5);
    
        $query = "UPDATE $table SET $set WHERE $values";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute();

            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                return 1;
            }
            else{
                return 0;
            }
        } catch (PDOException $e) {
            return 'error';
        }
    }


    public function delete($table, $data) {
        $db = $this->connect();

        $where = '';

        foreach ($data as $key => $value) {
            $where = $where.$key." = '".$value."' AND ";
        }
      
        $where = substr($where, 0, -5);
    
        $query = "DELETE FROM $table WHERE $where";


        try {
            $stmt = $db->prepare($query);
            $stmt->execute();

            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                return 1;
            }
            else{
                return 0;
            }
        } catch (PDOException $e) {
            return 'error';
        }
    }

    public function getAllTasks() {
        $db = $this->connect();
        $stmt = $db->query("SELECT ts.*, pr.project_name FROM tasks as ts LEFT JOIN projects as pr on pr.project_id = ts.project_id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAllEntry() {
        $db = $this->connect();
        $stmt = $db->query("SELECT et.hours, et.description, et.date, et.project_id, pr.project_name, tk.task_name FROM entry as et LEFT JOIN projects as pr on pr.project_id = et.project_id LEFT JOIN tasks as tk on tk.task_id = et.task_id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getProjectHours() {
        $db = $this->connect();
        $stmt = $db->query("SELECT et.project_id, pr.project_name, SUM(hours) AS total_hours FROM entry as et LEFT JOIN projects as pr on pr.project_id = et.project_id GROUP BY et.project_id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getProjectTask($projectId) {
        $db = $this->connect();
        $stmt = $db->query("SELECT et.*, ts.task_name FROM entry as et LEFT JOIN tasks as ts on ts.task_id = et.task_id WHERE et.project_id = $projectId");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function projectGroup() {
        $db = $this->connect();
        $stmt = $db->query("SELECT et.hours, et.description, et.date, et.project_id, pr.project_name, tk.task_name FROM entry as et LEFT JOIN projects as pr on pr.project_id = et.project_id LEFT JOIN tasks as tk on tk.task_id = et.task_id GROUP BY et.project_id");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
}


$model = new Model();
// $projects = $model->all('projects');

// $data = [ 'project_id' => 2, 'status' => '1'];
// $project = $model->find('projects', $data);

// $whereData = [ 'project_id' => 2, 'status' => '1'];
// $selectData = ['project_name'];
// $project = $model->findSelect('projects',$selectData, $whereData);


// $data = [
//     'project_name' => 'agin project',
//     'created_at' => '2dates'
// ];

// $project = $model->create('projects', $data);


// $setData = [
//     'project_name' => 'new project name',
//     'created_at' => 'new datresssssss'
// ];


// $whereData = [
//     'project_id' => '3',
//     'status' => '1'
// ];

// $project = $model->update('projects', $setData, $whereData);



// $data = [
//     'project_id' => '3',
//     'status' => '1'
// ];

// $project = $model->delete('projects', $data);
// print_r($project);


?>
