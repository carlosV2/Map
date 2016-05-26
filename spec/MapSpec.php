<?php

namespace spec\carlosV2\Map;

use PhpSpec\ObjectBehavior;

class MapSpec extends ObjectBehavior
{
    function it_is_an_ArrayAccess()
    {
        $this->shouldHaveType('\ArrayAccess');
    }

    function it_is_a_Countable()
    {
        $this->shouldHaveType('\Countable');
    }

    function it_is_an_IteratorAggregate()
    {
        $this->shouldHaveType('\IteratorAggregate');
    }

    function it_stores_values_under_any_offset_type()
    {
        $obj1 = new \stdClass();
        $obj1->key1 = 1;

        $obj2 = new \stdClass();
        $obj2->key2 = 2;

        $this->set(1, 'value1');
        $this->set(null, 'value2');
        $this->set('abc', 'value3');
        $this->set($obj1, 'value4');
        $this->set($obj2, 'value5');
        $this->set(array(), 'value6');

        $this->get(1)->shouldReturn('value1');
        $this->get(null)->shouldReturn('value2');
        $this->get('abc')->shouldReturn('value3');
        $this->get($obj1)->shouldReturn('value4');
        $this->get($obj2)->shouldReturn('value5');
        $this->get(array())->shouldReturn('value6');
    }

    function it_knows_if_it_has_an_offset()
    {
        $this->set(array(), 'value');

        $this->has(array())->shouldReturn(true);
        $this->has(new \stdClass())->shouldReturn(false);
    }

    function it_gets_the_value_for_an_offset_with_an_optional_default_value()
    {
        $this->set(array(), 'value');

        $this->get(array())->shouldReturn('value');
        $this->get(new \stdClass())->shouldReturn(null);
        $this->get(new \stdClass(), 'default')->shouldReturn('default');
    }

    function it_is_ArrayAccess_compliant()
    {
        $this->offsetSet(array(), 'value');

        $this->offsetExists(array())->shouldReturn(true);
        $this->offsetExists(new \stdClass())->shouldReturn(false);

        $this->offsetGet(array())->shouldReturn('value');
        $this->offsetGet(new \stdClass())->shouldReturn(null);

        $this->offsetUnset(array());
        $this->offsetExists(array())->shouldReturn(false);
    }

    function it_is_Countable_compliant()
    {
        $this->set(null, 'value1');
        $this->set('abc', 'value2');
        $this->set(array(), 'value3');

        $this->count()->shouldReturn(3);
    }

    function it_is_IteratorAggregate_compliant()
    {
        $this->set(null, 'value1');
        $this->set(array(), 'value2');

        $iterator = $this->getIterator();
        $iterator->shouldBeAnInstanceOf('carlosV2\Map\MapIterator');

        $iterator->rewind();
        $iterator->valid()->shouldReturn(true);
        $iterator->key()->shouldReturn(null);
        $iterator->current()->shouldReturn('value1');
        $iterator->next();
        $iterator->valid()->shouldReturn(true);
        $iterator->key()->shouldReturn(array());
        $iterator->current()->shouldReturn('value2');
        $iterator->next();
        $iterator->valid()->shouldReturn(false);
    }

    function it_returns_the_array_of_keys()
    {
        $this->set(null, 'value1');
        $this->set(array(), 'value2');

        $this->keys()->shouldReturn(array(null, array()));
    }

    function it_returns_the_array_of_values()
    {
        $this->set(null, 'value1');
        $this->set(array(), 'value2');

        $this->values()->shouldReturn(array('value1', 'value2'));
    }

    function it_allows_to_apply_a_callable_to_each_value()
    {
        $this->set(null, 'value1');
        $this->set(array(), 'value2');

        $map = $this->map(function ($value, $key) {
            return sprintf('%s_%s', json_encode($key), $value);
        });
        $map->shouldBeAnInstanceOf('carlosV2\Map\Map');

        $map->keys()->shouldReturn(array(null, array()));
        $map->values()->shouldReturn(array('null_value1', '[]_value2'));
    }
}
