# Phase 2: Models & Database (Days 4-6)

## Overview
This phase focuses on creating the database models, migrations, and establishing relationships between different entities in the student management system.

## Tasks Completed

### Day 4: Core Models Creation
- [x] User model with role-based functionality
- [x] Department model for academic departments
- [x] Course model for course management
- [x] Student model with academic information
- [x] Teacher model with qualifications and experience

### Day 5: Academic Models
- [x] Enrollment model for course enrollments
- [x] Exam model for assessments and tests
- [x] Assignment model for assignments and projects
- [x] AssignmentSubmission model for student submissions
- [x] Result model for grades and marks
- [x] Attendance model for attendance tracking

### Day 6: Supporting Models
- [x] Fee model for fee structure
- [x] Payment model for payment tracking
- [x] Book model for library management
- [x] BookIssue model for book borrowing
- [x] Hall model for student accommodation
- [x] Notice model for announcements
- [x] Staff model for staff management

## Database Schema

### Core Academic Tables

#### Departments Table
```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(10) UNIQUE NOT NULL,
    description TEXT NULL,
    head_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (head_id) REFERENCES users(id) ON DELETE SET NULL
);
```

#### Courses Table
```sql
CREATE TABLE courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    description TEXT NULL,
    credits DECIMAL(3,1) NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    semester VARCHAR(20) NULL,
    academic_year VARCHAR(10) NULL,
    course_type ENUM('core', 'elective', 'optional') DEFAULT 'core',
    currency VARCHAR(3) DEFAULT 'USD',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);
```

#### Students Table
```sql
CREATE TABLE students (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    roll_number VARCHAR(20) UNIQUE NULL,
    registration_number VARCHAR(20) UNIQUE NULL,
    session VARCHAR(20) NULL,
    academic_year VARCHAR(10) NULL,
    semester VARCHAR(20) NULL,
    admission_date DATE NULL,
    hall_id BIGINT UNSIGNED NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NULL,
    guardian_name VARCHAR(255) NULL,
    guardian_phone VARCHAR(20) NULL,
    cgpa DECIMAL(3,2) NULL,
    total_credits INT DEFAULT 0,
    completed_credits INT DEFAULT 0,
    status ENUM('active', 'inactive', 'graduated', 'suspended') DEFAULT 'active',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
    FOREIGN KEY (hall_id) REFERENCES halls(id) ON DELETE SET NULL
);
```

#### Teachers Table
```sql
CREATE TABLE teachers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    designation VARCHAR(100) NOT NULL,
    qualifications TEXT NULL,
    experience_years INT DEFAULT 0,
    specialization VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    office_location VARCHAR(255) NULL,
    bio TEXT NULL,
    is_department_head BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);
```

### Academic Management Tables

#### Enrollments Table
```sql
CREATE TABLE enrollments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('active', 'completed', 'dropped') DEFAULT 'active',
    grade_point DECIMAL(3,2) NULL,
    letter_grade VARCHAR(2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id)
);
```

#### Exams Table
```sql
CREATE TABLE exams (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    exam_type ENUM('midterm', 'final', 'quiz', 'assignment') NOT NULL,
    total_marks DECIMAL(8,2) NOT NULL,
    duration_minutes INT NULL,
    exam_date DATETIME NOT NULL,
    venue VARCHAR(255) NULL,
    instructions TEXT NULL,
    status ENUM('scheduled', 'ongoing', 'completed', 'cancelled') DEFAULT 'scheduled',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);
```

