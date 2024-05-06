<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Analisis Regresi</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

header {
    background-color: #007bff;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    width: 100%;
}

footer {
    background-color: #007bff;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    width: 100%;
}

form {
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    width: 50%;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"] {
    width: 100%;
    padding: 5px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
}

th {
    background-color: #f2f2f2;
}

h2, p {
    text-align: center;
}

.output {
    margin-top: 20px;
    padding: 10px;
    background-color: #f2f2f2;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.conclusion {
    text-align: center;
    font-weight: bold;
    margin-top: 20px;
}

.output-container {
    margin-top: 20px;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.output-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.output-item {
    margin-bottom: 5px;
}

.output-label {
    font-weight: bold;
    color: #555;
}

.output-value {
    color: #007bff;
}

.conclusion {
    margin-top: 20px;
    padding: 10px;
    border-radius: 5px;
}

.rejected {
    color: #dc3545; /* Warna merah untuk hipotesis ditolak */
}

.accepted {
    color: #28a745; /* Warna hijau untuk hipotesis diterima */
}

.rumus {
    font-weight: bold;
    font-style: italic;
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #333;
}

.rumus span {
    color: #ff6600; /* Warna untuk highlight rumus */
}

.root {
    padding: 0;
    margin: 0;
    font-size: 18px;
}

section {
    padding-top: 1rem;
    width: 95%;
    margin: auto;
}

h1 {
    font-size: 2rem;
    font-weight: 500;
}

details[open] summary ~ * {
    animation: open 2s ease-in-out;
}

.open-animation summary ~ * {
    animation: open 2s ease-in-out;
}

@keyframes open {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

details summary::-webkit-details-marker {
    display: none;
}

details summary {
    width: 100%;
    padding: 0.5rem 0;
    border-top: 1px solid black;
    position: relative;
    cursor: pointer;
    font-size: 1.25rem;
    font-weight: 300;
    list-style: none;
}

details summary:after {
    content: "+";
    color: black;
    position: absolute;
    font-size: 1.75rem;
    line-height: 0;
    margin-top: 0.75rem;
    right: 0;
    font-weight: 200;
    transform-origin: center;
    transition: 200ms linear;
    animation: open 2s ease-in-out;
}

details[open] summary:after {
    transform: rotate(45deg);
    font-size: 2rem;
}

details summary {
    outline: 0;
}

details p {
    font-size: 0.95rem;
    margin: 0 0 1rem;
    padding-top: 1rem;
    animation: open 2s ease-in-out;
}

</style>
<script>
detail.addEventListener('toggle', function () {
    if (detail.open) {
        detail.classList.add('open-animation');
    } else {
        detail.classList.remove('open-animation'); // Hapus kelas saat detail ditutup
    }
});

</script>
</head>
<body>
<header>
    <h1>Kalkulator Analisis Of Variance</h1>
</header><br><br>
<form action="" method="post">
    <label for="biaya_promosi">Input x (pisahkan dengan koma):</label>
    <input type="text" id="biaya_promosi" name="biaya_promosi" placeholder="Contoh: 31,38,48,52,63" value="<?php echo isset($_POST['biaya_promosi']) ? htmlspecialchars($_POST['biaya_promosi']) : ''; ?>">
    <label for="kenaikan_penjualan">Input Y (pisahkan dengan koma):</label>
    <input type="text" id="kenaikan_penjualan" name="kenaikan_penjualan" placeholder="Contoh: 553,590,608,682,752" value="<?php echo isset($_POST['kenaikan_penjualan']) ? htmlspecialchars($_POST['kenaikan_penjualan']) : ''; ?>">
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST['biaya_promosi']) || empty($_POST['kenaikan_penjualan'])) {
                echo "<p style='color: red;'>Masukkan kedua angka.</p>";
            }
        }
    ?>
    <input type="submit" value="Analisis">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $biayaPromosi = isset($_POST['biaya_promosi']) ? explode(',', $_POST['biaya_promosi']) : array();
    $kenaikanPenjualan = isset($_POST['kenaikan_penjualan']) ? explode(',', $_POST['kenaikan_penjualan']) : array();

    // Lanjutkan dengan proses analisis regresi
    // Menghitung jumlah, jumlah kuadrat, jumlah produk, x*y, x^2, dan y^2
    $n = count($biayaPromosi);
    $sumX = array_sum($biayaPromosi);
    $sumY = array_sum($kenaikanPenjualan);
    $sumXY = 0;
    $sumX2 = 0;
    $sumY2 = 0;
    
    for ($i = 0; $i < $n; $i++) {
        $x = $biayaPromosi[$i];
        $y = $kenaikanPenjualan[$i];
        $sumXY += $x * $y;
        $sumX2 += $x * $x;
        $sumY2 += $y * $y;
    }

    // Inisialisasi variabel total
