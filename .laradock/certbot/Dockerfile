FROM certbot/certbot:latest

#COPY run-certbot.sh /root/certbot/run-certbot.sh

RUN certonly dry-run --webroot --webroot-path={$APP_CODE_PATH_CONTAINER}/letsencrypt \
    --email duek.digital@gmail.com --agree-tos --no-eff-email \
    -d olaviajantes.com.br \
    -d www.olaviajantes.com.br

#ENTRYPOINT bash -c "bash /root/certbot/run-certbot.sh && sleep infinity"
