<p align="center">
    <h1 align="center">ShinyDot FORUM</h1>
    <p align="center">A simple forum system built with PHP</p>
    <div align="center">
        <img src="https://img.shields.io/badge/php-^5.6-blue"/>
        <a href="https://github.com/Oliverlin67/ShinyDot/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/Oliverlin67/ShinyDot"></a>
        <a href="https://github.com/Oliverlin67/ShinyDot/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/Oliverlin67/ShinyDot"></a>
        <a href="https://github.com/Oliverlin67/ShinyDot/blob/master/LICENSE"><img alt="GitHub license" src="https://img.shields.io/github/license/Oliverlin67/ShinyDot"></a>
    </div>
</p>


## Installation

### System Requirements
- Apache2
- PHP 5.6+
- MySQL;
- PHP GD
- PHP gettext
- PHP mbstring
- Composer cli

### Clone this repository

```
git clone https://github.com/Oliverlin67/ShinyDot.git
```

### Setup MySQL Database

#### Login to MySQL
```
mysql -u root -p
```

#### Create a new Database

```
CREATE DATABASE `shiny_dot` && USE `shiny_dot`
```

#### Set Character Encoding

```
SET NAMES UTF8MB4
```

#### Import sql file

```
source [path to shiny_dot.sql]
```

### Install packages

```
composer install
```

### Finish✌

<small>Please remember to setup virtual host if you need(DocumentRoot value should be "public")</small>
