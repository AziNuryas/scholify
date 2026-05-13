@extends('layouts.admin')
@section('title', 'Edit Jadwal - Schoolify Admin')
@section('page-title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="max-w-4xl mx-auto animate-fadeInUp">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[1.5rem] bg-blue-500/10 text-blue-600 flex items-center justify-center shadow-inner">
                <i data-lucide="calendar-range" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">Edit Jadwal Pelajaran</h3>
                <p class="text-xs text-[var(--text-secondary)] font-bold uppercase tracking-widest">ID Jadwal: #{{ $jadwal->id }}</p>
            </div>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="neo-btn px-6 py-3 rounded-2xl text-[var(--text-secondary)] hover:text-rose-500 flex items-center gap-2 transition-all group">
            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-sm font-black">KEMBALI</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="neo-flat rounded-[2.5rem] overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 px-8 py-6 border-b border-[var(--shadow-dark)]/5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="edit-3" class="w-5 h-5 text-blue-500"></i>
                    <h4 class="font-black text-sm text-[var(--text-primary)] uppercase tracking-wider">Perbarui Informasi Jadwal</h4>
                </div>
                <span class="text-[10px] font-black px-3 py-1 rounded-full bg-blue-500 text-white shadow-lg shadow-blue-500/20">MODE EDIT</span>
            </div>
        </div>

        <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="door-open" class="w-4 h-4 text-blue-500"></i> Pilih Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="school_class_id" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ old('school_class_id', $jadwal->school_class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="user-check" class="w-4 h-4 text-blue-500"></i> Pilih Guru Pengampu <span class="text-rose-500">*</span>
                    </label>
                    <select name="guru_id" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        <option value="">Pilih Guru</option>
                        @foreach($teachers ?? [] as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('guru_id', $jadwal->guru_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Subject & Day -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="book-open" class="w-4 h-4 text-blue-500"></i> Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        @php $isLainnya = !in_array($jadwal->mata_pelajaran, $mapel ?? []); @endphp
                        <select name="mata_pelajaran" id="mapelSelect" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mapel ?? [] as $m)
                            <option value="{{ $m }}" {{ old('mata_pelajaran', $jadwal->mata_pelajaran) == $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                            @endforeach
                            <option value="Lainnya" {{ $isLainnya ? 'selected' : '' }}>Lainnya (Ketik Manual)</option>
                        </select>
                    </div>
                    <input type="text" name="mata_pelajaran_lain" id="mapelLainInput" value="{{ $isLainnya ? $jadwal->mata_pelajaran : '' }}" class="w-full neo-input py-3.5 px-5 font-bold text-sm mt-3 {{ $isLainnya ? '' : 'hidden' }} animate-fadeInUp" placeholder="Ketik Mata Pelajaran Manual...">
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="calendar" class="w-4 h-4 text-blue-500"></i> Hari <span class="text-rose-500">*</span>
                    </label>
                    <select name="hari" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        <option value="">Pilih Hari</option>
                        @foreach($hari ?? [] as $h)
                        <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Time Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                            <i data-lucide="clock-3" class="w-4 h-4 text-blue-500"></i> Jam Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) }}" class="w-full neo-input py-3.5 px-5 font-bold text-sm" required>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                            <i data-lucide="clock-9" class="w-4 h-4 text-rose-500"></i> Jam Selesai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) }}" class="w-full neo-input py-3.5 px-5 font-bold text-sm" required>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-500"></i> Ruangan / Lokasi
                    </label>
                    <input type="text" name="ruangan" value="{{ old('ruangan', $jadwal->ruangan) }}" placeholder="Contoh: Ruang 101, Lab IPA" class="w-full neo-input py-3.5 px-5 font-bold text-sm">
                </div>
            </div>

            <!-- Academic Year & Semester -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="layers" class="w-4 h-4 text-blue-500"></i> Semester <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-4 p-2 neo-pressed rounded-2xl">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="semester" value="1" class="sr-only peer" {{ old('semester', $jadwal->semester) == '1' ? 'checked' : '' }}>
                            <div class="py-2.5 text-center rounded-xl text-[10px] font-black uppercase tracking-widest peer-checked:bg-[var(--accent)] peer-checked:text-white peer-checked:shadow-md transition-all text-[var(--text-muted)]">GANJIL (1)</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="semester" value="2" class="sr-only peer" {{ old('semester', $jadwal->semester) == '2' ? 'checked' : '' }}>
                            <div class="py-2.5 text-center rounded-xl text-[10px] font-black uppercase tracking-widest peer-checked:bg-[var(--accent)] peer-checked:text-white peer-checked:shadow-md transition-all text-[var(--text-muted)]">GENAP (2)</div>
                        </label>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="calendar-check" class="w-4 h-4 text-blue-500"></i> Tahun Ajaran <span class="text-rose-500">*</span>
                    </label>
                    <select name="tahun_ajaran" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunAjaranOptions ?? [] as $ta)
                        <option value="{{ $ta }}" {{ old('tahun_ajaran', $jadwal->tahun_ajaran) == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="activity" class="w-4 h-4 text-blue-500"></i> Status Jadwal
                    </label>
                    <select name="status" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer">
                        <option value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $jadwal->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div class="space-y-3">
                <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                    <i data-lucide="info" class="w-4 h-4 text-blue-500"></i> Catatan Tambahan (Opsional)
                </label>
                <textarea name="keterangan" rows="3" placeholder="Informasi tambahan terkait jadwal..." class="w-full neo-input py-4 px-5 font-bold text-sm resize-none">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-[var(--shadow-dark)]/10">
                <a href="{{ route('admin.jadwal.index') }}" class="neo-btn px-8 py-4 text-[10px] font-black text-[var(--text-secondary)] uppercase tracking-widest hover:text-rose-500 transition-all">
                    Batalkan Perubahan
                </a>
                <button type="submit" class="neo-btn px-10 py-4 text-[10px] font-black text-white bg-[var(--accent)] uppercase tracking-widest shadow-lg shadow-blue-500/30 hover:scale-105 transition-all">
                    SIMPAN PERUBAHAN JADWAL
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapelSelect = document.getElementById('mapelSelect');
        const mapelLainInput = document.getElementById('mapelLainInput');
        
        if(mapelSelect) {
            mapelSelect.addEventListener('change', function() {
                if(this.value === 'Lainnya') {
                    mapelLainInput.classList.remove('hidden');
                    mapelLainInput.setAttribute('name', 'mata_pelajaran');
                    mapelLainInput.setAttribute('required', 'required');
                    this.removeAttribute('name');
                } else {
                    mapelLainInput.classList.add('hidden');
                    mapelLainInput.removeAttribute('name');
                    mapelLainInput.removeAttribute('required');
                    this.setAttribute('name', 'mata_pelajaran');
                }
            });
        }
    });
</script>
@endpush
