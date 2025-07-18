### `docs/deployment.md`
```markdown
# Deployment Guide

## Production Server Requirements
- Ubuntu 20.04 LTS
- Nginx
- PHP 8.1 with FPM
- MySQL 8.0

## Deployment Steps
1. Clone the repo to `/var/www/project`
2. Set up environment variables
3. Run:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run production
   php artisan optimize