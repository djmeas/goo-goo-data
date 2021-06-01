<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::insert([
            [
                'group' => 'Feeding',
                'name' => 'Milk',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'oz'
            ],
            [
                'group' => 'Feeding',
                'name' => 'Puree',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'oz'
            ],
            [
                'group' => 'Feeding',
                'name' => 'Solids',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'oz'
            ],
            [
                'group' => 'Feeding',
                'name' => 'Liquids (non-milk)',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'oz'
            ],
            [
                'group' => 'Feeding',
                'name' => 'Snack',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'oz'
            ],

            [
                'group' => 'Changing',
                'name' => 'Diaper',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => null
            ],
            [
                'group' => 'Changing',
                'name' => 'Clothes',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => null
            ],
            [
                'group' => 'Changing',
                'name' => 'Bib',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => null
            ],

            [
                'group' => 'Expense',
                'name' => 'Milk',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Liquids (non-milk)',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Puree',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Solids',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Toy / Entertainment',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Clothes',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Medical',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Daycare / Babysitter',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],
            [
                'group' => 'Expense',
                'name' => 'Misc',
                'type' => 'decimal',
                'prefix' => '$',
                'suffix' => null
            ],

            [
                'group' => 'Event',
                'name' => 'Nap / Sleep',
                'type' => 'decimal',
                'prefix' => null,
                'suffix' => 'hours'
            ],
            [
                'group' => 'Event',
                'name' => 'Bathe',
                'type' => null,
                'prefix' => null,
                'suffix' => null
            ],
            [
                'group' => 'Event',
                'name' => 'Play',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => 'minutes'
            ],
            [
                'group' => 'Event',
                'name' => 'Read',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => 'minutes'
            ],
            [
                'group' => 'Event',
                'name' => 'Exercise',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => 'minutes'
            ],
            [
                'group' => 'Event',
                'name' => 'Learn',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => 'minutes'
            ],
            [
                'group' => 'Event',
                'name' => 'Medical',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => null
            ],
            [
                'group' => 'Event',
                'name' => 'Misc',
                'type' => 'integer',
                'prefix' => null,
                'suffix' => null
            ]
        ]);
    }
}
