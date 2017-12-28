# Infakt API Client Bundle

|        Style-CI         |
|:-----------------------:|
| [![StyleCI](https://styleci.io/repos/115550336/shield?branch=master)](https://styleci.io/repos/115550336) |

The **InfaktClientBundle** provides integration of the [**InfaktClient**](https://github.com/miisieq/InfaktClient) library into the Symfony framework.


## Installation

### Step 1: Install the bundle

First, open a command console, enter your project directory and execute the following command to download the latest version of this bundle:

```
composer require miisieq/InfaktClientBundle
```

### Step 2: Register the bundle in your kernel
Then add the bundle to your kernel:
```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Infakt\ClientBundle\InfaktClientBundle(),
        ];

        // ...
    }
}
```

### Step 3: Configure the bundle
Add your Infakt API key to the configuration:

``` yaml
# app/config/config.yml

infakt_client:
    api_key: d8578edf8458ce06fbc5bb76a58c5ca4d8578edf
```


## License
This package is released under the MIT license. See the included
[LICENSE](LICENSE) file for more information.
