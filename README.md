# AlgoritmoFlow

A Laravel 12 + PHP 8.4 project that powers a learning and music-driven platform.  
---

## 🚀 Tech Stack

- **PHP** 8.4
- **Laravel** 12.28
- **MySQL** (or compatible database)
- **Composer** (dependency manager)
- **Node.js & NPM** (for frontend assets if needed)
- **Tailwind CSS** (for styling, optional)
- **Mail**: Laravel Mailables (with Markdown templates)

---

## 📂 Features

- Home page with basic controller and Blade view
- Contact page:
  - Form validation
  - Persists messages in DB (`contact_messages` table)
  - Sends notification emails using `ContactMessageMail`
- MVC structure following Laravel conventions

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/elhaza/algoritmoflow.git
cd algoritmoflow
```

Install PHP dependencies:

```bash
composer install
```

Install Node dependencies (if using Vite/Tailwind):

```bash
npm install
npm run dev
```

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Run database migrations:

```bash
php artisan migrate
```

---

## 📧 Email Configuration

In your `.env`, set up mail credentials:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@algoritmoflow.test
MAIL_FROM_NAME="AlgoritmoFlow"
```

For development, you can log emails instead of sending:

```dotenv
MAIL_MAILER=log
```

---

## 🖥️ Development

Start the local development server:

```bash
php artisan serve
```

or if using Laravel Herd/Valet, open:

```
http://algoritmoflow.test
```

---

## 🗄️ Database

Main table used for contact form submissions:

- **contact_messages**
  - id
  - name
  - email
  - message
  - ip
  - user_agent
  - subject
  - timestamps

---

## 🛠️ Useful Commands

Clear caches:

```bash
php artisan optimize:clear
```

Run tests:

```bash
php artisan test
```

Check routes:

```bash
php artisan route:list
```

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you’d like to change.

---

## 📜 License

This project is licensed under the MIT License.