$totalX = 0;
$totalY = 0;
$totalXX = 0;
$totalYY = 0;
$totalXY = 0;

// Menampilkan tabel data
echo "<h2>Data</h2>";
echo "<table border='1'>";
echo "<tr><th>No</th><th>X</th><th>Y</th><th>X<sup>2</sup></th><th>Y<sup>2</sup></th><th>X*Y</th></tr>";
for ($i = 0; $i < $n; $i++) {
    $x = $biayaPromosi[$i];
    $y = $kenaikanPenjualan[$i];
    
    // Mengakumulasi total
    $totalX += $x;
    $totalY += $y;
    $totalXX += $x * $x;
    $totalYY += $y * $y;
    $totalXY += $x * $y;

    echo "<tr><th>" . ($i + 1) . "</th><td style=\"text-align:right;\">" . number_format($x) . "</td><td style=\"text-align:right;\">" . number_format($y) .
    "</td><td style=\"text-align:right;\">" . number_format($x * $x) . "</td><td style=\"text-align:right;\">" . number_format($y * $y) . "</td><td style=\"text-align:right;\">" . number_format($x * $y) . "</td></tr>";
}

// Menampilkan total
echo "<tr><th><strong>Total</strong></th><th style=\"text-align:right;\"><strong>" . number_format($totalX) . "</strong></th><th style=\"text-align:right;\"><strong>" . number_format($totalY) . "</strong></th><th style=\"text-align:right;\"><strong>" . number_format($totalXX) . "</strong></th><th style=\"text-align:right;\"><strong>" . number_format($totalYY) . "</strong></th><th style=\"text-align:right;\"><strong>" . number_format($totalXY) . "</strong></th></tr>";
    echo "</table>";

// Menghitung penduga β1
$b1 = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - pow($sumX, 2));
// Membulatkan ke dua desimal
$b1 = round($b1 * 100.0) / 100.0;

// Menghitung penduga β0
$b0 = ($sumY - $b1 * $sumX) / $n;
// Membulatkan ke dua desimal
$b0 = round($b0 * 100.0) / 100.0;

    // Lanjutkan dengan perhitungan statistik uji F, koefisien determinasi, dan lainnya
    // ...
    $JKXY = $sumXY - ($sumX * $sumY) / $n; // Perbaikan rumus JKXY
// Membulatkan ke dua desimal
$JKXY = round($JKXY * 100.0) / 100.0;

// Menghitung Jumlah Kuadrat X*X (JKXX)
$JKXX = $sumX2 - pow($sumX, 2) / $n; // Jumlah Kuadrat X*X
// Membulatkan ke dua desimal
$JKXX = round($JKXX * 100.0) / 100.0;

// Menghitung Jumlah Kuadrat Y*Y (JKYY)
$JKYY = $sumY2 - pow($sumY, 2) / $n; // Jumlah Kuadrat Y*Y
// Membulatkan ke dua desimal
$JKYY = round($JKYY * 100.0) / 100.0;

$Y = $b0 + $b1 * $i++;

// Menghitung statistik uji F
$JKR = $b1 * $JKXY; // Jumlah Kuadrat Regresi
// Membulatkan ke dua desimal
$JKR = round($JKR * 100.0) / 100.0;
$JKT = $sumY2 - pow($sumY, 2) / $n; // Jumlah Kuadrat Total
// Membulatkan ke dua desimal
$JKT = round($JKT * 100.0) / 100.0;

$JKG = $JKT - $JKR; // Jumlah Kuadrat Galat
// Membulatkan ke dua desimal
$JKG = round($JKG * 100.0) / 100.0;

$KTR = $JKR; // Derajat Kebebasan Regresi
$KTG = $JKG / 3; // Derajat Kebebasan Galat
// Membulatkan ke dua desimal
$KTG = round($KTG * 100.0) / 100.0;

