# nostr-storage

# Setup
```bash
git clone https://github.com/layer-systems/nostr-storage.git
cd nostr-storage
docker compose up -d syncthing

snap install certbot --classic
certbot certonly --standalone

# NOW COPY THE CERTS TO THE CERTS FOLDER
cp -R /etc/letsencrypt/live/YOUR-DOMAIN/ ssl/

docker compose up -d web
```