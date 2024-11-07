<?php
require 'koneksi.php'; // Koneksi ke database
session_start(); // Memulai sesi
$response = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp_code']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $otp_code = $_POST['otp_code']; // Mendapatkan OTP yang digabungkan dari input form

    // Cek apakah OTP valid di database
    $stmt = $koneksi->prepare("SELECT * FROM password_resets WHERE email = :email AND otp_code = :otp_code AND status = 'pending' AND expires_at > NOW()");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':otp_code', $otp_code);
    $stmt->execute();
    $reset = $stmt->fetch();

    if ($reset) {
        // Jika OTP benar, simpan email ke dalam sesi untuk digunakan di halaman berikutnya
        $_SESSION['email_reset'] = $email;

        // Update status OTP menjadi 'verified'
        $stmt = $koneksi->prepare("UPDATE password_resets SET status = 'verified' WHERE email = :email AND otp_code = :otp_code");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':otp_code', $otp_code);
        $stmt->execute();

        // Script SweetAlert yang akan dijalankan setelah verifikasi berhasil
        $response = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Berhasil Diverifikasi',
                            text: 'Anda akan diarahkan ke halaman ubah kata sandi.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'kata_sandibaru.php'; // Redirect ke halaman ubah kata sandi
                        });
                     </script>";
    } else {
        // OTP salah atau kedaluwarsa
        $response = "<script>Swal.fire('Gagal', 'OTP salah atau sudah kedaluwarsa.', 'error');</script>";
    }
    echo $response;
    exit; // Hentikan script setelah menampilkan respons
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukan Kode OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #239D9F;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .otp-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .otp-container img {
            width: 80px;
            margin-bottom: 15px;
        }

        .otp-container h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .otp-container p {
            color: gray;
            margin-bottom: 20px;
        }

        .otp-inputs input {
            width: 50px;
            height: 60px;
            margin: 0 5px;
            text-align: center;
            font-size: 24px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .otp-actions .btn {
            width: 45%;
            margin: 10px 2%;
            border-radius: 10px;
            background-color: #229799;
            color: white;
            border: none;
        }

        .otp-actions .btn:hover {
            background-color: #1e8888;
        }

        .resend-link {
            margin-top: 10px;
            display: block;
            color: #239D9F;
            text-decoration: none;
            font-weight: 500;
        }

        .resend-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <img src="assets/img/email_msg.png" alt="OTP Icon">
        <h2>Masukan Kode OTP</h2>
        <p>Masukkan 5 digit kode OTP yang sudah kami kirim ke email Anda!</p>

        <form method="POST" action="">
            <!-- Input hidden untuk email -->
            <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

            <div class="otp-inputs d-flex justify-content-center">
                <input type="text" maxlength="1" class="form-control" required>
                <input type="text" maxlength="1" class="form-control" required>
                <input type="text" maxlength="1" class="form-control" required>
                <input type="text" maxlength="1" class="form-control" required>
                <input type="text" maxlength="1" class="form-control" required>
            </div>

            <a href="lupa_password.php" class="resend-link">Belum menerima kode OTP? <strong>Kirim Ulang</strong></a>

            <div class="otp-actions">
                <button type="button" class="btn" onclick="window.history.back()">Kembali</button>
                <button type="submit" class="btn">Kirim</button>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk input OTP otomatis berpindah -->
    <script>
        document.querySelectorAll('.otp-inputs input').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else if (input.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Gabungkan nilai OTP dari semua input sebelum dikirimkan
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();
            let otpCode = "";
            document.querySelectorAll('.otp-inputs input').forEach(input => otpCode += input.value);

            // Tambahkan otp_code ke dalam form secara dinamis
            let hiddenOtpInput = document.createElement("input");
            hiddenOtpInput.type = "hidden";
            hiddenOtpInput.name = "otp_code";
            hiddenOtpInput.value = otpCode;
            this.appendChild(hiddenOtpInput);
            this.submit();
        });
    </script>

<?php
// Menampilkan SweetAlert berdasarkan hasil verifikasi OTP
echo $response;
?>
</body>
</html>