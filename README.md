
## Installation Instructions

### Backend (Laravel API)

```bash
#clone backend repository
git clone https://github.com/tansibMuttakin/Inventory-And-Financial-Reporting-System.git

#go to project directory
cd Inventory-And-Financial-Reporting-System

# Install dependencies
composer install

# Copy env and generate app key
cp .env.example .env
php artisan key:generate

# Setup DB
php artisan migrate --seed

# Serve the app
php artisan serve
```
