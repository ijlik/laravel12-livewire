<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class InsertRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Masukan Email yang ingin di tambah role');
        $roleName = $this->choice('Pilih Role', Role::all()->pluck('name')->toArray());

        $user = User::where('email', $email)->first();
        $role = Role::where('name', $roleName)->first();
        if ($user) {
            $user->assignRole($role);
            $this->info('Sukses');
        } else {
            $this->error('User tidak ditemukan');
        }

    }
}
