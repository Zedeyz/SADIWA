# SADIWA: Community-Based Cultural Heritage Information Systemss

A comprehensive web-based system for documenting, monitoring, and visualizing earthquake-affected heritage churches in Bohol, Philippines.

## 📋 Table of Contents
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation Instructions](#installation-instructions)
- [User Roles](#user-roles)
- [Database Schema](#database-schema)
- [Usage Guide](#usage-guide)
- [Security Features](#security-features)
- [Credits](#credits)

## ✨ Features

### 1. Interactive Map
- Powered by Leaflet.js
- Displays all heritage churches in Bohol
- Color-coded risk level markers
- Popup information for each church
- Covers entire Bohol province with actual coordinates

### 2. Church Management (Admin)
- Add new churches
- Edit church information
- Delete churches
- View detailed church profiles

### 3. Damage Reporting (Contributors)
- Submit damage reports
- Upload images
- Assign risk levels
- Track report status

### 4. Reports & Analytics
- Risk summary dashboard
- Searchable, sortable, paginated tables
- Damage history per church
- Contributor activity tracking

### 5. Role-Based Access Control
- Admin: Full system access
- Contributor: Submit reports, view data
- Viewer: Read-only access

## 🛠 Technology Stack

### Frontend
- HTML5
- CSS3
- Bootstrap 5.3.0
- JavaScript
- Leaflet.js 1.9.4 (Interactive Maps)
- jQuery 3.7.0
- DataTables 1.13.6 (Tables with search, sort, pagination)

### Backend
- PHP 8.2
- MySQL/MariaDB

### Libraries & Frameworks
- OpenStreetMap (Map tiles)
- Font Awesome (Icons)

## 📦 Installation Instructions

### Prerequisites
- XAMPP (or any PHP development environment)
  - PHP 8.0 or higher
  - MySQL 5.7 or higher
  - Apache Web Server

### Step 1: Download and Extract
1. Download the SADIWA folder
2. Extract to your XAMPP `htdocs` directory
   ```
   C:\xampp\htdocs\SADIWA
   ```

### Step 2: Database Setup
1. Start XAMPP (Apache and MySQL)
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Create a new database named `sadiwa_db`
4. Import the database schema:
   - Click on `sadiwa_db` database
   - Go to "Import" tab
   - Choose file: `SADIWA/database/schema.sql`
   - Click "Go" to execute

The schema includes:
- Database structure (4 tables)
- Sample data (12 churches, 3 users, 7 reports)
- Pre-configured risk levels

### Step 3: Configure Database Connection
1. Open `SADIWA/config/database.php`
2. Update the database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');        // Your MySQL username
   define('DB_PASS', '');            // Your MySQL password
   define('DB_NAME', 'sadiwa_db');
   ```

### Step 4: Set File Permissions
Ensure the `uploads` folder is writable:
```
SADIWA/uploads/ (chmod 755 or 777)
```

### Step 5: Access the System
1. Open your web browser
2. Navigate to: `http://localhost/SADIWA`
3. Click "Get Started" or go directly to login: `http://localhost/SADIWA/pages/login.php`

## 👥 User Roles

### Demo Accounts
The system comes with 3 pre-configured accounts:

| Username      | Password     | Role        | Access Level |
|--------------|--------------|-------------|--------------|
| admin        | password  | Admin       | Full access  |
| contributor  | password  | Contributor | Submit & view|
| viewer       | password  | Viewer      | View only    |

### Admin Capabilities
- Manage churches (Add, Edit, Delete)
- Approve/Reject damage reports
- View all reports and statistics
- Full system access

### Contributor Capabilities
- Submit damage reports
- Upload photos
- View interactive map
- View churches and reports

### Viewer Capabilities
- View churches
- View interactive map
- View approved reports
- Read-only access

## 🗄 Database Schema

### Tables

#### 1. Users
- `user_id` (Primary Key)
- `username` (Unique)
- `password_hash` (Password hashed with PHP's password_hash)
- `role` (Admin, Contributor, Viewer)
- `created_at` (Timestamp)

#### 2. Churches
- `church_id` (Primary Key)
- `name`
- `municipality`
- `latitude` (Decimal)
- `longitude` (Decimal)
- `year_built`
- `architectural_style`
- `created_at` (Timestamp)

#### 3. RiskLevels
- `risk_id` (Primary Key)
- `level_name` (Low, Moderate, High, Critical)
- `description`
- `color_code` (Hex color for map markers)

#### 4. DamageReports
- `report_id` (Primary Key)
- `church_id` (Foreign Key → Churches)
- `contributor_id` (Foreign Key → Users)
- `report_date`
- `damage_description` (Text)
- `risk_level` (Foreign Key → RiskLevels)
- `image_path` (Optional)
- `status` (Pending, Approved, Rejected)
- `created_at` (Timestamp)

## 📖 Usage Guide

### Logging In
1. Navigate to login page
2. Enter username and password
3. System redirects based on role

### Viewing the Interactive Map
1. Click "Interactive Map" in navigation
2. View all churches with color-coded risk markers:
   - 🟢 Green = Low Risk
   - 🟡 Yellow = Moderate Risk
   - 🟠 Orange = High Risk
   - 🔴 Red = Critical Risk
   - ⚫ Gray = No Assessment
3. Click markers for detailed church information

### Submitting a Damage Report (Contributor/Admin)
1. Navigate to "Submit Report"
2. Select a church from dropdown
3. Choose report date
4. Select risk level
5. Enter detailed damage description
6. Optionally upload an image (JPG/PNG)
7. Click "Submit Report"
8. Report will be pending until admin approval

### Managing Churches (Admin Only)
1. Navigate to "Admin" → "Manage Churches"
2. **Add Church**: Fill in form with church details
3. **Edit Church**: Click "Edit" button, modify details
4. **Delete Church**: Click "Delete" (with confirmation)

### Approving Reports (Admin Only)
1. Navigate to "Admin" → "Approve Reports"
2. Review submitted reports
3. Click "Approve" to accept report
4. Click "Reject" to decline report
5. Tables are searchable and sortable

### Viewing Reports
1. Navigate to "Reports"
2. View all approved reports
3. Use search box to filter
4. Click column headers to sort
5. Pagination for easy browsing

## 🔒 Security Features

### 1. Authentication
- Session-based authentication
- Secure password hashing (PHP password_hash with bcrypt)
- Session regeneration
- Auto-logout on browser close

### 2. SQL Injection Prevention
- Prepared statements for all database queries
- Parameter binding
- Input sanitization

### 3. Input Validation
- Server-side validation
- XSS prevention (htmlspecialchars)
- File upload validation (type and size)

### 4. Access Control
- Role-based permissions
- Page-level access control
- Function-level security checks

### 5. File Upload Security
- Allowed file types: JPG, PNG only
- Unique filename generation
- Stored outside web root (recommended for production)

## 📁 Project Structure

```
SADIWA/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styles
│   └── js/                     # JavaScript files
├── config/
│   ├── database.php           # Database connection
│   └── session.php            # Session management
├── database/
│   └── schema.sql             # Database schema & sample data
├── functions/
│   ├── auth.php               # Authentication functions
│   ├── church.php             # Church management functions
│   └── report.php             # Report management functions
├── pages/
│   ├── includes/
│   │   └── navbar.php         # Navigation bar
│   ├── approve_reports.php    # Admin: Approve reports
│   ├── church_details.php     # Church detail view
│   ├── churches.php           # Churches list
│   ├── dashboard.php          # Main dashboard
│   ├── login.php              # Login page
│   ├── logout.php             # Logout handler
│   ├── manage_churches.php    # Admin: Church management
│   ├── map.php                # Interactive map
│   ├── reports.php            # Reports list
│   └── submit_report.php      # Submit damage report
├── uploads/                    # Uploaded images
├── index.html                 # Landing page
└── README.md                  # This file
```

## 🎯 Key Features Demonstration

### For Presentation:
1. **Show the interactive map** - Main highlight with risk visualization
2. **Demonstrate role-based access** - Login as different users
3. **Submit a sample report** - Show the reporting workflow
4. **Display the dashboard** - Risk summary and statistics
5. **Admin approval process** - Show report moderation

### Sample Churches Included:
- Baclayon Church (Baroque, 1727)
- Loboc Church (Spanish Colonial, 1602)
- Maribojoc Church (Baroque, 1768)
- Tagbilaran Cathedral (Neo-Classical, 1767)
- And 8 more heritage churches

## 🐛 Troubleshooting

### Common Issues:

**Database Connection Error:**
- Check MySQL is running in XAMPP
- Verify database credentials in `config/database.php`
- Ensure `sadiwa_db` database exists

**Login Not Working:**
- Clear browser cache and cookies
- Verify users exist in database
- Check PHP session is enabled

**Map Not Displaying:**
- Check internet connection (Leaflet.js and map tiles load from CDN)
- Verify JavaScript is enabled in browser
- Check browser console for errors

**Images Not Uploading:**
- Ensure `uploads/` folder exists
- Check folder permissions (755 or 777)
- Verify file size and type

## 📝 Sample Data

The system includes:
- **12 Sample Churches** in various Bohol municipalities
- **3 User Accounts** (Admin, Contributor, Viewer)
- **7 Damage Reports** with various risk levels
- **4 Risk Levels** (Low, Moderate, High, Critical)

## 🚀 Future Enhancements (Suggestions)

- Email notifications for report approvals
- PDF report generation
- Multi-language support (English, Filipino, Cebuano)
- Mobile app version
- Historical damage timeline
- Restoration project tracking
- Community discussion forum
- Weather data integration

## 👨‍💻 Development Notes

### Code Style:
- Simple, beginner-friendly PHP code
- Well-commented functions
- Consistent naming conventions
- Modular structure (separation of concerns)

### Best Practices Implemented:
- MVC-inspired architecture
- DRY (Don't Repeat Yourself) principle
- Prepared statements for database security
- Responsive design (mobile-friendly)
- Accessible UI elements

## 📞 Support & Documentation

For questions or issues:
1. Check this README thoroughly
2. Review code comments in each file
3. Verify database is properly set up
4. Test with demo accounts first

## 🎓 Academic Use

This system is designed as a student project demonstrating:
- Full-stack web development
- Database design and management
- Role-based access control
- Interactive mapping with Leaflet.js
- Community-based data collection
- Cultural heritage preservation technology

## 📄 License

This project is created for educational purposes. Free to use and modify for academic and non-commercial purposes.

---

**SADIWA** - Preserving Bohol's cultural heritage through community participation and technology.

*Developed with attention to simplicity, security, and functionality.*
