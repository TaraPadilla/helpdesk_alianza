<?php

namespace App\Http\Controllers;

use App\Models\ImagenTicket;
use App\Http\Resources\ImagenTicketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImagenTicketController extends Controller
{
    public function index()
    {
        $imagenes = ImagenTicket::all();
        return ImagenTicketResource::collection($imagenes);
    }

    public function indexTicket($ticket_id)
    {
        $imagenes = ImagenTicket::where('ticket_id', $ticket_id)->get();
        return ImagenTicketResource::collection($imagenes);
    }
    
    public function store(Request $request)
    {

        Log::info('store ImagenTicketController', ['request' => $request->all()]);
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'imagenes.*' => 'required|file|mimes:jpg,jpeg,png,gif,pdf',
            'imagenes' => 'required|array',
            'descripcion.*' => 'nullable|string',
            'tipo.*' => 'nullable|string|max:100',
        ]);

        $ticket_id = $request->input('ticket_id');
        $imagenes = $request->file('imagenes');
        $descripciones = $request->input('descripcion', []);
        $tipos = $request->input('tipo', []);
        Log::info('store ImagenTicketController', ['ticket_id' => $ticket_id, 'imagenes' => $imagenes, 'descripciones' => $descripciones, 'tipos' => $tipos]);

        $imagenesCreadas = [];

        DB::beginTransaction();
        try {
            foreach ($imagenes as $i => $imagen) {
                $nombreArchivo = uniqid('ticket_') . '.' . $imagen->getClientOriginalExtension();
                $destino = storage_path("app/public/tickets/" . $nombreArchivo);
                // Log::info("Moviendo archivo a: " . $destino);
                // $imagen->move(storage_path('app/public/tickets'), $nombreArchivo);
                                
                $rutaStorage = $imagen->storeAs('public/tickets', $nombreArchivo);
                $rutaPublica = '/storage/tickets/' . $nombreArchivo;
                Log::info("Nombre archivo: " . $nombreArchivo);
                Log::info("Ruta real: " . storage_path("app/public/tickets/$nombreArchivo"));   

                $img = ImagenTicket::create([
                    'ticket_id' => $ticket_id,
                    'ruta' => $rutaPublica,
                    'descripcion' => $descripciones[$i] ?? null,
                    'tipo' => $tipos[$i] ?? null,
                ]);
                $imagenesCreadas[] = $img;
            }
            DB::commit();
            Log::info('store ImagenTicketController', ['imagenesCreadas' => $imagenesCreadas]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al guardar imágenes', 'details' => $e->getMessage()], 500);
        }

        return ImagenTicketResource::collection(collect($imagenesCreadas));
    }

    public function destroy($id)
    {
        $imagen = ImagenTicket::findOrFail($id);

        // Extraer ruta interna en storage
        $ruta = str_replace('/storage/', 'public/', $imagen->ruta);
        
        if (Storage::exists($ruta)) {
            $nombreArchivo = basename($ruta); // mantiene el nombre exacto
            Storage::move($ruta, 'public/eliminadas/' . $nombreArchivo);
        }
        
        $imagen->delete();
        
        return response()->json(['message' => 'Imagen eliminada correctamente']);
    }
}
