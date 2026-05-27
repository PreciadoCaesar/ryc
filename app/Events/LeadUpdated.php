<?php

namespace App\Events;

use App\Models\Lead;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lead;
    public $advisorId;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
        $this->advisorId = $lead->advisor_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('leads.' . $this->advisorId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'lead.updated';
    }
}
