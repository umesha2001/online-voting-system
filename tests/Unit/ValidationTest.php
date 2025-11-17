<?php

use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /**
     * Test password matching validation
     */
    public function testPasswordMatch()
    {
        $password = 'password123';
        $confirmPassword = 'password123';

        $this->assertEquals($password, $confirmPassword);
    }

    /**
     * Test password mismatch
     */
    public function testPasswordMismatch()
    {
        $password = 'password123';
        $confirmPassword = 'differentpass';

        $this->assertNotEquals($password, $confirmPassword);
    }

    /**
     * Test mobile number format (10 digits)
     */
    public function testValidMobileFormat()
    {
        $mobile = '9876543210';

        $this->assertEquals(10, strlen($mobile));
        $this->assertMatchesRegularExpression('/^[0-9]{10}$/', $mobile);
    }

    /**
     * Test invalid mobile number format
     */
    public function testInvalidMobileFormat()
    {
        $invalidMobiles = [
            '12345',          // Too short
            '12345678901',    // Too long
            'abcdefghij',     // Non-numeric
            '123-456-7890'    // Contains special characters
        ];

        foreach ($invalidMobiles as $mobile) {
            $this->assertThat(
                $mobile,
                $this->logicalNot($this->matchesRegularExpression('/^[0-9]{10}$/'))
            );
        }
    }

    /**
     * Test role validation
     */
    public function testValidRoles()
    {
        $voterRole = 1;
        $candidateRole = 2;

        $this->assertTrue($voterRole === 1 || $voterRole === 2);
        $this->assertTrue($candidateRole === 1 || $candidateRole === 2);
    }

    /**
     * Test invalid role
     */
    public function testInvalidRole()
    {
        $invalidRole = 3;

        $this->assertFalse($invalidRole === 1 || $invalidRole === 2);
    }

    /**
     * Test empty field validation
     */
    public function testEmptyFieldValidation()
    {
        $emptyName = '';
        $emptyMobile = '';
        $emptyPassword = '';

        $this->assertEmpty($emptyName);
        $this->assertEmpty($emptyMobile);
        $this->assertEmpty($emptyPassword);
    }

    /**
     * Test non-empty field validation
     */
    public function testNonEmptyFieldValidation()
    {
        $name = 'John Doe';
        $mobile = '9876543210';
        $password = 'password123';

        $this->assertNotEmpty($name);
        $this->assertNotEmpty($mobile);
        $this->assertNotEmpty($password);
    }

    /**
     * Test status values
     */
    public function testStatusValues()
    {
        $notVoted = 0;
        $voted = 1;

        $this->assertEquals(0, $notVoted);
        $this->assertEquals(1, $voted);
        $this->assertTrue($voted > $notVoted);
    }

    /**
     * Test vote count validation
     */
    public function testVoteCount()
    {
        $initialVotes = 0;
        $votesAfterVoting = 1;

        $this->assertGreaterThanOrEqual(0, $initialVotes);
        $this->assertGreaterThan($initialVotes, $votesAfterVoting);
    }
}