$KTRG = $KTR / $KTG;
$F0 = $KTR / $KTG; // Output error
$F0 = round($F0 * 100.0) / 100.0;
$formattedF0 = $F0 ;

// Menghitung total kuadrat tengah (KT)
$KT = $KTG;

// Penghitungan F Tabel
$alphaSimultan = 0.05;
$dbr = 1; // Derajat Kebebasan Regresi
$dbg = $n - 2; // Derajat Kebebasan Galat
$fTab = 4.413873; // Nilai F tabel yang telah dihitung sebelumnya

// Uji parsial untuk β1
$b1StandardError = sqrt($JKG / (($n - 2) * $sumX2));
$b1StandardError = round($b1StandardError * 100.0) / 100.0;

// Menghitung t0
$t0 = $b1 / $b1StandardError;
$t0 = round($t0 * 100.0) / 100.0;

// Menambahkan rumus yang diminta
$tCriticalParsial = 3.18; // Sesuai dengan nilai yang diberikan
$tStatistik = ($b1 - 0) / sqrt($JKXX / $KTG); // Rumus statistik uji t

    // Output ANOVA
echo "<h2>Tabel ANOVA (Analisis Of Variance)</h2>";
echo "<table border='1' style='width: 40%; margin: auto;'>";
echo "<tr><th>Sumber</th><th>db</th><th>Jumlah Kuadrat (JK)</th><th>Kuadrat Tengah (KT)</th><th>F<sub>0</sub> (F.Hitung)</th></tr>";
echo "<tr><th>Regresi</th><td style=\"text-align:center;\">1</td><td style=\"text-align:right;\">" . $JKR . "</td><td style=\"text-align:right;\">" . $JKR . "</td><td style=\"text-align:right;\">" . $F0 . "</td></tr>";
echo "<tr><th>Galat</th><td style=\"text-align:center;\">" . ($n - 2) . "</td><td style=\"text-align:right;\">" . $JKG . "</td><td style=\"text-align:right;\">" . $KTG ."</td> <td></td></tr>";
echo "<tr><th>Total</th><td style=\"text-align:center;\">" . ($n - 1) . "</td><td style=\"text-align:right;\">" . $JKT . "</td><td style=\"text-align:right;\">" . ($JKR + $KTG) . "</td><td></td> </tr>";
echo "</table><br><br>";

echo "<section>";
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
echo "<summary> <b>1. β1 & β0</b> </summary>";
echo "<b> Penduga untuk β1 (b1) = </b>" . $b1 . "<br>";

echo "<b> Penduga untuk β0 (b0) = </b> " . $b0 . "<br>";
echo "</div>";
echo "</details>";

    // Output Persamaan regresi linear
    echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
    echo "<details>";
    echo "<summary><b>2. Persamaan regresi linear</b></summary>";
    echo "<b>Y = </b>" . $b0 . " + " . $b1 . " X<sub>(i)</sub><br>";


echo "<b> Persamaan regresi linear: Y = </b>" . $b0 . " + " . ($b1 * $i++) . " = " . $Y . " <br>";

// Output Total KT
echo "<b> Total KT = </b>\t\t\t" . $KT . "<br>";

echo "<b>F Tabel untuk alpha =</b>" . $alphaSimultan . "<br><b>df1</b> = " . $dbr . "<br><b>df2</b> =" . $dbg . ": " . $fTab . "<br>";

echo "</details></div>";

// // Output tambahan
// echo "<br><br>";
// echo "Output Tambahan:<br>";
// echo "Statistik Uji F0 = " . $formattedF0 . "<br>";
// echo "JKT (Jumlah Kuadrat Total): " . $JKYY . "<br>";
// echo "JKR (Jumlah Kuadrat Regresi): " . $JKR . "<br>";
// echo "JKG (Jumlah Kuadrat Galat): " . $JKG . "<br>";
// echo "KTR (Derajat Kebebasan Regresi): " . $KTR . "<br>";
// echo "KTG (Derajat Kebebasan Galat): " . $KTG . "<br>";
// echo "JKXX (Jumlah Kuadrat X): " . $JKXX . "<br>";
// echo "JKXY (Jumlah Kuadrat XY/n): " . $JKXY . "<br>";
// echo "JKYY (Jumlah Kuadrat YY): " . $JKYY . "<br>";

