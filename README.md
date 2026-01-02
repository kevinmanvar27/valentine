   git clone <repository-url>
   cd valentine
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   For SQLite (default):
   ```bash
   touch database/database.sqlite
   ```
   
   For MySQL, update `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=valentine
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - User site: `http://localhost:8000`
    - Admin panel: `http://localhost:8000/admin/dashboard`

## Creating Admin User

Run tinker to create an admin user:
