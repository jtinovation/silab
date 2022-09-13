create view vpenggantian_praktek as SELECT
a.id,
a.jadwal_asli,
a.jadwal_ganti,
a.acara_praktek,
a.tr_kaprodi_id,
a.tr_member_laboratorium_id,
b.tm_laboratorium_id,
b.tm_staff_id as `staff_laboratorium`,
a.created_at,
a.updated_at,
a.kode,
a.tr_matakuliah_semester_prodi_id,
a.tm_staff_id
from
	tr_penggantian_praktek a, tr_member_laboratorium b
where
	a.tr_member_laboratorium_id = b.id and b.is_aktif=1
