# Goo Goo Data

Goo Goo Data (GGD moving forward) is web application meant to assist parents 
in tracking data such as feedings, changings, and expenses for their children. 

## Features
- Add multiple children and caretakers with different access (administrative or read-only).
- Quickly add, edit, and delete tracker entries.
- Generate charts and reports for different categories and date ranges.
- Invite caretakers (such as family members or healthcare professionals) to view
your children's data.
- Mobile responsive and accessible on any web-enabled device.

## Requirements

### Laravel

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Local Development

- Node v10.16.3 +
- NPM 6.9.0 +
- Composer 1.10.7 +
- MySQL 5.7 +
- Local LAMP/LEMP stack (such as Laragon, WAMP, XAMPP or something similar)

`Note: If you do not have Node, Composer or MySQL globally installed, Laragon comes
pre-loaded with all three.`

#### Setup Overview

As this web application was developed on a `Windows 10` machine, these instructions pertain to this particular OS. Setting it up on a Mac will be similar for Node, NPM and Composer, but you will have to find a MacOS compatible LAMP/LEMP stack software.

1) Setup Laragon: https://laragon.org/download/
    - You may choose the full or portable version of Laragon. GGD was developed using the full version.
    - Once installed, you may run Laragon.
    - In Laragon's main window, click the `Start All` button to start Apache and MySQL.
    If any Windows network prompts appear regarding Apache and MySQL, allow network permission.
    - In Laragon's main window, click the `Terminal` button. This will open an instance of the Cmder console.
        - Within Cmder, check to make sure you have the right version of Node, NPM and Composer 
        installed with the following commands (by running them individually):
            - `node -v`
            - `npm -v`
            - `composer -v`
        - You may not clone the repository into Laragon's `www` folder: `your_laragon_path`/www/
        
2) Install dependencies:
    - With the repository cloned, in your console, navigate to the root of the application (default path is `your_laragon_path`/www/goo-goo-data/).
    - In the console, run the following commands to install all the PHP and JS dependencies:
        - `npm install`
        - `composer install`

3) Laravel/Vue development
    - While in the root of GGD, you will need to create an `.env` file to configure Laravel development. Run the command       in the console:
        - `cp .env.example .env`
        - open the `.env` file in your editor of choice and update any configurations as needed (such as MySQL credentials and AWS S3 bucket details).
        - You may notice you `.env` file does not have an `APP_KEY` value. Create it by running the command: `php artisan key:generate`
        - Once your `.env` details are completed, you may not visit `goo-goo-data.test` (or the name of the folder you placed GGD into in kebab-case) in the browser of your choice to view GGD. `Note: Laragon should have updated your Windows `host` file with a URL to access GGD locally. If you cannot resolve `goo-goo-data.test`, try restarting Laragon to resolve the virtual host issue.
        - With the site loading properly, you may begin PHP/Laravel development.
        - To further develop in JS/Vue.js, you will need to run the following command at the root of GGD:
            - `npm run watch-poll`
            - This command will watch all `.vue` files for changes and recompile them into a single `app.js` file.

You're all set up for development!