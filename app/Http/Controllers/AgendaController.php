<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar agenda (untuk admin)
     */
    public function index()
    {
        $agendas = Agenda::with('creator')
            ->orderBy('start_date', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => Agenda::count(),
            'active' => Agenda::active()->count(),
            'upcoming' => Agenda::active()->upcoming()->count(),
            'ongoing' => Agenda::active()->get()->filter(fn($a) => $a->is_ongoing)->count(),
        ];
        
        return view('admin.agendas.index', compact('agendas', 'stats'));
    }

    /**
     * Form tambah agenda
     */
    public function create(Request $request)
    {
        $defaultDate = $request->get('date', now()->toDateString());
        return view('admin.agendas.create', compact('defaultDate'));
    }

    /**
     * Simpan agenda baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:ujian,uts,uas,rapat,libur,kegiatan,lainnya',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'target_role' => 'required|in:semua,admin,guru,siswa',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->boolean('is_active', true);

        $agenda = Agenda::create($validated);

        return redirect()->route('admin.agendas.index')
            ->with('success', '📅 Agenda "' . $agenda->title . '" berhasil ditambahkan!');
    }

    /**
     * Form edit agenda
     */
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('admin.agendas.edit', compact('agenda'));
    }

    /**
     * Update agenda
     */
    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:ujian,uts,uas,rapat,libur,kegiatan,lainnya',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'target_role' => 'required|in:semua,admin,guru,siswa',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')
            ->with('success', '📅 Agenda "' . $agenda->title . '" berhasil diperbarui!');
    }

    /**
     * Hapus agenda
     */
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $title = $agenda->title;
        $agenda->delete();

        return redirect()->route('admin.agendas.index')
            ->with('success', '🗑️ Agenda "' . $title . '" berhasil dihapus!');
    }

    /**
     * Toggle status aktif agenda (via AJAX)
     */
    public function toggleActive($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->is_active = !$agenda->is_active;
        $agenda->save();

        return response()->json([
            'success' => true,
            'is_active' => $agenda->is_active,
            'message' => $agenda->is_active ? 'Agenda diaktifkan' : 'Agenda dinonaktifkan',
        ]);
    }

    /**
     * Mendapatkan agenda untuk kalender (via AJAX)
     */
    public function calendarEvents(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? 'siswa';
        
        $agendas = Agenda::active()
            ->forRole($role)
            ->get()
            ->map(function ($agenda) {
                return [
                    'id' => $agenda->id,
                    'title' => $agenda->title,
                    'start' => $agenda->start_date->format('Y-m-d'),
                    'end' => $agenda->end_date ? $agenda->end_date->addDay()->format('Y-m-d') : $agenda->start_date->format('Y-m-d'),
                    'type' => $agenda->type,
                    'type_label' => $agenda->type_label,
                    'description' => $agenda->description,
                    'location' => $agenda->location,
                    'time' => $agenda->formatted_time,
                    'color' => $agenda->type_color,
                    'is_ongoing' => $agenda->is_ongoing,
                ];
            });

        return response()->json($agendas);
    }
}