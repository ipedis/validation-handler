### Validation-handler

This library is useful for file validation built on top of `symfony/validator` component. 

### How to use?

Prepare your data inside [DataWrapper](src/Data/DataWrapper.php) and create validation chain with validators.

```php
use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Ipedis\ValidationHandler\ValidatorFactory;

$file = __DIR__."/../tests/data/265kb.pdf";
$data = new DataWrapper(new SplFileInfo($file));

/**
 * build validator with list of constraints.
 */
$validator = ValidatorFactory::build(validations: [
    new FileSize('100', 'k'),
    new MimeTypes(['application/pdf'])
]);
// run validations
$result = $validation->handle();

var_dump($result->isFailed(), $result->getErrorMessage());
```

Result will be instance of [ValidationResult](src/Validator/Modal/ValidationResult.php), `isFailed()` is helper to know 
if validation failed or not. `getError()` will give you instance of symfony's [ConstraintViolationInterface](https://github.com/symfony/validator/blob/6.1/ConstraintViolationInterface.php).

#### Adding more validator

Each validator class extends [HandlerAbstract](src/Handler/HandlerAbstract.php). You can create new class and perform 
your own required validations.


#### Limitations and TODO

- For now validation is only for [uploaded files](src/Data/DataWrapperInterface.php), 
we can expand it to use other types.
