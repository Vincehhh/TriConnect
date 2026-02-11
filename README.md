# TriConnect
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Strava](https://img.shields.io/badge/Strava-FC4C02?style=for-the-badge&logo=strava&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Stars](https://img.shields.io/github/stars/Vincehhh/Triconnect?style=social)
![Forks](https://img.shields.io/github/forks/Vincehhh/Triconnect?style=social)
![Watchers](https://img.shields.io/github/watchers/Vincehhh/Triconnect?style=social)
![Repo Size](https://img.shields.io/github/repo-size/Vincehhh/Triconnect)
![Language Count](https://img.shields.io/github/languages/count/Vincehhh/Triconnect)
![Top Language](https://img.shields.io/github/languages/top/Vincehhh/Triconnect)
[![Issues](https://img.shields.io/github/issues/Vincehhh/Triconnect)](https://github.com/Vincehhh/Triconnect/issues?q=is%3Aopen+is%3Aissue)
![Last Commit](https://img.shields.io/github/last-commit/Vincehhh/Triconnect?color=red)
[![Release](https://img.shields.io/github/release/Vincehhh/Triconnect.svg)](https://github.com/Vincehhh/Triconnectreleases)
[![Sponsor](https://img.shields.io/static/v1?label=Sponsor&message=%E2%9D%A4&logo=GitHub&color=%23fe8e86)](https://github.com/sponsors/Vincehhh)


## 📋 Overview

TriConnect is a comprehensive web platform designed to help athletes master triathlon training across all three disciplines: swimming, cycling, and running. The platform combines personalized training plans, performance tracking, community forums, and sports science education to provide an optimized training experience.

<img width="1898" height="894" alt="image" src="https://github.com/user-attachments/assets/734c17c3-e271-44eb-86e1-83a581a7521e" />


### Key Highlights

- 🏊 **Multi-Sport Training**: Dedicated modules for swimming, cycling, and running
- 📊 **Strava Integration**: Automatic activity sync and performance tracking
- 👥 **Community Forums**: Sport-specific discussion boards and knowledge sharing
- 🎯 **Personalized Plans**: AI-generated training programs based on fitness level and goals
- 📈 **Performance Analytics**: Track your progress with detailed metrics and insights
- 🧬 **Sports Science**: Educational content on exercise physiology and training methodology

---

## 🎯 Features

### Training & Planning
- **Customized Training Plans**: Generate personalized workout schedules based on your fitness level, goals, and current health status
- **Multi-Sport Coverage**: Separate training modules for swimming, cycling, and running
- **Progress Tracking**: Monitor your improvement across all three disciplines

### Performance Tracking
- **Strava Integration**: Seamless OAuth authentication and automatic activity synchronization
- **Activity Dashboard**: View your latest workouts, distances, and performance metrics
- **Physical Stats Management**: Track VO2 max, FTP, heart rate zones, and more

### Community & Learning
- **Sport-Specific Forums**: Dedicated discussion boards for each discipline
- **Expert Knowledge Base**: Educational resources on sports science and anatomy
- **Social Features**: Connect with fellow triathletes and share experiences

### User Management
- **Secure Authentication**: Password hashing with industry-standard security
- **Profile Customization**: Manage your personal information and athletic stats
- **OAuth Integration**: Connect third-party services like Strava

---

## 🛠️ Technology Stack

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with custom properties
- **JavaScript (ES6+)** - Interactive UI components
- **Responsive Design** - Mobile-first approach

### Backend
- **PHP 7.4+** - Server-side logic
- **MySQL 5.7+** - Relational database
- **PDO** - Secure database interactions
- **Session Management** - User authentication

### APIs & Integrations
- **Strava API v3** - Activity tracking and athlete data
- **OAuth 2.0** - Secure third-party authentication

---

## 📦 Installation

### Prerequisites

Ensure you have the following installed:

- **PHP** >= 7.4 with extensions:
  - `pdo_mysql`
  - `curl`
  - `json`
- **MySQL** >= 5.7 or **MariaDB** >= 10.2
- **Web Server**: Apache or Nginx
- **Composer** (optional, for dependency management)

### Setup Instructions

1. **Clone the Repository**

```bash
git clone https://github.com/vincehhh/triconnect.git
cd triconnect
```

2. **Database Configuration**

Import the database schema:

```bash
mysql -u your_username -p < sql/triconnect_db
```

Or manually create the database:

```sql
CREATE DATABASE triconnect_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then import the schema from `sql/triconnect_db`.

3. **Configure Database Connection**

Edit `assets/php/db_connect.php` with your credentials:

```php
$host = 'localhost';
$dbname = 'triconnect_db';
$username = 'your_username';
$password = 'your_password';
```

4. **Strava API Setup**

To enable Strava integration:

1. Create a Strava application at [Strava Developers](https://www.strava.com/settings/api)
2. Create `assets/php/config_strava.php`:

```php
<?php
define('STRAVA_CLIENT_ID', 'your_client_id');
define('STRAVA_CLIENT_SECRET', 'your_client_secret');
define('STRAVA_REDIRECT_URI', 'http://yourdomain.com/assets/php/callback_strava.php');
?>
```

5. **Set Permissions**

```bash
chmod 755 assets/php/
chmod 644 assets/php/*.php
```

6. **Start Development Server**

Using PHP built-in server:

```bash
php -S localhost:8000
```

Or configure your Apache/Nginx virtual host to point to the project root.

7. **Access the Application**

Navigate to `http://localhost:8000` in your browser.

---

## 🚀 Usage

### Getting Started

1. **Create an Account**
   - Visit the registration page at `/inscription.html`
   - Fill in your details and create a secure password
   - Verify your email address

2. **Complete Your Profile**
   - Add your physical stats (weight, height, VO2 max, etc.)
   - Set your training goals and current fitness level

3. **Connect Strava (Optional)**
   - Navigate to your profile
   - Click "Connect Strava"
   - Authorize TriConnect to access your activities

4. **Generate Training Plans**
   - Select your sport (swimming, cycling, or running)
   - Input your current level and goals
   - Receive a personalized training program

5. **Join the Community**
   - Browse sport-specific forums
   - Ask questions and share knowledge
   - Connect with fellow athletes

### User Roles

- **User**: Basic access to training features and forums
- **Moderator**: Forum moderation capabilities
- **Admin**: Full platform management access

---

## 🔌 API Integration

### Strava Integration

TriConnect integrates with Strava to automatically sync your activities:

#### Authentication Flow

```php
// 1. Initiate OAuth
$authUrl = "https://www.strava.com/oauth/authorize?client_id={CLIENT_ID}&redirect_uri={REDIRECT_URI}&response_type=code&scope=read,activity:read_all";

// 2. Handle callback (callback_strava.php)
// Exchanges authorization code for access token
// Stores tokens in oauth_tokens table

// 3. Fetch athlete data (infos_strava.php)
$athleteInfo = callStravaAPI('https://www.strava.com/api/v3/athlete', $token);
```

#### Available Endpoints

- **Athlete Profile**: `/api/v3/athlete`
- **Activities**: `/api/v3/athlete/activities`
- **Stats**: `/api/v3/athletes/{id}/stats`

### Database Schema

#### Key Tables

**users**
- Primary user information and authentication
- Roles: user, moderator, admin

**user_physical_stats**
- Athletic metrics (VO2 max, FTP, heart rate zones)
- One-to-one relationship with users

**oauth_tokens**
- Third-party service credentials
- Supports Strava and Garmin

**activities**
- Synced workout data
- Linked to external activity IDs

**forum_threads** & **forum_posts**
- Community discussion content
- Categorized by sport

---

## 📁 Project Structure

```
triconnect/
├── assets/
│   ├── css/              # Stylesheets
│   │   ├── style.css
│   │   ├── connexion.css
│   │   └── inscription.css
│   ├── js/               # JavaScript modules
│   │   ├── carousel.js
│   │   └── fichier.js
│   ├── img/              # Images and logos
│   └── php/              # Backend logic
│       ├── db_connect.php
│       ├── login.php
│       ├── register.php
│       ├── callback_strava.php
│       └── infos_strava.php
├── sql/
│   └── triconnect_db     # Database schema
├── connexion.html        # Login page
├── inscription.html      # Registration page
├── profil.php           # User profile
├── sport.html           # Main dashboard
├── natation.html        # Swimming module
├── velo.html           # Cycling module
├── running.html        # Running module
└── README.md
```

---

## 🔒 Security

TriConnect implements several security best practices:

- **Password Hashing**: Using `PASSWORD_DEFAULT` algorithm (bcrypt)
- **Prepared Statements**: All database queries use PDO prepared statements
- **Input Sanitization**: `htmlspecialchars()` on user inputs
- **Session Management**: Secure session handling for authenticated users
- **HTTPS Required**: OAuth redirects require HTTPS in production
- **SQL Injection Prevention**: Parameterized queries throughout

### Security Recommendations

For production deployment:

1. Enable HTTPS/SSL
2. Set secure session cookie flags
3. Implement CSRF protection
4. Add rate limiting on authentication endpoints
5. Use environment variables for sensitive credentials
6. Regular security audits and dependency updates

---

## 🤝 Contributing

We welcome contributions from the community! Here's how you can help:

### Reporting Issues

1. Check existing issues to avoid duplicates
2. Use the issue template
3. Include detailed reproduction steps
4. Attach screenshots if applicable

### Pull Requests

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards for PHP
- Write meaningful commit messages
- Add comments for complex logic
- Test your changes thoroughly
- Update documentation as needed

---

## 📝 Roadmap

### Upcoming Features

- [ ] Garmin Connect integration
- [ ] Mobile responsive improvements
- [ ] Advanced analytics dashboard
- [ ] Training plan marketplace
- [ ] Video tutorial library
- [ ] Nutrition tracking module
- [ ] Race calendar integration
- [ ] Coach-athlete messaging system
- [ ] Group training challenges
- [ ] Export training data (CSV, PDF)

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

- **Vincent** - *Initial work* - [@vincehhh](https://github.com/vincehhh)

---

## 🙏 Acknowledgments

- [Strava API](https://developers.strava.com/) for activity tracking integration
- The triathlon community for inspiration and feedback
- Open source contributors and libraries used in this project

---

<div align="center">

Made with ❤️ by the TriConnect Team

**[Website](https://triconnect.com)** • **[Documentation](https://docs.triconnect.com)** • **[Community](https://community.triconnect.com)**

</div>
