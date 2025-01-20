<?php

use App\Enums\EncodingMethodsEnum;
use Illuminate\Contracts\Encryption\DecryptException;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('randomImage')) {
    /**
     * Returns decoded Item
     */
    function randomImage(): array
    {
        return[
            'https://m.media-amazon.com/images/I/41WpqIvJWRL._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/61ghDjhS8vL._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/61c1QC4lF-L._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/710VzyXGVsL._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/61EPT-oMLrL._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/71r3ktfakgL._AC_UY436_QL65_.jpg',
            'https://m.media-amazon.com/images/I/61CqYq+xwNL._AC_UL640_QL65_.jpg',
            'https://m.media-amazon.com/images/I/71cVOgvystL._AC_UL640_QL65_.jpg',
            'https://m.media-amazon.com/images/I/71E+oh38ZqL._AC_UL640_QL65_.jpg',
            'https://m.media-amazon.com/images/I/61uSHBgUGhL._AC_UL640_QL65_.jpg',
            'https://m.media-amazon.com/images/I/71nDK2Q8HAL._AC_UL640_QL65_.jpg'
        ];
    }
}
