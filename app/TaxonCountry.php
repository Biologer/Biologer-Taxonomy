<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TaxonCountry extends Pivot
{
    protected $casts = [
        'allochthonous' => 'boolean',
        'invasive' => 'boolean',
        'restricted' => 'boolean',
    ];
}
