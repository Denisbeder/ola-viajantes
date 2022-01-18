FROM certbot/certbot:latest

COPY run-certbot.sh /root/certbot/run-certbot.sh

CMD certonly dry-run --webroot --webroot-path={$WEBROOT_PATH}/letsencrypt \
    --email duek.digital@gmail.com --agree-tos --no-eff-email \
    -d olaviajantes.com.br \
    -d www.olaviajantes.com.br

ENTRYPOINT bash -c "bash /root/certbot/run-certbot.sh && sleep infinity"
