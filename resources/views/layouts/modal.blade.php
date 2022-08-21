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
