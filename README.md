<p align="center">
    <h1 align="center">ShinyDot FORUM</h1>
    <p>A simple forum system built with PHP</p>
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
source [path to shinydot.sql]
```

### Finish✌

<small>Please remember to setup virtual host if you need(DocumentRoot value should be "public")</small>
