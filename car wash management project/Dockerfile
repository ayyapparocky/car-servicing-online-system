# Base image with Apache and PHP
FROM php:7.4-apache

# Copy all files into Apache root
COPY . /var/www/html/

# Install PHP extensions if needed
RUN docker-php-ext-install mysqli

# Enable Apache rewrite and PHP handling
RUN a2enmod rewrite

# Ensure Apache uses index.php by default
RUN echo "<IfModule dir_module>\n    DirectoryIndex index.php index.html\n</IfModule>" > /etc/apache2/mods-enabled/dir.conf

# Optional: Set ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
