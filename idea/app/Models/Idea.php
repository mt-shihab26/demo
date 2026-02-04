<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property AsArrayObject $links
 * @property IdeaStatus $status
 * @property string|null $image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read array<Step> $steps
 */
class Idea extends Model
{
    /** @use HasFactory<IdeaFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'links',
        'status',
        'image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'links' => AsArrayObject::class,
            'status' => IdeaStatus::class,
        ];
    }

    /**
     * The owner of this idea
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The idea can have many steps
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
}
