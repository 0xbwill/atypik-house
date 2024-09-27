<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservations;
use Carbon\Carbon;

class DeletePendingReservations extends Command
{
    /**
     * @var string
     */
    protected $signature = 'reservations:delete-pending';

    /**
     * @var string
     */
    protected $description = 'Supprime les réservations en pending depuis plus de 30 secondes';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $deletedRows = Reservations::where('payment_status', 'pending')
            ->where('created_at', '<', Carbon::now()->subSeconds(30))
            ->forceDelete();

        $this->info("Nombre de réservations supprimées : $deletedRows");
    }
}
