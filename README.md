# phpagiadition
PHP AGI Adition for asterisk

# Install guide

1. Download phpagiadition.php
2. Movie file to /var/lib/asterisk/agi-bin
3. Include to your agi script

# Example

```php
#!/usr/bin/php -q
<?php
require('phpagi.php');
$agi = new AGI();
$adt = new AGIAddition($agi,"ru"); // Use first parameter to set $agi class, and second to set default language

$phone = "1234567";
$adt->SayPhone($phone); // Correct say phone number

?>
```
