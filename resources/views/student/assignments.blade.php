@extends('layouts.student')

@section('title', 'Tugas - Schoolify')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="font-outfit font-bold text-3xl text-[#2B3674] mb-2">Daftar Tugas</h1>
            <p class="text-[#A3AED0]">Selesaikan semua kewajiban akademismu tepat waktu.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('student.assignments', ['filter' => 'active']) }}" class="{{ request('filter', 'active') == 'active' ? 'bg-[#4318FF] text-white shadow-md shadow-indigo-100' : 'bg-white text-[#A3AED0] border border-gray-200 hover:bg-gray-50' }} px-4 py-2 rounded-xl text-sm font-bold transition">Sedang Aktif</a>
            <a href="{{ route('student.assignments', ['filter' => 'completed']) }}" class="{{ request('filter') == 'completed' ? 'bg-[#4318FF] text-white shadow-md shadow-indigo-100' : 'bg-white text-[#A3AED0] border border-gray-200 hover:bg-gray-50' }} px-4 py-2 rounded-xl text-sm font-bold transition">Selesai</a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-2">
        <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-2">
        <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
    </div>
    @endif

    @if($assignments->count() > 0)
        <div class="grid grid-cols-1 gap-4">
            @foreach($assignments as $assign)
            <div class="glass-card bg-white p-5 rounded-2xl border border-gray-100 hover:border-indigo-200 transition-colors shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 cursor-pointer group">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class='bx bx-book-bookmark'></i>
                    </div>
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-[#2B3674] group-hover:text-[#4318FF] transition">{{ $assign->title ?? 'Tugas Baru' }}</h3>
                        <p class="text-sm font-medium text-[#A3AED0]">{{ $assign->subject->name ?? 'Mata Pelajaran' }} • Diberikan bulan ini</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto">
                    <!-- Deadline Box -->
                    <div class="bg-red-50 border border-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1">
                        <i class='bx bx-time-five text-sm'></i> 
                        Tenggat: {{ $assign->due_date ? \Carbon\Carbon::parse($assign->due_date)->format('d M Y, H:i') : 'Segera' }}
                    </div>
                    @if(request('filter') == 'completed')
                        <button disabled class="w-full sm:w-auto bg-green-50 border border-green-200 text-green-600 px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm flex items-center justify-center gap-2">
                            <i class='bx bx-check'></i> Selesai
                        </button>
                    @else
                        <button onclick="openModal('{{ $assign->id }}', '{{ addslashes($assign->title) }}')" class="w-full sm:w-auto bg-white border border-gray-200 hover:bg-gray-50 text-[#2B3674] px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                            Kumpulkan Tugas
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-[24px] p-12 text-center bg-white border border-gray-100 mt-8">
            <div class="w-24 h-24 bg-green-50 text-green-500 mx-auto rounded-full flex items-center justify-center text-4xl mb-6">
                🎉
            </div>
            <h2 class="font-outfit font-bold text-2xl text-[#2B3674] mb-2">{{ request('filter') == 'completed' ? 'Belum Ada Tugas Selesai' : 'Tidak Ada Tugas Aktif!' }}</h2>
            <p class="text-[#A3AED0] max-w-md mx-auto">{{ request('filter') == 'completed' ? 'Ayo kerjakan tugas yang masih aktif.' : 'Selamat! Kamu sudah menyelesaikan semua tugas dari guru. Tetap pantau untuk update tugas baru.' }}</p>
        </div>
    @endif
</div>

<!-- Modal Container (Akan dipindahkan ke body) -->
<div id="modal-container" class="hidden fixed inset-0 z-[9999] bg-slate-900/40 backdrop-blur-sm items-center justify-center p-4">
    <div id="modal-content" class="bg-white rounded-3xl w-full max-w-lg shadow-2xl relative overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        
        <!-- Header -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 to-purple-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                    <i class='bx bx-cloud-upload text-white text-xl'></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Kumpulkan Tugas</h3>
                    <p id="modal-task-title" class="text-xs text-slate-500 font-medium truncate max-w-[200px]">Judul Tugas</p>
                </div>
            </div>
            <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 hover:border-rose-100 transition-all">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('student.assignment.submit') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="assignment_id" id="modal-assignment-id">
            
            <!-- File Upload -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Upload File Jawaban <span class="text-rose-500">*</span></label>
                <div class="relative group">
                    <input type="file" name="file" required id="file-upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                    <div class="w-full bg-slate-50 border-2 border-dashed border-slate-300 group-hover:border-indigo-400 group-hover:bg-indigo-50/30 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all">
                        <i class='bx bx-cloud-upload text-4xl text-slate-400 group-hover:text-indigo-500 mb-3 transition-colors'></i>
                        <p class="text-sm font-bold text-slate-700 mb-1" id="file-name">Klik untuk browse atau drag file</p>
                        <p class="text-xs text-slate-400 font-medium">Format didukung: PDF, DOCX, JPG, PNG (Max. 10MB)</p>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="3" placeholder="Tuliskan pesan untuk guru (misal: Maaf Pak, tulisan saya agak kurang rapi)..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-400 focus:bg-white outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all text-sm flex items-center justify-center gap-2">
                    <i class='bx bx-send'></i> Kirim Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Memindahkan modal ke root document.body agar position:fixed bekerja sempurna
    document.addEventListener('DOMContentLoaded', function() {
        const modalContainer = document.getElementById('modal-container');
        if (modalContainer && modalContainer.parentNode !== document.body) {
            document.body.appendChild(modalContainer);
        }
    });

    function openModal(id, title) {
        document.getElementById('modal-assignment-id').value = id;
        document.getElementById('modal-task-title').textContent = title;
        
        const modal = document.getElementById('modal-container');
        const content = document.getElementById('modal-content');
        
        // Reset form state
        document.getElementById('file-upload').value = '';
        document.getElementById('file-name').textContent = 'Klik untuk browse atau drag file';
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Animate in
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('modal-container');
        const content = document.getElementById('modal-content');
        
        // Animate out
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        // Hide after animation
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
    
    function updateFileName(input) {
        const fileNameElement = document.getElementById('file-name');
        if (input.files && input.files.length > 0) {
            fileNameElement.textContent = input.files[0].name;
            fileNameElement.classList.add('text-indigo-600');
        } else {
            fileNameElement.textContent = 'Klik untuk browse atau drag file';
            fileNameElement.classList.remove('text-indigo-600');
        }
    }
</script>
@endsection
