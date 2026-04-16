@extends('layouts.guru')

@section('content')
<div class="p-2 md:p-4">
    <div class="mb-10">
        <h2 class="text-3xl font-heading font-bold text-slate-800 tracking-tight">Input Nilai Siswa</h2>
        <p class="text-slate-500 mt-1 flex items-center gap-2 text-sm font-medium">
            <i data-lucide="edit-3" class="w-4 h-4 text-indigo-500"></i>
            Kelola nilai tugas dan ujian siswa.
        </p>
    </div>

    {{-- 🔥 LANGKAH 4: FORM DENGAN CSRF --}}
    <form method="POST" action="{{ route('guru.nilai.store') }}">
        @csrf

        <div class="bg-white rounded-[2.5rem] border border-slate-200 p-6 mb-8 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kelas</label>
                    <select name="class_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                    <select name="subject_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                        <option value="">Pilih Mapel</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Penilaian</label>
                    {{-- 🔥 LANGKAH 6: SELECT DENGAN NAME type --}}
                    <select name="type" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                        <option value="">Pilih Jenis</option>
                        <option value="tugas">Tugas Harian</option>
                        <option value="quiz">Quiz</option>
                        <option value="uts">UTS</option>
                        <option value="uas">UAS</option>
                        <option value="praktikum">Praktikum</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="filterData()" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">
                    <i data-lucide="search" class="w-4 h-4 inline mr-2"></i> Tampilkan
                </button>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">NISN</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Keterangan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        {{-- 🔥 LANGKAH 1 & 2: HAPUS DATA DUMMY, PAKAI $students --}}
                        @forelse($students as $index => $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $index + 1 }}</td>
                            {{-- 🔥 LANGKAH 3: PAKAI OBJEK BUKAN ARRAY --}}
                            <td class="px-6 py-4 text-sm font-mono text-slate-500">{{ $s->nisn }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($s->name) }}&background=4F46E5&color=fff" class="w-8 h-8 rounded-full">
                                    <span class="font-medium text-slate-700">{{ $s->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{-- 🔥 LANGKAH 5: INPUT DENGAN NAME grades[siswa_id][score] --}}
                                <input type="number" 
                                       name="grades[{{ $s->id }}][score]" 
                                       value="{{ old('grades.' . $s->id . '.score', $s->grade->score ?? '') }}"
                                       class="w-20 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-center text-sm"
                                       placeholder="0-100"
                                       min="0"
                                       max="100">
                            </td>
                            <td class="px-6 py-4">
                                <select name="grades[{{ $s->id }}][status]" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                                    <option value="">- Pilih -</option>
                                    <option value="tuntas" {{ ($s->grade->status ?? '') == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                                    <option value="remedial" {{ ($s->grade->status ?? '') == 'remedial' ? 'selected' : '' }}>Remedial</option>
                                    <option value="tidak_tuntas" {{ ($s->grade->status ?? '') == 'tidak_tuntas' ? 'selected' : '' }}>Tidak Tuntas</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="saveSingle({{ $s->id }})" class="p-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition-colors">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300"></i>
                                <p>Belum ada data siswa</p>
                                <p class="text-sm mt-1">Silakan pilih kelas dan mata pelajaran terlebih dahulu</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-between items-center">
                <div class="text-sm text-slate-500">
                    Menampilkan {{ $students->count() }} dari {{ $students->count() }} data
                </div>
                {{-- 🔥 LANGKAH 7: BUTTON SIMPAN SEMUA --}}
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all">
                    <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i> Simpan Semua
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
    
    function filterData() {
        const classId = document.querySelector('select[name="class_id"]').value;
        const subjectId = document.querySelector('select[name="subject_id"]').value;
        
        if(classId && subjectId) {
           window.location.href = "{{ route('guru.nilai') }}?class_id=" + classId + "&subject_id=" + subjectId;
        } else {
            alert('Pilih kelas dan mata pelajaran terlebih dahulu!');
        }
    }
    
    function saveSingle(studentId) {
        // Untuk save per siswa (opsional)
        const form = document.querySelector('form');
        const submitEvent = new Event('submit', { cancelable: true });
        form.dispatchEvent(submitEvent);
    }
</script>
@endsection