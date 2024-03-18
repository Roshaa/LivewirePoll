<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Poll;

class CreatePoll extends Component
{

    public $title;
    public $options = ['First'];

    protected $rules = [
        'title' => 'required|min:6|max:255',
        'options' => 'required|array|min:2|max:20',
        'options.*' => 'required|min:1|max:255'
    ];

    protected $messages=[
        'options.*.required' => 'Option cannot be empty',
        'options.*.min' => 'Option must be at least 1 character long',
        'options.*.max' => 'Option must be at most 255 characters long',
        'title.required' => 'Title cannot be empty',
        'title.min' => 'Title must be at least 6 characters long',
        'title.max' => 'Title must be at most 255 characters long',
        'options.required' => 'Options cannot be empty',
        'options.min' => 'Options must be at least 2 characters long',
        'options.max' => 'Options must be at most 20 characters long',
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function  addOption(){
        $this->options[] = '';
    }   

    public function removeOption($index){
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {

        $this->validate();

        Poll::create([
            'title' => $this->title
        ])->options()->createMany(collect($this->options)->map(fn ($option) => ['name' => $option])->all());

        /* foreach ($this->options as $optionName) {
            $poll->options()->create(['name' => $optionName]);
            
        }*/
 
        $this->reset(['title', 'options']);
        //nao percebo porque nao da e a esta hora da noite ja nao tou com paciencia $this->emit('refresh');

    }
}
