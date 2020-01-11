<?php

function create(string $class, array $attributes = []) {
    return factory($class)->create($attributes);
}

function make(string $class, array $attributes = []) {
    return factory($class)->make($attributes);
}
