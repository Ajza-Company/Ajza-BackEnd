<?php

if (!function_exists('userCompany')) {
    /**
     * Returns decoded Item
     */
    function userCompany()
    {
        return auth('api')->user()?->company;
    }
}
