use Carbon\Carbon;
use App\Models\User;

public function handle()
{
    $today = Carbon::today();

    $users = User::all();

    foreach ($users as $user) {

        $fecha18 = Carbon::parse($user->birthdate)->addYears(18);

        // 2 meses antes
        if ($today->equalTo($fecha18->copy()->subMonths(2))) {
            $this->notificar($user, 'Faltan 2 meses para cumplir 18');
        }

        // 15 días antes
        if ($today->equalTo($fecha18->copy()->subDays(15))) {
            $this->notificar($user, 'Faltan 15 días para cumplir 18');
        }

        // 1 día antes
        if ($today->equalTo($fecha18->copy()->subDay())) {
            $this->notificar($user, 'Mañana cumple 18');
        }
    }
}