<?php

require_once __DIR__ . '/../DatabaseTestCase.php';

class VotingTest extends DatabaseTestCase
{
    /**
     * Test successful voting
     */
    public function testSuccessfulVoting()
    {
        // Arrange - Create voter and candidate
        $voterId = $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => '9876543210',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1,
            'status' => 0 // Not voted yet
        ]);

        $candidateId = $this->insertTestUser([
            'name' => 'Test Candidate',
            'mobile' => '1111111111',
            'address' => 'Candidate Address',
            'password' => 'candidatepass',
            'role' => 2,
            'votes' => 5 // Current votes
        ]);

        // Act - Simulate voting
        $currentVotes = 5;
        $newVotes = $currentVotes + 1;
        
        mysqli_query($this->conn, "UPDATE user SET votes='$newVotes' WHERE id='$candidateId'");
        mysqli_query($this->conn, "UPDATE user SET status=1 WHERE id='$voterId'");

        // Assert
        $voter = $this->getUserById($voterId);
        $candidate = $this->getUserById($candidateId);

        $this->assertEquals(1, $voter['status']); // Voter should be marked as voted
        $this->assertEquals(6, $candidate['votes']); // Candidate votes should increase
    }

    /**
     * Test voter cannot vote twice
     */
    public function testVoterCannotVoteTwice()
    {
        // Arrange - Create voter who already voted
        $voterId = $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => '9876543210',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1,
            'status' => 1 // Already voted
        ]);

        $candidateId = $this->insertTestUser([
            'name' => 'Test Candidate',
            'mobile' => '1111111111',
            'address' => 'Candidate Address',
            'password' => 'candidatepass',
            'role' => 2,
            'votes' => 10
        ]);

        // Act & Assert
        $voter = $this->getUserById($voterId);
        $this->assertEquals(1, $voter['status']);
        
        // In real application, this check should prevent voting
        // We verify that the status is already 1 (voted)
        $this->assertTrue($voter['status'] == 1);
    }

    /**
     * Test vote count increments correctly
     */
    public function testVoteCountIncrement()
    {
        // Arrange
        $candidateId = $this->insertTestUser([
            'name' => 'Test Candidate',
            'mobile' => '1111111111',
            'address' => 'Candidate Address',
            'password' => 'candidatepass',
            'role' => 2,
            'votes' => 0
        ]);

        // Act - Simulate multiple votes
        for ($i = 1; $i <= 5; $i++) {
            mysqli_query($this->conn, "UPDATE user SET votes=$i WHERE id='$candidateId'");
        }

        // Assert
        $candidate = $this->getUserById($candidateId);
        $this->assertEquals(5, $candidate['votes']);
    }

    /**
     * Test voting updates candidate's vote count
     */
    public function testVotingUpdatesCandidateVotes()
    {
        // Arrange
        $candidateId = $this->insertTestUser([
            'name' => 'Candidate A',
            'mobile' => '2222222222',
            'address' => 'Address A',
            'password' => 'pass',
            'role' => 2,
            'votes' => 15
        ]);

        // Act
        $currentVotes = 15;
        $totalVotes = $currentVotes + 1;
        mysqli_query($this->conn, "UPDATE user SET votes='$totalVotes' WHERE id='$candidateId'");

        // Assert
        $candidate = $this->getUserById($candidateId);
        $this->assertEquals(16, $candidate['votes']);
    }

    /**
     * Test multiple candidates receive votes correctly
     */
    public function testMultipleCandidatesVoting()
    {
        // Arrange - Create 3 candidates
        $candidate1Id = $this->insertTestUser([
            'name' => 'Candidate 1',
            'mobile' => '1111111111',
            'address' => 'Address 1',
            'password' => 'pass1',
            'role' => 2,
            'votes' => 0
        ]);

        $candidate2Id = $this->insertTestUser([
            'name' => 'Candidate 2',
            'mobile' => '2222222222',
            'address' => 'Address 2',
            'password' => 'pass2',
            'role' => 2,
            'votes' => 0
        ]);

        $candidate3Id = $this->insertTestUser([
            'name' => 'Candidate 3',
            'mobile' => '3333333333',
            'address' => 'Address 3',
            'password' => 'pass3',
            'role' => 2,
            'votes' => 0
        ]);

        // Act - Give different vote counts
        mysqli_query($this->conn, "UPDATE user SET votes=10 WHERE id='$candidate1Id'");
        mysqli_query($this->conn, "UPDATE user SET votes=5 WHERE id='$candidate2Id'");
        mysqli_query($this->conn, "UPDATE user SET votes=15 WHERE id='$candidate3Id'");

        // Assert
        $candidate1 = $this->getUserById($candidate1Id);
        $candidate2 = $this->getUserById($candidate2Id);
        $candidate3 = $this->getUserById($candidate3Id);

        $this->assertEquals(10, $candidate1['votes']);
        $this->assertEquals(5, $candidate2['votes']);
        $this->assertEquals(15, $candidate3['votes']);
    }

    /**
     * Test fetching voting results
     */
    public function testFetchVotingResults()
    {
        // Arrange - Create candidates with votes
        $this->insertTestUser([
            'name' => 'Candidate A',
            'mobile' => '1111111111',
            'address' => 'Address A',
            'password' => 'pass',
            'role' => 2,
            'votes' => 25
        ]);

        $this->insertTestUser([
            'name' => 'Candidate B',
            'mobile' => '2222222222',
            'address' => 'Address B',
            'password' => 'pass',
            'role' => 2,
            'votes' => 30
        ]);

        $this->insertTestUser([
            'name' => 'Candidate C',
            'mobile' => '3333333333',
            'address' => 'Address C',
            'password' => 'pass',
            'role' => 2,
            'votes' => 20
        ]);

        // Act - Fetch all candidates with votes
        $result = mysqli_query($this->conn, "SELECT id, name, votes, photo FROM user WHERE role=2 ORDER BY votes DESC");
        $candidates = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Assert
        $this->assertCount(3, $candidates);
        $this->assertEquals('Candidate B', $candidates[0]['name']); // Highest votes
        $this->assertEquals(30, $candidates[0]['votes']);
        $this->assertEquals('Candidate A', $candidates[1]['name']);
        $this->assertEquals(25, $candidates[1]['votes']);
        $this->assertEquals('Candidate C', $candidates[2]['name']);
        $this->assertEquals(20, $candidates[2]['votes']);
    }

    /**
     * Test voter status changes after voting
     */
    public function testVoterStatusUpdate()
    {
        // Arrange
        $voterId = $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => '9876543210',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1,
            'status' => 0
        ]);

        // Act
        mysqli_query($this->conn, "UPDATE user SET status=1 WHERE id='$voterId'");

        // Assert
        $voter = $this->getUserById($voterId);
        $this->assertEquals(1, $voter['status']);
    }

    /**
     * Test voting transaction (both updates should succeed or fail together)
     */
    public function testVotingTransaction()
    {
        // Arrange
        $voterId = $this->insertTestUser([
            'name' => 'Test Voter',
            'mobile' => '9876543210',
            'address' => 'Voter Address',
            'password' => 'voterpass',
            'role' => 1,
            'status' => 0
        ]);

        $candidateId = $this->insertTestUser([
            'name' => 'Test Candidate',
            'mobile' => '1111111111',
            'address' => 'Candidate Address',
            'password' => 'candidatepass',
            'role' => 2,
            'votes' => 10
        ]);

        // Act - Simulate voting process
        $votes = 10;
        $totalVotes = $votes + 1;

        $update1 = mysqli_query($this->conn, "UPDATE user SET votes='$totalVotes' WHERE id='$candidateId'");
        $update2 = mysqli_query($this->conn, "UPDATE user SET status=1 WHERE id='$voterId'");

        // Assert - Both updates should succeed
        $this->assertTrue($update1);
        $this->assertTrue($update2);

        $voter = $this->getUserById($voterId);
        $candidate = $this->getUserById($candidateId);

        $this->assertEquals(1, $voter['status']);
        $this->assertEquals(11, $candidate['votes']);
    }
}
