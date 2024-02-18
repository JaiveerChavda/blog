# Blog (using laravel 10.0 || for begineer - intermediate)

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
