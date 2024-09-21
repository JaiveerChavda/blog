# Blog (using laravel 10.0 || for begineer - intermediate) [Live](https://blog.gocoding.in)

## Overview 

Blog is a fully functional blog management web app, which is built using laravel v10.0 as a backend framework, used tailwing v2.0 and alpine.js v3.0 for handling frontend stuff.
It can manage posts, with some great functionality like WYSIWYG text editor, save as draft feature, dynamic filtering options with search and category dropdown.

I built this project following [this](https://laracasts.com/series/laravel-8-from-scratch) awesome tutorial by [@jeffrey_way](https://twitter.com/jeffrey_way), by following this series you learn a lot about the basics of laravel , that you may did'nt discovered before. highly recommended for beginner of laravel.

I completed this project by adding all features listed in this [readme.md](https://github.com/JeffreyWay/Laravel-From-Scratch-Blog-Project?tab=readme-ov-file#further-ideas) file.
so after completing the series, while doing the additional features , if you find yourself stuck any where or don't have idea how to start , follow the commits provided in this repo , and you're good to go.  

## Prerequisites

You need to have installed the following software:

- PHP 8.3.0
- Composer 2.5.0
- MySQL 8.2.0

## Features

- Manage Blogs
- Save as draft (to publish it later)
- Follow/Unfollow Authors ( follow any author to receive email notifications when they publish new blog.) 
- Post Publish Notification
- Bookmark posts ( if you enjoy reading any post then bookmark it to read it later. )
- RSS feed reader

## Installation 

Follow these steps to set up a development environment:

1. **Clone the repository**

    ```bash
    git clone https://github.com/JaiveerChavda/blog.git
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Duplicate the .env.example file and rename it to .env**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**

    ```bash
    php artisan key:generate
    ```

5. **Run migration and seed**

    ```bash
    php artisan migrate --seed
    ```

6. **Run the application**

    ```bash
    php artisan serve
    ```
## Before Starting

### Authentication Details

Register yourself and you will get able to access dashboard.  

click on you name in the upper right corner and you will able to see link to dashboard page  

Use username:admin  and email as admin@example.org while registration, to get admin privileges.  

![image](https://github.com/JaiveerChavda/blog/assets/108678186/db5dd5e6-9dd0-46f4-aeb8-ae607f6c5fe7)

### Configure Mail Driver

configure your mail mailer and host in .env file.

### Publish Post

before you publish post(create) please start queue:work  


```bash
php artisan queue:work
```

## Give Feedback 💬

Give your feedback on [@JaiveerChavda](https://x.com/JaiveerChavda)



 
