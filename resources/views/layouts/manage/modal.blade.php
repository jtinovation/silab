{{-- USULAN ALAT --}}
<div id="ShowUsulanAlat" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel">DAFTAR USULAN KEBUTUHAN BAHAN PRAKTEK</h5>
                <div class="row col-lg-12 col-md-12 mt-3 mb-3">
                    <div class="col-xl-4 col-lg-6 col-md-12 row">
                        <div class="col-lg-12 col-md-12 row">
                            <div class="col-lg-4 col-6">MATAKULIAH</div>
                            <div class="col-lg-8 col-6" id="dtMK">test</div>
                        </div>
                        <div class="col-lg-12 col-md-12 row">
                            <div class="col-lg-4 col-6">SEMESTER</div>
                            <div class="col-lg-8 col-6" id="dtSmstr"></div>
                        </div>
                    </div>

                    <div class="col-xl-5 col-lg-6 col-md-12 row">
                        <div class="col-lg-12 col-md-12 row">
                            <div class="col-lg-4 col-6">PROGRAM STUDI</div>
                            <div class="col-lg-8 col-6" id="dtProdi"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 row">
                            <div class="col-lg-4 col-6">JURUSAN</div>
                            <div class="col-lg-8 col-6" id="dtJrsn"></div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-12 row">
                        <div class="col-lg-12 col-md-12 row">
                            <div class="col-lg-8 col-8">TAHUN AKADEMIK</div>
                            <div class="col-lg-4 col-4" id="dtAkademik"></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="tableDetailUsulan" class="table align-middle mb-0" width="100%">
                                <thead class="table-light">
                                    <tr>
                                        <th>Minggu Ke</th>
                                        <th>Tanggal</th>
                                        <th>Acara Praktek</th>
                                        <th>Nama Barang</th>
                                        <th>Spesifikasi</th>
                                        <th>Keb/Kel</th>
                                        <th>Jml Kel</th>
                                        <th>Jml Gol</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Buttons with Label -->
                <button type="button" class="btn btn-primary btn-label waves-effect waves-light mdlPrint" data-href=""><i class="ri-printer-fill label-icon align-middle fs-16 me-2"></i> <span> Cetak </span> </button>
                <button type="button" class="btn btn-success btn-label waves-effect waves-light mdlEdit" data-href=""><i class="ri-edit-2-line label-icon align-middle fs-16 me-2"></i> <span>Ubah</span> </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@if($data['npage'] == 83)
{{-- ADD ALAT --}}
@can('inventaris-alat-create')
<div id="ShowAddAlatlab" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel" >TAMBAH DATA ALAT LABORATORIUM</h5>
                <h5 class="modal-title text-center mdlHeaderTitle" id="myModalLabel" ></h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon "></i><strong>Form Tambah Alat</strong>
                        </div>
                        <div class="wrap-alat-to-lab">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectAlat" class="form-label text-right">Pilih Alat </label></br>
                                        <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" id="selectAlat" required>
                                            <option value="">Pilih Alat Laboratorium</option>
                                        </select>
                                    </div>
                                    <small>alat belum terdaftar? <a href="#"><span class="addMode"><strong>Tambahkan Data Alat</strong></span> </a></small>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="jmlh" class="form-label text-right">Jumlah</label></br>
                                        <input type="text" class="form-control number" name="jumlah" id="jmlh" required>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-4">
                                    <button type="button" id="btnAlatLab" class="ol-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Alat Laboratorium</button>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-master-alat" style="display: none;">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="barang" class="form-label">Barang</label>
                                    <input class="form-control" type="text" value="" id="barang" name="nama_barang" placeholder="Masukan Barang" required="" style=" text-transform: capitalize;">
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="satuanDefault" class="form-label">Satuan</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_satuan_id" id="satuanDefault">
                                        <option value="">Pilih Satuan</option>
                                    </select>
                                </div>

                                <div class="col-xxl-4 col-md-12 mt-1">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                                </div>
                                @can('inventaris-alat-create')
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 row d-flex mt-2">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnMasterAlat" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Data Alat</button>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnCancel" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Batal Input Data</button>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #e2e5ed;">
               <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endcan

@can('inventaris-alat-edit')
<div id="ShowEditAlatlab" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel" >UBAH DATA ALAT LABORATORIUM</h5>
                <h5 class="modal-title text-center mdlHeaderTitle" id="myModalLabel" ></h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon "></i><strong>Form ubah stok Alat</strong>
                        </div>
                        <div class="wrap-ubah-alat">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectAlat" class="form-label text-right">Pilih Alat </label></br>
                                        <input type="text" class="form-control" name="nama_barang" id="nmbrg" readonly>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="jmlh" class="form-label text-right">Jumlah</label></br>
                                        <input type="text" class="form-control number" name="jumlah" id="jmlhubah" required>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-4">
                                    <button type="button" id="btnAlatLabUpdate" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Ubah Alat Laboratorium</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #e2e5ed;">
               <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endcan

