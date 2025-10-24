# Laravel Student Management System - Complete Guide

## Overview
This is a comprehensive Student Management System built with Laravel 11, featuring role-based access control, payment integration, and modern UI components.

## Features

### 🎯 Core Features
- **Multi-role Authentication** (Admin, Teacher, Student, Staff)
- **Course Management** with enrollment system
- **Exam & Assignment Management** with grading
- **Fee Management** with payment tracking
- **Library Management** with book issuing
- **Hall Management** for student accommodation
- **Notice Board** for announcements
- **Attendance Tracking**
- **Result Management** with GPA calculation

### 💳 Payment Integration
- **bKash Payment Gateway** integration
- **Payment History** tracking
- **Fee Payment** processing
- **Refund Management**

### 📊 Advanced Features
- **Dashboard Analytics** for all roles
- **Report Generation**
- **Audit Logging**
- **File Upload** support
- **Email Notifications**
- **Responsive Design** with Tailwind CSS

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- XAMPP/WAMP/LAMP

### Step 1: Clone and Setup
```bash
git clone <repository-url>
cd myapp1
composer install
npm install
```

### Step 2: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myapp1_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 4: Asset Compilation
```bash
npm run build
# or for development
npm run dev
```

### Step 5: Storage Link
```bash
php artisan storage:link
```

## Default Login Credentials

### Admin
- **Email:** admin@example.com
- **Password:** password

### Teacher
- **Email:** teacher@example.com
- **Password:** password

### Student
- **Email:** student@example.com
- **Password:** password

## Project Structure

```
myapp1/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── Teacher/        # Teacher panel controllers
│   │   └── Student/        # Student panel controllers
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic services
│   └── Traits/             # Reusable traits
├── database/
│   ├── migrations/         # Database migrations
│   ├── seeders/           # Database seeders
│   └── factories/         # Model factories
├── resources/
│   ├── views/              # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/
│   ├── web.php            # Web routes
│   └── auth.php           # Authentication routes
└── public/                # Public assets
```

## Database Schema

### Core Tables
- **users** - User authentication and basic info
- **departments** - Academic departments
- **courses** - Course information
- **students** - Student profiles and academic info
- **teachers** - Teacher profiles and qualifications
- **staff** - Staff member information
- **halls** - Student accommodation halls

### Academic Tables
- **enrollments** - Student course enrollments
- **exams** - Exam/assessment information
- **assignments** - Assignment details
- **assignment_submissions** - Student assignment submissions
- **results** - Exam and assignment results
- **attendances** - Student attendance records

### Financial Tables
- **fees** - Fee structure and amounts
- **payments** - Payment records and history

### Library Tables
- **books** - Library book catalog
- **book_issues** - Book borrowing records

### Communication Tables
- **notices** - System announcements and notices

## API Endpoints

### Authentication
- `POST /login` - User login
- `POST /logout` - User logout
- `POST /register` - User registration

### Admin Routes
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/students` - Student management
- `GET /admin/teachers` - Teacher management
- `GET /admin/courses` - Course management
- `GET /admin/exams` - Exam management
- `GET /admin/fees` - Fee management

### Teacher Routes
- `GET /teacher/dashboard` - Teacher dashboard
- `GET /teacher/courses` - Teacher's courses
- `GET /teacher/exams` - Exam management
- `GET /teacher/assignments` - Assignment management
- `GET /teacher/results` - Result management

### Student Routes
- `GET /student/dashboard` - Student dashboard
- `GET /student/courses` - Enrolled courses
- `GET /student/exams` - Exam schedule
- `GET /student/assignments` - Assignment submissions
- `GET /student/results` - Academic results

## Payment Integration

### bKash Configuration
Update your `.env` file with bKash credentials:
```env
BKASH_APP_KEY=your_app_key
BKASH_APP_SECRET=your_app_secret
BKASH_USERNAME=your_username
BKASH_PASSWORD=your_password
BKASH_SANDBOX=true
```

### Payment Flow
1. Student initiates fee payment
2. System creates bKash payment request
3. Student completes payment on bKash
4. System receives callback and updates payment status
5. Payment confirmation sent to student

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Seeding
```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=StudentSeeder
php artisan db:seed --class=TeacherSeeder
```

## Deployment

### Production Setup
1. Update `.env` with production values
2. Set `APP_ENV=production`
3. Set `APP_DEBUG=false`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`

### Server Requirements
- PHP 8.2+
- MySQL 8.0+ or PostgreSQL 13+
- Redis (for caching)
- SSL Certificate (for production)

## Troubleshooting

### Common Issues

#### Database Connection Error
- Check database credentials in `.env`
- Ensure database server is running
- Verify database exists

#### Permission Errors
- Run `chmod -R 755 storage bootstrap/cache`
- Ensure web server has write permissions

#### Asset Loading Issues
- Run `php artisan storage:link`
- Run `npm run build`
- Check file permissions

### Log Files
- Application logs: `storage/logs/laravel.log`
- Web server logs: Check your web server configuration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions:
- Create an issue on GitHub
- Contact the development team
- Check the documentation wiki

## Changelog

### Version 1.0.0
- Initial release
- Core functionality implemented
- Payment integration added
- Multi-role authentication
- Responsive UI design

---

**Built with ❤️ using Laravel 11**
