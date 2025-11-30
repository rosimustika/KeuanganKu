<?php
// Mulai session
session_start();
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_profile";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data pengguna dari database (user ID tetap di-hardcode atau diambil dari session)
$userId = 1; // Ganti sesuai mekanisme login Anda
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    die("User not found");
}

// Perbarui data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];
    // Update ke database
    $updateSql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssssi", $firstName, $lastName, $email, $phoneNumber, $address, $userId);

    if ($updateStmt->execute()) {
        // Refresh data pengguna
        $userData['first_name'] = $firstName;
        $userData['last_name'] = $lastName;
        $userData['email'] = $email;
        $userData['phone_number'] = $phoneNumber;
        $userData['address'] = $address;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Data finance (contoh statis untuk saat ini)
$incomeData = [
    ["type" => "income", "amount" => "Rp 3.500.000", "source" => "Gaji"],
    ["type" => "income", "amount" => "Rp 500.000", "source" => "Investasi"],
    ["type" => "expense", "amount" => "Rp 50.000", "source" => "Makan"],
    ["type" => "expense", "amount" => "Rp 30.000", "source" => "Rokok"],
    ["type" => "income", "amount" => "Rp 100.000", "source" => "Investasi"],
    ["type" => "expense", "amount" => "Rp 25.000", "source" => "Rokok"],
    ["type" => "income", "amount" => "Rp 50.000", "source" => "Hadiah"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <!-- Bagian Profile -->
        <div class="Profile bg-light">
            <div class="Profile-header d-flex">
                <img src="pp.admin.png" alt="Profile" class="Profile-img">
                <div class="Profile-text-container">
                    <h1 class="Profile-title"><?php echo $userData['first_name'] . ' ' . $userData['last_name']; ?></h1>
                    <p class="Profile-email"><?php echo $userData['email']; ?></p>
                </div>
            </div>

            <!-- Menu -->
            <div class="menu">
                <a href="#" class="menu-link active" id="accountLink"><i class="fa fa-circle-user menu-icon"></i>Account</a>
                <a href="#" class="menu-link" id="notificationLink"><i class="fa fa-bell menu-icon"></i>Notification</a>
                <a href="index.php" class="menu-link" id="logoutBtn"><i class="fa fa-right-from-bracket menu-icon"></i>Logout</a>
            </div>
        </div>

        <!-- Account Section -->
        <form class="Account bg-light" method="POST" action="">
            <div class="Account-Header d-flex justify-content-between align-items-center">
                <h1 class="Account-Title">Account Setting</h1>
                <div class="btn-Container">
                    <button type="submit" class="btn-Save">Save</button>
                    <button class="btn-Cancel"><a href="indexadmin.php">Cancel</a></button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-Container">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo $userData['first_name']; ?>" placeholder="First Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-Container">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $userData['last_name']; ?>" placeholder="Last Name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-Container">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>" placeholder="Email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-Container">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo $userData['phone_number']; ?>" placeholder="Phone Number">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-Container">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" placeholder="Address"><?php echo $userData['address']; ?></textarea>
                    </div>
                </div>
            </div>
        </form>

        <!-- Notification Section -->
        <div id="Notification" class="Notification bg-light" style="display:none;">
            <div class="Notification-Header">
                <h1 class="Notification-Title">Notifications</h1>
            </div>
            <div class="Notification-Content">
                <h2>Articles</h2>
                <ul class="article-list">
                    <li><a href="artikeladmin.php">4 Tips Mengelola Keuangan yang Cocok dengan Karakteristik Gen Z</a></li>
                    <li><a href="artikeladmin.php">6 Tahapan Mudah Untuk Pengelolaan Keuangan!</a></li>
                    <li><a href="artikeladmin.php">Mengenal OJK dan Fungsinya dalam Mengawasi Pasar Keuangan</a></li>
                    <li><a href="artikeladmin.php">Pentingnya Pengelolaan Keuangan Digital untuk wujudkan UMKM yang hebat</a></li>
                    <li><a href="artikeladmin.php">Tips Raih Untung Investasi Sesuai Harapan Dengan Melakukan 6 Hal Ini</a></li>
                    <li><a href="artikeladmin.php">Nilai tukar rupiah terendah dalam 4 tahun terakhir gara-gara libur lebaran kelamaan</a></li>
                </ul>
                <h2>Finance Updates</h2>
                <ul class="finance-list">
                    <?php foreach ($incomeData as $data) : ?>
                        <li class="<?php echo $data['type']; ?>">
                            <?php echo ucfirst($data['type']) . ': ' . $data['amount'] . ' (' . $data['source'] . ')'; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <script src="profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>