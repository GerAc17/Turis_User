<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Viajes;
use Exception;
Use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ViajesController extends Controller
{

    public function create()
    {
        return view('viajes.create');
    }

    public function show_viajes()
    {
        $request = request();
        $nombreUsuario = $request->input('nombreUsuario');
        $viajes = Viajes::all();

        return view('viajes.index', compact('viajes', 'nombreUsuario'));
    }

    public function subscribe($id)
    {
        $viaje = Viajes::findOrFail($id);
        return view('viajes.subscribe', compact('viaje'));
    }

    public function append_viajero()
    {
        $request = request();
        $id = $request->input('id');
        $request->validate([
            'viajeros' => 'required|array',
            'viajeros.*.nombre' => 'required|string|max:255',
            'viajeros.*.edad' => 'required|integer|min:0',
            'viajeros.*.nacionalidad' => 'required|string|max:255',
            'viajeros.*.sexo' => 'required|string|in:Masculino,Femenino',
            'viajeros.*.experiencia' => 'string|max:255',
        ]);
        
        $viaje = Viajes::findOrFail($id);
        
        try {
            foreach ($request->input('viajeros') as $viajero) {
                $viajero = [
                    'nombre' => $viajero['nombre'],
                    'edad' => $viajero['edad'],
                    'nacionalidad' => $viajero['nacionalidad'],
                    'sexo' => $viajero['sexo'],
                    'experiencia' => $viajero['experiencia'] ?? '',
                ];
                
                $viaje->viajeros = array_merge($viaje->viajeros, [$viajero]);
            } 
            $viaje->save();
            return view('viajes.notification', ['status' => 'success', 'message' => 'Te has inscrito correctamente en el viaje.']);
        } catch (Exception $e) {
            return view('viajes.notification', ['status' => 'error', 'message' => 'Hubo un problema al inscribirte en el viaje.']);
        }
    }

    public function unsubscribe($id, $nombreUsuario)
    {
        $nombreUsuario = urldecode($nombreUsuario);
        $viaje = Viajes::findOrFail($id);
        return view('viajes.unsubscribe', compact('viaje', 'nombreUsuario'));
    }

    public function confirm_unsubscribe()
    {
        $request = request();
        $id = $request->input('id');
        $nombreUsuario = $request->input('nombreUsuario');
        $viaje = Viajes::findOrFail($id);
        
        try {
            $viaje->viajeros = array_filter($viaje->viajeros, function ($viajero) use ($nombreUsuario) {
                return $viajero['nombre'] !== $nombreUsuario;
            });
            $viaje->save();
            return view('viajes.notification', ['status' => 'success', 'message' => 'Te has desinscrito correctamente del viaje.']);
        } catch (Exception $e) {
            return view('viajes.notification', ['status' => 'error', 'message' => 'Hubo un problema al desinscribirte del viaje.']);
        }
    }

    public function edit($id)
    {
        $viaje = Viajes::findOrFail($id);
        return view('viajes.edit', compact('viaje'));
    }

    public function show_update()
    {
        $request = request();
        $id = $request->input('id');
        // Validar los datos del formulario
        $request->validate([
            'destino' => 'required|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'alimentos' => 'required|array',
            'alimentos.*.tipo' => 'required|string|max:255',
            'alimentos.*.cantidad' => 'required|integer|min:1',
            'alimentos.*.descripcion' => 'required|string|max:255',
            'viajeros' => 'required|array',
            'viajeros.*.nombre' => 'required|string|max:255',
            'viajeros.*.edad' => 'required|integer|min:0',
            'viajeros.*.nacionalidad' => 'required|string|max:255',
            'viajeros.*.sexo' => 'required|string|in:Masculino,Femenino',
            'viajeros.*.experiencia' => 'required|string|max:255',
        ]);

        try {
            // Encontrar el viaje existente
            $viaje = Viajes::findOrFail($id);

            // Actualizar los datos del viaje
            $viaje->destino = $request->input('destino');
            $viaje->fecha = $request->input('fecha');
            $viaje->alimentos = $request->input('alimentos');
            $viaje->viajeros = $request->input('viajeros');
            $viaje->save();

            // Devolver una vista de notificación de éxito
            return view('viajes.notification', ['status' => 'success', 'message' => 'El viaje se ha actualizado correctamente.']);
        } catch (Exception $e) {
            // Devolver una vista de notificación de error
            return view('viajes.notification', ['status' => 'error', 'message' => 'Hubo un problema al actualizar el viaje.']);
        }
    }

    public function show_create(Request $request)
    {
        // Validar los datos del formulario (solo destino y fecha requeridos)
        $request->validate([
            'destino' => 'required|string|max:255',
            'fecha' => 'required|date_format:Y-m-d\TH:i',
            'alimentos' => 'array',
            'alimentos.*.tipo' => 'string|max:255',
            'alimentos.*.cantidad' => 'integer|min:1',
            'alimentos.*.descripcion' => 'string|max:255',
            'viajeros' => 'array',
            'viajeros.*.nombre' => 'string|max:255',
            'viajeros.*.edad' => 'integer|min:0',
            'viajeros.*.nacionalidad' => 'string|max:255',
            'viajeros.*.sexo' => 'string|in:Masculino,Femenino',
            'viajeros.*.experiencia' => 'string|max:255',
        ]);

        try {
            // Crear un nuevo viaje
            $viaje = new Viajes;
            $viaje->destino = $request->input('destino');
            $viaje->fecha = $request->input('fecha');
            $viaje->alimentos = $request->input('alimentos') ?? [];
            $viaje->viajeros = $request->input('viajeros') ?? [];
            $viaje->save();

            // Devolver una vista de notificación de éxito
            return view('viajes.notification', ['status' => 'success', 'message' => 'El viaje se ha creado correctamente.']);
        } catch (Exception $e) {
            // Devolver una vista de notificación de error
            return view('viajes.notification', ['status' => 'error', 'message' => 'Hubo un problema al crear el viaje.']);
        }
    }

    public function confirm_delete($id)
    {
        $viaje = Viajes::find($id);
        return view('viajes.confirm_delete', compact('viaje'));
    }

    public function destroy_viaje()
    {
        $id = request()->input('id');
        $viaje = Viajes::find($id);
        
        try {
            $viaje->delete();
            return view('viajes.notification', ['status' => 'success', 'message' => 'El viaje se ha eliminado correctamente.']);
        } catch (Exception $e) {
            return view('viajes.notification', ['status' => 'error', 'message' => 'Hubo un problema al eliminar el viaje.']);
        }
    }
}
