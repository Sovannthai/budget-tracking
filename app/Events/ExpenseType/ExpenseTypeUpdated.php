<?php

namespace App\Events\ExpenseType;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseTypeUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $expenseType;
    /**
     * Create a new event instance.
     */
    public function __construct($expenseType)
    {
        $this->expenseType = $expenseType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('expense-types'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'expense-type.updated';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->expenseType->id,
            'name' => $this->expenseType->name,
            'icon' => $this->expenseType->icon,
            'customer_id' => $this->expenseType->customer_id,
            'description' => $this->expenseType->description,
            'updated_at' => $this->expenseType->updated_at,
        ];
    }
}
