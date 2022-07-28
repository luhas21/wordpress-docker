FROM wordpress:6.0.1-php8.1-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo pdo_mysql

RUN  apt-get update \
  && apt-get install -y wget \
  && rm -rf /var/lib/apt/lists/*

RUN  apt-get update -y && \
     apt-get upgrade -y && \
     apt-get dist-upgrade -y && \
     apt-get -y autoremove && \
     apt-get clean

RUN apt-get install zip unzip \
    && rm -rf /var/lib/apt/lists/*

# fetch plugins
COPY plugins.list /tmp/plugins.list
RUN cd /var/www/html/wp-content/plugins && rm -rfv * && \
    # Strip comments from plugins.list file (https://unix.stackexchange.com/a/157619/352972) and then install each plugin:
    for plugin in $(sed '/^[[:blank:]]*#/d;s/#.*//' /tmp/plugins.list); do \
        # The for loop swallows any non-zero exit code, we need to exit explicitly on failure:
        echo "Installing plugin $plugin" && \
        wget -q $plugin -O temp.zip && \
        unzip -q temp.zip && \
        rm temp.zip || exit 1; \
    done

# set correct rights for plugins
RUN chown -R www-data:www-data /var/www/html/wp-content/plugins
