# Pionia Collections

This package provides a portal to interact with arrays in a more dynamic and advanced way. PHP has the performance, this package adds the math.

**This package is also in its early stages of development and is not yet available on packagist.**

It is inspired by Python's Pandas and Numpy libraries, and aims to provide similar functionality in PHP.

There are around Five Variations of collections it provides:

1. ### Associative Collection
    This collection is used to store data in key-value pairs.
    ```injectablephp
    $collection = \Pionia\Collections\Collection::make([
        'name' => 'John Doe',
        'age' => 25,]);
    ```
2. ### Indexed Collection
    This collection is used to store data in indexed form.
    ```injectablephp
    $collection = \Pionia\Collections\Collection::make([
        'John Doe',
        25,]);
    ```
   ## Multi dimensional Arrays(matrices)

3. ### MatrixAssociative Collection
    This collection is used to store data in a matrix form with key-value pairs.
    ```injectablephp
    $collection = \Pionia\Collections\Collection::make([
        ['name' => 'John Doe', 'age' => 25],
        ['name' => 'Jane Doe', 'age' => 24],
    ]);
    ```
4. ### MatrixIndexed Collection(Multi dimensional)
    This collection is used to store data in indexed matrix form.
    ```injectablephp
    $collection = \Pionia\Collections\Collection::make([
        ['John Doe', 25],
        ['Jane Doe', 24],
    ]);
    ```
5. ### Matrix Mixed Collection
    This collection is used to store data in mixed matrix form. A single item might contain both key-value pairs and indexed data.
    ```injectablephp
    $collection = \Pionia\Collections\Collection::make([
        ['name' => 'John Doe', 25],
        ['name' => 'Jane Doe', 24],
    ]);
    ```

## Installation

Coming soon!
[//]: # (```bash)

[//]: # (composer require pionia/collections)

[//]: # (```)

This package requires PHP 8.1 or higher and so far has no dependencies.

On complete testing, it will also be available on packagist and in the core of Pionia framework
