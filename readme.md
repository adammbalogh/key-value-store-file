# Key Value File Store

[![Author](http://img.shields.io/badge/author-@adammbalogh-blue.svg?style=flat)](https://twitter.com/adammbalogh)
[![Build Status](https://img.shields.io/travis/adammbalogh/key-value-store-file/master.svg?style=flat)](https://travis-ci.org/adammbalogh/key-value-store-file)
[![Coverage Status](https://img.shields.io/coveralls/adammbalogh/key-value-store-file.svg?style=flat)](https://coveralls.io/r/adammbalogh/key-value-store-file)
[![Quality Score](https://img.shields.io/scrutinizer/g/adammbalogh/key-value-store-file.svg?style=flat)](https://scrutinizer-ci.com/g/adammbalogh/key-value-store-file)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/adammbalogh/key-value-store-file.svg?style=flat)](https://packagist.org/packages/adammbalogh/key-value-store-file)
[![Total Downloads](https://img.shields.io/packagist/dt/adammbalogh/key-value-store-file.svg?style=flat)](https://packagist.org/packages/adammbalogh/key-value-store-file)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/603b6684-cd0a-4ce3-902c-81a840780554/small.png)](https://insight.sensiolabs.com/projects/603b6684-cd0a-4ce3-902c-81a840780554)

# Description

This library provides a layer to a key value file store.

It uses the [fire015/flintstone](https://github.com/fire015/flintstone) package.

Check out the [abstract library](https://github.com/adammbalogh/key-value-store) to see the other adapters and the Api.

# Installation

Install it through composer.

```json
{
    "require": {
        "adammbalogh/key-value-store-file": "@stable"
    }
}
```

**tip:** you should browse the [`adammbalogh/key-value-store-file`](https://packagist.org/packages/adammbalogh/key-value-store-file)
page to choose a stable version to use, avoid the `@stable` meta constraint.

# Usage

```php
<?php
use AdammBalogh\KeyValueStore\KeyValueStore;
use AdammBalogh\KeyValueStore\Adapter\FileAdapter as Adapter;
use Flintstone\Flintstone;

$fileClient = Flintstone::load('usersDatabase', ['dir' => '/tmp']);

$adapter = new Adapter($fileClient);

$kvs = new KeyValueStore($adapter);

$kvs->set('sample_key', 'Sample value');
$kvs->get('sample_key');
$kvs->delete('sample_key');
```

# API

**Please visit the [API](https://github.com/adammbalogh/key-value-store#api) link in the abstract library.**

# Toolset

| Key                 | Value               | Server           |
|------------------   |---------------------|------------------|
| ✔ delete            | ✔ get               | ✔ flush          |
| ✔ expire            | ✔ set               |                  |
| ✔ getTtl            |                     |                  |
| ✔ has               |                     |                  |
| ✔ persist           |                     |                  |

# Support

[![Support with Gittip](http://img.shields.io/gittip/adammbalogh.svg?style=flat)](https://www.gittip.com/adammbalogh/)
