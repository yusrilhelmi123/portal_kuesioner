USE kuisioner_pm;

-- Seed VARK Questions (Sample)
INSERT INTO vark_questions (teks_pertanyaan, opt_v, opt_a, opt_r, opt_k) VALUES
('Anda sedang membangun sebuah model untuk menunjukkan kepada orang lain. Anda akan:', 'Membuat diagram yang menunjukkan struktur dan hubungannya.', 'Menjelaskan model tersebut secara lisan.', 'Menulis deskripsi tertulis tentang bagaimana model itu bekerja.', 'Mulai merakit bagian-bagian model tersebut.'),
('Anda ingin mempelajari program perangkat komputer baru. Anda akan:', 'Melihat tangkapan layar (screenshots) di buku panduan.', 'Bertanya kepada orang lain tentang program tersebut.', 'Membaca petunjuk tertulis yang menyertai program.', 'Langsung mencoba menggunakan program tersebut.');

-- Seed MSLQ Questions (Sample - Motivation Dimension)
INSERT INTO mslq_questions (teks_pertanyaan, dimensi) VALUES
('Dalam kelas seperti ini, saya lebih suka materi yang benar-benar menantang sehingga saya bisa mempelajari hal-hal baru.', 'Intrinsic Value'),
('Jika saya belajar dengan cara yang benar, saya akan mampu mempelajari materi dalam kursus ini.', 'Control Beliefs'),
('Saya yakin saya bisa memahami materi yang paling sulit yang disajikan dalam bacaan untuk kursus ini.', 'Self-Efficacy');

-- Seed AMS Questions (Sample)
INSERT INTO ams_questions (teks_pertanyaan, kategori) VALUES
('Karena saya mendapatkan kesenangan dan kepuasan saat mempelajari hal-hal baru.', 'intrinsic'),
('Karena saya pikir pendidikan tinggi akan mempersiapkan saya lebih baik untuk karier yang saya pilih.', 'extrinsic'),
('Karena saya ingin membuktikan kepada diri sendiri bahwa saya bisa sukses dalam studi saya.', 'achievement'),
('Saya tidak tahu; saya merasa bahwa saya tidak mampu sukses dalam belajar.', 'amotivation');
