@extends('layouts.admin')
@section('title', 'Tambah Jadwal Massal - Schoolify Admin')
@section('page-title', 'Tambah Jadwal Mingguan')

@section('content')
<div class="max-w-6xl mx-auto animate-fadeInUp">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[1.5rem] bg-indigo-500/10 text-indigo-600 flex items-center justify-center shadow-inner">
                <i data-lucide="calendar-range" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="font-outfit font-black text-2xl text-[var(--text-primary)]">Input Jadwal Mingguan</h3>
                <p class="text-xs text-[var(--text-secondary)] font-bold uppercase tracking-widest">Input Massal (Grid Form)</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.jadwal.index') }}" class="neo-btn px-6 py-3 rounded-2xl text-[var(--text-secondary)] hover:text-rose-500 flex items-center gap-2 transition-all group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-sm font-black">KEMBALI</span>
            </a>
            <!-- Tombol Import Excel (Akan dikerjakan di fase 2) -->
            <button onclick="alert('Fitur Import Excel akan segera ditambahkan di Fase 2!')" class="neo-btn px-6 py-3 rounded-2xl text-[var(--text-secondary)] hover:text-green-600 flex items-center gap-2 transition-all group">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                <span class="text-sm font-black">IMPORT EXCEL</span>
            </button>
        </div>
    </div>

    <form action="{{ route('admin.jadwal.store-bulk') }}" method="POST" id="bulkScheduleForm">
        @csrf
        
        <!-- PENGATURAN UMUM KELAS -->
        <div class="neo-flat rounded-[2.5rem] overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 px-8 py-6 border-b border-[var(--shadow-dark)]/5">
                <div class="flex items-center gap-3">
                    <i data-lucide="settings-2" class="w-5 h-5 text-indigo-500"></i>
                    <h4 class="font-black text-sm text-[var(--text-primary)] uppercase tracking-wider">Pilih Kelas & Periode</h4>
                </div>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="door-open" class="w-4 h-4 text-indigo-500"></i> Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="school_class_id" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="layers" class="w-4 h-4 text-indigo-500"></i> Semester <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-4 p-2 neo-pressed rounded-2xl">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="semester" value="1" class="sr-only peer" checked>
                            <div class="py-2.5 text-center rounded-xl text-[10px] font-black uppercase tracking-widest peer-checked:bg-[var(--accent)] peer-checked:text-white peer-checked:shadow-md transition-all text-[var(--text-muted)]">GANJIL (1)</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="semester" value="2" class="sr-only peer">
                            <div class="py-2.5 text-center rounded-xl text-[10px] font-black uppercase tracking-widest peer-checked:bg-[var(--accent)] peer-checked:text-white peer-checked:shadow-md transition-all text-[var(--text-muted)]">GENAP (2)</div>
                        </label>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-2 text-xs font-black text-[var(--text-secondary)] uppercase tracking-widest ml-1">
                        <i data-lucide="calendar-check" class="w-4 h-4 text-indigo-500"></i> Tahun Ajaran <span class="text-rose-500">*</span>
                    </label>
                    <select name="tahun_ajaran" class="w-full neo-input py-3.5 px-5 font-bold text-sm appearance-none cursor-pointer" required>
                        @foreach($tahunAjaranOptions ?? [] as $ta)
                        <option value="{{ $ta }}" {{ $loop->first ? 'selected' : '' }}>{{ $ta }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- GRID JADWAL MINGGUAN -->
        <div class="neo-flat rounded-[2.5rem] overflow-hidden mb-8 p-8">
            <h4 class="font-black text-lg text-[var(--text-primary)] mb-6">Susunan Jadwal Per Hari</h4>
            
            <div id="daysContainer" class="space-y-6">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                <div class="neo-pressed rounded-2xl p-6 relative">
                    <h5 class="font-outfit font-bold text-lg text-indigo-600 mb-4 flex items-center gap-2">
                        <i data-lucide="calendar-days" class="w-5 h-5"></i> Hari {{ $hari }}
                    </h5>
                    
                    <div class="schedule-rows-container space-y-4" id="container-{{ $hari }}">
                        <!-- Baris akan di-generate via JS -->
                    </div>
                    
                    <button type="button" onclick="addRow('{{ $hari }}')" class="mt-4 neo-btn px-4 py-2 text-xs font-black text-indigo-600 hover:text-indigo-800 transition-all flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i> TAMBAH JAM PELAJARAN
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ACTION BUTTON -->
        <div class="flex justify-end gap-4">
            <button type="submit" class="neo-btn px-10 py-5 text-sm font-black text-white bg-[var(--accent)] uppercase tracking-widest shadow-lg shadow-blue-500/30 hover:scale-105 transition-all w-full md:w-auto text-center rounded-2xl">
                SIMPAN SEMUA JADWAL
            </button>
        </div>
    </form>
</div>

<!-- Template Baris (Hidden) -->
<template id="rowTemplate">
    <div class="schedule-row grid grid-cols-1 md:grid-cols-12 gap-3 items-start neo-flat p-4 rounded-xl relative group">
        <input type="hidden" name="jadwal[__INDEX__][hari]" value="__HARI__">
        
        <div class="col-span-2">
            <label class="block text-[10px] font-black text-[var(--text-secondary)] mb-1">JAM MULAI</label>
            <input type="time" name="jadwal[__INDEX__][jam_mulai]" class="w-full neo-input py-2 px-3 text-xs font-bold" required>
        </div>
        <div class="col-span-2">
            <label class="block text-[10px] font-black text-[var(--text-secondary)] mb-1">JAM SELESAI</label>
            <input type="time" name="jadwal[__INDEX__][jam_selesai]" class="w-full neo-input py-2 px-3 text-xs font-bold" required>
        </div>
        <div class="col-span-3">
            <label class="block text-[10px] font-black text-[var(--text-secondary)] mb-1">MATA PELAJARAN</label>
            <select name="jadwal[__INDEX__][mata_pelajaran]" class="w-full neo-input py-2 px-3 text-xs font-bold" required>
                <option value="">Pilih Mapel</option>
                @foreach($mapel ?? [] as $m)
                <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-[10px] font-black text-[var(--text-secondary)] mb-1">GURU PENGAMPU</label>
            <select name="jadwal[__INDEX__][guru_id]" class="w-full neo-input py-2 px-3 text-xs font-bold" required>
                <option value="">Pilih Guru</option>
                @foreach($teachers ?? [] as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-1">
            <label class="block text-[10px] font-black text-[var(--text-secondary)] mb-1">RUANG</label>
            <input type="text" name="jadwal[__INDEX__][ruangan]" placeholder="-" class="w-full neo-input py-2 px-3 text-xs font-bold text-center">
        </div>
        <div class="col-span-1 flex items-end justify-center h-full">
            <button type="button" onclick="this.closest('.schedule-row').remove()" class="text-rose-400 hover:text-rose-600 p-2 opacity-50 group-hover:opacity-100 transition-opacity" title="Hapus Baris">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let globalIndex = 0;

    function addRow(hari) {
        const container = document.getElementById('container-' + hari);
        const template = document.getElementById('rowTemplate').innerHTML;
        
        // Buat ID index unique untuk name attribute
        const html = template.replace(/__INDEX__/g, globalIndex).replace(/__HARI__/g, hari);
        
        container.insertAdjacentHTML('beforeend', html);
        globalIndex++;
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Tambahkan 1 baris default untuk Senin saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        addRow('Senin');
    });

    // Form submission validation
    document.getElementById('bulkScheduleForm').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('.schedule-row');
        if(rows.length === 0) {
            e.preventDefault();
            alert('Silakan tambahkan setidaknya satu jadwal mata pelajaran!');
        }
    });
</script>
@endpush
