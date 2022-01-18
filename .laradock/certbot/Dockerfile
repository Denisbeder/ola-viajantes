FROM certbot/certbot:latest

#COPY run-certbot.sh /root/certbot/run-certbot.sh

CMD certonly dry-run --webroot --webroot-path={$WEBROOT_PATH}/letsencrypt \
    --email duek.digital@gmail.com --agree-tos --no-eff-email \
    -d olaviajantes.com.br \
    -d www.olaviajantes.com.br

ARG FILE=certbot/dhparam/dhparam-2048.pem

RUN set -eux; \ 
    if [ ! -f "$FILE" ]; then \
        openssl dhparam -out ${FILE} 2048; \
    fi

#ENTRYPOINT bash -c "bash /root/certbot/run-certbot.sh && sleep infinity"
