# News Article

Web application for creating news articles that include styleable text and GIFs.
The following tools were used: Laravel, Vue.js, Node.js, Express.js, Bootstrap

## Features

-   Log in, log out and sign up.
-   Display all articles for gust or auth users.
-   Display my articles for auth users.
-   Articles urls with slug to be SEO friendlly.
-   Create, edit, delete articles for auth users.
-   Editer.js plugin for inserting multible gifs in an article content.
-   Search for gifs.
-   Node.js API to provide gifs.
-   Responsive design for all device sizes.

## Setup

-   Install composer from this url: https://getcomposer.org/download/
-   Install Node.js from this url: https://nodejs.org/en/download/
-   Install XAMPP Control Panel from this url: https://www.apachefriends.org/download.html
-   Open XAMPP and run Apache & MySQL
-   Go to http://localhost/phpmyadmin/ and create new database named "news_articles"
-   Clone project into your device:

```
    git clone https://github.com/ghaithatfeh/news_articles.git
```

-   Go to project directory:

```
    cd news_articles
```

-   Run the following commands:

```
    composer update
    npm install
    php artisan migrate
```

-   Run this commands in separate terminals:

```
    php artisan serve
    node gif_provider/app.js
```

-   Go to http://localhost:8000 and the project should be started
