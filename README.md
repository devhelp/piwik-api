[![Build Status](https://travis-ci.org/devhelp/piwik-api.svg?branch=master)](https://travis-ci.org/devhelp/piwik-api)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/28e1c8a6-8931-4a57-b836-594734457b56/mini.png)](https://insight.sensiolabs.com/projects/28e1c8a6-8931-4a57-b836-594734457b56)

## Installation

Composer is suggested to install the component, please check [composer website](http://getcomposer.org) for more information.

```
$ composer require 'devhelp/piwik-api:dev-master'
```

## Purpose

Helps creating self-contained piwik methods that are able to make call to piwik api with predefined or/and runtime arguments.
Helps in using piwik segmentation and in lazy-loading api parameters values on method call.

## Usage

Basically only thing that you need to implement in order to be able to use the Method is your PiwikClient class.
There is an already implemented PiwikGuzzleClient for which you have to configure the Guzzle http client.

### Standalone Method usage

```
$myPiwikClient = new MyPiwikClient();

$method = new Method($myPiwikClient, 'http://my.piwik.pro', 'MyModule.myAction')

$method->call(array('token_auth' => 'MY_TOKEN'));

```

### Creating multiple methods with Api

```
$myPiwikClient = new MyPiwikClient();

$api = new Api($myPiwikClient, 'http://my.piwik.pro');
$api->setDefaultParams(array(
    'token_auth' => 'MY_TOKEN',
));

$api->getMethod('MyModule.myAction')->call();
$api->getMethod('MyOtherModule.myOtherAction')->call();
$api->getMethod('MyXXXModule.myXXXAction')->call();
```

### Passing parameters to the call

This can be done be passing an array on method call or setting it as default params for the method or the whole api.
Parameters can be either a scalar or an object implementing Param interface.

When class implements a Param interface it's value is resolved on call so implementation can resolve it at runtime
(resulting in lazy-loaded param value). There is a Segment param that will be explained later. Lazy-loading can be
particularly useful for returning a token_auth by user that is currently logged in

```
$params = array(
    'myCustomVar1' => 'someValue',
     new TokenAuth(new LazyTokenAuthValue()),
     new MyParam(),
);

/*
 * params to which $params array will be resolved on method call are:
 * array(
 *     'myCustomVar1' => 'someValue',
 *     'token_auth' => ..., //this what was resolved from LazyTokenAuthValue
 *     (...) //whatever value => key pairs that were returned by MyParam,
 * );
 */
```

### Using segments

Segment param has its own implementation that allows to build piwik segment query. It's value is resolved on call

```
use Devhelp\Piwik\Api\Param\Segment as SegmentParam;
use Devhelp\Piwik\Api\Param\Segment\Segment;

$segment = new Segment();

$segment->where(new Equals('country', 'PL'))
        ->andWhere(new NotEquals('actions', 1))
        ->andWhere(new Contains('referrerName', 'piwik'))
        ->orWhere(new DoesNotContain('referrerKeyword', 'myBrand'));

$params = array(new SegmentParam($segment));

/*
 * this will be resolved to
 * array('segment' => 'country==PL;actions!=1;referrerName=@piwik,referrerKeyword!@myBrand');
 */
```

## Credits

Brought to you by : Devhelp.pl (http://devhelp.pl)
