<?php

function create(string $class, array $attributes = [], $times = null) {
    return factory($class, $times)->create($attributes);
}

function make(string $class, array $attributes = [], $times = null) {
    return factory($class, $times)->make($attributes);
}
