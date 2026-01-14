<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string name
 * @property int|null parent_id
 * @property string slug
 * @property bool is_active
 * @property bool is_license_required
 * @property bool show_in_home_top_slider
 * @property int|null prio
 * @property string|null image_path
 * @property string|null icon_path
 * @property-read Collection<Category> subCategories
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'is_active',
        'is_license_required',
        'show_in_home_top_slider',
        'prio',
        'image_path',
        'icon_path',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'show_in_home_top_slider' => 'bool',
        'is_license_required' => 'bool',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function providerDetails(): BelongsToMany
    {
        return $this->BelongsToMany(ProviderDetail::class);
    }

    public function providerDetailsForSub(): BelongsToMany
    {
        return $this->BelongsToMany(ProviderDetail::class, 'provider_detail_sub_category')
            ->withPivot(['id', 'license_verified_at', 'license_expires_on']);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
