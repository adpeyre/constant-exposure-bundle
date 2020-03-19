# Constant Exposure Bundle

This Symfony Bundle is useful if you need to expose constants to front.
Currently, class constants and symfony parameters are supported.

## Example

Your yaml configuration file in `config/packages/constant_exposure.yaml`:
``` yaml
constant_exposure:
  parameter:
    debug: '%kernel.debug%'
    sentry_dsn: '%env(SENTRY_DSN)%'
    password_expire: !php/const App\Entity\Password::EXPIRE_PASSWORD
    normalizer_type_enforcement: !php/const Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT
```

Expose your constants on a route:
`/js/constant-exposure.json`:

```json
{
  "parameter": {
    "debug": true,
    "sentry_dsn": "https://<key>@sentry.io/<project>",
    "password_expire": 86400,
    "normalizer_type_enforcement": "disable_type_enforcement"
  }
}
```

Get your constants in Javascript:
``` javascript
// Check if you are in debug mode
const isDebug = ConstantExpsure.getParameter('debug');

// If sentry_dsn is not defined, default value is an empty string
const sentryDsn = ConstantExpsure.getParameter('sentry_dsn', '');
```

## Install

### Composer
`composer require constant-exposure/constant-exposure-bundle ^2.0` 

### Load the bundle
In `config/bundles.php`, add this line:

``` php 
return [
    ...
    ConstantExposureBundle\ConstantExposureBundle::class => ['all' => true],
];
```

### Constants to expose
Create a file `config/packages/constant_exposure.yaml` in your project. Then, configure constants to expose.
``` yaml
constant_exposure:
    parameter:
        debug: '%kernel.debug%'
        sentry_dsn: '%env(SENTRY_DSN)%'
        password_expire: !php/const App\Entity\Password::EXPIRE_PASSWORD 
```

### Route exposure
If you need to expose your constants on a route, add these lines in your routing file:
``` yaml
constant_exposure:
    resource: "@ConstantExposureBundle/Resources/config/routing.yaml"
```

### Page exposure
Add the line bellow in your twig template. Pass as parameter a name for your javascript object.
``` twig
{{ constant_exposure_object('ConstantExposure') }}
```

Get them in Javascript:
``` javascript
ConstantExposure.getParameter(PARAMETER_NAME [, DEFAUlT_VALUE = null] );
```