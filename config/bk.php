<?php

/**
 * config/bk.php
 * Konfigurasi sistem BK — Deteksi Dini & Asesmen
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Tahun Ajaran & Semester Aktif
    |--------------------------------------------------------------------------
    */
    'tahun_ajaran_aktif' => env('BK_TAHUN_AJARAN', '2024/2025'),
    'semester_aktif'     => env('BK_SEMESTER', 'genap'),

    /*
    |--------------------------------------------------------------------------
    | Bank Pertanyaan Asesmen
    | format: ['teks' => '...', 'tipe' => 'radio|checkbox|skala', 'opsi' => [...], 'nilai_kunci' => '...']
    |--------------------------------------------------------------------------
    */
    'pertanyaan' => [

        // ─── Gaya Belajar (VAK) — 15 pertanyaan ───────────────────────────
        'gaya_belajar' => [
            ['teks' => 'Ketika belajar materi baru, saya lebih mudah mengerti jika...', 'tipe' => 'radio', 'opsi' => [
                'V' => 'Melihat diagram, gambar, atau video',
                'A' => 'Mendengarkan penjelasan langsung',
                'K' => 'Mencoba atau mempraktikkan langsung',
            ]],
            ['teks' => 'Saya lebih suka mengingat sesuatu dengan cara...', 'tipe' => 'radio', 'opsi' => [
                'V' => 'Membuat catatan / mind map berwarna',
                'A' => 'Mengulang-ulang secara lisan',
                'K' => 'Gerakan atau simulasi fisik',
            ]],
            ['teks' => 'Ketika membaca buku, saya...', 'tipe' => 'radio', 'opsi' => [
                'V' => 'Suka membayangkan visualisasinya',
                'A' => 'Lebih suka membaca dengan suara',
                'K' => 'Perlu duduk sambil bergerak / mencorat-coret',
            ]],
            ['teks' => 'Saya paling mudah bosan saat...', 'tipe' => 'radio', 'opsi' => [
                'V' => 'Tidak ada visual sama sekali (tulisan saja)',
                'A' => 'Suasana berisik / tidak bisa fokus mendengar',
                'K' => 'Harus duduk diam terlalu lama',
            ]],
            ['teks' => 'Cara favorit saya belajar bahasa baru adalah...', 'tipe' => 'radio', 'opsi' => [
                'V' => 'Flashcard dan label visual',
                'A' => 'Mendengarkan podcast / lagu',
                'K' => 'Langsung percakapan / praktik',
            ]],
        ],

        // ─── Minat & Bakat (Holland RIASEC) — 18 pertanyaan ───────────────
        'minat_bakat' => [
            ['teks' => 'Saya senang memperbaiki barang elektronik atau mesin', 'tipe' => 'radio', 'opsi' => ['R' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'R'],
            ['teks' => 'Saya suka membaca atau meneliti tentang topik ilmu pengetahuan', 'tipe' => 'radio', 'opsi' => ['I' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'I'],
            ['teks' => 'Saya menikmati kegiatan seni seperti melukis, musik, atau menulis kreatif', 'tipe' => 'radio', 'opsi' => ['A' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'A'],
            ['teks' => 'Saya suka membantu teman yang sedang punya masalah', 'tipe' => 'radio', 'opsi' => ['S' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'S'],
            ['teks' => 'Saya tertarik memimpin sebuah proyek atau tim', 'tipe' => 'radio', 'opsi' => ['E' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'E'],
            ['teks' => 'Saya teliti dan suka mengatur data atau administrasi', 'tipe' => 'radio', 'opsi' => ['C' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'C'],
            ['teks' => 'Saya suka kegiatan di alam terbuka atau olahraga', 'tipe' => 'radio', 'opsi' => ['R' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'R'],
            ['teks' => 'Saya ingin memahami cara kerja sesuatu secara mendalam', 'tipe' => 'radio', 'opsi' => ['I' => 'Ya', 'X' => 'Tidak'], 'nilai' => 'I'],
        ],

        // ─── Skrining Kesehatan Mental (SDQ-like) ─────────────────────────
        'kesehatan_mental' => [
            ['teks' => 'Saya sering merasa sedih atau murung tanpa alasan yang jelas', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak pernah', 'kadang' => 'Kadang-kadang', 'sering' => 'Sering', 'selalu' => 'Hampir selalu']],
            ['teks' => 'Saya sulit berkonsentrasi saat belajar atau mengerjakan tugas', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak pernah', 'kadang' => 'Kadang-kadang', 'sering' => 'Sering', 'selalu' => 'Hampir selalu']],
            ['teks' => 'Saya merasa cemas atau khawatir berlebihan tentang sesuatu', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak pernah', 'kadang' => 'Kadang-kadang', 'sering' => 'Sering', 'selalu' => 'Hampir selalu']],
            ['teks' => 'Saya punya setidaknya satu teman dekat yang bisa saya percaya', 'tipe' => 'radio', 'opsi' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
            ['teks' => 'Saya sering merasa tidak disukai atau tidak diterima teman', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak pernah', 'kadang' => 'Kadang-kadang', 'sering' => 'Sering', 'selalu' => 'Hampir selalu']],
            ['teks' => 'Saya pernah berpikir untuk menyakiti diri sendiri', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak', 'ya' => 'Pernah', 'sering' => 'Sering']],
            ['teks' => 'Saya merasa punya semangat dan energi untuk menjalani hari', 'tipe' => 'radio', 'opsi' => ['selalu' => 'Selalu', 'sering' => 'Sering', 'kadang' => 'Kadang-kadang', 'tidak' => 'Jarang/tidak pernah']],
            ['teks' => 'Saya merasa sulit tidur atau justru tidur berlebihan', 'tipe' => 'radio', 'opsi' => ['tidak' => 'Tidak', 'kadang' => 'Kadang-kadang', 'sering' => 'Sering', 'selalu' => 'Hampir selalu']],
        ],

        // ─── DCM — Daftar Cek Masalah ──────────────────────────────────────
        'masalah_umum' => [
            ['teks' => 'Nilai akademik saya menurun drastis', 'tipe' => 'checkbox'],
            ['teks' => 'Saya sering terlambat atau tidak masuk sekolah', 'tipe' => 'checkbox'],
            ['teks' => 'Ada konflik dengan teman atau terlibat perkelahian', 'tipe' => 'checkbox'],
            ['teks' => 'Saya merasa tidak cocok dengan jurusan/program studi saat ini', 'tipe' => 'checkbox'],
            ['teks' => 'Ada masalah keuangan di keluarga yang mempengaruhi sekolah saya', 'tipe' => 'checkbox'],
            ['teks' => 'Saya mengalami perundungan (bullying) fisik atau verbal', 'tipe' => 'checkbox'],
            ['teks' => 'Saya kesulitan mengatur waktu belajar dan bermain', 'tipe' => 'checkbox'],
            ['teks' => 'Hubungan saya dengan orang tua sedang tidak baik', 'tipe' => 'checkbox'],
            ['teks' => 'Saya merasa kecanduan gadget atau media sosial', 'tipe' => 'checkbox'],
            ['teks' => 'Saya belum punya gambaran karir atau masa depan yang jelas', 'tipe' => 'checkbox'],
            ['teks' => 'Saya merasa tertekan dengan ekspektasi orang tua', 'tipe' => 'checkbox'],
            ['teks' => 'Saya pernah bersentuhan dengan rokok, alkohol, atau zat berbahaya', 'tipe' => 'checkbox'],
        ],

        // ─── Sosiometri — pemetaan hubungan sosial ────────────────────────
        'sosiometri' => [
            ['teks' => 'Siapa 3 teman yang paling sering kamu ajak belajar bersama?', 'tipe' => 'teman_picker', 'maks' => 3],
            ['teks' => 'Siapa 3 teman yang paling kamu percaya untuk bercerita masalah?', 'tipe' => 'teman_picker', 'maks' => 3],
            ['teks' => 'Siapa teman yang menurutmu paling populer/disukai di kelas?', 'tipe' => 'teman_picker', 'maks' => 1],
            ['teks' => 'Apakah ada teman yang pernah membuatmu tidak nyaman?', 'tipe' => 'radio', 'opsi' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
            ['teks' => 'Bagaimana kamu mendeskripsikan peranmu di kelas?', 'tipe' => 'radio', 'opsi' => [
                'pemimpin'    => 'Pemimpin / penggerak kelompok',
                'pendukung'   => 'Pendukung / mengikuti arahan',
                'mandiri'     => 'Lebih suka bekerja mandiri',
                'pengamat'    => 'Pengamat / jarang terlibat',
            ]],
        ],
    ],
];
