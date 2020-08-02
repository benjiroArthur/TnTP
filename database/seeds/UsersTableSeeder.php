<?php

use App\Admin;
use App\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->comment("Welcome to a free Installation. This wizard will take you through to create an admin account.");

        $firstName = $this->command->ask("Enter your First name","Admin");

        $lastName = $this->command->ask("Enter your Last name","Admin");

        $otherName = $this->command->ask("Enter your other name if applicable. Or just press Enter.",null);

        $email = $this->command->ask("Enter your Email.","admin@mail.com");

        $password = $this->command->ask("Enter your Password.","secret");


        if($otherName == null){
            $full_name =$firstName.' '.$lastName;
        }
        else{
            $full_name = $firstName.' '.$otherName.' '.$lastName;
        }
        $admin = Admin::create([
            'last_name' => $lastName,
            'first_name' => $firstName,
            'other_name' => $otherName,
            'email' => $email,
            'full_name' => $full_name
        ]);
        $role = Role::where('name', 'admin')->first();
        $user = $admin->user()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'role_id' => $role->id
        ]);

        $this->command->alert("Admin Account Created. Now log In with the credentials you used here.");

    }
}
