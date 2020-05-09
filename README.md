LSBNumberingBundle
------------------

[![Build Status](https://travis-ci.com/LSBDataWeFeelIT/LSBNumberingBundle.svg?branch=master)](https://travis-ci.com/LSBDataWeFeelIT/LSBNumberingBundle) [![Latest Stable Version](https://poser.pugx.org/lsb/numbering-bundle/v/stable)](https://packagist.org/packages/lsb/numbering-bundle)

This bundle provides functionality of generating subsequent numbers for any given object e.g. Order, Invoice etc. in Symfony 5 applications.
 
It creates a simple config in system database, which stores current counter and context data.


### Installation

```
composer require lsb/numbering-bundle
```

### Configuration
Configure the bundle by defining patterns and counter config data in **lsb_numbering.yaml** file.
```
# examples of configuration

lsb_numbering:
    patterns:
        - { name: pattern1, pattern: 'IN/{year}/{number|6}'}
        - { name: pattern2, pattern: "ON/{day}/{number|4}"}
        - { name: pattern3, pattern: "{number|5}-{context_object}-{month}"}

    counter_configs:
        - {name: counterConfig1, patternName: pattern1, step: 1, start: 10 }
        - {name: counterConfig2, patternName: pattern2, step: 2, start: 20, time_context: year }
        - {name: counterConfig3, patternName: pattern3, step: 3, start: 30, time_context: month, context_object_fqcn: "App/Entity/Branch" }

```
##### Rules of configuration:
* Number patterns can be defined by any string with predefined tags (see Tags section)
* Tags must be enclosed in curly brackets
* Only {number} tag is required
* Counters can work in time context
* Some tags can be followed by a length modifier e.g {year|2}, {number|6} which limits the resolved value to the given length.


##### Tags:
| Tag name | Required | Modifiers | Description |
| ------------- | ------------- | ------------- | ------------ |
| {number}  | yes | length | current value of the counter   |
| {year}  | no | length [2,4] | current year |
| {semester}  | no | - | current semester of the year   |
| {quarter}  | no | - | current quarter of the year   |
| {month}  | no | - | current month of the year  |
| {week}  | no | - | current week of the year   |
| {day}  | no | - | current day of the year  |
| {context_object}  | no | - | context object value  |


### Usage
A subject object is any object you want to generate numbers for. It needs to implement NumberableInterface.

```
<?php

namespace App\Entity;

use LSB\NumberingBundle\Interfaces\NumberableInterface;

class Order implements NumberableInterface
{
    // class body
}
```

Example of usage NumberingGenerator service
```
<?php

namespace App\Service;

use App\Entity\Order;
use LSB\NumberingBundle\Model\GeneratorOptions;
use LSB\NumberingBundle\Service\NumberingGenerator;
use LSB\NumberingBundle\Interfaces\NumberableInterface;

class ExampleService
{
    /** @var NumberingGenerator */
    protected $ng;

    public function __construct(NumberingGenerator $generator)
    {
        $this->ng = $generator;
    }

    public function exampleNumbers(): void
    {
        // subject example object
        $order = new Order();

        // options object
        $options = new GeneratorOptions('counterConfig1');

        // generate number
        $simpleNumber = $this->ng->generateNumber($order, $options);

        // returns resolved number e.g. IN/2020/000001
        $simpleNumber->getNumber(); 
    }
}
```

#### License

LSBNumberingBundle is available under an [MIT License](https://github.com/LSBDataWeFeelIT/LSBNumberingBundle/blob/master/LICENSE).
