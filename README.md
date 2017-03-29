# AssetsAPI #

Exists to create, delete, and read an asset. The AssetsAPI is a centralized API endpoint that handles all asset creation.

## Why? ##

Receiving and sending assets can become quite task heavy. The uploading task takes into account asset manipulation for the MILF clients, reducing the asset until it only has the bare necessities, and caching the asset until destroyed. The storage task for MILF servers takes accounts for tracking usage and if there is none collecting that asset as garbage. 

## C.R.D. ##

The decision to stick with only create, read, and delete is a simplification in implementation. When an asset needs to exist we create it, allowing it to be read; when an asset is no longer necessary, should be read, we delete that asset.

This mentality allows for clean design philosophy with no other use cases. If an asset needs to be updated it can be updated on the client side as a new asset, removing the old asset.

## Testing Locally ##

To test locally install PHPUnit and imagemagick for php. After their installation simply run:

```shell
$ phpunit -c build/phpunit.xml 
```

### PHPUnit: ###

```shell
$ wget https://phar.phpunit.de/phpunit-4.8.phar
$ sudo chmod +x phpunit-4.8.phar
$ sudo mv phpunit-4.8.phar /usr/local/bin/phpunit
```

### [Brew](https://media.giphy.com/media/3o85xjSETVG3OpPyx2/giphy.gif) ... to [ImageMagick](https://media.giphy.com/media/QeuIjgyfsHp6w/giphy.gif) ###

Run the script below to install [brew](https://brew.sh/)

```shell
$ /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

Once [brew](https://media.giphy.com/media/LHrCZhpFnlyNO/giphy.gif) is running we can install some image magick dependencies:

```shell
$ sudo chown -R `whoami`:admin /usr/local/share
$ brew link unixodbc

$ brew install imagemagick
$ brew install homebrew/php/php55-imagick
```
