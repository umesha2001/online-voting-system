# Online Voting System - Test Suite

This directory contains comprehensive test cases for the Online Voting System.

## Test Structure

```
tests/
├── bootstrap.php                    # PHPUnit bootstrap file
├── DatabaseTestCase.php             # Base test class for database tests
├── Integration/                     # Integration tests
│   ├── RegistrationTest.php        # User registration tests
│   ├── LoginTest.php               # User login tests
│   └── VotingTest.php              # Voting functionality tests
└── Unit/                           # Unit tests
    ├── DatabaseConnectionTest.php  # Database connection tests
    └── ValidationTest.php          # Input validation tests
```

## Prerequisites

1. **XAMPP** must be installed and running (Apache and MySQL)
2. **Composer** must be installed
3. PHP 7.4 or higher

## Installation

1. Install PHPUnit and dependencies:
```bash
cd c:\xampp\htdocs\online-voting-system
composer install
```

2. The test database will be created automatically when tests run.

## Running Tests

### Run All Tests
```bash
composer test
```

Or:
```bash
vendor\bin\phpunit
```

### Run Specific Test Suite
```bash
# Run only Integration tests
vendor\bin\phpunit --testsuite "Integration Tests"

# Run only Unit tests
vendor\bin\phpunit --testsuite "Unit Tests"
```

### Run Specific Test File
```bash
vendor\bin\phpunit tests\Integration\RegistrationTest.php
vendor\bin\phpunit tests\Integration\LoginTest.php
vendor\bin\phpunit tests\Integration\VotingTest.php
```

### Run Specific Test Method
```bash
vendor\bin\phpunit --filter testSuccessfulRegistration
vendor\bin\phpunit --filter testSuccessfulVoting
```

## Test Coverage

### Registration Tests (RegistrationTest.php)
- ✅ Successful user registration
- ✅ Duplicate mobile number validation
- ✅ Voter registration
- ✅ Candidate/group registration
- ✅ Registration with photo upload
- ✅ Multiple users registration

### Login Tests (LoginTest.php)
- ✅ Successful voter login
- ✅ Successful candidate login
- ✅ Login with invalid mobile number
- ✅ Login with invalid password
- ✅ Login with wrong role
- ✅ Fetching candidates after login
- ✅ Login returns correct user data
- ✅ Login with empty credentials

### Voting Tests (VotingTest.php)
- ✅ Successful voting
- ✅ Voter cannot vote twice validation
- ✅ Vote count increments correctly
- ✅ Voting updates candidate's vote count
- ✅ Multiple candidates receive votes
- ✅ Fetching voting results
- ✅ Voter status changes after voting
- ✅ Voting transaction integrity

### Unit Tests
- ✅ Database connection validation
- ✅ Password matching validation
- ✅ Mobile number format validation
- ✅ Role validation
- ✅ Empty field validation
- ✅ Status values validation
- ✅ Vote count validation

## Test Database

The tests use a separate database: `online-voting-system-test`

- Database is created automatically
- Tables are recreated before each test
- Data is cleaned up after each test
- Production database remains untouched

## Configuration

Test database settings are in `phpunit.xml`:
```xml
<env name="DB_HOST" value="localhost"/>
<env name="DB_USER" value="root"/>
<env name="DB_PASS" value=""/>
<env name="DB_NAME" value="online-voting-system-test"/>
```

## Viewing Test Results

Tests will output:
- ✓ Green dot: Test passed
- F Red: Test failed
- E Yellow: Test error

Example output:
```
PHPUnit 9.5.x by Sebastian Bergmann and contributors.

Integration Tests
 ✓ Successful registration
 ✓ Duplicate mobile registration
 ✓ Voter registration
 ✓ Candidate registration
 ...

Time: 00:00.245, Memory: 8.00 MB

OK (25 tests, 75 assertions)
```

## Troubleshooting

### Issue: Cannot connect to MySQL
**Solution**: Make sure XAMPP MySQL is running

### Issue: Composer not found
**Solution**: Install Composer from https://getcomposer.org/

### Issue: PHPUnit not found
**Solution**: Run `composer install` first

### Issue: Tests fail with database errors
**Solution**: Ensure MySQL is running and credentials in `phpunit.xml` are correct

## Writing New Tests

1. Extend `DatabaseTestCase` for database tests:
```php
use Tests\DatabaseTestCase;

class MyNewTest extends DatabaseTestCase
{
    public function testSomething()
    {
        // Your test code
    }
}
```

2. Use provided helper methods:
- `$this->insertTestUser($data)` - Insert test user
- `$this->getUserById($id)` - Get user by ID
- `$this->getUserByMobile($mobile)` - Get user by mobile

## Best Practices

1. Each test should be independent
2. Clean up is automatic (handled by DatabaseTestCase)
3. Use descriptive test method names
4. Test both success and failure scenarios
5. Assert expected behavior clearly

## Test Data

Test data is automatically managed:
- Created in `setUp()` method
- Cleaned in `tearDown()` method
- Isolated from production data
- Each test starts with clean slate
