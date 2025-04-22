FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Create storage directories
RUN mkdir -p /var/www/html/storage/framework/cache/data
RUN mkdir -p /var/www/html/storage/framework/sessions
RUN mkdir -p /var/www/html/storage/framework/views
RUN mkdir -p /var/www/html/storage/app/public

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader
RUN npm ci && npm run build

# Generate key and optimize
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan storage:link

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www/html

# Expose port 8000
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000
