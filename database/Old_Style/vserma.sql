
CREATE VIEW `silab`.`v_serma` AS
SELECT
a.id,
a.kode,
a.tr_matakuliah_dosen_id,
d.`tr_matakuliah_semester_prodi_id`,
d.`tm_staff_id` AS `pengampu`,
a.tr_member_laboratorium_id,
b.tm_laboratorium_id
FROM
	tr_serma_hasil_sisa_praktek a, tr_member_laboratorium b, tr_matakuliah_dosen d
WHERE
	a.tr_member_laboratorium_id = b.id
AND
	a.`tr_matakuliah_dosen_id` = d.id
