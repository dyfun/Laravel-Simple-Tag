## Simple Laravel Tag Package
This package is a simple tag package for Laravel. It allows you to add tags to any model in your Laravel application.

### Installation
You can install the package via composer:

```bash
-
```

add the service provider to your config/app.php file:

```php
'providers' => [
    ...
    Dyfun\Tags\TagsServiceProvider::class,
    ...
];
```

### Usage
Apply HasTags trait to a model

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Dyfun\Tags\HasTags;

class File extends Model
{
    use HasTags;
    ...
}
```

Example:
```php
$file = File::find(1);
$file->attachTag("apple");
$file->attachTags(["apple", "orange", "watermelon"]);

$file->detachTag("apple");
$file->detachTags(["apple", "orange"]);
```



