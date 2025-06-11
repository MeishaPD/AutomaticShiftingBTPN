# Bank BTPN Automatic Shifting

An automated employee shift management system for Bank BTPN.

## System Requirements

Before you begin, ensure your computer has the following installed:

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x (for asset compilation)
- Git

## Installation Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/joki-kim/BankBTPNAutomaticShifting.git
   cd AutomaticShiftingBTPN
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Copy Environment File**
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Configure Database**
   - Open `.env` file
   - Adjust database configuration:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=autoshift
     DB_USERNAME=root
     DB_PASSWORD=
     ```

6. **Create Database**
   ```bash
   mysql -u root -p
   CREATE DATABASE autoshift;
   exit;
   ```

7. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

8. **Run Seeders**
   ```bash
   php artisan db:seed
   ```

9. **Install Node.js Dependencies**
   ```bash
   npm install
   ```

10. **Run Development Server**
   ```bash
   npm run dev
   ```

11. **Start Development Server**
    ```bash
    php artisan serve
    ```

12. **Access Application**
    - Open browser and navigate to `http://localhost:8000`
    - Login with default credentials:
      - Admin:
        - Email: admin@btpn.com
        - Password: password
        - NIK: 1234567890123456
      - Employee:
        - Email: employee@btpn.com
        - Password: password
        - NIK: 6543210987654321

## Key Features

- Automated employee shift management
- New employee onboarding
- Shift request system
- Shift reporting
- Role-based access control (Admin & Employee)

## Roles and Permissions

The system uses role-based access control (RBAC) with the following roles and permissions:

### Available Permissions
- `view dashboard` - Access to the main dashboard
- `request shifting` - Ability to request shift changes
- `view reports` - View shift reports
- `download reports` - Download shift reports
- `manage employee onboarding` - Manage employee onboarding process
- `delete employee shifts` - Delete employee shifts

### Role Permissions Matrix

| Permission | Admin | Employee |
|------------|-------|----------|
| view dashboard | ✓ | ✓ |
| request shifting | ✓ | ✓ |
| view reports | ✓ | ✗ |
| download reports | ✓ | ✗ |
| manage employee onboarding | ✓ | ✗ |
| delete employee shifts | ✓ | ✗ |

## Troubleshooting

1. **Permission Issues**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. **Composer Dependencies Issues**
   ```bash
   composer clear-cache
   composer install --no-cache
   ```

3. **Node Modules Issues**
   ```bash
   rm -rf node_modules
   npm cache clean --force
   npm install
   ```
