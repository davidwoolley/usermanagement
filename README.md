# Datatrain User Management Package

In many ways this package is an exercise in building a 'composer' compliant package. The goal is to provide a working implementation of Sentry 2 using 'read to go' controllers, views and email templates.

### Features

### Installation
Add `datatrain\user` as a requirement to composer.json:

```javascript
{
    "require": {
        "datatrain/user": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

Once Composer has installed or updated your packages you need to register User with Laravel itself. Open up app/config/app.php and find the providers key towards the bottom and add:

```php
'Datatrain\UserServiceProvider'
```
### Configuration
