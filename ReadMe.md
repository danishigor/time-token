TimeToken
===

Temporary tokens are often used in links to confirm E-mail and other actions.

Install
---

The preferred way to install this extension is composer.
You can download composer from the official website: "http://getcomposer.org/download/".

To connect the library to the project, use:
> composer require danishigor/time-token

or add this line to the "require" section of your composer.json:
> "danishigor/time-token": "dev-master"

Examples
---

```php
<?php

use DanishIgor\TimeToken\TokenManager;

// Create TimeToken object.
$tokenManager = new TokenManager();

// Generate token.
$token = $tokenManager->generate(); // "c4NUUjEFp5eUZO9GyIdo_4204983745".

// Check token.
if ($tokenManager->check($token)) {
    echo 'Token is correct.';
} else {
    echo 'Token is wrong.';
}
```

By default, this time is 3600 seconds and the length is 32 lowercase characters. If necessary, in the constructor,
you can specify the lifetime, length and set of characters from which a random string is generated.

```php
<?php

use DanishIgor\TimeToken\TokenManager;

// Create TimeToken object with non-standard parameters.
// Life time: 600 seconds.
// Length token: 100 characters.
// Characters for generation: 1, 2, 3, "a", "c", "x".
$tokenManager = new TokenManager(600, 100, [1, 2, 3, "a", "c", "x"]);

// Generate token.
$token = $tokenManager->generate(); // "1c2axx1x2_1575630395".

// Check token.
if ($tokenManager->check($token)) {
    echo 'Token is correct.';
} else {
    echo 'Token is wrong.';
}
```