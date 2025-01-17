#!/bin/bash

echo "Starting setup process..."

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer and try again."
    exit 1
fi

# Create .env file
if [ ! -f .env ]; then
    cp .env.example .env
    if [ $? -ne 0 ]; then
        echo "Failed to copy .env.example to .env. Please check if the .env.example file exists."
        exit 1
    fi
else
    echo ".env file already exists. Skipping .env creation."
fi

# Install Composer dependencies
composer install
if [ $? -ne 0 ]; then
    echo "Composer install failed. Please check the error above."
    exit 1
fi

# Generate Laravel key
php artisan key:generate
if [ $? -ne 0 ]; then
    echo "Failed to generate application key. Please check if PHP is installed correctly and Laravel is set up."
    exit 1
fi

# Create the database if it doesn't exist
echo "Creating database if it doesn't exist..."
mysql -u root -e "CREATE DATABASE IF NOT EXISTS it_project;"
if [ $? -ne 0 ]; then
    echo "Failed to create database. Please ensure MySQL is installed and running, and the root user has access."
    exit 1
fi

# Run migrations
php artisan session:table
if [ $? -ne 0 ]; then
    echo "Failed to create session table."
    exit 1
fi

php artisan migrate --force
if [ $? -ne 0 ]; then
