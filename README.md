# News Article
Web application for creating news articles that include styleable text and GIFs.
The following tools were used: Laravel, Vue.js, Node.js, Express.js

## Features
- Log in, log out and sign up.
- Display all articles for gust or auth users.
- Display my articles for auth users.
- Articles urls with slug to be SEO friendlly.
- Create, edit, delete articles for auth users.
- Editer.js plugin for inserting multible gifs in an article content.
- Search for gifs.
- Node.js API to provide gifs.

## Setup
- Install XAMPP Control Panel from this url: 
- Run Apache & MySQL
- Go to http://localhost/phpmyadmin/ and create new database named "news_articles"
- Clone project into your device:
` git clone https://github.com/omer73364/lazy-load-list.git `
- Go to project directory:
` cd news_article `
- Run the following commands:
` composer install `
` php artisan migrate `
- Run this commands in sapret terminals:
` php artisan serve `
` node gif_provider/app.js `
- Go to http://localhost:8000