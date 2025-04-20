# Use official PHP with Apache image
FROM php:7.4-apache

# Copy project files to the Apache root directory
COPY . /var/www/html/

# Install MySQLi extension (if needed)
RUN docker-php-ext-install mysqli

# Set index.php as the default file
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Optional: Set proper permissions (especially useful on Render)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
