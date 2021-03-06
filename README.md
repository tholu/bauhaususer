Bauhaus User - User integration for [Bauhaus](https://github.com/krafthaus/bauhaus)
---

[![Total Downloads](https://poser.pugx.org/krafthaus/bauhaususer/downloads.png)](https://packagist.org/packages/krafthaus/bauhaususer)
[![License](https://poser.pugx.org/krafthaus/bauhaususer/license.png)](https://packagist.org/packages/krafthaus/bauhaususer)

Bauhaus itself is a bring-your-own-authentication kind of package and therefor does not, by default, come with a user login. To fix this you can either:
- Use something like [Sentry](https://github.com/cartalyst/sentry)
- Or use Bauhaus User

Installation
---
Add bauhaus user to your composer.json file:
```
"require": {
	"krafthaus/bauhaususer": "dev-master"
}
```

Use composer to install this package.
```
$ composer update
```

### Register the package
```php
'providers' => array(
	'KraftHaus\Bauhaus\BauhausServiceProvider', // This should already be there
	'KraftHaus\BauhausUser\BauhausUserServiceProvider'
)
```

### Update auth.permission
In `app/config/packages/krafthaus/config/admin.php` update
```php
'auth' => [
	'permission' => function () {
		return true;
	}
]
```

to:
```php
'auth' => [
	'permission' => function () {
		return Auth::check();
	}
]
```

### Update auth.model
In `app/auth.php` update
```php
'model' => 'User'
```

to:
```php
'model' => 'KraftHaus\BauhausUser\User'
```

### Run the migrations
```
$ php artisan migrate --package=krafthaus/bauhaususer
```

### Create your first user
```
$ php artisan bauhaus:user:register email password [firstname] [lastname]
```

Now, when you visit the admin url you'll be presented with a brand new, ultra awesome, login screen where you can login with you newly created user.
