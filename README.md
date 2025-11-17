# Online Voting System

A web-based online voting system built with PHP and MySQL that allows users to register as voters or candidates and participate in elections.

## Features

- **User Registration**: Users can register as either a Voter or a Group/Candidate
- **Secure Login**: Authentication system with mobile number and password
- **Photo Upload**: Users can upload profile photos during registration
- **Voting System**: Voters can cast their vote for registered candidates
- **Real-time Results**: View live election results with vote counts
- **Vote Tracking**: System tracks voting status to prevent duplicate voting
- **Responsive Design**: Clean and user-friendly interface

## Technologies Used

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Apache + MySQL)

## Installation

### Prerequisites
- XAMPP (or any PHP + MySQL environment)
- Web browser

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/umesha2001/online-voting-system.git
   ```

2. **Move to XAMPP directory**
   ```bash
   # Move the project to your XAMPP htdocs folder
   # Example: C:\xampp\htdocs\online-voting-system
   ```

3. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL** services

4. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `online-voting-system`
   - Import the `database.sql` file from the project root

5. **Access the Application**
   - Open your browser and navigate to:
   ```
   http://localhost/online-voting-system/
   ```

## Usage

### Registration
1. Click on "Register here" on the login page
2. Fill in your details:
   - Name
   - Mobile number (must be unique)
   - Password and confirm password
   - Address
   - Upload a profile photo
   - Select role: **Voter** or **Group** (Candidate)
3. Click Register

### Login
1. Enter your mobile number
2. Enter your password
3. Select your role (Voter or Group)
4. Click Login

### Voting (For Voters)
1. After login, you'll see the dashboard with:
   - Your profile information
   - List of all candidates/groups
2. Click the "Vote" button next to your preferred candidate
3. Once voted, your status changes to "Voted" and you cannot vote again

### View Results
- Click on "View Election Results" to see:
  - All candidates
  - Their vote counts
  - Profile photos

## Database Structure

### User Table
- `id` - Primary key (Auto increment)
- `name` - User's full name
- `mobile` - Mobile number (Unique)
- `address` - User's address
- `password` - User's password
- `photo` - Profile photo filename
- `role` - 1 for Voter, 2 for Group/Candidate
- `status` - 0 for Not Voted, 1 for Voted
- `votes` - Total votes received (for candidates)

## Project Structure

```
online-voting-system/
├── api/
│   ├── connect.php       # Database connection
│   ├── login.php         # Login logic
│   ├── register.php      # Registration logic
│   └── vote.php          # Voting logic
├── css/
│   └── stylesheet.css    # Styles
├── routes/
│   ├── dashboard.php     # Main dashboard
│   ├── logout.php        # Logout handler
│   ├── register.html     # Registration form
│   └── results.php       # Election results page
├── uploads/              # User uploaded photos
├── database.sql          # Database schema
└── index.html            # Login page
```

## Configuration

To change database credentials, edit `api/connect.php`:

```php
$connect = mysqli_connect("localhost", "root", "", "online-voting-system");
```

## Security Notes

⚠️ **Important**: This is a basic implementation for educational purposes. For production use, consider:
- Password hashing (bcrypt/argon2)
- SQL injection prevention (prepared statements)
- Input validation and sanitization
- Session security improvements
- HTTPS implementation
- CSRF protection

## Screenshots

### Login Page
Simple login interface with mobile number and password

### Dashboard
- User profile display
- List of candidates with voting options
- Real-time vote tracking

### Results Page
Shows all candidates and their vote counts

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available under the MIT License.

## Author

**Umesha**
- GitHub: [@umesha2001](https://github.com/umesha2001)

## Support

For issues, questions, or suggestions, please open an issue on GitHub.

---

**Note**: Make sure to keep your database credentials secure and never commit sensitive information to public repositories.

