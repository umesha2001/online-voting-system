<?php

use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{
    protected $conn;
    protected $dbHost;
    protected $dbUser;
    protected $dbPass;
    protected $dbName;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Disable mysqli exceptions temporarily for setup
        mysqli_report(MYSQLI_REPORT_OFF);
        
        // Get database credentials from environment
        $this->dbHost = getenv('DB_HOST') ?: 'localhost';
        $this->dbUser = getenv('DB_USER') ?: 'root';
        $this->dbPass = getenv('DB_PASS') ?: '';
        $this->dbName = getenv('DB_NAME') ?: 'online-voting-system-test';

        // Create test database connection
        $this->conn = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass);
        
        if (!$this->conn) {
            $this->fail('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        // Create test database if not exists
        mysqli_query($this->conn, "CREATE DATABASE IF NOT EXISTS `{$this->dbName}`");
        mysqli_select_db($this->conn, $this->dbName);

        // Create user table
        $this->createTables();
        
        // Clear existing data
        $this->clearTables();
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        $this->clearTables();
        
        if ($this->conn) {
            mysqli_close($this->conn);
        }
        
        parent::tearDown();
    }

    protected function createTables(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `mobile` varchar(20) NOT NULL,
            `address` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `photo` varchar(255) NOT NULL,
            `role` int(11) NOT NULL COMMENT '1=Voter, 2=Group/Candidate',
            `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Not Voted, 1=Voted',
            `votes` int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            UNIQUE KEY `mobile` (`mobile`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        if (!mysqli_query($this->conn, $sql)) {
            $this->fail('Failed to create user table: ' . mysqli_error($this->conn));
        }
    }

    protected function clearTables(): void
    {
        mysqli_query($this->conn, "DELETE FROM user");
        mysqli_query($this->conn, "ALTER TABLE user AUTO_INCREMENT = 1");
    }

    protected function insertTestUser($data): int
    {
        $name = $data['name'] ?? 'Test User';
        $mobile = $data['mobile'] ?? '1234567890';
        $address = $data['address'] ?? 'Test Address';
        $password = $data['password'] ?? 'password123';
        $photo = $data['photo'] ?? '';
        $role = $data['role'] ?? 1;
        $status = $data['status'] ?? 0;
        $votes = $data['votes'] ?? 0;

        $sql = "INSERT INTO user (name, mobile, address, password, photo, role, status, votes) 
                VALUES ('$name', '$mobile', '$address', '$password', '$photo', '$role', '$status', '$votes')";

        if (mysqli_query($this->conn, $sql)) {
            return mysqli_insert_id($this->conn);
        }

        return 0;
    }

    protected function getUserById($id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM user WHERE id='$id'");
        return mysqli_fetch_assoc($result);
    }

    protected function getUserByMobile($mobile)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM user WHERE mobile='$mobile'");
        return mysqli_fetch_assoc($result);
    }
}
