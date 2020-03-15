<?php

namespace App\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Item;

class ItemSold
{
    use Dispatchable, SerializesModels;
    public $quantity_sold;
    public $item;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Item $item, int $quantity_sold)
    {
        $this->item = $item;
        $this->$quantity_sold = $quantity_sold;
    }
}