@endif
@if($data['npage'] == 86)
{{-- ADD ALAT --}}
@can('inventaris-bahan-create')
<div id="ShowAddBahanlab" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel" >TAMBAH DATA BAHAN LABORATORIUM</h5>
                <h5 class="modal-title text-center mdlHeaderTitle" id="myModalLabel" ></h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon "></i><strong>Form Tambah Bahan</strong>
                        </div>
                        <div class="wrap-bahan-to-lab">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectBahan" class="form-label text-right">Pilih Bahan </label></br>
                                        <select class="form-control select2_el first" style="font-size: 15px;" name="barang[]" id="selectBahan" required>
                                            <option value="">Pilih Bahan Laboratorium</option>
                                        </select>
                                    </div>
                                    <small>bahan belum terdaftar? <a href="#"><span class="addMode"><strong>Tambahkan Data Bahan</strong></span> </a></small>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="jmlh" class="form-label text-right">Jumlah</label></br>
                                        <input type="text" class="form-control number" name="jumlah" id="jmlh" value="0" required>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-4">
                                    <button type="button" id="btnBahanLab" class="ol-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Alat Laboratorium</button>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-master-alat" style="display: none;">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="barang" class="form-label">Barang</label>
                                    <input class="form-control" type="text" value="" id="barang" name="nama_barang" placeholder="Masukan Barang" required="" style=" text-transform: capitalize;">
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="satuanDefault" class="form-label">Satuan</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_satuan_id" id="satuanDefault">
                                        <option value="">Pilih Satuan</option>
                                    </select>
                                </div>

                                <div class="col-xxl-4 col-md-12 mt-1">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                                </div>
                                @can('inventaris-alat-create')
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 row d-flex mt-2">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnMasterAlat" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Data Alat</button>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnCancel" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Batal Input Data</button>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #e2e5ed;">
               <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endcan

@can('inventaris-bahan-edit')
<div id="ShowEditBahanlab" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel" >UBAH DATA Bahan LABORATORIUM</h5>
                <h5 class="modal-title text-center mdlHeaderTitle" id="myModalLabel" ></h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon "></i><strong>Form ubah stok Bahan</strong>
                        </div>
                        <div class="wrap-ubah-Bahan">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectBahan" class="form-label text-right">Pilih Bahan </label></br>
                                        <input type="text" class="form-control" name="nama_barang" id="nmbrg" readonly>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="jmlh" class="form-label text-right">Jumlah</label></br>
                                        <input type="text" class="form-control number" name="jumlah" id="jmlhubah" required>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-4">
                                    <button type="button" id="btnBahanLabUpdate" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Ubah Alat Laboratorium</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #e2e5ed;">
               <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endcan

@endif

@if($data['npage'] == 80)
{{-- ADD ALAT --}}
@can('serma-create')
<div id="ShowAddHasil" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel" >TAMBAH DATA HASIL PRAKTIKUM</h5>
                <h5 class="modal-title text-center mdlHeaderTitle" id="myModalLabel" ></h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon "></i><strong>Form Tambah Hasil Praktikum</strong>
                        </div>
                        <div class="wrap-alat-to-lab">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectAlat" class="form-label text-right">Pilih Hasil Praktikum </label></br>
                                        <select class="form-control tambahHasil" style="font-size: 15px;" name="barang[]" id="selectAlat" required>
                                            <option value="">Pilih Hasil Praktikum</option>
                                        </select>
                                    </div>
                                    <small>Data Tidak Ditemukan? <a href="#"><span class="addMode"><strong>Tambahkan Data Master Hasil Praktikum</strong></span> </a></small>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="jmlh" class="form-label text-right">Jumlah</label></br>
                                        <input type="text" class="form-control number" name="jumlah" id="jmlh" required>
                                    </div>
                                </div>

                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mt-4">
                                    <button type="button" id="btnHasilLab" class="ol-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Hasil Ke Laboratorium</button>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-master-alat" style="display: none;">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="barang" class="form-label">Hasil Praktikum</label>
                                    <input class="form-control" type="text" value="" id="barang" name="nama_barang" placeholder="Masukan Barang" required="" style=" text-transform: capitalize;">
                                </div>

                                <div class="col-xxl-4 col-md-6 mt-1">
                                    <label for="satuanDefault" class="form-label">Satuan</label></br>
                                    <select class="form-control" style="font-size: 15px;" name="tm_satuan_id" id="satuanDefault">
                                        <option value="">Pilih Satuan</option>
                                    </select>
                                </div>

                                <div class="col-xxl-4 col-md-12 mt-1">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                                </div>
                                @can('serma-create')
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 row d-flex mt-2">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnMasterAlat" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Tambah Data Hasil</button>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnCancel" class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 btn btn-primary waves-effect waves-light ">Batal Input Data</button>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #e2e5ed;">
               <button type="button" class="btn btn-danger mt-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endcan

@endif
