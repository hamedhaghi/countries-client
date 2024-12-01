FROM php:7.0-cli-alpine

# Install dependencies (bash, curl, git, and unzip)
RUN apk update && apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    && rm -rf /var/cache/apk/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Add Composer's global bin to PATH (use correct location for PHP Alpine image)
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Run the command
CMD ["tail", "-f", "/dev/null"]
