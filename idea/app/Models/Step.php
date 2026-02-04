<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\StepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $idea_id
 * @property string $description
 * @property bool $completed
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Idea $idea
 */
class Step extends Model
{
    /** @use HasFactory<StepFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'idea_id',
        'description',
        'completed',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
        ];
    }

    /**
     * The owner of this step
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
