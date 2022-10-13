<?php

function create($model, $attributes = [])
{
    return $model::factory()->create($attributes);
}

function make($model, $attributes = [])
{
    return $model::factory()->make($attributes);
}

function makeMany($model, $count = 2, $attributes = [])
{
    return $model::factory()->count($count)->make($attributes);
}

function createMany($model, $count = 2, $attributes = [])
{
    return $model::factory()->count($count)->create($attributes);
}
