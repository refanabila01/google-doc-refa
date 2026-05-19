<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CursorMoved implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $documentId;
    public $position;
    public $user;

    public function __construct($documentId, $position, $user)
    {
        $this->documentId = $documentId;
        $this->position = $position;
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('document.' . $this->documentId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'cursor.moved';
    }
}