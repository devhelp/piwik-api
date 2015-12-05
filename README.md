[![Build Status](https://travis-ci.org/devhelp/piwik-api.svg?branch=master)](https://travis-ci.org/devhelp/piwik-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/devhelp/piwik-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/devhelp/piwik-api?branch=master)

## Installation

Please check [composer website](http://getcomposer.org) for more information.

```
$ composer require 'devhelp/piwik-api:dev-master'
```

## Purpose

Helps creating self-contained Piwik methods that are able to make call to [Piwik API](http://developer.piwik.org/api-reference/reporting-api) with predefined or/and runtime arguments.
Helps in using [Piwik segmentation](http://developer.piwik.org/api-reference/reporting-api-segmentation) and in lazy-loading api parameters values on method call.

## Usage

Basically only thing that you need to implement in order to be able to use the `Method` is your `PiwikClient` class.
There is an already implemented `PiwikGuzzleClient` for which you have to configure the `Guzzle` http client.

You can include `PiwikGuzzleClient` by adding [devhelp/piwik-api-guzzle](http://github.com/devhelp/piwik-api-guzzle) in composer.json

### Standalone Method usage

```php
$myPiwikClient = new MyPiwikClient();

$method = new Method($myPiwikClient, 'http://my.piwik.pro', 'MyModule.myAction')

$method->call(array('token_auth' => $myPiwikToken));

```

### Creating multiple methods with Api

```php
$myPiwikClient = new MyPiwikClient();

$api = new Api($myPiwikClient, 'http://my.piwik.pro');
$api->setDefaultParams(array(
    'token_auth' => $myPiwikToken,
));

$api->getMethod('MyModule.myAction')->call();
$api->getMethod('MyOtherModule.myOtherAction')->call();
$api->getMethod('MyXXXModule.myXXXAction')->call();
```

### Passing parameters to the call

This can be done be passing an array on method call or setting it as default params for the method or the whole api.
Parameters can be either a scalar, a callback or an object implementing `Param` interface.

When parameter value implements a `Param` interface or is a callback then it's final value is resolved on call() runtime
(resulting in lazy-loaded param value). There is a Segment param that will be explained later. Lazy-loading can be
particularly useful for returning a token_auth by user that is currently logged in

```php
$params = array(
    'myCustomVar1' => 'someValue',
    'myCustomVar2' => function() {/*..*/},
    'token_auth' => new LazyTokenAuthValue()
);

$api->getMethod('MyModule.myAction')->call($params);

/*
 * params to which $params array will be resolved on method call are:
 * array(
 *     'myCustomVar1' => 'someValue',
 *     'myCustomVar2' => ..., //this what was resolved from anonymous function
 *     'token_auth' => ..., //this what was resolved from LazyTokenAuthValue
 * );
 */
```

### Using segments

`Segment` param has its own implementation that allows to build Piwik segment query. It's value is resolved on call

```php
use Devhelp\Piwik\Api\Param\Segment as SegmentParam;
use Devhelp\Piwik\Api\Param\Segment\Segment;

$segment = new Segment();

$segment->where(new Equals('country', 'PL'))
        ->andWhere(new NotEquals('actions', 1))
        ->andWhere(new Contains('referrerName', 'piwik'))
        ->orWhere(new DoesNotContain('referrerKeyword', 'myBrand'));

$params = array('segment' => new SegmentParam($segment));

/*
 * this will be resolved to
 * array('segment' => 'country==PL;actions!=1;referrerName=@piwik,referrerKeyword!@myBrand');
 */
```

### Integrations

* [devhelp/piwik-bundle](http://github.com/devhelp/piwik-bundle)
* [devhelp/piwik-silex-provider](http://github.com/devhelp/piwik-silex-provider)

## Credits

Brought to you by : [devhelp.pl](http://devhelp.pl)
