# ulnTools


ULN (Unique Learner Number) tools to validate an uln as per the specification at 



Usage:

install with composer
```
composer require fisss-apprentice/esfa-apprentice
```


to create a single test uln



or to create an array with the all the details required for submission to the ESFA api


```php
<?php

use EsfaTools\UlnCreate;

$epaoOrgId = 'EPA0001';
$larsCode = 25;
$addNumber = 10;

$testUlns = UlnCreate::createTestApprentice($epaoOrgId, $larsCode, $addNumber);

print_r($testUlns);

```