#### Assignments Table
```sql
CREATE TABLE assignments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    due_date DATETIME NOT NULL,
    total_marks DECIMAL(8,2) DEFAULT 100,
    file_path VARCHAR(500) NULL,
    instructions TEXT NULL,
    is_published BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Assignment Submissions Table
```sql
CREATE TABLE assignment_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    assignment_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    submission_text TEXT NULL,
    file_path VARCHAR(500) NULL,
    submitted_at DATETIME NOT NULL,
    marks DECIMAL(8,2) NULL,
    feedback TEXT NULL,
    graded_at DATETIME NULL,
    graded_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_submission (assignment_id, student_id)
);
```

#### Results Table
```sql
CREATE TABLE results (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    exam_id BIGINT UNSIGNED NOT NULL,
    marks DECIMAL(8,2) NOT NULL,
    grade VARCHAR(2) NULL,
    grade_point DECIMAL(3,2) NULL,
    is_published BOOLEAN DEFAULT FALSE,
    remarks TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    UNIQUE KEY unique_result (student_id, exam_id)
);
```

### Financial Management Tables

#### Fees Table
```sql
CREATE TABLE fees (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    fee_type ENUM('tuition', 'library', 'hall', 'exam', 'other') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE NOT NULL,
    academic_year VARCHAR(10) NOT NULL,
    semester VARCHAR(20) NULL,
    description TEXT NULL,
    is_paid BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
```

#### Payments Table
```sql
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    fee_id BIGINT UNSIGNED NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'bank_transfer', 'bkash', 'nagad', 'rocket') NOT NULL,
    transaction_id VARCHAR(255) NULL,
    payment_date DATETIME NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    reference_number VARCHAR(255) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (fee_id) REFERENCES fees(id) ON DELETE SET NULL
);
```

### Library Management Tables

#### Books Table
```sql
CREATE TABLE books (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE NULL,
    publisher VARCHAR(255) NULL,
    publication_year YEAR NULL,
    category VARCHAR(100) NULL,
    total_copies INT DEFAULT 1,
    available_copies INT DEFAULT 1,
    shelf_location VARCHAR(50) NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Book Issues Table
```sql
CREATE TABLE book_issues (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NULL,
    staff_id BIGINT UNSIGNED NULL,
    issue_date DATE NOT NULL,
    return_date DATE NULL,
    due_date DATE NOT NULL,
    fine_amount DECIMAL(8,2) DEFAULT 0,
    status ENUM('active', 'returned', 'overdue') DEFAULT 'active',
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
);
```

### Accommodation & Communication Tables

#### Halls Table
```sql
CREATE TABLE halls (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    capacity INT NOT NULL,
    type ENUM('male', 'female', 'mixed') NOT NULL,
    location VARCHAR(255) NULL,
    description TEXT NULL,
    facilities JSON NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### Notices Table
```sql
CREATE TABLE notices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    type ENUM('general', 'academic', 'exam', 'fee', 'library', 'event') NOT NULL,
    priority ENUM('low', 'medium', 'high', 'urgent') NOT NULL,
    target_roles JSON NOT NULL,
    publish_date DATE NOT NULL,
    expiry_date DATE NULL,
    is_published BOOLEAN DEFAULT FALSE,
    is_pinned BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Model Relationships

### User Model Relationships
```php
// User has one Student, Teacher, or Staff profile
public function student()
{
    return $this->hasOne(Student::class);
}

public function teacher()
{
    return $this->hasOne(Teacher::class);
}

public function staff()
{
    return $this->hasOne(Staff::class);
}
```

### Student Model Relationships
```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function department()
{
    return $this->belongsTo(Department::class);
}

public function hall()
{
    return $this->belongsTo(Hall::class);
}

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function courses()
{
    return $this->belongsToMany(Course::class, 'enrollments')
        ->withPivot('enrollment_date', 'status', 'grade_point', 'letter_grade')
        ->withTimestamps();
}

public function results()
{
    return $this->hasMany(Result::class);
}

public function fees()
{
    return $this->hasMany(Fee::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function bookIssues()
{
    return $this->hasMany(BookIssue::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}
```

### Course Model Relationships
```php
public function department()
{
    return $this->belongsTo(Department::class);
}

public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function students()
{
    return $this->belongsToMany(Student::class, 'enrollments')
        ->withPivot('enrollment_date', 'status', 'grade_point', 'letter_grade')
        ->withTimestamps();
}

public function exams()
{
    return $this->hasMany(Exam::class);
}

public function assignments()
{
    return $this->hasMany(Assignment::class);
}
```

## Model Features

### Soft Deletes
Models with soft delete functionality:
- Student
- Teacher
- Staff
- Assignment
- AssignmentSubmission
- Notice

### Scopes
Common scopes implemented:
```php
// Active records
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

// Published records
public function scopePublished($query)
{
    return $query->where('is_published', true);
}

// Recent records
public function scopeRecent($query, $days = 30)
{
    return $query->where('created_at', '>=', now()->subDays($days));
}
```

### Accessors & Mutators
```php
// Full name accessor
public function getFullNameAttribute()
{
    return $this->user->name;
}

// Email accessor
public function getEmailAttribute()
{
    return $this->user->email;
}

// Status accessor
public function getStatusAttribute()
{
    if ($this->due_date < now()) {
        return 'overdue';
    } elseif ($this->due_date <= now()->addDays(3)) {
        return 'due_soon';
    } else {
        return 'active';
    }
}
```

## Database Seeders

### Admin Seeder
```php
User::create([
    'name' => 'System Administrator',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

### Sample Data Seeders
- DepartmentSeeder
- CourseSeeder
- StudentSeeder
- TeacherSeeder
- StaffSeeder
- HallSeeder
- BookSeeder
- NoticeSeeder

## Migration Commands

### Create Migrations
```bash
php artisan make:migration create_departments_table
php artisan make:migration create_courses_table
php artisan make:migration create_students_table
php artisan make:migration create_teachers_table
php artisan make:migration create_enrollments_table
php artisan make:migration create_exams_table
php artisan make:migration create_assignments_table
php artisan make:migration create_assignment_submissions_table
php artisan make:migration create_results_table
php artisan make:migration create_fees_table
php artisan make:migration create_payments_table
php artisan make:migration create_books_table
php artisan make:migration create_book_issues_table
php artisan make:migration create_halls_table
php artisan make:migration create_notices_table
php artisan make:migration create_staff_table
php artisan make:migration create_attendances_table
```

### Run Migrations
```bash
php artisan migrate
php artisan migrate:status
php artisan migrate:rollback
php artisan migrate:reset
```

## Testing

### Model Tests
- Model creation and validation
- Relationship testing
- Scope testing
- Accessor/mutator testing

### Database Tests
- Migration testing
- Seeder testing
- Foreign key constraint testing

## Next Steps
- [ ] Implement model factories for testing
- [ ] Add model validation rules
- [ ] Create model observers for automatic actions
- [ ] Implement model caching strategies
- [ ] Add database indexing for performance

---

**Phase 2 Status: ✅ COMPLETED**
