# Constant Exposure Bundle

[![Version](https://poser.pugx.org/constant-exposure/constant-exposure-bundle/version)](//packagist.org/packages/constant-exposure/constant-exposure-bundle)
[![License](https://poser.pugx.org/constant-exposure/constant-exposure-bundle/license)](//packagist.org/packages/constant-exposure/constant-exposure-bundle)

This **Symfony Bundle** is usefull if you need to expose constants to front.

## Install

### Composer
`composer require constant-exposure/constant-exposure-bundle:^2.2` 

### Load the bundle
In `config/bundles.php`, add this line:

``` php 
return [
    ...
    ConstantExposureBundle\ConstantExposureBundle::class => ['all' => true],
];
```
## Usage

### Define constants to expose
Create a file `config/packages/constant_exposure.yaml` in your project. Then, configure constants to expose.
``` yaml
constant_exposure:
    parameter:
        debug: '%kernel.debug%'
        sentry_dsn: '%env(SENTRY_DSN)%'
        password_expire: !php/const App\Entity\Password::EXPIRE_PASSWORD 
```

### Use constants in JavaScript

Add this line in your Twig template. Pass as parameter a name for your JavaScript object.
``` twig
{{ constant_exposure_object('ConstantExposure') }}
```

Get them in Javascript:
``` javascript
ConstantExposure.getParameter(PARAMETER_NAME [, DEFAUlT_VALUE = null] );
```

``` javascript
// Check if you are in debug mode
const isDebug = ConstantExposure.getParameter('debug');

// If sentry_dsn is not defined, default value is an empty string
const sentryDsn = ConstantExopsure.getParameter('sentry_dsn', '');
```

### Route exposure
If you need to expose your constants on a route, add these lines in your routing file:
``` yaml
constant_exposure:
    resource: "@ConstantExposureBundle/Resources/config/routing.yaml"
```

Then, you can access it with this url: 
- /constant-exposure.json for a **JSON** format
- /constant-exposure.xml for a **XML** format
- /constant-exposure.csv for a **CSV** format
