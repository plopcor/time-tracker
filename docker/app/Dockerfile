FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid=1000

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan commands
RUN useradd --create-home -G www-data,root -u $uid $user
ENV USER_HOME=/home/$user
# Create new directories and chown them
RUN mkdir -p $USER_HOME/.composer && \
    chown -R $user:$user $USER_HOME

# Copy entrypoint script to user's binary folder (can run anywhere using the filename)
COPY --chown=$user:$user --chmod=744 docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT entrypoint.sh

# Set working directory
WORKDIR /var/www/app
USER $user
