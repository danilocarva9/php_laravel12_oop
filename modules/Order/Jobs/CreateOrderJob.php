<?php

namespace Modules\Order\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreatePaymentAction;

class CreateOrderJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CreatePaymentAction $action): void
    {
        $action->handle($this->order);
    }
}
