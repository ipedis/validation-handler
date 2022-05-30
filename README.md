### Validation-handler

This library is useful for file validation built on top of `symfony/validator` component. 

### How to use?

Prepare your data inside [DataWrapper](src/Data/DataWrapper.php) and create validation chain with validators.


```phpt
$file = __DIR__."/../test/data/test.txt";
/*
 * interesting find, UploadedFile object will not work like this. https://stackoverflow.com/a/67796852
 * But it provides a parameter "test" when set to false it will bypass the is_uploaded_file check.
 */
$data = new DataWrapper(new UploadedFile(
    path: $file,
    originalName: '14mb',
    test: true
));

// initial validator
$validation = new FileSizeValidator($data, new FileSize('2', 'M'));

// you can chain all validators by calling setNext() method
$validation->setNext(new MimeTypeValidator($data, new MimeTypes(['text/plain'])));

$result = $validation->handle();
```

Result will be instance of [ValidationResult](src/Validator/Modal/ValidationResult.php), `isFailed()` is helper to know 
if validtion failed or not. `getError()` will give you instance of symfony's [ConstraintViolationInterface](https://github.com/symfony/validator/blob/6.1/ConstraintViolationInterface.php).

#### Adding more validator

Each validator class extends [HanlderAbstract](src/Handler/HandlerAbstract.php). You can create new class and perform 
your own required validations.


#### Limitations and TODO

- For now validation is only for [uploaded files](\Ipedis\ValidationHandler\Data\DataWrapperInterface::SUPPORTED_TYPES), 
we can expand it to use other types.
