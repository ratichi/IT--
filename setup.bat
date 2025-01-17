@echo off

REM Step 1: Check and create .env file if it doesn't exist
IF NOT EXIST .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
) ELSE (
    echo .env file already exists.
)

REM Step 2: Ask for database name if not already configured
findstr /C:"DB_DATABASE" .env >nul || (
    set /p db_name="Please enter your database name: "
    powershell -Command "(Get-Content .env) -replace 'DB_DATABASE=homestead', 'DB_DATABASE=%db_name%' | Set-Content .env"
)

REM Step 3: Ask for database username if not already configured
findstr /C:"DB_USERNAME" .env >nul || (
    set /p db_username="Please enter your database username: "
    powershell -Command "(Get-Content .env) -replace 'DB_USERNAME=homestead', 'DB_USERNAME=%db_username%' | Set-Content .env"
)

REM Step 4: Ask for database password if not already configured
findstr /C:"DB_PASSWORD" .env >nul || (
    set /p db_password="Please enter your database password: "
    powershell -Command "(Get-Content .env) -replace 'DB_PASSWORD=secret', 'DB_PASSWORD=%db_password%' | Set-Content .env"
)

REM Step 5: Install Composer dependencies
echo Installing Composer dependencies...
composer install
IF %ERRORLEVEL% NEQ 0 (
    echo Composer installation failed! Please ensure Composer is installed.
    pause
    exit /b
)

REM Step 6: Generate the Laravel application key
echo Generating application key...
php artisan key:generate
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate application key. Please ensure PHP and Laravel are installed properly.
    pause
    exit /b
)

REM Step 7: Run database migrations
echo Running database migrations...
php artisan migrate
IF %ERRORLEVEL% NEQ 0 (
    echo Migration failed. Please check the database connection and configuration.
    pause
    exit /b
)

REM Step 8: (Optional) Seed the database with sample data
echo Seeding the database...
php artisan db:seed
IF %ERRORLEVEL% NEQ 0 (
    echo Seeding failed. Please check your database setup.
    pause
    exit /b
)

REM Step 9: Create a symbolic link for storage
echo Creating storage link...
php artisan storage:link
IF %ERRORLEVEL% NEQ 0 (
    echo Storage link creation failed. Please check your Laravel setup.
    pause
    exit /b
)

REM Step 10: Run Laravel's development server
echo Starting Laravel server...
php artisan serve
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to start Laravel server. Please ensure your PHP setup is correct.
    pause
    exit /b
)

REM Final message
echo Setup completed! You can now run the application using 'php artisan serve'.
pause
