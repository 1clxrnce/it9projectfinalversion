# How to Transfer Your Project to Your Laptop

## ✅ Step 1: Everything is Already Pushed to GitHub!

Your project is now safely stored on GitHub at:
**https://github.com/1clxrnce/it9projectfinalversion**

All your latest changes have been pushed successfully.

---

## 📥 Step 2: Clone the Project on Your Laptop

### Option A: Using Git Command Line

1. **Open Terminal/Command Prompt on your laptop**
   - Windows: Press `Win + R`, type `cmd`, press Enter
   - Mac: Press `Cmd + Space`, type `terminal`, press Enter

2. **Navigate to where you want the project**
   ```bash
   cd Desktop
   # Or wherever you want to put the project
   ```

3. **Clone the repository**
   ```bash
   git clone https://github.com/1clxrnce/it9projectfinalversion.git
   ```

4. **Enter the project folder**
   ```bash
   cd it9projectfinalversion
   ```

### Option B: Using GitHub Desktop (Easier for Beginners)

1. **Download GitHub Desktop**
   - Go to: https://desktop.github.com/
   - Download and install

2. **Sign in to GitHub Desktop**
   - Open GitHub Desktop
   - Click "Sign in to GitHub.com"
   - Enter your GitHub credentials

3. **Clone the repository**
   - Click "File" → "Clone repository"
   - Find "1clxrnce/it9projectfinalversion" in the list
   - Choose where to save it on your laptop
   - Click "Clone"

---

## 🔧 Step 3: Set Up the Project on Your Laptop

After cloning, you need to set up the Laravel project:

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Set Up Environment File

```bash
# Copy the example environment file
copy .env.example .env
# On Mac/Linux use: cp .env.example .env
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Set Up Database

The project uses SQLite, so the database file should already be included. If not:

```bash
# Create a new SQLite database
php artisan migrate --seed
```

### 5. Create Storage Link

```bash
php artisan storage:link
```

### 6. Build Frontend Assets

```bash
npm run build
```

---

## 🚀 Step 4: Run the Project

```bash
# Start the Laravel development server
php artisan serve
```

The project will be available at: **http://127.0.0.1:8000**

---

## 🔐 Step 5: Login Credentials

Use these credentials to log in:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Staff Account:**
- Email: `staff@example.com`
- Password: `password`

**Customer Account:**
- Email: `customer@example.com`
- Password: `password`

---

## 📝 Step 6: Making Changes and Syncing

### When You Make Changes on Your Laptop:

1. **Check what changed**
   ```bash
   git status
   ```

2. **Add all changes**
   ```bash
   git add .
   ```

3. **Commit changes**
   ```bash
   git commit -m "Description of what you changed"
   ```

4. **Push to GitHub**
   ```bash
   git push origin main
   ```

### When You Want to Get Latest Changes on Your Desktop:

1. **Pull latest changes**
   ```bash
   git pull origin main
   ```

---

## 🔄 Complete Workflow Between Desktop and Laptop

### On Desktop (Before Switching to Laptop):
```bash
git add .
git commit -m "Your changes"
git push origin main
```

### On Laptop (After Desktop Push):
```bash
git pull origin main
composer install
npm install
php artisan migrate
```

### On Laptop (Before Switching Back to Desktop):
```bash
git add .
git commit -m "Your changes"
git push origin main
```

### On Desktop (After Laptop Push):
```bash
git pull origin main
composer install
npm install
php artisan migrate
```

---

## ⚠️ Important Notes

### Database Considerations:

The SQLite database file (`database/database.sqlite`) is included in the repository. This means:

✅ **Pros:**
- Easy to transfer between computers
- No need to set up MySQL/PostgreSQL
- All your data moves with the project

⚠️ **Cons:**
- Changes to the database on one computer won't automatically sync to the other
- You might have different data on desktop vs laptop

### Solutions:

**Option 1: Use the same database (Recommended for development)**
- The database file is in the repo, so it will sync
- But be careful: if you make changes on both computers, you might have conflicts

**Option 2: Use separate databases**
- Add `database/database.sqlite` to `.gitignore`
- Each computer has its own data
- Run `php artisan migrate --seed` on each computer

**Option 3: Use a shared database (Best for production)**
- Set up MySQL or PostgreSQL
- Both computers connect to the same database server
- Update `.env` file with database credentials

---

## 🆘 Troubleshooting

### "composer: command not found"
- Install Composer: https://getcomposer.org/download/

### "npm: command not found"
- Install Node.js: https://nodejs.org/

### "php: command not found"
- Install PHP: https://www.php.net/downloads

### Storage link not working
```bash
# Remove old link and recreate
rm public/storage
php artisan storage:link
```

### Permission errors (Mac/Linux)
```bash
chmod -R 775 storage bootstrap/cache
```

### Database errors
```bash
# Reset database
php artisan migrate:fresh --seed
```

---

## 📦 What's Included in the Repository

✅ All source code
✅ Database file (SQLite)
✅ Uploaded images (in storage/app/public)
✅ Configuration files
✅ Dependencies list (composer.json, package.json)

❌ Not included (will be installed):
- vendor/ folder (PHP dependencies)
- node_modules/ folder (JavaScript dependencies)
- .env file (you'll copy from .env.example)

---

## 🎯 Quick Start Checklist for Laptop

- [ ] Clone repository from GitHub
- [ ] Run `composer install`
- [ ] Run `npm install`
- [ ] Copy `.env.example` to `.env`
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan storage:link`
- [ ] Run `npm run build`
- [ ] Run `php artisan serve`
- [ ] Open http://127.0.0.1:8000
- [ ] Login with admin@example.com / password

---

## 📞 Need Help?

If you encounter any issues:
1. Check the error message carefully
2. Make sure all dependencies are installed
3. Verify your PHP version (should be 8.1 or higher)
4. Check that the .env file is configured correctly

---

**Your GitHub Repository:**
https://github.com/1clxrnce/it9projectfinalversion

**Last Updated:** April 29, 2026
