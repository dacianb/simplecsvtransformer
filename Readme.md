# Simple CSV Transformer
**Author:** *Dacian Bujor* <bdacian18@gmail.com>

## About
Simple PHP CLI application for importing, processing and exporting datasets. Current implementation offers only CSV file reading and writing.

## Prerequisites

- Git
- PHP >= 7.4
- Composer >= 2.1.8 - https://getcomposer.org/

## Installation and execution

1. `git clone https://git.isupply.ro/dacian/SimpleCSVTransformer.git`
    * User: world
    * Password: !L0veG!t
2. `cd ./SimpleCSVTransformer`
3. `composer update`
4. Place input CSV file in the `SimpleCSVTransformer` folder
5. For linux\unix systems you may need to enable the execute flag `chmod +x ./transformer.php`
6. `php transform.php -i input.csv -o output.csv --input-header-offset=0 --input-delimiter=";"`

### Execution flags

Flag name | Default | Description
----------|---------|------------
-i | | Input file path relative to transformer.php
-o | | Output file path relative to transformer.php
--input-header-offset | null | Location of the header row starting at 0, null value means no header
--input-delimiter | ',' | Input CSV delimiter character
--output-delimiter | --input-delimiter | Output CSV delimiter character

### Testing
1. `php vendor/bin/phpunit`

## Application requirements:

The application requirements as stated in "Software Engineer (PHP) Coding Challenge" for [Castor](https://www.castoredc.com/)

1. Develop a PHP application that transforms data from the input CSV into an output CSV whilst
applying the transformation options. The application must be able to flexibly import source files
with different column orders, column names and transformations.
2. Implement three different transformations used in the input.csv → output.csv
transformation:
    * Recode values (mapping a finite list of values from one to another, for example textual to
    numeric values)
    * Calculate (i.e. multiply input value by 10)
    * Transform date
3. Make your code future proof, so it would be able to import data from other sources (Excel,
RSS, API endpoints, etc.). Make it possible to easily add new transformations. You don’t need to
implement these, just explain how the application would handle them.

## Application design and considerations:

### Design
I am using Composer as a package manager and autoloading function.

Addressing the requirements point by point:

1. Tabular data (CSV, Excel, XML, API) can be read and written by creating new classes inside App\Services\DataSources. All classes should implement the `DataSourceInterface` to provide a common way to interact with them.
The data is then loaded inside `TabularDataProvider` where it can be modified by interacting with public methods.

2. & 3. All the transformations are handled by the `TransformerService` which accepts a (numeric) array containing tabular data column oriented and performs transformations using rules for each column.
The rules are provided in the form of a multidimensional array, an example can be found inside `config.php`. Each rule has multiple "transformations" that are executed one after another. The "transformations" provide information on what `Transformer` should be used as well as options to transform the data.
New transformers can be added by creating new static classes inside App\Services\Transformers that implement the `TransformerInterface` and are added to the transformer register array.
I implemented simple math, string and date transformers.


### Performance
Since PHP language is not ideal when dealing with heavy processing, the code in this repository is not written/optimized for maximum throughput and memory efficiency. Memory limitation is also a factor to consider, large data sets may require more memory/execution time then it is usually available to PHP scripts.
Possibile solutions:
* Using different language Ex: Go, Rust, C++;
* Batch processing;
* Multithreading  - https://github.com/krakjoe/pthreads

### Flexibility
Due to limited time and information some compromises around code structure have been made. I tried to adhere to general OOP SOLID and DRY principles but in the end, some refactoring should help make it more future proof then the current form.

### Testing
As mentioned above, due to time limitations, I managed to write only two tests.



