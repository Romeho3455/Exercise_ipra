# Use an official PHP runtime as a parent image
FROM php:7.4-fpm

# Set the working directory to /app
WORKDIR /app

# Install any dependencies your application needs
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Copy the current directory contents into the container at /app
COPY . /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install

# Expose port 8000 to the outside world
EXPOSE 8000

# Run php artisan serve when the container launches
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
