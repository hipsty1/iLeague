<?php
include "../php/connect.php";
session_start();

// Validasi Login (Opsional)
if (!isset($_SESSION['username'])) { header("Location: signin.php"); exit(); }

$filter_id = isset($_GET['team_id']) ? $_GET['team_id'] : '';

// 1. AMBIL DATA TIM
$teams = [];
$sql_t = "SELECT id_tim, nama_tim, `Logo Tim` as logo, stadion FROM tim ORDER BY nama_tim ASC";
$res_t = $conn->query($sql_t);
while($row = $res_t->fetch_assoc()) {
    $teams[$row['id_tim']] = $row;
}

// 2. AMBIL RIWAYAT (REAL DARI DATABASE)
$history_matches = [];
$played_pairs = []; 

$sql_m = "SELECT * FROM pertandingan ORDER BY tanggal_pertandingan DESC";
$res_m = $conn->query($sql_m);

while($row = $res_m->fetch_assoc()) {
    $key = $row['tim_home'] . '-' . $row['tim_away'];
    $played_pairs[$key] = true;

    // Filter Tampilan History
    if (empty($filter_id) || $row['tim_home'] == $filter_id || $row['tim_away'] == $filter_id) {
        $history_matches[] = $row;
    }
}

// 3. GENERATE JADWAL CERDAS (SMART SCHEDULING)
$upcoming_matches = [];
$pending_pairs = [];

// Langkah A: Kumpulkan pasangan
foreach ($teams as $home_id => $home) {
    foreach ($teams as $away_id => $away) {
        if ($home_id == $away_id) continue;
        
        $key = $home_id . '-' . $away_id;
        if (isset($played_pairs[$key])) continue; 

        $pending_pairs[] = ['home' => $home_id, 'away' => $away_id];
    }
}

// Langkah B: Acak Antrian
shuffle($pending_pairs);

// Langkah C: Tentukan Tanggal (Sistem Istirahat)
$team_availability = []; 
$start_date = strtotime("tomorrow");

foreach ($teams as $id => $val) {
    $team_availability[$id] = $start_date;
}

foreach ($pending_pairs as $pair) {
    $h_id = $pair['home'];
    $a_id = $pair['away'];

    $date_h = $team_availability[$h_id];
    $date_a = $team_availability[$a_id];

    $play_date_ts = max($date_h, $date_a);
    
    // Random delay 0-2 hari
    $random_delay = rand(0, 2); 
    $final_play_ts = strtotime("+$random_delay days", $play_date_ts);
    
    $dateString = date('Y-m-d', $final_play_ts);

    // Update Ketersediaan (Istirahat 4 hari)
    $next_free_ts = strtotime("+4 days", $final_play_ts);
    $team_availability[$h_id] = $next_free_ts;
    $team_availability[$a_id] = $next_free_ts;

    // Filter View
    if (empty($filter_id) || $h_id == $filter_id || $a_id == $filter_id) {
        $upcoming_matches[] = [
            'date' => $dateString,
            'home_id' => $h_id,
            'away_id' => $a_id,
            'home_name' => $teams[$h_id]['nama_tim'],
            'home_logo' => $teams[$h_id]['logo'],
            'home_stadion' => $teams[$h_id]['stadion'],
            'away_name' => $teams[$a_id]['nama_tim'],
            'away_logo' => $teams[$a_id]['logo']
        ];
    }
}

// Urutkan Jadwal
usort($upcoming_matches, function($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});

