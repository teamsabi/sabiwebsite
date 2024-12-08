<?php
require_once '../../layout/top.php';
 ?>

        <!--Content body start-->
        <div class="content-body">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Hasil Pengerjaan Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="NilaiTable" class="display" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Nilai PG</th>
                                                <th>Nilai Essay</th>
                                                <th>Jumlah Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data siswa dan nilai akan ditambahkan melalui JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk jawaban PG siswa -->
            <div class="modal fade" id="jawabanPGModal" tabindex="-1" role="dialog" aria-labelledby="jawabanPGLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jawabanPGLabel">Jawaban Pilihan Ganda</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="PGJawabanTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Jawaban Siswa</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data jawaban PG siswa akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal untuk jawaban Essay siswa -->
            <div class="modal fade" id="jawabanEssayModal" tabindex="-1" role="dialog" aria-labelledby="jawabanEssayLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jawabanEssayLabel">Jawaban Essay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="EssayJawabanTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Jawaban Siswa</th>
                                        <th>Beri Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data jawaban Essay siswa akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    // Inisialisasi DataTable
                    var table = $('#NilaiTable').DataTable({
                        data: [
                            // Contoh data, tambahkan data siswa di sini
                            [1, 'Nama Siswa 1', 'Kelas 10', '85 <button class="btn btn-info btn-sm nilaiPGBtn"><i class="fa fa-check text-white"></i></button>', '90 <button class="btn btn-info btn-sm nilaiEssayBtn"><i class="fa fa-check text-white"></i></button>', 175],
                            [2, 'Nama Siswa 2', 'Kelas 11', '80 <button class="btn btn-info btn-sm nilaiPGBtn"><i class="fa fa-check text-white"></i></button>', '85 <button class="btn btn-info btn-sm nilaiEssayBtn"><i class="fa fa-check text-white"></i></button>', 165]
                        ],
                        columns: [
                            { title: "No" },
                            { title: "Nama Siswa" },
                            { title: "Kelas" },
                            { title: "Nilai PG" },
                            { title: "Nilai Essay" },
                            { title: "Jumlah Nilai" }
                        ]
                    });

                    // Event untuk membuka modal jawaban PG
                    $('#NilaiTable tbody').on('click', '.nilaiPGBtn', function () {
                        var data = table.row($(this).parents('tr')).data();
                        // Load jawaban PG siswa untuk ditampilkan di dalam modal
                        var jawabanPG = [
                            [1, 'Soal 1', 'A', 10],
                            [2, 'Soal 2', 'B', 10],
                            [3, 'Soal 3', 'C', 15]
                        ];

                        // Masukkan data ke dalam tabel PGJawabanTable
                        var pgTableBody = $('#PGJawabanTable tbody');
                        pgTableBody.empty();
                        jawabanPG.forEach((jawaban, index) => {
                            var row = `<tr>
                                <td>${index + 1}</td>
                                <td>${jawaban[1]}</td>
                                <td>${jawaban[2]}</td>
                                <td>${jawaban[3]}</td>
                            </tr>`;
                            pgTableBody.append(row);
                        });

                        // Tampilkan modal jawaban PG
                        $('#jawabanPGModal').modal('show');
                    });

                    // Event untuk membuka modal jawaban Essay
                    $('#NilaiTable tbody').on('click', '.nilaiEssayBtn', function () {
                        var data = table.row($(this).parents('tr')).data();
                        // Load jawaban Essay siswa
                        var jawabanEssay = [
                            [1, 'Soal Essay 1', 'Jawaban siswa 1', `<input type="number" min="0" max="100" class="form-control" placeholder="Beri Nilai">`],
                            [2, 'Soal Essay 2', 'Jawaban siswa 2', `<input type="number" min="0" max="100" class="form-control" placeholder="Beri Nilai">`]
                        ];

                        // Masukkan data ke dalam tabel EssayJawabanTable
                        var essayTableBody = $('#EssayJawabanTable tbody');
                        essayTableBody.empty();
                        jawabanEssay.forEach((jawaban, index) => {
                            var row = `<tr>
                                <td>${index + 1}</td>
                                <td>${jawaban[1]}</td>
                                <td>${jawaban[2]}</td>
                                <td>${jawaban[3]}</td>
                            </tr>`;
                            essayTableBody.append(row);
                        });

                        // Tampilkan modal jawaban Essay
                        $('#jawabanEssayModal').modal('show');
                    });
                });
            </script>
        </div>
        <!--Content body end-->

<?php
require_once '../../layout/footer.php';
?>
