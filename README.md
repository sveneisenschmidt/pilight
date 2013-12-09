#pilight

[![Latest Stable Version](https://poser.pugx.org/se/pilight/v/stable.png)](https://packagist.org/packages/se/pilight)

Library to call Pilight (currently pilight-send) from php.

#### Dev branch is master branch.

[![Build Status](https://api.travis-ci.org/sveneisenschmidt/pilight.png?branch=master)](https://travis-ci.org/sveneisenschmidt/pilight)


##### Table of Contents

1. [Installation](#installation)
2. [Usage](#usage)
    * [Send](#send) 

<a name="installation"></a>
## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```yaml
{
    "require": {
        "se/pilight": "dev-master"
    }
}
```

### Basic usage
Require the composer autload file and import the namespace.

```php
require_once __DIR__.'/vendor/autoload.php';

use \SE\Component\Pilight;

```

### Send

```php

$sender =  new Pilight\Sender();
// or set a custom ip and port
$sender =  new Pilight\Sender($host = '129.168.2.1', $port = 6535);

$protocol = 'elro';
$arguments = array(
    's' => 31,
    'u' => 1,
);

$device = new Pilight\Device($protocol, $arguments);
// or add the arguments later via setArguments
$device->setArguments($arguments);

// turn it on
$device->addArgument('t');

// send it!
$sender->send($device);
```

If you need root permissions to call *pilight-send*, call setSudo(true) on $sender.
```php

$sender->setSudo(true);
$sender->send($device);
```

You can add the *pilight-send* executable to your sudoers configuration to make it callable via sudo without the need to enter a password. In case your *pilight-send* needs to be called via sudo you can get some unexpected output during runtime.

```bash
$ sudo nano /etc/sudoers.d/pilight
```

Contents:
```bash
www-data ALL= NOPASSWD: /usr/local/sbin/pilight-send
pi ALL= NOPASSWD: /usr/local/sbin/pilight-send
<REPLACE YOU USER> ALL= NOPASSWD: /usr/local/sbin/pilight-send
```









