<?php
require_once '../../layout/top.php';
 ?>

        <!--Content body start*-->
        <div class="content-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Soal Pilihan Ganda</h4>
                            </div>

                            <!-- Button Tambah Soal -->
                            <div class="row mb-3">
                                <div class="col-lg-8 col-12" style="margin-top: -30px; margin-left: 180px;">
                                    <button class="btn btn-success" style="color: #f1f5f8; background-color: #229799; border-color: #229799;" data-toggle="modal" data-target="#addSoal">
                                        <i class="fa fa-plus"></i> Tambah Soal Pilihan Ganda
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="SoalTable" class="display" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pertanyaan</th>
                                                <th>Pil A</th>
                                                <th>Pil B</th>
                                                <th>Pil C</th>
                                                <th>Pil D</th>
                                                <th>Pil E</th>
                                                <th>Kunci</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data Dummy -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Soal Pilihan Ganda -->
            <div class="modal fade" id="addSoal" tabindex="-1" role="dialog" aria-labelledby="modalSoalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Tambah Soal Pilihan Ganda</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formTambahSoal">
                                <div class="form-group">
                                    <label for="soal">Soal</label>
                                    <input type="text" class="form-control" id="soal" placeholder="Masukkan Soal" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilA">Pilihan A</label>
                                    <input type="text" class="form-control" id="pilA" placeholder="Masukkan Pilihan A" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilB">Pilihan B</label>
                                    <input type="text" class="form-control" id="pilB" placeholder="Masukkan Pilihan B" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilC">Pilihan C</label>
                                    <input type="text" class="form-control" id="pilC" placeholder="Masukkan Pilihan C" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilD">Pilihan D</label>
                                    <input type="text" class="form-control" id="pilD" placeholder="Masukkan Pilihan D" required>
                                </div>
                                <div class="form-group">
                                    <label for="pilE">Pilihan E</label>
                                    <input type="text" class="form-control" id="pilE" placeholder="Masukkan Pilihan E" required>
                                </div>
                                <div class="form-group">
                                    <label for="kunci">Kunci Jawaban</label>
                                    <select class="form-control" id="kunci" required>
                                        <option value="">Pilih Kunci Jawaban</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript untuk SweetAlert2 dan Fungsi Form -->
            <script>
                $(document).ready(function () {
                    // Inisialisasi DataTable
                    var table = $('#SoalTable').DataTable();
                    var currentRow; // Menyimpan baris yang sedang diedit

                    // Tambah Soal Pilihan Ganda
                    $('#formTambahSoal').on('submit', function (e) {
                        e.preventDefault();

                        // Ambil nilai dari inputan
                        var soal = $('#soal').val();
                        var pilA = $('#pilA').val();
                        var pilB = $('#pilB').val();
                        var pilC = $('#pilC').val();
                        var pilD = $('#pilD').val();
                        var pilE = $('#pilE').val();
                        var kunci = $('#kunci').val();

                        // Cek jika ada baris yang sedang diedit
                        if (currentRow) {
                            // Update DataTable jika sedang mengedit
                            table.row(currentRow).data([
                                table.rows().count(), // No (otomatis dihitung)
                                soal, // Soal
                                pilA, // Pilihan A
                                pilB, // Pilihan B
                                pilC, // Pilihan C
                                pilD, // Pilihan D
                                pilE, // Pilihan E
                                kunci, // Kunci Jawaban
                                `<button class="btn btn-sm btn-primary editBtn"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger deleteBtn"><i class="fa fa-trash"></i></button>`
                            ]).draw();

                            currentRow = null; // Reset currentRow setelah edit
                        } else {
                            // Tambahkan data baru ke DataTable
                            table.row.add([
                                table.rows().count() + 1, // No
                                soal, // Soal
                                pilA, // Pilihan A
                                pilB, // Pilihan B
                                pilC, // Pilihan C
                                pilD, // Pilihan D
                                pilE, // Pilihan E
                                kunci, // Kunci Jawaban
                                `<button class="btn btn-sm btn-primary editBtn"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger deleteBtn"><i class="fa fa-trash"></i></button>`
                            ]).draw();
                        }

                        // Tutup modal dan reset form
                        $('#addSoal').modal('hide');
                        $('#formTambahSoal')[0].reset();
                    });

                    // Hapus Soal
                    $('#SoalTable tbody').on('click', '.deleteBtn', function () {
                        table.row($(this).parents('tr')).remove().draw();
                    });

                    // Edit Soal
                    $('#SoalTable tbody').on('click', '.editBtn', function () {
                        currentRow = $(this).parents('tr'); // Simpan baris yang sedang diedit

                        var data = table.row(currentRow).data(); // Ambil data dari baris
                        $('#soal').val(data[1]); // Soal
                        $('#pilA').val(data[2]); // Pilihan A
                        $('#pilB').val(data[3]); // Pilihan B
                        $('#pilC').val(data[4]); // Pilihan C
                        $('#pilD').val(data[5]); // Pilihan D
                        $('#pilE').val(data[6]); // Pilihan E
                        $('#kunci').val(data[7]); // Kunci Jawaban

                        // Tampilkan modal
                        $('#addSoal').modal('show');
                    });
                });
            </script>
        </div>
        <!--Content body end-->


<?php
require_once '../../layout/footer.php';
?>