# Carbon

[![Latest Stable Version](https://poser.pugx.org/ahmedsaoud31/payfort-php/v/stable.png)](https://packagist.org/packages/ahmedsaoud31/payfort-php)
[![Total Downloads](https://poser.pugx.org/ahmedsaoud31/payfort-php/downloads.png)](https://packagist.org/packages/ahmedsaoud31/payfort-php)
[![License](https://poser.pugx.org/ahmedsaoud31/payfort-php/license.svg)](https://packagist.org/packages/ahmedsaoud31/payfort-php)

### Configuration

go to `path/to/config.php` to set all API configuration.

## Installation

### With Composer

```
$ composer require ahmedsaoud31/payfort-php
```

```json
{
    "require": {
        "ahmedsaoud31/payfort-php": "~1.0"
    }
}
```

```php
<?php
require 'vendor/autoload.php';

use Payfort\Payfort;

$payfort = new Payfort;
```

<a name="install-nocomposer"/>
### Without Composer

```php
<?php
require 'path/to/Payfort.php';

use Payfort\Payfort;

$payfort = new Payfort;
```

## Docs

[https://testfort.payfort.com/api/docs/merchant-page-two/build/index.html](https://testfort.payfort.com/api/docs/merchant-page-two/build/index.html)
