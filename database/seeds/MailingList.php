<?php

use Illuminate\Database\Seeder;

class MailingList extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MailingList::class, 1000)->create();
    }
}
