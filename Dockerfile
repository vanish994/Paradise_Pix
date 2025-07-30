FROM php:8.1-apache

# Habilita reescrita de URL se necessário
RUN a2enmod rewrite

# Copia todos os arquivos do seu projeto
COPY . /var/www/html/

# Define permissões (opcional)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
