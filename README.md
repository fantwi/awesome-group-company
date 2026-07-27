# Awesome Group Company Information System

A framework-free group assignment built with PHP, HTML, CSS Grid, Flexbox, JavaScript, and SQLite.

## Features

- Responsive home, company, contact, and JavaScript demonstration pages
- Four editable group-member profile cards
- JavaScript scrolling announcement text
- Automatic/manual five-image homepage slider
- Alert, confirm, and prompt pop-up demonstrations
- Secure registration and login with password hashing
- Protected information-system dashboard
- Add, retrieve/search, update, and delete company records
- Prepared database statements and CSRF protection

## Run locally

PHP 8+ with the PDO SQLite extension is required.

```bash
php -S localhost:8000
```

Open `http://localhost:8000`.

The SQLite database is created automatically at `data/awesome.sqlite` on first request.

Demo login:

- Email: `admin@awesomegroup.test`
- Password: `Awesome123!`

## Add the real group profiles

Edit the `$members` array in `index.php`. Replace the four placeholder names and student IDs. To use real photos, replace each `.avatar` block with an `<img>` element or set the corresponding image in CSS.

## Project structure

```text
assets/          CSS, JavaScript, and slider illustrations
data/            Auto-created SQLite database (not committed)
includes/        Shared configuration, navigation, and footer
index.php        Homepage and team profiles
about.php        Company information
contact.php      Contact form demonstration
popups.php       JavaScript pop-ups
login.php        Login
register.php     Registration
dashboard.php    Protected CRUD information system
```
