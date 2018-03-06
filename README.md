# [![PGS Software](https://www.pgs-soft.com/pgssoft-logo.png)](https://www.pgs-soft.com) / HashId

Symfony 4 bundle for route parameters (integer) encoding and request parameters decoding with http://www.hashids.org/

## Instalation
```bash
    composer require pgs-soft/hashid-bundle 
```

## Hashids configuration
```yaml
# config/packages/hash_id.yaml
#optional, default parameters provided

hash_id:
    salt: 'my super salt'
    min_hash_length: 20
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
     * @Hash({"id","other"})
     */
    public function test(int $id, int $other)
    {
    //...
    }
}
```

You can also check our `DemoController`

## Contributing

Bug reports and pull requests are welcome on GitHub at [https://github.com/PGSSoft/__REPOSITORY__](https://github.com/PGSSoft/__REPOSITORY__).


## About

The project maintained by [software development agency](https://www.pgs-soft.com/) [PGS Software](https://www.pgs-soft.com/).
See our other [open-source projects](https://github.com/PGSSoft) or [contact us](https://www.pgs-soft.com/contact-us/) to develop your product.


## Follow us

[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/intent/tweet?text=https://github.com/PGSSoft/InAppPurchaseButton)
[![Twitter Follow](https://img.shields.io/twitter/follow/pgssoftware.svg?style=social&label=Follow)](https://twitter.com/pgssoftware)