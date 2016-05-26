# Map

Map allows you to use an array-like object which allows keys to be of any type as opposed to the
default integer or string types.


[![License](https://poser.pugx.org/carlosv2/map/license)](https://packagist.org/packages/carlosv2/map)
[![Build Status](https://travis-ci.org/carlosV2/Map.svg?branch=master)](https://travis-ci.org/carlosV2/Map)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3223ef19-b378-44bb-ab61-4538de8466d6/mini.png)](https://insight.sensiolabs.com/projects/3223ef19-b378-44bb-ab61-4538de8466d6)

### Installation

Install with:
```
$ composer require carlosv2/map
```

### Usage

To use Map you only need to create an instance of it and start using it as if it was an regular array:
```
$foo = new Foo();

$map = new Map();
$map[$foo] = 'bar';
```

You can use any type you want as key. If you want, you can even mix them:
```
$map = new Map();

$map[null] = 'null';
$map[[]] = 'array';
$map['string'] = 'string';
$map[1] = 'integer';
$map[true] = 'boolean';
$map[new \stdClass()] = 'object';

foreach ($map as $key => $value) {
    var_dump($key, $value);
}
```

### API

The following functions are available in the Map class.

has:
----

Checks whether a key exists or not:
```
$obj = new \stdClass();

$map = new Map();
$map[$obj] = 'value';

$map->has($obj); // true
$map->has([]); // false
```

get:
----

Returns the value associated with the given key:
```
$obj = new \stdClass();

$map = new Map();
$map[$obj] = 'value';

$map->get($obj); // 'value'
$map->get([]); // null
```

Optionally, a fallback value can be returned if the given key does not exist:
```
$map = new Map();
$map->get([], 'default'); // 'default'
```

set:
----

Assigns the given value to the given key:
```
$map = new Map();

$map->set($key, $value); // Equivalent to: $map[$key] = $value;
```

keys:
-----

Returns the array of keys for that instance:
```
$map = new Map();

$map[null] = 'null';
$map[[]] = 'array';
$map[true] = 'boolean';

$map->keys(); // [null, [], true]
```

values:
-------

Returns the array of values for that instance:
```
$map = new Map();

$map[null] = 'null';
$map[[]] = 'array';
$map[true] = 'boolean';

$map->values(); // ['null', 'array', 'boolean']
```

map:
----

Similar to `array_map` but it returns another Map instance instead. The callable function may have the key as a
second argument:
```
$map = new Map();

$map[null] = 'null';
$map[[]] = 'array';
$map[true] = 'boolean';

$newMap = $map->map(function ($value, $key) { return json_encode($key) . '_' . $value; });
$newMap->keys(); // [null, [], true]
$newMap->values(); // ['null_null', '[]_array', 'true_boolean']
```

### Interfaces

The Map class implements the following interfaces:
- [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)
- [Countable](http://php.net/manual/en/class.countable.php)
- [IteratorAggregate](http://php.net/manual/en/class.iteratoraggregate.php)
