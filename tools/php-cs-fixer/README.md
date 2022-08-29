## PHP-CS-Fixer
This tool is used for automatically fixing code to follow a defined coding standard and/or modernize 
code through the use of rules and rule sets. The configuration file can be found in the root directory and is called `.php-cs-fixer.dist.php`.

### Setup
To get the tool into a workable state, there are a few steps that must be completed depending on the target usage. Our normal setup will use IntelliJ's integration, so you get IDE hints when code does not conform to our standards, but it can be used entirely via the command line.

#### Composer
The tool's code must first be installed via composer in order for it to be used in either context. To do that, simply run the following from the root directory of the project:
```shell
npm run composer-tools
```
At this point, the tool is usable via the command line. See [Usage](#usage) for more info.

#### IntelliJ Integration
See [IntelliJ Setup](intellij_setup.md).

### Usage
From the root directory, to fix all files defined in the configuration file:
```shell
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix
```

To fix a given directory:
```shell
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix path/to/directory
```

To fix a given file:
```shell
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix path/to/file.php
```

For more info see [usage](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v3.9.3/doc/usage.rst).