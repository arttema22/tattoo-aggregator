FROM nginx:alpine
WORKDIR /var/www

EXPOSE 80 443

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]
