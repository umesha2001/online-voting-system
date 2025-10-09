# Online Voting System

A web-based voting platform that enables secure and efficient online elections. This system supports both voters and candidate groups with role-based access control.

## Features

- **User Authentication**: Secure login system with mobile number and password
- **Role-Based Access**: Support for two user types - Voters and Candidate Groups
- **User Registration**: Simple registration process with photo upload functionality
- **Voting Interface**: Interactive dashboard to view candidates and cast votes
- **Vote Tracking**: Real-time vote counting and status tracking
- **Election Results**: Dedicated page to view election results and vote distribution
- **Session Management**: Secure session handling and logout functionality
- **Vote Status**: Prevents duplicate voting with status indicators

## Tech Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Server**: Apache (localhost)

## Project Structure

```
online-voting-system/
├── api/
│   ├── connect.php          # Database connection
│   ├── login.php            # User authentication
│   ├── register.php         # User registration
│   ├── vote.php             # Voting logic
│   └── logout.php           # Session termination
├── routes/
│   ├── dashboard.php        # Main voting dashboard
│   └── results.php          # Election results page
├── css/
│   └── stylesheet.css       # Application styles
├── uploads/                 # User profile photos directory
├── index.html               # Login page
└── register.html            # Registration page
```

