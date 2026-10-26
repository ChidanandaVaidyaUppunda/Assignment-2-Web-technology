# Online Application & Registration Form

A responsive registration form built with HTML, CSS, JavaScript, jQuery and PHP. On valid submission, PHP checks the submitted fields and displays a formatted confirmation page with an application reference and a print option.

## Run locally

1. Install PHP 8+ (or XAMPP/WAMP).
2. Put this folder inside your server's web root (for XAMPP, `htdocs`).
3. Start Apache.
4. Open `http://localhost/online-registration-app/` in your browser.

Alternatively, from this folder run `php -S localhost:8000` and open `http://localhost:8000`.

## Host it online (example: InfinityFree)

1. Create an account at [InfinityFree](https://www.infinityfree.com/) and create a free hosting account/domain.
2. Open the hosting Control Panel and launch **Online File Manager** (or connect using FTP credentials).
3. Upload the files in this folder (`index.php`, `style.css`, `script.js`) into the website's `htdocs` directory. Upload the files themselves, not the enclosing folder, if you want the site at the domain root.
4. Visit the domain assigned to your hosting account and test a sample submission.
5. Keep PHP enabled; this application must be served by a PHP-capable host. GitHub Pages alone cannot execute PHP.

## Notes

- jQuery is loaded from the official jQuery CDN, so users need an internet connection for the client-side enhancements.
- The sample validates data and displays it after submission, but intentionally does not save applicant details to a database or send email.
- For a real production application, add HTTPS, server-side CSRF protection, a database with appropriate access controls, privacy/retention policies, and stronger validation. Do not collect sensitive personal information unless necessary.