// Judul Tim Filter
$current_team_name = "";
if($filter_id && isset($teams[$filter_id])) {
    $current_team_name = $teams[$filter_id]['nama_tim'];
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Match Centre | ILeague</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f5f7fa; font-family: system-ui, -apple-system, sans-serif; }
    .btn-back { text-decoration: none; color: #6c757d; font-weight: 600; display: inline-flex; align-items: center; margin-bottom: 20px; transition: color 0.2s; }
    .btn-back:hover { color: #212529; }

    /* Card Styling */
    .card-custom { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 12px; overflow: hidden; background: #fff;}
    
    /* Layout Item Pertandingan */
    .match-row { display: flex; align-items: center; justify-content: space-between; padding: 15px; }
    .team-box { width: 35%; display: flex; align-items: center; gap: 10px; }
    .team-box.home { justify-content: flex-end; text-align: right; }
    .team-box.away { justify-content: flex-start; text-align: left; }
    
    /* --- PERBAIKAN LOGO: Tambahkan object-fit: contain --- */
    .team-logo { width: 40px; height: 40px; object-fit: contain; } 
    
    .team-name { font-weight: 600; font-size: 0.85rem; color: #2d3436; }
    
    /* Center Area */
    .center-box { text-align: center; min-width: 90px; }
    .score-badge { background: #2d3436; color: #fff; padding: 5px 12px; border-radius: 6px; font-weight: bold; font-size: 1.1rem; }
    
    /* Date & Meta */
    .match-meta { margin-top: 5px; font-size: 0.7rem; color: #adb5bd; }
    .venue-info { font-size: 0.7rem; color: #636e72; background: #f8f9fa; padding: 5px; text-align: center; border-top: 1px solid #eee;}

    /* Styling Jadwal (Kanan) */
    .schedule-item { background: #fff; border-bottom: 1px solid #f1f1f1; padding: 12px 15px; transition: background 0.2s;}
    .schedule-item:hover { background: #fcfcfc; }
    .schedule-date-badge { background: #e3f2fd; color: #0d6efd; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; margin-bottom: 8px; display: inline-block; }
    .vs-text { font-weight: 900; color: #dfe6e9; font-size: 1.2rem; font-style: italic; }
  </style>
</head>
<body>

<div class="container py-4">
    <a href="../index.php" class="btn-back"><i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda</a>

    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary me-2"></i>Jadwal & Hasil</h3>
            <p class="text-muted small mb-0">Riwayat pertandingan & perkiraan jadwal musim ini.</p>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <form action="" method="GET">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel"></i></span>
                    <select name="team_id" class="form-select border-start-0" onchange="this.form.submit()">
                        <option value="">-- Tampilkan Semua Tim --</option>
                        <?php foreach($teams as $id => $val): ?>
                            <option value="<?= $id; ?>" <?= ($filter_id == $id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($val['nama_tim']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0 text-dark">Hasil Pertandingan</h5>
                <?php if($filter_id) echo "<span class='badge bg-secondary'>$current_team_name</span>"; ?>
            </div>

            <?php if (count($history_matches) > 0): ?>
                <?php foreach ($history_matches as $row): 
                    $h = $teams[$row['tim_home']];
                    $a = $teams[$row['tim_away']];
                ?>
                    <div class="card card-custom">
                        <div class="match-row">
                            <div class="team-box home">
                                <span class="team-name d-none d-sm-block"><?= htmlspecialchars($h['nama_tim']); ?></span>
                                <img src="<?= htmlspecialchars($h['logo']); ?>" class="team-logo" alt="Home">
                            </div>
                            <div class="center-box">
                                <div class="score-badge">
                                    <?= $row['skor_tim_home']; ?> - <?= $row['skor_tim_away']; ?>
                                </div>
                                <div class="match-meta">
                                    <?= date('d M Y', strtotime($row['tanggal_pertandingan'])); ?>
                                </div>
                            </div>
                            <div class="team-box away">
                                <img src="<?= htmlspecialchars($a['logo']); ?>" class="team-logo" alt="Away">
                                <span class="team-name d-none d-sm-block"><?= htmlspecialchars($a['nama_tim']); ?></span>
                            </div>
                        </div>
                        <div class="venue-info">
                            <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($h['stadion']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-light text-center border">Belum ada pertandingan yang selesai.</div>
            <?php endif; ?>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 20px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold m-0 text-primary"><i class="bi bi-calendar-plus me-2"></i>Jadwal Berikutnya</h6>
                    <small class="text-muted">Simulasi jadwal sisa musim ini</small>
                </div>
                <div class="card-body p-0 bg-light" style="max-height: 80vh; overflow-y: auto;">
                    
                    <?php if (count($upcoming_matches) > 0): ?>
                        <?php foreach ($upcoming_matches as $row): 
                            $ts = strtotime($row['date']);
                            $dateLabel = date('l, d F Y', $ts);
                        ?>
                            <div class="schedule-item">
                                <div class="text-center">
                                    <span class="schedule-date-badge">
                                        <?= $dateLabel; ?>
                                    </span>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div class="text-center" style="width: 40%;">
                                        <img src="<?= htmlspecialchars($row['home_logo']); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                                        <div class="fw-bold mt-1 lh-sm" style="font-size: 0.8rem;"><?= htmlspecialchars($row['home_name']); ?></div>
                                    </div>

                                    <div class="text-center vs-text">VS</div>

                                    <div class="text-center" style="width: 40%;">
                                        <img src="<?= htmlspecialchars($row['away_logo']); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                                        <div class="fw-bold mt-1 lh-sm" style="font-size: 0.8rem;"><?= htmlspecialchars($row['away_name']); ?></div>
                                    </div>
                                </div>

                                <div class="text-center mt-2 text-muted fst-italic" style="font-size: 0.75rem;">
                                    <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($row['home_stadion']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-check2-circle fs-1 mb-2"></i>
                            <p>Semua pertandingan musim ini sudah selesai!</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>