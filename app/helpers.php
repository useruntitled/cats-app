<?php

if (! function_exists('get_model')) {
    function get_model(string $name): string
    {
        return \Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel(strtolower($name));
    }
}
