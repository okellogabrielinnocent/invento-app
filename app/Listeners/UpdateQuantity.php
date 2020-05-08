<?php

namespace App\Listeners;

use App\Events\ItemSold;

class UpdateQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ItemSold  $event
     * @return void
     */
    public function handle(ItemSold $event)
    {
        $request = [];

        $remaining_quantity = $event->item->quantity - $event->quantity_sold;

        $request['quantity'] = $remaining_quantity;

        if ($remaining_quantity <= $event->item->minimum_quantity) {
            $request['saleable'] = false;
        }else{
            
        }

        $event->item->update($request);
    }
}
