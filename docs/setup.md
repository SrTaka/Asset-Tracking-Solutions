# Project Setup Guide

## Requirements
- PHP 8.1+
- Composer 2.0+
- MySQL 8.0+

## Installation
1. Clone the repository:
   ```bash
   git clone project-url

## Install dependencies:
composer install
npm install

## Configure environment:
cp .env.example .env
php artisan key:generate

## Database Setup
php artisan migrate --seed


## Running Locally
php artisan serve
npm run dev