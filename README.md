# Generate Password

## Introduction

This is a tempareture convertor that converts __Degree Celsius__ to __Degree Fahrenheit__

### Installation

```
composer require nnil/generate-password
```

### Example

#### How to import the package on a normal php script

```
<?php

require 'vendor/autoload.php';

use Nnil\GeneratePassword\GeneratePassword;
```

#### Generating a password with a length of 12 characters

```
$random_password = GeneratePassword::random(12);
```

#### Generating a regex pattern to validate a password with a length of 12 characters

```
$pattern = GeneratePassword::getPattern(12);
```