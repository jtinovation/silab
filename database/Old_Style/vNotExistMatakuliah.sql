create View vNotExistMK as SELECT
a.id AS tm_tahun_ajaran_id,
a.tahun_ajaran,
a.is_genap,
a.is_aktif,
b.id AS tm_semester_id,
b.semester,
c.id AS tr_matakuliah_semester_prodi_id,
c.tm_program_studi_id,
c.tm_matakuliah_id,
e.matakuliah,
e.kode,
c.jumlah_golongan,
d.id AS tr_matakuliah_dosen_id,
d.tm_staff_id,
f.nama
FROM
tm_tahun_ajaran a, tm_semester b, tr_matakuliah_semester_prodi c, tr_matakuliah_dosen d, tm_matakuliah e, tm_staff f
WHERE
a.id = b.tm_tahun_ajaran_id AND b.id = c.tm_semester_id AND c.id = d.tr_matakuliah_semester_prodi_id AND a.is_aktif = 0 AND c.tm_matakuliah_id=e.id AND d.tm_staff_id = f.id
