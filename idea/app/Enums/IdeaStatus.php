<?php

declare(strict_types=1);

namespace App\Enums;

enum IdeaStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in-progress';
    case COMPLETED = 'completed';

    /**
     * Get associated label for specific status
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        };
    }
}
