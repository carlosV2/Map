<?php

namespace spec\carlosV2\Map;

use PhpSpec\ObjectBehavior;

class MapIteratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(array(null, array(), 'abc'), array('value1', 'value2', 'value3'));
    }

    function it_is_an_Iterator()
    {
        $this->shouldHaveType(\Iterator::class);
    }

    function it_iterates_the_keys_and_values()
    {
        $this->rewind();
        $this->valid()->shouldReturn(true);
        $this->key()->shouldReturn(null);
        $this->current()->shouldReturn('value1');
        $this->next();
        $this->valid()->shouldReturn(true);
        $this->key()->shouldReturn(array());
        $this->current()->shouldReturn('value2');
        $this->next();
        $this->valid()->shouldReturn(true);
        $this->key()->shouldReturn('abc');
        $this->current()->shouldReturn('value3');
        $this->next();
        $this->valid()->shouldReturn(false);
    }
}
