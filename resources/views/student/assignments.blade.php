@extends('layouts.student')
@section('title', 'Tugas - Schoolify')
@section('page_title', 'Tugas')

@section('content')
<div class="space-y-5">
    {{-- Tab switcher --}}
    <div style="display:inline-flex; background:rgba(255,255,255,0.7); backdrop-filter:blur(12px); border:1.5px solid rgba(255,255,255,0.9); padding:5px; border-radius:18px; gap:4px; box-shadow:0 2px 12px rgba(99,102,241,0.07);">
        <a href="{{ route('student.assignments', ['filter'=>'active']) }}" style="padding:10px 24px; border-radius:13px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s; {{ $filter==='active' ? 'background:white; color:#1e293b; box-shadow:0 2px 12px rgba(0,0,0,0.08);' : 'color:#94a3b8;' }}">Aktif</a>
        <a href="{{ route('student.assignments', ['filter'=>'completed']) }}" style="padding:10px 24px; border-radius:13px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s; {{ $filter==='completed' ? 'background:white; color:#1e293b; box-shadow:0 2px 12px rgba(0,0,0,0.08);' : 'color:#94a3b8;' }}">Selesai</a>
    </div>

    @if(session('success'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#ecfdf5; border:1.5px solid rgba(16,185,129,0.25); border-radius:16px; font-size:14px; font-weight:600; color:#065f46;">
        <div style="width:32px; height:32px; background:#10b981; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-check' style="color:white; font-size:18px;"></i></div>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="display:flex; align-items:center; gap:12px; padding:16px 20px; background:#fff1f2; border:1.5px solid rgba(239,68,68,0.25); border-radius:16px; font-size:14px; font-weight:600; color:#be123c;">
        <div style="width:32px; height:32px; background:#ef4444; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class='bx bx-x' style="color:white; font-size:18px;"></i></div>
        {{ session('error') }}
    </div>
    @endif

    @if($assignments->count() > 0)
    <div style="display:flex; flex-direction:column; gap:12px;">
        @foreach($assignments as $assign)
        @php
            $sub = $submittedIds->contains($assign->id);
            $late = $assign->due_date && $assign->due_date->isPast() && !$sub;
        @endphp
        <div class="glass-card" style="padding:22px 26px; display:flex; align-items:center; gap:18px; {{ $late ? 'border-color:rgba(239,68,68,0.25);' : '' }}" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            {{-- Icon --}}
            <div style="width:52px; height:52px; border-radius:18px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; {{ $sub ? 'background:rgba(16,185,129,0.1); color:#10b981;' : ($late ? 'background:rgba(239,68,68,0.1); color:#ef4444;' : 'background:rgba(99,102,241,0.1); color:#6366f1;') }}">
                <i class='bx {{ $sub ? 'bx-check-circle' : ($late ? 'bx-error' : 'bx-file') }}'></i>
            </div>
            {{-- Info --}}
            <div style="flex:1; min-width:0;">
                <h3 style="font-size:16px; font-weight:700; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:4px;">{{ $assign->title ?? 'Tugas' }}</h3>
                <p style="font-size:13px; color:#64748b; font-weight:500;">{{ $assign->subject->name ?? '-' }}{{ $assign->teacher ? ' · ' . $assign->teacher->name : '' }}</p>
                @if($assign->description)
                <p style="font-size:12px; color:#94a3b8; margin-top:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $assign->description }}</p>
                @endif
            </div>
            {{-- Action --}}
            <div style="flex-shrink:0; display:flex; align-items:center; gap:12px;">
                @if($sub)
                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#059669; background:#ecfdf5; border:1.5px solid rgba(5,150,105,0.2); padding:8px 16px; border-radius:12px;">
                        <i class='bx bx-check'></i> Dikumpulkan
                    </span>
                @elseif($late)
                    <span style="font-size:12px; font-weight:700; color:#ef4444;">Lewat deadline</span>
                    <button onclick="openModal({{ $assign->id }}, '{{ addslashes($assign->title) }}')" style="background:linear-gradient(135deg,#f87171,#ef4444); color:white; border:none; border-radius:12px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(239,68,68,0.3); transition:all 0.2s; font-family:inherit;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Kumpulkan</button>
                @else
                    <span style="font-size:12px; font-weight:600; color:#94a3b8;">{{ $assign->due_date ? $assign->due_date->format('d M, H:i') : '-' }}</span>
                    <button onclick="openModal({{ $assign->id }}, '{{ addslashes($assign->title) }}')" class="btn-primary" style="padding:10px 20px; font-size:13px;">
                        <i class='bx bx-upload'></i> Kumpulkan
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="glass-card" style="padding:80px; text-align:center; max-width:440px; margin:40px auto;">
        @if($filter === 'completed')
        <div style="font-size:48px; margin-bottom:16px; opacity:0.4;">📂</div>
        <h2 style="font-size:20px; font-weight:800; color:#1e293b; margin-bottom:8px;">Belum Ada Tugas Dikumpulkan</h2>
        <p style="font-size:14px; color:#94a3b8; line-height:1.6;">Kerjakan tugasmu dari tab "Aktif"</p>
        @else
        <div style="font-size:48px; margin-bottom:16px; opacity:0.6;">🎉</div>
        <h2 style="font-size:20px; font-weight:800; color:#1e293b; margin-bottom:8px;">Semua Tugas Selesai!</h2>
        <p style="font-size:14px; color:#94a3b8; line-height:1.6;">Tetap pantau update tugas baru dari guru.</p>
        @endif
    </div>
    @endif
</div>

{{-- Modal --}}
<div id="submit-modal" style="display:none; position:fixed; inset:0; background:rgba(241,245,249,0.7); backdrop-filter:blur(16px); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="width:100%; max-width:440px; background:white; border-radius:32px; box-shadow:0 20px 40px rgba(0,0,0,0.08); display:flex; flex-direction:column; max-height:calc(100vh - 40px); overflow:hidden; border:1px solid rgba(226,232,240,0.6);">
        <div style="padding:24px 32px; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
            <h3 style="font-size:20px; font-weight:800; color:#0f172a;">Kumpulkan Tugas</h3>
            <button onclick="closeModal()" style="width:36px; height:36px; border-radius:12px; background:#f8fafc; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s; color:#64748b;" onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b';"><i class='bx bx-x' style="font-size:24px;"></i></button>
        </div>
        <form action="{{ route('student.assignment.submit') }}" method="POST" enctype="multipart/form-data" style="padding:0 32px 32px 32px; display:flex; flex-direction:column; gap:24px; overflow-y:auto;">
            @csrf
            <input type="hidden" name="assignment_id" id="modal-assign-id">
            
            <div style="background:#f8fafc; border-radius:20px; padding:16px 20px;">
                <p style="font-size:12px; font-weight:700; color:#64748b; margin-bottom:4px;">Tugas yang dipilih:</p>
                <p style="font-size:15px; font-weight:800; color:#0f172a; line-height:1.4;" id="modal-assign-title"></p>
            </div>
            
            <div>
                <label style="display:block; font-size:13px; font-weight:700; color:#334155; margin-bottom:10px;">File Tugas</label>
                <div style="border:2px dashed #cbd5e1; border-radius:24px; padding:32px; text-align:center; cursor:pointer; transition:all 0.2s; background:#f8fafc;" onclick="document.getElementById('file-input').click()" onmouseover="this.style.borderColor='#6366f1'; this.style.background='#eef2ff';" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc';">
                    <div style="width:56px; height:56px; background:white; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; box-shadow:0 4px 12px rgba(0,0,0,0.03);"><i class='bx bx-cloud-upload' style="font-size:28px; color:#6366f1;"></i></div>
                    <p style="font-size:14px; color:#334155; font-weight:700; margin-bottom:4px;" id="file-label">Pilih file untuk diupload</p>
                    <p style="font-size:12px; color:#94a3b8; font-weight:500;">Max 10MB (PDF, DOC, ZIP, JPG)</p>
                    <input type="file" id="file-input" name="file" style="display:none;" accept=".pdf,.doc,.docx,.zip,.rar,.jpg,.png" onchange="updateLabel(this)">
                </div>
            </div>
            
            <div>
                <label style="display:block; font-size:13px; font-weight:700; color:#334155; margin-bottom:10px;">Catatan Tambahan</label>
                <textarea name="notes" rows="3" placeholder="Tambahkan pesan untuk guru jika ada..." style="width:100%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:20px; padding:16px 20px; font-size:14px; color:#0f172a; outline:none; resize:none; font-family:inherit; transition:all 0.2s;" onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; box-shadow='0 0 0 4px rgba(99,102,241,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; box-shadow='none';"></textarea>
            </div>
            
            <button type="submit" style="width:100%; background:#0f172a; color:white; border:none; border-radius:20px; padding:18px; font-size:15px; font-weight:800; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(15,23,42,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class='bx bx-send' style="font-size:18px;"></i> Kirim Sekarang
            </button>
        </form>
    </div>
</div>

<script>
function openModal(id, title) { 
    document.getElementById('modal-assign-id').value = id; 
    document.getElementById('modal-assign-title').textContent = title; 
    document.getElementById('file-input').value = ''; 
    document.getElementById('file-label').textContent = 'Pilih file untuk diupload'; 
    document.getElementById('submit-modal').style.display = 'flex'; 
    document.body.style.overflow = 'hidden';
}
function closeModal() { 
    document.getElementById('submit-modal').style.display = 'none'; 
    document.body.style.overflow = '';
}
function updateLabel(input) { 
    if (input.files[0]) { 
        document.getElementById('file-label').textContent = input.files[0].name; 
        document.getElementById('file-label').style.color = '#6366f1';
    } 
}
document.getElementById('submit-modal').addEventListener('click', function(e) { 
    if (e.target === this) closeModal(); 
});
</script>
@endsection
