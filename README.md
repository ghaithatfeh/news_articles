# News Article

Web application for creating news articles that include styleable text and GIFs.
The following tools were used: Laravel, Vue.js, Node.js, Express.js, Bootstrap

## Features

-   Authentication (sign in, and sign up).
-   Display all articles for guest or auth users.
-   Display user's articles for auth users.
-   Articles URLs with a slug to be SEO friendly.
-   Create, edit, and delete articles for auth users.
-   Editer.js plugin for inserting multiple gifs in an article content.
-   Search for gifs.
-   Node.js API to provide gifs.
-   Responsive design for all device sizes.

## Setup

-   Install composer from this URL: https://getcomposer.org/download/
-   Install Node.js from this URL: https://nodejs.org/en/download/
-   Install the XAMPP Control Panel from this URL: https://www.apachefriends.org/download.html
-   Open XAMPP and run Apache & MySQL
-   Go to http://localhost/phpmyadmin/ and create a new database named "news_articles"
-   Clone project into your device:

```
    git clone https://github.com/ghaithatfeh/news_articles.git
```

-   Go to the project directory:

```
    cd news_articles
```

-   Run the following commands:

```
    composer update
    npm install
    php artisan migrate
```

-   Run the following commands in separate terminals:

```
    php artisan serve
    node gif_provider/app.js
```

-   Go to http://localhost:8000 and the project should be started
