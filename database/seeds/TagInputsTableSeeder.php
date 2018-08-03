<?php

use Illuminate\Database\Seeder;
use App\Models\TagInput;

class TagInputsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagInput::truncate();

        TagInput::create(['name' => 'text']);
        TagInput::create(['name' => 'number']);
        TagInput::create(['name' => 'checkbox']);
        TagInput::create(['name' => 'radio']);
        TagInput::create(['name' => 'file']);
        TagInput::create(['name' => 'textarea']);
        TagInput::create(['name' => 'date']);
        TagInput::create(['name' => 'datetime']);
        TagInput::create(['name' => 'select']);
        TagInput::create(['name' => 'hidden']);
        TagInput::create(['name' => 'button']);
        TagInput::create(['name' => 'email']);
        TagInput::create(['name' => 'password']);
        TagInput::create(['name' => 'color']);

        // kieu tu dinh nghia
        TagInput::create(['name' => 'define']);
    }
}
