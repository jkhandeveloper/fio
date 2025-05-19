<h1 align="center">FIO Hospital Management System</h1>
<h2>Table of Contents</h2>
<ol>
<li>System Overview</li>
<li>Features</li>
<li>Installation Guide</li>
<li>Configuration</li>
<li>User Roles</li>
<li>Database Schema</li>
<li>Troubleshooting</li>
<li>Maintenance</li>
<li>Security</li>
</ol>

<h2>System Overview</h2>
<p>This System is a comprehensive web application designed to streamline patient appointment operations by providing separate interfaces for doctors, patients, and staff members. Built with Laravel 10, the system offers appointment scheduling, patient management, and medical record keeping.</p>

<h3>Key Components:</h3>
<ul>
<li>Admin Portal to Add, Update and Delete records of Doctor, Patient and Staff.</li>
<li>Doctor portal for appointment slot management</li>
<li>Patient portal for appointment booking</li>
<li>Staff portal for patient check-in/out and records management</li>
<li>Secure authentication system</li>
<li>Email notification system</li>
</ul>

<h2>Features</h2>
<h3Core Features</h3>
<ul>
<li>Multi-role authentication (Doctor, Patient, Staff)</li>
<li>Appointment scheduling with time slot management</li>
<li>Patient verification and check-in system</li>
<li>Medical records creation and management</li>
</ul>

<h3>Doctor-Specific Features</h3>
<ul>
<li>Create and manage available time slots</li>
<li>View upcoming appointments</li>
</ul>

<h3>Patient-Specific Features</h3>
<ul>
<li>Book appointments with preferred doctors</li>
<li>View appointment history</li>
<li>Receive appointment confirmation email</li>
</ul>
<h3>Staff-Specific Features</h3>
<ul>
<li>Verify patient appointments</li>
<li>Manage patient check-in/out</li>
<li>Generate medical records</li>
</ul>

<h2>Installation Guide</h2>	
<h3>Server Requirements</h3>
<ul>
<li>PHP 8.1+</li>	
<li>MySQL 5.7+</li>
<li>Composer 2.0+</li>
<li>Web server (Apache/Nginx)</li>
</ul>
<h3>Installation Steps</h3>

<h4>Clone the repository</h4>
<p><code>git clone https://github.com/jkhandeveloper/fio.git</code></p>
<p><code>composer install</code></p>
<p><code>npm install</code></p>
<p><code>npm run build</code></p>
<p><code>php artisan serve</code></p>

<h4>Set up the environment</h4>

<p>Copy .env.example to  .env file</p>
<p>Run <code>php artisan key:generate</code> command</p>

<h4>Set up database</h4>
<ul>
<li>Open MySQL and create a new database</li>
<li>Update. env with database credentials</li>
</ul>
<h4>Run the following command to create tables and seed data:</h4>
<p><code>php artisan migrate –seed</code></p>     

<h2>Configuration</h2>
<h3>Environment Variables</h3>

<h4>Key configuration options in .env:</h4>
<ul>
<li>APP_NAME=HealthcarePortal</li>
<li>APP_ENV=production</li>
<li>APP_KEY=</li>
<li>APP_DEBUG=false</li>
<li>APP_URL=https://your-domain.com</li>
<li>DB_HOST=127.0.0.1</li>
<li>DB_PORT=3306</li>
<li>DB_DATABASE=healthcare_portal</li>
<li>DB_USERNAME=portal_user</li>
<li>DB_PASSWORD=secure_password</li>
<li>MAIL_MAILER=smtp</li>
<li>MAIL_HOST=mail.example.com<li>MAIL_PORT=587</li>
<li>MAIL_USERNAME=no-reply@example.com</li>
<li>MAIL_PASSWORD=email_password</li>
<li>MAIL_ENCRYPTION=tls</li>
</ul>

<h2>User Roles</h2>
<h3>Doctor Permissions</h3>
<ul>
<li>Manage appointment slots</li>
<li>View patient appointments</li>
<li>Access medical records</li>
</ul>
<h3>Patient Permissions</h3>
<ul>
<li>Book/cancel appointments</li>
<li>View appointment history</li>	
<li>Update personal information</li>
</ul>
<h3>Staff Permissions</h3>
<ul>
<li>Verify patient appointments</li>
<li>Check patients in/out</li>
<li>Create medical records</li>
</ul>



<h2>Database Schema</h2>
 
<h3>Main tables:</h3>
<ul>
<li>users - Base user accounts</li>	
<li>doctors - Doctor-specific information</li>
<li>patients - Patient-specific information</li>
<li>staff - Staff member information</li>
<li>slots - Available time slots</li>
<li>appointments - Booked appointments</li>
<li>patient_visits - Visit records</li>
<li>medical_records - Treatment documentation</li>
</ul>

<h2>Troubleshooting</h2>
<h3>Common Issues</h3>	
<h4>Email Not Sending</h4>
<ul>
<li>Check .env configuration</li>
<li>Verify SMTP settings</li>
<li>Check mail server logs</li>
<li>Test email functionality with php artisan test:email</li>
</ul>
<h4>Permission Errors</h4>
<ul>
<li>Ensure correct ownership and permissions on storage and bootstrap/cache directories</li>
<li>Run the following commands:</li>
<ul>
<li>chmod -R 775 storage bootstrap/cache</li>
<li>chown -R www-data:www-data .</li>
</ul>
</ul>
<h4>Database Migration Issues</h4>
<ul>
<li>Check migration files for syntax errors</li>
<li>Ensure database connection settings in .env are correct</li>
<li>Run php artisan migrate --force to apply migrations</li>
</ul>

<h2>Maintenance</h2>
<h3>Backup Procedures</h3>
<h4>Database Backup</h4>
<p><code>mysqldump -u username -p healthcare_portal > backup-$(date +%F).sql</code></p>

<h3>Update Procedure</h3>
<h4>>Pull latest changes</h4>
<p><code>git pull origin main</code></p>
<h4>Update dependencies</h4>
<p><code>composer update</code></p>
<h4>Run migrations</h4>
<p><code>php artisan migrate</code></p>
<h4>Clear caches</h4>
<p><code>php artisan optimize:clear</code></p>



<h2>Security</h2>
<h3>Security Measures</h3>
<h4>Authentication</h4>
<ul>
<li>Use Laravel's built-in authentication system</li>
<li>Implement password hashing with bcrypt</li>
<li>Use HTTPS for secure data transmission</li>
<li>Implement CSRF protection</li>
<li>Use Laravel's built-in CSRF protection</li>
<li>Use Laravel's built-in XSS protection</li>
<li>Sanitize user inputs</li>
<li>Use Laravel's built-in XSS protection</li>
<li>Validate and sanitize all user inputs</li>
</ul>

<h3>Best Practices</h3>
<h4>Regular Updates</h4>
<ul>
<li>Keep Laravel and dependencies updated</li>
<li>Monitor security advisories</li>
<li>Use secure coding practices</li>
</ul>
<h4>Access Control</h4>
<ul>
<li>Use middleware for route protection</li>
</ul>
<h4>Data Protection</h4>
<ul>
<li>Use HTTPS for secure data transmission</li>
<li>Implement data encryption for sensitive information</li>
<li>Implement proper session management</li>
</ul>
<h4>Security Headers</h4>
<h5>The system includes these HTTP headers by default:</h5>
<ul>
	<li>Content Security Policy (CSP)</li>
	<li>X-Content-Type-Options</li>
	<li>X-Frame-Options</li>
	<li>Strict-Transport-Security</li>
</ul>
