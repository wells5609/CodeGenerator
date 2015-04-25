CodeGenerator
=============

Generate PHP code using PHP.

Currently, the library only allows you to generate code for classes.

##Example

```php
use CodeGen\Canvas;
use CodeGen\Php\Class_ as PhpClass;
use CodeGen\Php\Property;
use CodeGen\Php\Method;
use CodeGen\Php\Parameter;

// Create a canvas
$canvas = new Canvas();

// Set the namespace and add uses
$canvas->setNamespace('App\Controller')
	->use('Serializable');

// Create the class object
$class = new PhpClass($canvas);
$class->setName('MyController')
	->extends('App\Controller\BaseController')
	->implements('Serializable');

// Add some properties
$class->addProperty(
	(new Property($canvas, 'action'))
		->setVisibility('protected')
);

$class->addProperty(
	(new Property($canvas))
		->setName('defaultAction')
		->setVisibility('private')
		->setDefault('index')
);

// Create a method
$constructor = new Method($canvas, '__construct');
$constructor->addParam(
	(new Parameter($canvas))
		->setName('something')
		->setType('Countable')
);
// Attach the method to the class
$class->addMethod($constructor);

// Add the class object to the canvas
$canvas->addObject($class);
```

Now we simply cast the canvas to a string:
```php
print $canvas; 
```
Which will print the following:
```php
namespace App\Controller; 

use Serializable;

class MyController extends BaseController implements Serializable
{

	/** 
	 * @var mixed
	 */
	protected $action;

	/** 
	 * @var string
	 */
	private $defaultAction = "index";

	public function serialize() {
	}

	public function unserialize($serialized) {
	}

	public function __construct(\Countable $something) {
	}

}
```
