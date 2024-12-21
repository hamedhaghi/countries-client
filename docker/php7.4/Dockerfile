FROM php:7.4-cli-alpine

# Install dependencies (bash, curl, git, unzip, and autoconf)
RUN apk update && apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    autoconf \
    make \
    gcc \
    g++ \
    libzip-dev \
    && rm -rf /var/cache/apk/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Install PHP extensions
RUN pecl install xdebug-2.9.8 \ 
    && docker-php-ext-enable xdebug \
    && echo "xdebug.coverage_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set working directory
WORKDIR /app

# Add Composer's global bin to PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Run the command
CMD ["tail", "-f", "/dev/null"]
