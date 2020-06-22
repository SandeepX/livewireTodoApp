<?php

namespace App\Http\Livewire;

use App\Todo;
use Livewire\Component;
use Auth;

class Todos extends Component
{
    public $title ='';


 

    public function render(){
        $Id = Auth::id();
        $todos = Todo::where('user_id', '=', $Id)->orderBy('completed', 'ASC')->get();
         return view('livewire.todos', [
            'todos' => $todos
        ]);

        // return view('livewire.todos',[
        // 	'todos' => auth()->user()->todos
        // ]);  

    }

    public function addTodo(){

        $this->validate([
            'title' => 'required|max:100',
        ]);
        Todo::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'completed' => false,
        ]);

        $this->title ='';
    }

   public function deleteTodo($id){

        Todo::find($id)->delete();
    }

    public function toggleTodo($id){
        $todo = Todo:: find($id);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

     public function updateTodo($id, $title){
        //dd($id);
        
        $todo = Todo::find($id);
        $todo->title = $title;
        $todo->save();

        session()->flash('message', 'task successfully updated.');
    }
}
