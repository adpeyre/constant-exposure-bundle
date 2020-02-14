# Constant Exposure Bundle

This Symfony Bundle is useful if you need to expose constants to front.
Currently, class constants and symfony parameters are supported.

## Example

Your yaml configuration file in `config/packages/constant_exposure.yaml`:
``` yaml
constant_exposure:
  class:
    App\Entity\Password:
      alias: Password
      constants:
        - EXPIRE_PASSWORD
        - PREFIX
    Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer:
      alias: Normalizer
      constants:
        - DISABLE_TYPE_ENFORCEMENT
  parameter:
    - kernel.name  
```

You can expose your constants on a route:
`/js/constant-exposure.json`

```json
{
  "class": {
    "Password": {
      "EXPIRE_PASSWORD": 86400,
      "PREFIX": "MY_PREFIX"
    },
    "Normalizer": {
      "DISABLE_TYPE_ENFORCEMENT": "disable_type_enforcement"
    }
  },
  "parameter": {
    "kernel.name": "myApp"
  }
}
```

You can expose your constants on your page:
``` html
<script>
    var ConstantExposure = {
        "class": {
            "Password":{"EXPIRE_PASSWORD": 86400, "PREFIX": "MY_PREFIX"},
            "Normalizer":{"DISABLE_TYPE_ENFORCEMENT": "disable_type_enforcement"}
        },
        "parameter": {
            "kernel.name": "myApp"
        }
    };
</script>
```

## Install

### Composer
`composer require constant-exposure/constant-exposure-bundle`

### Constants to expose
Create a file `config/packages/constant_exposure.yaml` in your project. Then, configure constants to expose.
``` yaml
constant_exposure:
    class:
        CLASS_NAME:
            alias: CLASS_NAME_EXPOSED
            constants:
                - CONSTANT_1
                - CONSTANT_2
    parameter:
        - kernel.name
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