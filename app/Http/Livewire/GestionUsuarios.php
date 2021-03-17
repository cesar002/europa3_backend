<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\UserAdmin;

class GestionUsuarios extends Component
{
	public $usuarios;

	public function delete($id)
	{
		try{
			UserAdmin::findOrFail($id)->update([
				'username' => 'XXXXXXXXXXXXXXX'
			]);

			UserAdmin::destroy($id);

			$this->usuarios = UserAdmin::all();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Usuario eliminado con éxito'
			]);
		}catch(\Throwable $th){
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar el usuario'
			]);
		}
	}

    public function render()
    {
        return view('livewire.gestion-usuarios');
    }
}
