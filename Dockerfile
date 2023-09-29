# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Create a 'todolist' subdirectory
RUN mkdir todolist

# Copy your app files to the container
COPY app/ /var/www/html/todolist/app/
COPY assets/ /var/www/html/todolist/assets/
COPY index.php /var/www/html/todolist/
COPY .htaccess /var/www/html/todolist/
COPY README.md /var/www/html/todolist/

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
