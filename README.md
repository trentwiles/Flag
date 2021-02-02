# Flag

Simple short video sharing. Share and upload videos up to 20 MBs in size.


## Self hosting

Self hosting a Flag instance is quite easy! We still need to make some changes to the codebase to make selfhosting a btt smoother, but it is possible.

### Requirements

- **PHP 7.2+** (main instance uses 7.3.19)
- **MySQL 15+** (main instance uses 15.1)
- **Apache or Nginx** (main instance uses Apache 2.4.38, but should work on Nginx, you might just have to convert the .htaccess file to nginx.conf)
- **Composer** (main instance uses 1.10.13)

### Setup

Clone this repo into the directory of choice:

```
git clone https://github.com/RiversideRocks/Flag.git && cd Flag
```

Open MySQL and run the installer:

```
MariaDB [(none)]> SOURCE source.sql;
```

Once the installer has finished, install all dependencies:

```
composer install
```

Enter your .env file and edit the values.

- CAPTCHA is the hCaptcha API token.
- EMAIL_USERNAME is your email server username
- EMAIL_PASSWORD is your email server password
- NAME is the name you want to send emails as (if you use gmail mail servers, set this to the name of your account)


Create a virtual host for Flag in your Apache config. (generally found under `/etc/apache2/sites-available/000-default.conf`). Our example doesn't use SSL, but we reccomend that you do.

```Apache
<VirtualHost *:80> # replace 80 with the port you want
  ServerName yourwebsite.com
  DocumentRoot /var/www/flag/ # or wherever your flag instance is on the machine
  ServerAdmin trent@riverside.rocks
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
  RemoteIPHeader CF-Connecting-IP
</VirtualHost>
```

Add the required DNS records, then your site should be live. Additional configuration may be needed.

