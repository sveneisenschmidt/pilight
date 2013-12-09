```php

use \SE\Component\Pilight;

$sender = new Pilight\Send($host = 127.0.0.1, $port = 5000);

$device = new Pilight\Device($protocoll = 'elro', array(
  's' => 15,
  'u' => 2
));

$device->on();

$sender->send($device);

```
