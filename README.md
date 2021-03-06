# phpMdAdmin
Super-super-lightweight Markdown admin tool made with PHP

## Installation

1. Upgrade to php7
1. sudo apt-get update
1. Install bz2 extension sudo apt-get install php7.0-bz2
otherwise get gzip error.
1. Set the buildpack environment variable
```
dokku config:set phpmdadmin BUILDPACK_URL=https://github.com/heroku/heroku-buildpack-php.git#v95
```
5. Set the base path environment variable to an empty string
```
dokku config:set phpmdadmin APP_BASEPATH=
```

### Dokku Storage
#### creating storage for the app 'node-js-app'
```
mkdir -p  /var/lib/dokku/data/storage/phpmdadmin
```

#### ensure the proper user has access to this directory
```
chown -R dokku:dokku /var/lib/dokku/data/storage/phpmdadmin
```

#### as of 0.7.x, you should chown using the `32767` user and group id
```
chown -R 32767:32767 /var/lib/dokku/data/storage/phpmdadmin
```

#### mount the directory into your container's /app/storage directory, relative to root
```
dokku storage:mount phpmdadmin /var/lib/dokku/data/storage/phpmdadmin:/app/storage
```

### nginx Configuration
Increase size allowed in upload
```
mkdir /home/dokku/phpmdadmin/nginx.conf.d/
echo 'client_max_body_size 50M;' > /home/dokku/phpmdadmin/nginx.conf.d/upload.conf
chown dokku:dokku /home/dokku/phpmdadmin/nginx.conf.d/upload.conf
service nginx reload
```

### php.ini
Make sure the php.ini file allows for larger uploads, too:
```
mkdir -p /usr/local/etc/php/conf.d/
touch /usr/local/etc/php/conf.d/uploads.ini
echo "upload_max_filesize = 24M;" >> /usr/local/etc/php/conf.d/uploads.ini
echo "post_max_size = 32M;" >> /usr/local/etc/php/conf.d/uploads.ini
chown dokku:dokku /usr/local/etc/php/conf.d/uploads.ini
dokku ps:restart phpmdadmin
```

## Cloud9 Installation
1. https://github.com/GabrielGil/c9-lemp
