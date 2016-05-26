<?php

namespace spec\carlosV2\Map;

use carlosV2\Map\Map;
use carlosV2\Map\MapIterator;
use PhpSpec\ObjectBehavior;

class MapSpec extends ObjectBehavior
{
    function it_is_an_ArrayAccess()
    {
        $this->shouldHaveType(\ArrayAccess::class);
    }

    function it_is_a_Countable()
    {
        $this->shouldHaveType(\Countable::class);
    }

    function it_is_an_IteratorAggregate()
    {
        $this->shouldHaveType(\IteratorAggregate::class);
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
        $this->set([], 'value6');

        $this->get(1)->shouldReturn('value1');
        $this->get(null)->shouldReturn('value2');
        $this->get('abc')->shouldReturn('value3');
        $this->get($obj1)->shouldReturn('value4');
        $this->get($obj2)->shouldReturn('value5');
        $this->get([])->shouldReturn('value6');
    }

    function it_knows_if_it_has_an_offset()
    {
        $this->set([], 'value');

        $this->has([])->shouldReturn(true);
        $this->has(new \stdClass())->shouldReturn(false);
    }

    function it_gets_the_value_for_an_offset_with_an_optional_default_value()
    {
        $this->set([], 'value');

        $this->get([])->shouldReturn('value');
        $this->get(new \stdClass())->shouldReturn(null);
        $this->get(new \stdClass(), 'default')->shouldReturn('default');
    }

    function it_is_ArrayAccess_compliant()
    {
        $this->offsetSet([], 'value');

        $this->offsetExists([])->shouldReturn(true);
        $this->offsetExists(new \stdClass())->shouldReturn(false);

        $this->offsetGet([])->shouldReturn('value');
        $this->offsetGet(new \stdClass())->shouldReturn(null);

        $this->offsetUnset([]);
        $this->offsetExists([])->shouldReturn(false);
    }

    function it_is_Countable_compliant()
    {
        $this->set(null, 'value1');
        $this->set('abc', 'value2');
        $this->set([], 'value3');

        $this->count()->shouldReturn(3);
    }

    function it_is_IteratorAggregate_compliant()
    {
        $this->set(null, 'value1');
        $this->set([], 'value2');

        $iterator = $this->getIterator();
        $iterator->shouldBeAnInstanceOf(MapIterator::class);

        $iterator->rewind();
        $iterator->valid()->shouldReturn(true);
        $iterator->key()->shouldReturn(null);
        $iterator->current()->shouldReturn('value1');
        $iterator->next();
        $iterator->valid()->shouldReturn(true);
        $iterator->key()->shouldReturn([]);
        $iterator->current()->shouldReturn('value2');
        $iterator->next();
        $iterator->valid()->shouldReturn(false);
    }

    function it_returns_the_array_of_keys()
    {
        $this->set(null, 'value1');
        $this->set([], 'value2');

        $this->keys()->shouldReturn([null, []]);
    }

    function it_returns_the_array_of_values()
    {
        $this->set(null, 'value1');
        $this->set([], 'value2');

        $this->values()->shouldReturn(['value1', 'value2']);
    }

    function it_allows_to_apply_a_callable_to_each_value()
    {
        $this->set(null, 'value1');
        $this->set([], 'value2');

        $map = $this->map(function ($value, $key) {
            return sprintf('%s_%s', json_encode($key), $value);
        });
        $map->shouldBeAnInstanceOf(Map::class);

        $map->keys()->shouldReturn([null, []]);
        $map->values()->shouldReturn(['null_value1', '[]_value2']);
    }
}
