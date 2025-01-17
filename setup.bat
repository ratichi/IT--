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

REM Step 6: Generate the Laravel application key
echo Generating application key...
php artisan key:generate

REM Step 7: Run database migrations
echo Running database migrations...
php artisan migrate

REM Step 8: (Optional) Seed the database with sample data
echo Seeding the database...
php artisan db:seed

REM Step 9: Create a symbolic link for storage
echo Creating storage link...
php artisan storage:link

REM Step 10: Run Laravel's development server
echo Starting Laravel server...
php artisan serve

REM Final message
echo Setup completed! You can now run the application using 'php artisan serve'.
pause
