<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentInstallment;
use App\Notifications\GeneralNotification;
use Carbon\Carbon;

class CheckInstallments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installments:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for due/overdue installments and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // 1. Installments due in 3 days
        $dueIn3Days = PaymentInstallment::with(['payment.user', 'payment.schoolClass'])
            ->where('status', 'pending')
            ->whereDate('due_date', $today->copy()->addDays(3))
            ->get();

        foreach ($dueIn3Days as $installment) {
            $user = $installment->payment->user;
            $class = $installment->payment->schoolClass;
            
            if ($user && $class) {
                $user->notify(new GeneralNotification(
                    'Installment Reminder',
                    "Tagihan cicilan Anda akan jatuh tempo dalam 3 hari.",
                    'payment',
                    route('student.payments')
                ));
                $this->info("Reminder sent to {$user->name} for upcoming installment.");
            }
        }

        // 2. Installments overdue
        $overdueInstallments = PaymentInstallment::with(['payment.user', 'payment.schoolClass'])
            ->where('status', 'pending')
            ->whereDate('due_date', '<', $today)
            ->get();

        foreach ($overdueInstallments as $installment) {
            $installment->update(['status' => 'overdue']);
            
            $user = $installment->payment->user;
            $class = $installment->payment->schoolClass;
            
            if ($user && $class) {
                // Mark user status as PAYMENT_OVERDUE if they don't already have it
                if ($user->student_status !== 'PAYMENT_OVERDUE') {
                    $user->update(['student_status' => 'PAYMENT_OVERDUE']);
                }
                
                $user->notify(new GeneralNotification(
                    'Installment Overdue',
                    "Selesaikan pembayaran anda terlebih dahulu.",
                    'payment',
                    route('student.payments')
                ));
                $this->info("Overdue notification sent to {$user->name}.");
            }
        }
        
        $this->info('Installments check completed.');
    }
}
