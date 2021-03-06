Getting Started With SimplewebSaaSBundle
========================================

## Prerequisites

This bundle has only been tested with Symfony 2.4.

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

## Installation

Installation is a quick (I promise!) 7 step process:

1. Download SimplewebSaaSBundle using composer
2. Enable the Bundle
3. Add the Subscriber trait to your User class
4. Configure the SimplewebSaaSBundle
5. Import SimplewebSaaSBundle routing
6. Update your database schema

### Step 1: Download SimplewebSaaSBundle using composer

Add SimplewebSaaSBundle in your composer.json:

``` js
{
    "require": {
        "simpleweb/saas-bundle": "~0.1@dev"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
php composer.phar update simpleweb/saas-bundle
```

Composer will install the bundle to your project's `vendor/simpleweb` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Simpleweb\SaaSBundle\SimplewebSaaSBundle(),
    );
}
```

### Step 3: Add our traits to your User class

``` php
<?php
// src/Acme/UserBundle/Entity/User.php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    use Simpleweb\SaaSBundle\Entity\Traits\Subscriber;
    use Simpleweb\SaaSBundle\Entity\Traits\Referrer; // (optional)
}
```

### Step 4: Create your Plan and Subscription classes

``` php
// src/Acme/SaaSBundle/Entity/Plan.php
<?php

namespace Acme\SaaSBundle\SaaSBundle\Entity;

use Simpleweb\SaaSBundle\Entity\Plan as BasePlan,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="plans")
 */
class Plan extends BasePlan
{
}
```

``` php
// src/Acme/SaaSBundle/Entity/Subscription.php
<?php

namespace Acme\SaaSBundle\SaaSBundle\Entity;

use Simpleweb\SaaSBundle\Entity\Subscription as BaseSubscription,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriptions")
 */
class Subscription extends BaseSubscription
{
}

```

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.

Your entity classes can live inside any bundle in your application. For example,
if you work at "Acme" company, then you might create a bundle called `AcmeSaaSBundle`
and place your entity classes in it.

**Note:**

> The doc uses a bundle named `AcmeSaaSBundle`. If you want to use the same
> name, you need to register it in your kernel. But you can of course place
> your user class in the bundle you want.

> If you override the __construct() method in your entity classes, be sure
> to call parent::__construct(), as the base entity classes depends on
> this to initialize some fields.

### Step 5: Configure the SimplewebSaaSBundle

You'll need to specify resolve_target_entities mapping for the relationships in
SaaSBundle to map correctly to the classes in your bundles, something along the
lines of the following should do the trick.

``` yaml
doctrine:
    orm:
        resolve_target_entities:
            FOS\UserBundle\Model\UserInterface: Acme\UserBundle\Entity\User
            Simpleweb\SaaSBundle\Entity\PlanInterface: Acme\SaaSBundle\Entity\Plan
            Simpleweb\SaaSBundle\Entity\SubscriptionInterface: Acme\SaaSBundle\Entity\Subscription
```

...

### Step 6: Import SimplewebSaaSBundle routing

...

### Step 7: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new trait, to the `User` class which you
added in Step 4.

``` bash
php app/console doctrine:schema:update --force
```

### Next Steps

...
