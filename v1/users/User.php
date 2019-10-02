<?php


class User
{

    // database connection and table name
    private $conn;
    private $table_name = "tbl_user";

    // object properties
    public $user_id;
    public $user_name;
    public $password;
    public $email;
    public $full_name;
    public $address;
    public $gender;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function toJson()
    {
        return json_encode([
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'password' => $this->password,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'address' => $this->address,
            'gender' => $this->gender,
            'created' => $this->created
        ]);
    }

    // used by select drop-down list
    public function read()
    {

        //select all data
        $query = "SELECT
               *
            FROM
                " . $this->table_name . "
            ORDER BY
                user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }


    // create product
    function add()
    {

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_name=:user_name, password=:password, email=:email, full_name=:full_name, address=:address, gender=:gender, created=:created";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":created", $this->created);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    // register user
    function register()
    {
        if ($this->isAlreadyExist()) {
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                user_name=:user_name, password=:password, email=:email, created=:created";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":created", $this->created);

        // execute query
        if ($stmt->execute()) {
            $this->user_id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }


    // login user
    function login()
    {
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    user_name='" . $this->user_name . "' AND password='" . $this->password . "'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    function isAlreadyExist()
    {
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                user_name='" . $this->user_name . "'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }

    }

}