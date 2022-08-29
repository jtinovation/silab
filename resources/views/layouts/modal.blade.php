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

<div id="ShowAddAlatlab" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title text-center" id="myModalLabel">TAMBAH DATA ALAT LABORATORIUM</h5>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 ">


                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="ri-user-smile-line label-icon"></i><strong>Form Tambah Alat</strong>
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


                                @can('inventaris-alat-create')
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                        <label for="selectAlat" class="form-label text-right">&nbsp;</label></br>
                                        <button type="button" id="btnAlatLab" class="btn btn-primary waves-effect waves-light ">Tambah Alat</button>
                                    </div>
                                </div>
                                @endcan
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
                                        <option></option>
                                        @foreach($data['satuan'] as $v)
                                            <option value="{{$v->id}}">{{$v->satuan}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xxl-4 col-md-12 mt-1">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <textarea class="form-control" name="spesifikasi" id="spesifikasi"></textarea>
                                </div>
                                @can('inventaris-alat-create')
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 row d-flex mt-2">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnMasterAlat" class="btn btn-primary waves-effect waves-light ">Tambah Data Alat</button>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <button type="button" id="btnCancel" class="btn btn-primary waves-effect waves-light ">Batal Input Data</button>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
