SELECT
a.id,
a.tm_laboratorium_id,
b.kode,
b.laboratorium,
b.tm_jurusan_id,
a.tm_barang_id,
c.nama_barang,
c.spesifikasi,
c.keterangan,
c.tm_satuan_id,
e.satuan,
c.tm_jenis_barang_id,
d.jenis_barang,
c.kode_barang,
FROM
	tr_barang_laboratorium a, tm_laboratorium b, tm_barang c, tm_jenis_barang d, tm_satuan e
where
	a.tm_laboratorium_id = b.id
and a.tm_barang_id = c.id
and c.tm_jenis_barang_id = d.id
and c.tm_satuan_id = e.id
