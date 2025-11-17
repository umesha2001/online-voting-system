<?php

require_once __DIR__ . '/../DatabaseTestCase.php';

class RegistrationTest extends DatabaseTestCase
{
    /**
     * Test successful user registration
     */
    public function testSuccessfulRegistration()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'mobile' => '9876543210',
            'address' => '123 Main St',
            'password' => 'password123',
            'photo' => '',
            'role' => 1
        ];

        // Act
        $userId = $this->insertTestUser($userData);

        // Assert
        $this->assertGreaterThan(0, $userId);
        
        $user = $this->getUserById($userId);
        $this->assertEquals($userData['name'], $user['name']);
        $this->assertEquals($userData['mobile'], $user['mobile']);
        $this->assertEquals($userData['address'], $user['address']);
        $this->assertEquals($userData['password'], $user['password']);
        $this->assertEquals($userData['role'], $user['role']);
        $this->assertEquals(0, $user['status']); // Should be not voted
        $this->assertEquals(0, $user['votes']); // Should have 0 votes
    }

    /**
     * Test duplicate mobile number registration
     */
    public function testDuplicateMobileRegistration()
    {
        // Arrange
        $mobile = '9876543210';
        $userData1 = [
            'name' => 'User One',
            'mobile' => $mobile,
            'address' => 'Address 1',
            'password' => 'pass1',
            'role' => 1
        ];

        // Act - Insert first user
        $userId1 = $this->insertTestUser($userData1);
        $this->assertGreaterThan(0, $userId1);

        // Try to insert duplicate mobile
        $userData2 = [
            'name' => 'User Two',
            'mobile' => $mobile, // Same mobile
            'address' => 'Address 2',
            'password' => 'pass2',
            'role' => 1
        ];

        $sql = "INSERT INTO user (name, mobile, address, password, photo, role, status, votes) 
                VALUES ('{$userData2['name']}', '{$userData2['mobile']}', '{$userData2['address']}', 
                        '{$userData2['password']}', '', '{$userData2['role']}', 0, 0)";
        
        // Suppress mysqli exception
        $oldErrorReporting = error_reporting(0);
        $result = @mysqli_query($this->conn, $sql);
        error_reporting($oldErrorReporting);

        // Assert - Should fail due to duplicate mobile
        $this->assertFalse($result);
        $error = mysqli_error($this->conn);
        $this->assertTrue(strpos($error, 'Duplicate entry') !== false);
    }

    /**
     * Test voter registration
     */
    public function testVoterRegistration()
    {
        // Arrange & Act
        $voterId = $this->insertTestUser([
            'name' => 'Voter User',
            'mobile' => '1111111111',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1 // Voter role
        ]);

        // Assert
        $voter = $this->getUserById($voterId);
        $this->assertEquals(1, $voter['role']);
        $this->assertEquals(0, $voter['status']);
    }

    /**
     * Test candidate/group registration
     */
    public function testCandidateRegistration()
    {
        // Arrange & Act
        $candidateId = $this->insertTestUser([
            'name' => 'Candidate User',
            'mobile' => '2222222222',
            'address' => 'Candidate Address',
            'password' => 'candidatepass',
            'role' => 2 // Candidate role
        ]);

        // Assert
        $candidate = $this->getUserById($candidateId);
        $this->assertEquals(2, $candidate['role']);
        $this->assertEquals(0, $candidate['votes']); // Initial votes should be 0
    }

    /**
     * Test registration with photo
     */
    public function testRegistrationWithPhoto()
    {
        // Arrange & Act
        $userId = $this->insertTestUser([
            'name' => 'User With Photo',
            'mobile' => '3333333333',
            'address' => 'Photo User Address',
            'password' => 'photopass',
            'photo' => 'user_photo.jpg',
            'role' => 1
        ]);

        // Assert
        $user = $this->getUserById($userId);
        $this->assertEquals('user_photo.jpg', $user['photo']);
    }

    /**
     * Test multiple users can be registered
     */
    public function testMultipleUsersRegistration()
    {
        // Arrange & Act
        $user1Id = $this->insertTestUser([
            'name' => 'User 1',
            'mobile' => '4444444444',
            'address' => 'Address 1',
            'password' => 'pass1',
            'role' => 1
        ]);

        $user2Id = $this->insertTestUser([
            'name' => 'User 2',
            'mobile' => '5555555555',
            'address' => 'Address 2',
            'password' => 'pass2',
            'role' => 2
        ]);

        $user3Id = $this->insertTestUser([
            'name' => 'User 3',
            'mobile' => '6666666666',
            'address' => 'Address 3',
            'password' => 'pass3',
            'role' => 1
        ]);

        // Assert
        $this->assertGreaterThan(0, $user1Id);
        $this->assertGreaterThan(0, $user2Id);
        $this->assertGreaterThan(0, $user3Id);
        $this->assertNotEquals($user1Id, $user2Id);
        $this->assertNotEquals($user2Id, $user3Id);
    }
}
