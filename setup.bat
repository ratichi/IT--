@echo off
setlocal

REM Step 1: Check if PHP is installed
echo Checking PHP version...
php -v > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo PHP is not installed or not in the system PATH. Please install PHP.
    type output.txt
    pause
    exit /b
)

REM Step 2: Check if Composer is installed
echo Checking Composer version...
composer --version > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo Composer is not installed or not in the system PATH. Please install Composer.
    type output.txt
    pause
    exit /b
)

REM Step 3: Check if .env exists, create if not
IF NOT EXIST .env (
    echo .env file not found. Creating from .env.example...
    copy .env.example .env > output.txt 2>&1
    IF %ERRORLEVEL% NEQ 0 (
        echo Failed to create .env file. Ensure .env.example exists and is accessible.
        type output.txt
        pause
        exit /b
    )
)

REM Step 4: Install Composer dependencies
echo Installing Composer dependencies...
composer install > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo Composer installation failed! Please check if your environment supports Composer.
    type output.txt
    pause
    exit /b
)

REM Add a short delay to allow Composer to finish
timeout /t 5

REM Step 5: Generate Laravel application key
echo Generating application key...
php artisan key:generate > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate application key. Ensure that PHP and Composer are working properly.
    type output.txt
    pause
    exit /b
)

REM Step 6: Run database migrations
echo Running database migrations...
php artisan migrate > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo Migration failed. Please check your database configuration and environment.
    type output.txt
    pause
    exit /b
)

REM Step 7: Start the Laravel development server
echo Starting Laravel server...
php artisan serve > output.txt 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to start Laravel server. Please ensure that PHP and Laravel are installed correctly.
    type output.txt
    pause
    exit /b
)

REM Final message
echo Setup completed! You can now access the application by navigating to http://localhost:8000 in your browser.
pause
