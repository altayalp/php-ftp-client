# PHP FTP Client Library

[![Latest Stable Version](https://poser.pugx.org/altayalp/ftp-client/version)](https://packagist.org/packages/altayalp/ftp-client)
[![Latest Unstable Version](https://poser.pugx.org/altayalp/ftp-client/v/unstable)](//packagist.org/packages/altayalp/ftp-client)
[![License](https://poser.pugx.org/altayalp/ftp-client/license)](https://packagist.org/packages/altayalp/ftp-client)

Php 5.4+ object oriented and unit tested library for FTP and SFTP (ssh ftp) process.

### Installation

Make sure the [PHP FTP](http://php.net/book_ftp) extension is installed or enabled.

The recommended way to install the library is through [composer](https://getcomposer.org/).

```bash
composer require altayalp/ftp-client
```

This command will install the library on current dir.

## Usage
### Connect and Log in to Server

```php
// connect to ftp server
use altayalp\FtpClient\FtpServer;

$server = new FtpServer('ftp.example.com');
$server->login('user', 'password');

// or connect to ssh server
use altayalp\FtpClient\SftpServer;

$server = new SftpServer('ssh.example.com');
$server->login('user', 'password');
```

You can call SftpServer class by port or FtpServer class by the port and timeout. The default port for SFTP is 22, for FTP is 21 and for timeout is 90 seconds.

```php
// connect to ftp server
use altayalp\FtpClient\FtpServer;

$server = new FtpServer('ftp.example.com', 21, 90);
$server->login('user', 'password');

// or connect to ssh server
use altayalp\FtpClient\SftpServer;

$server = new SftpServer('ssh.example.com', 22);
$server->login('user', 'password');
```

You can use same methods for FTP and SFTP after login server. The factory classes will return file or directory class instance.

If you have a problem login to FTP server, turnPassive() method may useful after login method. It's not exist for SFTP.

```php
$server->turnPassive();
```

### Fetching Files

```php
use altayalp\FtpClient\FileFactory;

$file = FileFactory::build($server);
$list = $file->ls('public_html');
print_r($list);
```

Will output:

```php
Array
(
    [0] => index.php
    [1] => .gitignore
    [2] => .htaccess
    [3] => composer.json
    [4] => phpunit.xml
    [5] => robots.txt
    [6] => server.php
)
```

This method takes two more optional parameters. $recursive also fetch subdirectories. $ignore parameter determine extension of the files which you don't want to see in list.

```php
$list = $file->ls('public_html' false, array('php','html'));
```

Will output:

```php
Array
(
    [0] => .gitignore
    [1] => .htaccess
    [2] => composer.json
    [3] => phpunit.xml
    [4] => robots.txt
)
```

### Fetching Directories

```php
use altayalp\FtpClient\DirectoryFactory;

$dir = DirectoryFactory::build($server);
$list = $dir->ls('public_html');
print_r($list);
```

Will output:

```php
Array
(
    [0] => app
    [1] => bootstrap
    [2] => css
    [3] => packages
    [4] => vendor
)
```

This method takes two more optional parameters. $recursive also fetch subdirectories. $ignore parameter determine name of the directories which you don't want to see in list.

```php
$list = $dir->ls('public_html' false, array('packages','vendor'));
print_r($list);
```

Will output:

```php
Array
(
    [0] => app
    [1] => bootstrap
    [2] => css
)
```

### Other File Operations

**Download file from server to local disc with rename**

```php
$file->download('public_html/remote.html', 'local.html');
```

**Upload file from local to server with rename**

```php
$file->upload('local.zip', 'public_html/remote.zip');
```

**Upload file from http server to server**

```php
$file->wget('http://www.example.com/remote.zip', 'public_html/remote.zip');
```

**Rename file to server**

```php
$file->rename('public_html/oldname.zip', 'public_html/newname.zip');
```

**Change chmod file to server**

```php
$file->chmod(0777, 'public_html/file.zip');
```

**Remove file to server**

```php
$file->rm('public_html/remote.zip');
```

**Get last modified time to file**

```php
$file->getLastMod('public_html/remote.zip');
```

**Get size to file**

```php
$file->getSize('public_html/remote.zip');
```

### Other Directory Operations

**Create new directory**

```php
$dir->mkdir('public_html/new_directory');
```

**Change current working directory**

```php
$dir->cd('public_html/new_directory');
```

**Changes to the parent directory (not exist Sftp)**

```php
$dir->cdUp();
```

**Get current working directory**

```php
$dir->pwd();
```

**Rename Directory**

```php
$dir->rename('public_html/oldname', 'public_html/newname');
```

**Change chmod directory to server**

```php
$dir->chmod(0777, 'public_html/directory');
```

**Remove Directory**

The directory must be empty.

```php
$dir->rm('public_html/directory');
```

### Usage Of Helper Class
Helper Class contains some useful methods for actions:
* Helper::formatByte: Format file size to human readable
* Helper::formatDate: Format unix time
* Helper::getFileExtension: Get given file extension
* Helper::newName: If exist local file, rename the file

```php
Helper::formatByte($file->getSize('public_html/dashboard.zip'));
// Will output: 32.47 Mb
Helper::formatDate($file->getLastMod('public_html/dashboard.zip'));
// Will output: 14.06.2016 23:31
// or
Helper::formatDate($file->getLastMod('public_html/dashboard'), 'd.m.Y');
// Will output: 14.06.2016
Helper::getFileExtension($fileName);
// Will output: html
$file->download('public_html/demo.html', Helper::newName('demo.html'));
// if exist local file, rename file
// demo.html renamed to demo_dae4c9057b2ea5c3c9e96e8352ac28f0c7d87f7d.html
```

### Test
Firstly rename phpunit.xml.dist to phpunit.xml and than open the file to edit ftp variables. After run the phpunit command.

```bash
phpunit tests/Ftp
# or
phpunit tests/Sftp
```

### License

The MIT License (MIT). Please see [License File](https://github.com/altayalp/php-ftp-client/blob/master/LICENSE) for more information.
