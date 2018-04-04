# [![PGS Software](https://www.pgs-soft.com/pgssoft-logo.png)](https://www.pgs-soft.com) / HashId

![PHP from Packagist](https://img.shields.io/packagist/php-v/symfony/symfony.svg)
[![Build Status](https://travis-ci.org/kjonski/HashId.svg?branch=dev-master)](https://travis-ci.org/kjonski/HashId)
[![Code Coverage](https://scrutinizer-ci.com/g/kjonski/HashId/badges/coverage.png?b=dev-master)](https://scrutinizer-ci.com/g/kjonski/HashId/?branch=dev-master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kjonski/HashId/badges/quality-score.png?b=dev-master)](https://scrutinizer-ci.com/g/kjonski/HashId/?branch=dev-master)

Symfony 4 bundle for encoding integer route parameters and decoding request parameters with <http://www.hashids.org/>  
Replace predictable integer url parameters in easy way:
  * `/hash-id/demo/decode/216/30` => `/hash-id/demo/decode/X46dBNxd79/30`
  * `/order/315` => `/order/4w9aA11avM`  

Pros:
  * no need to use extra filters
  * [Doctrine Converter](http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html#doctrine-converter) compatible

## Instalation
```bash
composer require pgs-soft/hashid-bundle 
```

## Hashids configuration
```yaml
# config/packages/pgs_hash_id.yaml

pgs_hash_id:
    salt: 'my super salt'
    min_hash_length: 20
    alphabet: 'qwertyasdzxc098765-'
```

## Controller configuration
```php
use Pgs\HashIdBundle\Annotation\Hash;

class UserController extends Controller
{
    /**
     * @Hash("id")
     */
    public function edit(int $id)
    {
    //...
    }
    
    /**
     * Process multiple parameters - 'oneMore' will not be processed
     * @Route(name="test", path="/test/{id}/{other}/{oneMore}")
     * @Hash({"id","other"})
     */
    public function test(int $id, int $other, int $oneMore)
    {
    //...
    }
}
```

You can also check our `DemoController`

## Contributing

Bug reports and pull requests are welcome on GitHub at [https://github.com/PGSSoft/HashId](https://github.com/PGSSoft/HashId).


## About

The project maintained by [software development agency](https://www.pgs-soft.com/) [PGS Software](https://www.pgs-soft.com/).
See our other [open-source projects](https://github.com/PGSSoft) or [contact us](https://www.pgs-soft.com/contact-us/) to develop your product.


## Follow us

[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/intent/tweet?text=https://github.com/PGSSoft/InAppPurchaseButton)
[![Twitter Follow](https://img.shields.io/twitter/follow/pgssoftware.svg?style=social&label=Follow)](https://twitter.com/pgssoftware)