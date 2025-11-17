<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    /**
     * Test database connection parameters
     */
    public function testDatabaseConnectionParameters()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $dbName = getenv('DB_NAME') ?: 'online-voting-system-test';

        $this->assertTrue(!empty($host));
        $this->assertTrue(!empty($user));
        $this->assertTrue(!empty($dbName));
    }

    /**
     * Test connection to MySQL server
     */
    public function testMySQLConnection()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';

        $conn = @mysqli_connect($host, $user, $pass);

        $this->assertTrue($conn !== false, 'Failed to connect to MySQL: ' . mysqli_connect_error());

        if ($conn) {
            mysqli_close($conn);
        }
    }
}
