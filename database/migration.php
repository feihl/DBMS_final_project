<?php

// Database configuration
$host = 'localhost';
$dbName = 'movies';
$username = 'root';
$password = '';

try {
    // Connect to the MySQL server
    $pdo = new PDO("mysql:host=$host;", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database exists
    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$dbName]);

    if ($stmt->rowCount() == 0) {
        // Create the database if it doesn't exist
        $pdo->exec("CREATE DATABASE $dbName");
        echo "Database '$dbName' created successfully!" . PHP_EOL;
    } else {
        echo "Database '$dbName' already exists!" . PHP_EOL;
    }

    // Connect to the specified database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the migration table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255),
            migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Define the migration SQL queries for multiple tables
    $tables = [
        'table1' => "
            CREATE TABLE IF NOT EXISTS user_account (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                password VARCHAR(255),
                access VARCHAR(255),
                active VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
        'table2' => "
            CREATE TABLE IF NOT EXISTS tbl_user_information (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_account_id int,
                email VARCHAR(255),
                fName VARCHAR(255),
                mName VARCHAR(255),
                lName VARCHAR(255),
                address VARCHAR(255),
                contactNo VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table3' => "
            CREATE TABLE IF NOT EXISTS tbl_movie_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                cast VARCHAR(255),
                director VARCHAR(255),
                img VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table4' => "
            CREATE TABLE IF NOT EXISTS tbl_movie_genre (
                id INT AUTO_INCREMENT PRIMARY KEY,
                genreType VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table5' => "
            CREATE TABLE IF NOT EXISTS tbl_movie_about (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tbl_movie_info_id int,
                tbl_movie_genre_id  VARCHAR(255),
                description VARCHAR(255),
                duration VARCHAR(255),
                year_release VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table6' => "
            CREATE TABLE IF NOT EXISTS tbl_movie_inventory_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tbl_movie_info_id int,
                price int,
                qty int,
                available int,
                borrowed int,
  
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table7' => "
            CREATE TABLE IF NOT EXISTS tbl_customer_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
            
                email VARCHAR(255),
                fName VARCHAR(255),
                mName VARCHAR(255),
                lName VARCHAR(255),
                address VARCHAR(255),
                contactNo VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
               'table8' => "
            CREATE TABLE IF NOT EXISTS tbl_rents_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tbl_user_information_id INT,
                tbl_customer_info_id INT,
                tbl_movie_info_id INT,
                requestedDate DATE,
                requestedQty INT,
                requestedAmount INT,
                status VARCHAR(255),
          
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ",
                   'table9' => "
            CREATE TABLE IF NOT EXISTS tbl_history_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tbl_rents_info_id int,
                duration INT(255),
                collected INT,
                remark VARCHAR(255),
                contactNo VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        "
    ];

    // Execute the migrations if they haven't been migrated before
    $migrationsExecuted = [];
    $stmt = $pdo->prepare("SELECT migration_name FROM migrations");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $migrationsExecuted[] = $row['migration_name'];
    }

    foreach ($tables as $tableName => $query) {
        if (!in_array($tableName, $migrationsExecuted)) {
            $pdo->exec($query);
            $pdo->prepare("INSERT INTO migrations (migration_name) VALUES (?)")->execute([$tableName]);
            echo "Migration for $tableName executed successfully!\n\n" . PHP_EOL;
        } else {
            echo "Migration for $tableName already executed!\n\n" . PHP_EOL;
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
