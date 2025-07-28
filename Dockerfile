# Start with the base WordPress image
FROM wordpress:latest

# Switch to the root user to install packages
USER root

# Install MySQL client
RUN apt-get update && \
    apt-get install -y default-mysql-client && \
    rm -rf /var/lib/apt/lists/*

# Copy the custom php.ini file
#COPY php.ini /usr/local/etc/php/

# Switch back to the original WordPress user
USER www-data

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
