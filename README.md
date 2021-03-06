[![Latest Stable Version](https://poser.pugx.org/arrilot/vue-templates-in-php/v/stable.svg)](https://packagist.org/packages/arrilot/vue-templates-in-php/)
[![Total Downloads](https://img.shields.io/packagist/dt/arrilot/vue-templates-in-php.svg?style=flat)](https://packagist.org/packages/arrilot/vue-templates-in-php)
[![Build Status](https://img.shields.io/travis/arrilot/vue-templates-in-php/master.svg?style=flat)](https://travis-ci.org/arrilot/vue-templates-in-php)

# Vue templates in PHP

## Introduction

There are two main ways to deal with vue components' templates:
1. Single file components
2. `<script type="text/x-template">`
    
Single files components are great, but they have their own problems:
1. You need a decent build setup.
2. You can't manage templates from php directly.
If this is not an issue for you - go with them, you don't need this package then.
Otherwise this small packages can help you to set up `<script type="text/x-template">` scheme in a simple and maintainable way.

## Installation

1. `composer require arrilot/vue-templates-in-php`

## Usage

First of all create a helper like that

```php
function vue()
{
    static $vue = null;

    if ($vue === null) {
        $vue = new \Arrilot\VueTemplates\TemplateManager('/absolute/path/to/directory/where/you/want/to/store/templates/');
    }

    return $vue;
}
```
or place `TemplateManager` object in a Service Container if you have one.

Add 
```php
<?php vue()->printTemplates() ?>
``` 
somewhere in footer *above* a script that starts vue application.

Now you can start making templates.
For example let's imagine that you want to create a component for main menu.
1. Create a component without template somewhere in js.
2. Create  a `main-menu.php` file inside the directory you passed to `TemplateManager`.
This is a component template. You don't need to add any `<script type="text/x-template">` or `<template>` tags to it. It's done behind the scenes.
3. Register this template on pages where you need it - `vue()->addTemplate('main-menu')`.
4. Now you can reference it in a vue component you have created in step 1 like that: `template: '#vue-main-menu-template'`