// // Statistik uji F dan Uji Hipotesis
// echo "<br>Uji Simultan (bersama) - ANOVA:<br>";
// echo "H0: β1 = 0 (model tidak sesuai/pas)<br>";
// echo "H1: β1 ≠ 0 (model sesuai/pas)<br>";
// echo "Statistik Uji F0 = " . $formattedF0 . "<br>";
// echo "Titik Kritis F(0.05, 1, " . ($n - 2) . ") = 10.13<br>";

// // Kesimpulan
// if ($F0 > 10.13) {
//     echo "Hipotesis Nol (H0) ditolak. Model sesuai/pas pada taraf nyata 5%.<br>";
// } else {
//     echo "Hipotesis Nol (H0) diterima. Model tidak sesuai/pas pada taraf nyata 5%.<br>";
// }

// Output tambahan
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
echo "<summary><b>3. Output Tambahan</b></summary>";
echo "<span style='font-weight: bold;'>JKT (Jumlah Kuadrat Total) = JK<sub><i>YY</i></sub> = </span> " . $JKYY . "<br>";
echo "<span style='font-weight: bold;'>JKR (Jumlah Kuadrat Regresi) = b<sub>1</sub> x JK<sub>XY</sub> = </span> " . $JKR . "<br>";
echo "<span style='font-weight: bold;'>JKG (Jumlah Kuadrat Galat) = JKT - JKR = </span> " . $JKG . "<br>";
echo "<span style='font-weight: bold;'>KTR (Derajat Kebebasan Regresi) = JKR/1 = </span> " . $KTR . "<br>";
echo "<span style='font-weight: bold;'>KTG (Derajat Kebebasan Galat) = JKG/3 = </span> " . $KTG . "<br>";
echo "<span style='font-weight: bold;'>Statistik Uji F<sub>0</sub> = KTR/KTG = </span> " . $formattedF0 . "<br>";
echo "<span style='font-weight: bold;'>JK<sub>XX</sub> (Jumlah Kuadrat X) = </span> " . $JKXX . "<br>";
echo "<div class='rumus'>";
echo "<span>JK<sub>XX</sub> = ∑x<sup>2</sup><sub>i</sub> - (Σx<sub>i</sub>)<sup>2 </sup>/n</span> = " .$JKXX. "<br>";
echo "</div>";
echo "<span style='font-weight: bold;'>JK<sub>XY</sub> (Jumlah Kuadrat XY/n) = </span> " . $JKXY . "<br>";
echo "<div class='rumus'>";
echo "<span>JK<sub>XY</sub> = ∑x<sub>i</sub>*y<sub>i</sub> - Σx<sub>i</sub>*Σy<sub>i </sub>/n </span> = " .$JKXY. "<br>";
echo "</div>";
echo "<span style='font-weight: bold;'>JK<sub>YY</sub> (Jumlah Kuadrat YY) = </span> " . $JKYY . "<br>";
echo "<div class='rumus'>";
echo "<span>JK<sub>YY</sub> = ∑ y<sub>i</sub><sup>2</sup> - (Σy<sub>i</sub>)<sup>2 </sup>/n </span> = " .$JKYY. "<br>";
echo "</details></div>";
echo "</div>";

// Statistik uji F dan Uji Hipotesis
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
echo "<summary><b>4. Uji Simultan - ANOVA </b></summary>";
echo "<span style='font-weight: bold;'>H0: β1 = 0 (model tidak sesuai/pas)</span><br>";
echo "<span style='font-weight: bold;'>H1: β1 ≠ 0 (model sesuai/pas)</span><br>";
echo "<span style='font-weight: bold;'>Statistik Uji F0:</span> " . $formattedF0 . "<br>";
echo "<span style='font-weight: bold;'>Titik Kritis F(0.05, 1, " . ($n - 2) . "):</span> 10.13<br>";

// Kesimpulan
echo "<strong>Kesimpulan : </strong>";
if ($F0 > 10.13) {
    echo "Hipotesis Nol (H0) ditolak. Model sesuai/pas pada taraf nyata 5%.";
} else {
    echo "Hipotesis Nol (H0) diterima. Model tidak sesuai/pas pada taraf nyata 5%.";
}
echo "</details></div>";

