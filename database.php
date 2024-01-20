<?php
$localhost = 'localhost:3806';
$username = 'root';
$password = '';
$database = 'products';
class database{
    private $connection ;
    public function connect($localhost,$username,$password,$database){
        $this->connection = new mysqli($localhost,$username,$password,$database);
        if($this->connection->connect_error){
            echo 'ERROR : '. $this->connection->connect_error . '<br>';
        }
    }
    public function exec($sql){
        $exec_query = $this->connection->query($sql);
        if(gettype($exec_query) == 'boolean'){
            if($exec_query == true){
                // echo "Query Executed Successfully" . '<br>';
            } elseif($exec_query == false){
                echo "ERROR During Execution" . '<br>';
                return NULL;
            } 
        } else{

            if($exec_query->num_rows > 0){ // select
                return $exec_query->fetch_all(MYSQLI_ASSOC);
                // while($p = $exec_query->fetch_assoc()){
                //     echo '<pre>';
                //     print_r($p);
                //     echo '</pre>';
                // }
            } else{
                return NULL;
            }
        }
        
        //close database
        $this->connection->close();
    }
}

// $sql = "CREATE TABLE products (
// product VARCHAR(50) NOT NULL,
// product_company VARCHAR(50) NOT NULL,
// product_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// product_link VARCHAR(250) NOT NULL,
// product_imgSrc VARCHAR(250) NOT NULL,
// product_description VARCHAR(100) NOT NULL,
// product_price INT(20) NOT NULL,
// product_priceSymbol VARCHAR(20) NOT NULL,
// product_rating DOUBLE(2,1),
// product_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// $sql = "CREATE DATABASE products";
// $database = '';

// $x = new database();
// $x->connect($localhost,$username,$password,$database);
// $x->exec($sql);


// $sql = "INSERT INTO products (product_imgSrc,product_description,product_price,product_priceSymbol) VALUES ('s','s',1,'e')";
