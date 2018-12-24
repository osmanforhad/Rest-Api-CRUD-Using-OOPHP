<?php

//Api.php

class API {

    private $connect = '';

    function __construct() {
        $this->database_connection();
    }

    function database_connection() {
        $this->connect = new PDO("mysql:host=localhost;dbname=RestApi", "root", "");
    }

    function fetch_all() {
        $query = "SELECT * FROM user ORDER BY id";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function insert() {
        if (isset($_POST["first_name"])) {
            $form_data = array(
                ':first_name' => $_POST["first_name"],
                ':last_name' => $_POST["last_name"]
            );
            $query = "
			INSERT INTO user 
			(first_name, last_name) VALUES 
			(:first_name, :last_name)
			";
            $statement = $this->connect->prepare($query);
            if ($statement->execute($form_data)) {
                $data[] = array(
                    'success' => '1'
                );
            } else {
                $data[] = array(
                    'success' => '0'
                );
            }
        } else {
            $data[] = array(
                'success' => '0'
            );
        }
        return $data;
    }

    function fetch_single($id) {
        $query = "SELECT * FROM user WHERE id='" . $id . "'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            foreach ($statement->fetchAll() as $row) {
                $data['first_name'] = $row['first_name'];
                $data['last_name'] = $row['last_name'];
            }
            return $data;
        }
    }

    function update() {
        if (isset($_POST["first_name"])) {
            $form_data = array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':id' => $_POST['id']
            );
            $query = "
			UPDATE user 
			SET first_name = :first_name, last_name = :last_name 
			WHERE id = :id
			";
            $statement = $this->connect->prepare($query);
            if ($statement->execute($form_data)) {
                $data[] = array(
                    'success' => '1'
                );
            } else {
                $data[] = array(
                    'success' => '0'
                );
            }
        } else {
            $data[] = array(
                'success' => '0'
            );
        }
        return $data;
    }

    function delete($id) {
        $query = "DELETE FROM user WHERE id = '" . $id . "'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $data[] = array(
                'success' => '1'
            );
        } else {
            $data[] = array(
                'success' => '0'
            );
        }
        return $data;
    }

}

?>