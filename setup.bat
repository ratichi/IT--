@echo on
echo Starting setup process...

:: Check if Composer is installed
call composer --version
if %errorlevel% neq 0 (
    echo Composer is not installed. Please install Composer and try again.
    pause
    exit /b
)

:: Create .env file
call copy .env.example .env
if %errorlevel% neq 0 (
    echo Failed to copy .env.example to .env. Please check if the .env.example file exists.
    pause
    exit /b
)

:: Install Composer dependencies
call composer install
if %errorlevel% neq 0 (
    echo Composer install failed. Please check the error above.
    pause
    exit /b
)

:: Generate Laravel key
call php artisan key:generate
if %errorlevel% neq 0 (
    echo Failed to generate application key. Please check if PHP is installed correctly and Laravel is set up.
    pause
    exit /b
)

call mysql -u root -e "CREATE DATABASE IF NOT EXISTS it_project;"

call php artisan migrate --force

:: Start the Laravel development server
call php artisan serve
if %errorlevel% neq 0 (
    echo Failed to start Laravel server. Please check PHP and Laravel configuration.
    pause
    exit /b
)

:: Keep the terminal open
echo Setup complete. Press any key to exit.
pause