// Uji hipotesis parsial
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
echo "<summary><b>5. Uji Parsial (β1) - ANOVA:</b></summary>";
echo "<b>H0: β1 = 0 (X tidak mempengaruhi Y)</b><br>";
echo "<b>H1: β1 ≠ 0 (X mempengaruhi Y)</b><br>";
echo "<b>Statistik Uji t0 = </b>" . $t0 . "\t <b><br>Sesuai dengan rumus = </b>" . $tStatistik . "<br>";
echo "<b>Hasil statistika uji t(0.025, " . ($n - 2) . ") = </b>" . $tCriticalParsial . "<br>";
echo "</details></div>";

// Kesimpulan parsial
// Menentukan tingkat signifikansi (alpha)
$alpha = 0.05;
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
echo "<summary><b>6. Signifikansi(95%)=" . $alpha . "</b></summary>";
echo "<b>5% : </b><br>";
if (abs($t0) > $tCriticalParsial) {
    echo " Hipotesis Nol (H0) ditolak. X mempengaruhi Y secara linear pada taraf nyata 5%. <br>";
} else {
    echo " Hipotesis Nol (H0) diterima. X tidak mempengaruhi Y secara linear pada taraf nyata 5%. <br>";
}
echo "</details></div>";

// Koefisien Determinasi R^2
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details>";
$R2 = $JKR / $JKT;
$R2 = round($R2 * 1000.0) / 10.0; // Membulatkan ke satu desimal
echo "<summary><b>7. Koefisien Determinasi R<sup>2</sup></b></summary> " ;
echo "<div class='rumus'>
    <span>R</span><sup>2</sup> = <span>JKR</span> / <span>JKT</span> × 100 = $R2%
</div>";

// Prediksi penjualan jika biaya promosi dinaikkan sebesar 5%
$Xbaru = 5; // Kenaikan biaya promosi sebesar 5%
$Yprediksi = $b0 + $b1 * $Xbaru;
$Yprediksi = round($Yprediksi * 100.0) / 100.0; // Membulatkan ke dua desimal
echo "Prediksi penjualan jika biaya promosi dinaikkan sebesar 5%: " . $Yprediksi . "<br>";
echo "Prediksi penjualan jika biaya promosi dinaikkan sebesar 5%: " . $Yprediksi . "%<br>";
echo "</div>";

// Calculate correlation coefficient (r)
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details><summary><b>8. Korelasi</b></summary>";
$r = ($n * $sumXY - $sumX * $sumY) / sqrt(($n * $sumX2 - $sumX * $sumX) * ($n * $sumY2 - $sumY * $sumY));
echo "Koefisien Korelasi (r) = " . $r . "<br>";
// Membulatkan ke dua desimal
$r = round($r * 100.0) / 100.0;

// Menghitung statistik uji
$t = ($b1 - $b1StandardError) * sqrt($JKXX /$KTG);

// Menentukan batas kritis
$tCritical = abs($t);

echo "Statistik Uji (t) = " . $t . "<br>";
echo "Batas Kritis (tCritical) = " . $tCritical . "<br>";
echo "</details></div>";

// Uji hipotesis untuk korelasi
echo "<div style='background-color: #f0f0f0; padding: 10px;'>";
echo "<details><summary><b>9. Uji Hipotesis Korelasi</b></summary>";
echo "H0: ρ = 0 (tidak ada korelasi)<br>";
echo "H1: ρ ≠ 0 (ada korelasi)<br>";
echo "</div></details>";

// Output kesimpulan
echo "<div style='background-color: #f0f0f0; padding: 10px;'><details>";
echo "<summary><b>10. Output Kesimpulan</b></summary>";
echo "Statistik Uji (t) = " . $t . "<br>";
echo "<b>Batas Kritis (tCritical) = </b>" . $tCritical . "<br>";

// Uji hipotesis untuk korelasi
echo "<br>Uji Hipotesis Korelasi:<br>";
echo "H0: ρ = 0 (tidak ada korelasi)<br>";
echo "H1: ρ ≠ 0 (ada korelasi)<br>";

if (abs($t) > $tCritical) {
    echo "Hipotesis Nol (H0) ditolak. Terdapat korelasi antara biaya promosi dan peningkatan penjualan.<br>";
} else {
    echo "Hipotesis Nol (H0) diterima. Tidak terdapat korelasi antara biaya promosi dan peningkatan penjualan.<br>";
}
}
echo "</section>";

echo "<br>";

?>
<br><br><br>
<header>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Analisis Regresi by sandi adam (11222128). All rights reserved.</p>
</footer>
</header>
</body>
</html>