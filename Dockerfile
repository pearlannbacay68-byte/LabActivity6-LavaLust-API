FROM php:8.3-apache

# Enable Apache mod_rewrite (needed for LavaLust's .htaccess routing)
RUN a2enmod rewrite

# Install PDO MySQL extension (needed for LavaLust database connection)
RUN docker-php-ext-install pdo pdo_mysql

# Set Apache's document root to the "public" folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides (AllowOverride All) so LavaLust's rewrite rules work
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy application files into the container
COPY . /var/www/html

# Set correct ownership and permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Render provides the PORT environment variable — tell Apache to listen on it
RUN sed -i 's/80/${PORT:-80}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT:-80}/g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]