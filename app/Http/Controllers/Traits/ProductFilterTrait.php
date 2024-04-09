<?php

namespace App\Http\Controllers\Traits;

use App\Models\Product;

trait ProductFilterTrait
{
    public function applyFilters($status)
    {
        switch ($status) {
            case 'available':
                return Product::available()->paginate(10);
            case 'unavailable':
                return Product::unavailable()->paginate(10);
            default:
                return Product::paginate(10);
        }
    }
}
