# SecureShop Web Security Simulation

An intentionally vulnerable PHP/MySQL web application for practicing offensive testing, defensive hardening, and Apache log analysis in an isolated lab. The repository supports a classroom capture-the-flag (CTF) exercise in which teams deploy local web servers, discover controlled vulnerabilities, collect flags, and investigate the resulting activity with Splunk.

> [!CAUTION]
> This project deliberately contains insecure code, weak credentials, embedded CTF flags, and vulnerable configurations. Run it only on an isolated VM or private lab network that you own or are explicitly authorized to test. Do not expose it to the public internet or reuse its credentials in any real system.

## Project goals

- Deploy a local Apache, PHP, and MariaDB web application.
- Demonstrate SQL injection, cross-site scripting (XSS), weak authentication, and related web risks.
- Practice incremental hardening without removing every planned CTF path.
- Forward Apache access and error logs to Splunk.
- Detect attack payloads, identify source IPs, and document response actions.
- Compare vulnerable and partially hardened implementations.

## Repository contents

| Path | Purpose |
| --- | --- |
| `DFIR/` | Partially hardened SecureShop implementation with selected CTF vulnerabilities retained. |
| `DFIR_test/` | Duplicate/test copy of the partially hardened implementation. |
| `SecureShop/` | Small baseline PHP implementation with intentionally direct SQL queries and minimal defenses. |
| `SecureShop1.0/` | Intermediate implementation with some prepared statements and validation. |
| `src/src/` | Another copy of the intermediate/partially hardened PHP application. |
| `bookstore-web-security/bookstore-web-security/` | Separate Laravel 8 bookstore scaffold with authentication, books, carts, middleware, and tests. |
| `kali_deployment_guide.txt` | Detailed Kali Linux, Apache, MariaDB, logging, and lab setup notes. |
| `ca.crt` | Certificate authority certificate supplied for the lab. Review its provenance before trusting it. |
| `*.zip`, `*.rar` | Archived copies of project variants. They are not required when the matching extracted directory is present. |

The recommended classroom target is `DFIR/`. Use `SecureShop/` when you need the simplest vulnerable baseline. The Laravel directory is a separate prototype rather than a drop-in replacement for the PHP target.

## Lab architecture

```text
Attacker VM/workstation
        |
        | authorized test traffic
        v
Apache + PHP + SecureShop ----> MariaDB
        |
        | access/error logs
        v
Splunk forwarder / Splunk VM
```

## Features

- User registration, login, logout, and session handling
- Product listing and product detail pages
- Admin-only user listing
- Basic validation and output escaping in the partially hardened variants
- Session regeneration and simple login-attempt throttling in `DFIR/`
- Intentionally retained CTF weaknesses and hidden flags
- Apache logging suitable for Splunk ingestion
- A separate Laravel bookstore prototype with book and cart workflows

## Requirements

For the plain-PHP SecureShop lab:

- Kali Linux, Ubuntu, or another Linux VM
- Apache 2
- PHP with `mysqli` support
- MariaDB or MySQL
- Splunk Enterprise or a Splunk forwarder (optional, for monitoring exercises)

Example package installation on Kali/Debian:

```bash
sudo apt update
sudo apt install apache2 mariadb-server php php-mysql libapache2-mod-php
sudo systemctl enable --now apache2 mariadb
sudo mysql_secure_installation
```

## Quick start

### 1. Create the lab database

Open MariaDB as an administrator:

```bash
sudo mysql
```

Create a dedicated database and local-only application account. The application currently expects the values shown below; change them in both MariaDB and `DFIR/db.php` if desired.

```sql
CREATE DATABASE secureshop;
CREATE USER 'shopuser'@'localhost' IDENTIFIED BY 'vulnerable123';
GRANT ALL PRIVILEGES ON secureshop.* TO 'shopuser'@'localhost';
FLUSH PRIVILEGES;
```

Create the required tables:

```sql
USE secureshop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Seed users, products, and exercise flags using the SQL examples in `kali_deployment_guide.txt`. Flags are intentionally not reproduced here to avoid README spoilers.

### 2. Deploy the application

Copy the recommended variant into Apache's document root:

```bash
sudo mkdir -p /var/www/html/secureshop
sudo cp -R DFIR/. /var/www/html/secureshop/
sudo chown -R www-data:www-data /var/www/html/secureshop
sudo find /var/www/html/secureshop -type d -exec chmod 755 {} \;
sudo find /var/www/html/secureshop -type f -exec chmod 644 {} \;
sudo systemctl restart apache2
```

Then open:

```text
http://localhost/secureshop/
```

### 3. Verify logging

Generate a few requests, then confirm Apache is recording them:

```bash
sudo tail -f /var/log/apache2/access.log
sudo tail -f /var/log/apache2/error.log
```

If you define a dedicated virtual host, its log names may differ. Keep directory listing disabled for the partially hardened deployment unless an exercise explicitly requires it.

## Splunk monitoring

Forward the Apache access and error logs to Splunk. Useful defensive searches include:

```spl
index=web sourcetype=access_combined
| stats count by clientip, status
| sort - count
```

```spl
index=web sourcetype=access_combined
| regex _raw="(?i)(union.*select|<script|%3cscript|\.\./|/etc/passwd)"
| table _time, clientip, method, uri, status, useragent
```

```spl
index=web sourcetype=access_combined uri_path="*login.php*"
| bin _time span=5m
| stats count by _time, clientip
| where count >= 5
```

Field names vary by Splunk add-on and sourcetype, so adjust `clientip`, `uri`, and `uri_path` to match your environment.

## Security exercise map

The codebase is designed to support investigation of the following categories without revealing exact payloads or flag locations:

- SQL injection in authentication and record lookup flows
- Reflected/stored output handling and XSS risk
- Weak password storage and default credentials
- Missing CSRF defenses in the plain-PHP variants
- Basic, session-local rate limiting that can be bypassed in realistic deployments
- Verbose error handling and information disclosure
- Authorization and session-management behavior
- Web server configuration and directory-listing risks

Some files contain labels such as `IMPROVED` even though the surrounding flow remains intentionally insecure. Treat these as teaching checkpoints, not proof that a variant is production-safe.

## Laravel prototype

The Laravel bookstore prototype targets PHP 7.3/8.x and Laravel 8:

```bash
cd bookstore-web-security/bookstore-web-security
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

The supplied directory is a lightweight scaffold and may require standard Laravel bootstrap files or regeneration in a fresh Laravel 8 project before these commands work. It also references authenticated API behavior that should be verified against the installed authentication packages. Do not commit `.env`; the archive currently includes one and it should be removed from Git history before publication.

## Testing workflow

1. Take VM snapshots before the exercise.
2. Restrict the lab to a host-only or otherwise isolated network.
3. Record the target IP, tester IP, and test window.
4. Establish normal traffic before launching controlled attacks.
5. Capture relevant Apache and Splunk evidence.
6. Patch one weakness at a time and repeat the same test.
7. Compare logs and application behavior before and after each change.
8. Restore or destroy the lab after the exercise.

For the Laravel prototype, run:

```bash
php artisan test
```

The plain-PHP variants do not include an automated test harness; validate them only inside the controlled lab.

## Before publishing to GitHub

- Remove the tracked `.env` file and add `.env` to `.gitignore`.
- Replace hard-coded database credentials with environment variables.
- Decide whether CTF flags should remain public; rotate them before each event.
- Remove duplicate directories and nested archives unless they are needed for comparison.
- Review `ca.crt` before distribution and never publish a corresponding private key.
- Add screenshots only after redacting IP addresses, usernames, tokens, and flags.
- Choose and add a license. No license should be assumed from the current archive.

## Intended deliverables

- Web server and database configuration notes
- Splunk setup and dashboard/search evidence
- Screenshots of intentionally vulnerable code and recovered flags
- Offensive testing report with authorized methods and results
- Defensive log-analysis report with IPs, payloads, detections, and response actions
- Post-exercise hardening comparison

## Ethics and authorization

Use these materials only for education, research, or testing where every affected system owner has provided explicit permission. Keep scanning and exploitation inside the agreed scope and time window. The maintainers and contributors are not responsible for unauthorized or unlawful use.

