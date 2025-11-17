<?php

require_once __DIR__ . '/../DatabaseTestCase.php';

class LoginTest extends DatabaseTestCase
{
    /**
     * Test successful voter login
     */
    public function testSuccessfulVoterLogin()
    {
        // Arrange - Create a voter
        $mobile = '9876543210';
        $password = 'voterpass123';
        $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => $mobile,
            'address' => 'Voter Address',
            'password' => $password,
            'role' => 1 // Voter
        ]);

        // Act - Query to check login
        $query = "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role=1";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(1, mysqli_num_rows($result));
        $user = mysqli_fetch_array($result);
        $this->assertEquals($mobile, $user['mobile']);
        $this->assertEquals(1, $user['role']);
    }

    /**
     * Test successful candidate login
     */
    public function testSuccessfulCandidateLogin()
    {
        // Arrange - Create a candidate
        $mobile = '1234567890';
        $password = 'candidatepass123';
        $this->insertTestUser([
            'name' => 'Test Candidate',
            'mobile' => $mobile,
            'address' => 'Candidate Address',
            'password' => $password,
            'role' => 2 // Candidate
        ]);

        // Act - Query to check login
        $query = "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role=2";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(1, mysqli_num_rows($result));
        $user = mysqli_fetch_array($result);
        $this->assertEquals($mobile, $user['mobile']);
        $this->assertEquals(2, $user['role']);
    }

    /**
     * Test login with invalid mobile number
     */
    public function testLoginWithInvalidMobile()
    {
        // Arrange - Create a user
        $this->insertTestUser([
            'name' => 'Test User',
            'mobile' => '9876543210',
            'address' => 'Address',
            'password' => 'correctpass',
            'role' => 1
        ]);

        // Act - Try to login with wrong mobile
        $query = "SELECT * FROM user WHERE mobile='0000000000' AND password='correctpass' AND role=1";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(0, mysqli_num_rows($result));
    }

    /**
     * Test login with invalid password
     */
    public function testLoginWithInvalidPassword()
    {
        // Arrange - Create a user
        $mobile = '9876543210';
        $this->insertTestUser([
            'name' => 'Test User',
            'mobile' => $mobile,
            'address' => 'Address',
            'password' => 'correctpass',
            'role' => 1
        ]);

        // Act - Try to login with wrong password
        $query = "SELECT * FROM user WHERE mobile='$mobile' AND password='wrongpass' AND role=1";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(0, mysqli_num_rows($result));
    }

    /**
     * Test login with wrong role
     */
    public function testLoginWithWrongRole()
    {
        // Arrange - Create a voter
        $mobile = '9876543210';
        $password = 'password123';
        $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => $mobile,
            'address' => 'Address',
            'password' => $password,
            'role' => 1 // Voter
        ]);

        // Act - Try to login as candidate
        $query = "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role=2";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(0, mysqli_num_rows($result));
    }

    /**
     * Test fetching groups/candidates after login
     */
    public function testFetchCandidatesAfterLogin()
    {
        // Arrange - Create voter and multiple candidates
        $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => '9876543210',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1
        ]);

        $candidate1Id = $this->insertTestUser([
            'name' => 'Candidate 1',
            'mobile' => '1111111111',
            'address' => 'Address 1',
            'password' => 'pass1',
            'role' => 2
        ]);

        $candidate2Id = $this->insertTestUser([
            'name' => 'Candidate 2',
            'mobile' => '2222222222',
            'address' => 'Address 2',
            'password' => 'pass2',
            'role' => 2
        ]);

        // Act - Fetch all candidates
        $query = "SELECT * FROM user WHERE role=2";
        $result = mysqli_query($this->conn, $query);
        $candidates = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Assert
        $this->assertCount(2, $candidates);
        $this->assertEquals('Candidate 1', $candidates[0]['name']);
        $this->assertEquals('Candidate 2', $candidates[1]['name']);
    }

    /**
     * Test login returns user data correctly
     */
    public function testLoginReturnsCorrectUserData()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'mobile' => '9876543210',
            'address' => '123 Main St',
            'password' => 'mypassword',
            'photo' => 'john.jpg',
            'role' => 1,
            'status' => 0,
            'votes' => 0
        ];
        $this->insertTestUser($userData);

        // Act
        $query = "SELECT * FROM user WHERE mobile='{$userData['mobile']}' AND password='{$userData['password']}' AND role={$userData['role']}";
        $result = mysqli_query($this->conn, $query);
        $user = mysqli_fetch_array($result);

        // Assert
        $this->assertNotNull($user);
        $this->assertEquals($userData['name'], $user['name']);
        $this->assertEquals($userData['mobile'], $user['mobile']);
        $this->assertEquals($userData['address'], $user['address']);
        $this->assertEquals($userData['photo'], $user['photo']);
        $this->assertEquals($userData['status'], $user['status']);
        $this->assertEquals($userData['votes'], $user['votes']);
    }

    /**
     * Test login with empty credentials
     */
    public function testLoginWithEmptyCredentials()
    {
        // Act
        $query = "SELECT * FROM user WHERE mobile='' AND password='' AND role=1";
        $result = mysqli_query($this->conn, $query);

        // Assert
        $this->assertEquals(0, mysqli_num_rows($result));
    }
}
