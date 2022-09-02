<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;

class Contacts extends Component
{
    public $contacts, $name, $phone, $contact_id;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;


    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        $this->contacts = Contact::all();
        return view('livewire.contacts');
    }

    private function resetInputFields() {
        $this->name = '';
        $this->phone = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name.0' => 'required',
            'phone.0' => 'required',
            'name.*' => 'required',
            'phone.*' => 'required',
        ],
        [
            'name.0.required' => 'Name field is required',
            'phone.0.required' => 'Phone field is required',
            'name.*.required' => 'Name field is required',
            'phone.*.required' => 'Phone field is required',
        ]
    );

    foreach ($this->name as $key => $value) {
        Contact::create(['name' => $this->name[$key], 'phone' => $this->phone[$key]]);
    }

    $this->inputs = [];

    $this->resetInputFields();

    session()->flash('message', 'Contact Has Been Created Successfully.');
    }
}
