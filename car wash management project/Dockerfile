# Use official PHP-Apache image
FROM php:7.4-apache

# Copy project files to Apache root
COPY . /var/www/html/

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Properly set DirectoryIndex in Apache config
RUN echo "<IfModule dir_module>\n    DirectoryIndex index.php index.html\n</IfModule>" > /etc/apache2/mods-enabled/dir.conf

# (Optional) Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
