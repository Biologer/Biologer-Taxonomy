<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConservationDocument extends Model
{
    use HasFactory;
    use Translatable;

    protected $translationForeignKey = 'doc_id';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'description'];

    /**
     * Attributes that can be translated.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * Countries for reference local id's.
     */
    public function countries()
    {
        return $this->belongsToMany(
            Country::class,
            'country_conservation_document',
            'doc_id',
            'country_id'
        )
            ->withPivot('ref_id');
    }

    /**
     * Get translated conservation document name.
     *
     * @return string|null
     */
    public function getNameAttribute()
    {
        return $this->translateOrNew($this->locale())->name;
    }

    /**
     * Get translated conservation document description.
     *
     * @return string|null
     */
    public function getDescriptionAttribute()
    {
        return $this->translateOrNew($this->locale())->description;
    }
}
