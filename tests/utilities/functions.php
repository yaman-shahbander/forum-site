<?php

function create($model, $attributes = [])
{
    return $model::factory()->create($attributes);
}

function make($model, $attributes = [])
{
    return $model::factory()->make($attributes);
}
