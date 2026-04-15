@extends('layouts.guru')

@section('page_title', 'Pengumuman')
@section('page_subtitle', 'Buat dan kelola pengumuman untuk siswa.')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Form Buat Pengumuman -->
    <div class="col-span-12 lg:col-span-5">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4 bg-gradient-to-r from-indigo-50/50 to-purple-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i data-lucide="megaphone" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Buat Pengumuman</h3>
                        <p class="text-xs text-slate-400">Informasi penting untuk siswa</p>
                    </div>
                </div>
            </div>
            
            <form class="p-5 space-y-4">
                <!-- Judul -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Judul Pengumuman <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           placeholder="Contoh: Ujian Tengah Semester Genap 2026" 
                           class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all">
                </div>

                <!-- Isi Pengumuman -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Isi Pengumuman <span class="text-rose-500">*</span>
                    </label>
                    <textarea rows="4" 
                              placeholder="Tulis detail pengumuman di sini..." 
                              class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all resize-none"></textarea>
                </div>

                <!-- Kirim Ke -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">
                        Kirim Ke <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border cursor-pointer transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50">
                            <input type="radio" name="target" value="single_class" class="w-3.5 h-3.5 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-indigo-500"></i>
                                    <span class="text-sm font-medium text-slate-700">Satu Kelas</span>
                                </div>
                                <p class="text-[10px] text-slate-400">Kirim ke satu kelas</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-2 p-2.5 rounded-lg border cursor-pointer transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50">
                            <input type="radio" name="target" value="all_classes" class="w-3.5 h-3.5 text-indigo-600 focus:ring-indigo-500" checked>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="layers" class="w-3.5 h-3.5 text-indigo-500"></i>
                                    <span class="text-sm font-medium text-slate-700">Semua Kelas</span>
                                </div>
                                <p class="text-[10px] text-slate-400">Kirim ke semua kelas</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Pilih Kelas -->
                <div id="singleClassSelect" class="hidden">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Pilih Kelas</label>
                    <select class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 bg-white">
                        <option value="">Pilih kelas...</option>
                        <option>10 - IPA 1</option>
                        <option>10 - IPA 2</option>
                        <option>10 - IPS 1</option>
                        <option>11 - IPA 1</option>
                        <option>11 - IPA 2</option>
                        <option>11 - IPS 1</option>
                        <option>12 - IPA 1</option>
                        <option>12 - IPS 1</option>
                    </select>
                </div>

                <!-- Lampiran -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">
                        Lampiran <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-3 text-center hover:border-indigo-400 transition-all cursor-pointer">
                        <input type="file" class="hidden" id="fileInput" multiple>
                        <label for="fileInput" class="cursor-pointer block">
                            <i data-lucide="paperclip" class="w-5 h-5 text-slate-400 mx-auto mb-1"></i>
                            <p class="text-xs text-slate-500">Klik untuk upload file</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">PDF, DOC, JPG (Max 5MB)</p>
                        </label>
                    </div>
                    <div id="fileList" class="mt-2 space-y-1"></div>
                </div>

                <!-- Tombol -->
                <div class="flex gap-2 pt-3">
                    <button type="reset" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-slate-500 text-sm font-medium hover:bg-slate-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition-all shadow-sm flex items-center justify-center gap-1.5">
                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="col-span-12 lg:col-span-7">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="border-b border-slate-100 px-5 py-3.5 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800">Riwayat Pengumuman</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Pengumuman yang telah dikirim</p>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="pl-8 pr-3 py-1.5 rounded-lg border border-slate-200 text-xs w-40 focus:ring-2 focus:ring-indigo-400">
                    <i data-lucide="search" class="absolute left-2.5 top-2 w-3.5 h-3.5 text-slate-400"></i>
                </div>
            </div>
            
            <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto">
                @php
                    $pengumuman = [
                        [
                            'judul' => 'Ujian Tengah Semester Genap 2026',
                            'isi' => 'UTS akan dilaksanakan pada tanggal 15-20 Maret 2026. Harap mempersiapkan diri dengan baik.',
                            'target' => 'Semua Kelas',
                            'tanggal' => '2026-03-01',
                            'status' => 'Terkirim',
                            'lampiran' => true
                        ],
                        [
                            'judul' => 'Peringatan Hari Pendidikan Nasional',
                            'isi' => 'Upacara bendera dalam rangka Hardiknas akan dilaksanakan hari Senin, 2 Mei 2026.',
                            'target' => 'Semua Kelas',
                            'tanggal' => '2026-04-28',
                            'status' => 'Terkirim',
                            'lampiran' => false
                        ],
                        [
                            'judul' => 'Remedial Matematika Kelas 10',
                            'isi' => 'Remedial akan dilaksanakan hari Sabtu, 10 Mei 2026 di Ruang 01.',
                            'target' => '10 - IPA 1, 10 - IPA 2',
                            'tanggal' => '2026-05-05',
                            'status' => 'Draft',
                            'lampiran' => true
                        ],
                        [
                            'judul' => 'Libur Isra Miraj',
                            'isi' => 'Libur sekolah dalam rangka Isra Miraj pada tanggal 27 Februari 2026.',
                            'target' => 'Semua Kelas',
                            'tanggal' => '2026-02-20',
                            'status' => 'Terkirim',
                            'lampiran' => false
                        ],
                        [
                            'judul' => 'Pendaftaran Ekstrakurikuler',
                            'isi' => 'Pendaftaran ekskul dibuka mulai 1-10 Maret 2026.',
                            'target' => 'Semua Kelas',
                            'tanggal' => '2026-02-25',
                            'status' => 'Terkirim',
                            'lampiran' => true
                        ],
                    ];
                @endphp
                
                @foreach($pengumuman as $index => $item)
                <div class="p-4 hover:bg-slate-50/80 transition-all cursor-pointer group">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                <h4 class="font-semibold text-sm text-slate-800 group-hover:text-indigo-600 transition-colors truncate">
                                    {{ $item['judul'] }}
                                </h4>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded {{ $item['status'] == 'Terkirim' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $item['status'] }}
                                </span>
                                @if($item['lampiran'])
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-500 flex items-center gap-0.5">
                                    <i data-lucide="paperclip" class="w-2.5 h-2.5"></i>
                                </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 mb-2 line-clamp-2">{{ $item['isi'] }}</p>
                            <div class="flex flex-wrap items-center gap-3 text-[10px] text-slate-400">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="target" class="w-3 h-3"></i>
                                    {{ $item['target'] }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ date('d M Y', strtotime($item['tanggal'])) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all">
                            <button class="p-1.5 rounded-lg text-indigo-500 hover:bg-indigo-50 transition-colors" title="Edit">
                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                            </button>
                            <button class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors" title="Hapus">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                            <button class="p-1.5 rounded-lg text-emerald-500 hover:bg-emerald-50 transition-colors" title="Kirim Ulang">
                                <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="border-t border-slate-100 px-5 py-3 bg-slate-50/50 flex justify-between items-center">
                <p class="text-[11px] text-slate-400">Menampilkan 5 dari 12</p>
                <div class="flex gap-1">
                    <button class="px-2 py-1 rounded-lg border border-slate-200 text-slate-400 text-xs hover:bg-white transition-all disabled:opacity-50" disabled>
                        <i data-lucide="chevron-left" class="w-3 h-3"></i>
                    </button>
                    <button class="w-6 h-6 rounded-lg bg-indigo-600 text-white text-xs">1</button>
                    <button class="w-6 h-6 rounded-lg border border-slate-200 text-slate-500 text-xs hover:bg-white transition-all">2</button>
                    <button class="w-6 h-6 rounded-lg border border-slate-200 text-slate-500 text-xs hover:bg-white transition-all">3</button>
                    <button class="px-2 py-1 rounded-lg border border-slate-200 text-slate-400 text-xs hover:bg-white transition-all">
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
    
    // Toggle class select untuk Satu Kelas vs Semua Kelas
    const radioSingle = document.querySelector('input[value="single_class"]');
    const radioAll = document.querySelector('input[value="all_classes"]');
    const singleClassDiv = document.getElementById('singleClassSelect');
    
    function toggleClassSelect() {
        if (radioSingle.checked) {
            singleClassDiv.classList.remove('hidden');
        } else {
            singleClassDiv.classList.add('hidden');
        }
    }
    
    if (radioSingle && radioAll) {
        radioSingle.addEventListener('change', toggleClassSelect);
        radioAll.addEventListener('change', toggleClassSelect);
    }
    
    // File upload preview
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            fileList.innerHTML = '';
            const files = Array.from(e.target.files);
            files.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-1.5 bg-slate-50 rounded-lg text-xs';
                fileItem.innerHTML = `
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="file" class="w-3.5 h-3.5 text-indigo-500"></i>
                        <span class="text-slate-600">${file.name}</span>
                        <span class="text-[10px] text-slate-400">(${(file.size / 1024).toFixed(1)} KB)</span>
                    </div>
                    <button type="button" class="text-rose-400 hover:text-rose-600 remove-file">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </button>
                `;
                fileList.appendChild(fileItem);
            });
            lucide.createIcons();
            
            document.querySelectorAll('.remove-file').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('div').remove();
                });
            });
        });
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection