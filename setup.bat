@echo off

REM Step 1: Create the .env file from .env.example if it doesn't exist
IF NOT EXIST .env (
    echo Creating .env file from .env.example...
    copy .env.example .env
    IF %ERRORLEVEL% NEQ 0 (
        echo Failed to create .env file. Ensure the .env.example file exists.
        pause
        exit /b
    )
)

REM Step 2: Install Composer dependencies
echo Installing Composer dependencies...
composer install
IF %ERRORLEVEL% NEQ 0 (
    echo Composer installation failed! Please ensure Composer is installed.
    pause
    exit /b
)

REM Step 3: Generate the Laravel application key
echo Generating application key...
php artisan key:generate
IF %ERRORLEVEL% NEQ 0 (
    echo Failed to generate application key. Please ensure PHP and Laravel are installed properly.
    pause
    exit /b
)

REM Step 4: Run database migrations
echo Running database migrations...
php artisan migrate
IF %ERRORLEVEL% NEQ 0 (
    echo Migration failed. Please check the database connection and configuration.
    pause
    exit /b
)

REM Step 5: Start the Laravel development server
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
