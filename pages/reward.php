<?php 
    include "../php/connect.php";
    session_start();
    // Cek apakah user sudah login
    $timeout_duration = 600; // durasi timeout dalam detik
    if(!isset($_SESSION['username'])){
        echo "<script>alert('Anda Belum Login!'); window.location.href='pages/signin.php';</script>";
        exit();
    }
    // Cek Timeout Session
    if(isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $timeout_duration){
        session_unset();
        session_destroy();
        echo "<script>alert('Sesi Anda Telah Berakhir. Silakan Login Kembali.'); window.location.href='pages/signin.php';</script>";
        exit();
    }
    $_SESSION['start_time'] = time();
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reward — ILeague</title>

    <!-- Bootstrap & Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />

    <style>
      :root {
        --pl-purple: #37003c;
        --pl-pink: #ff2882;
        --pl-bg: #f7f5fb;
        --pl-surface: #ffffff;
        --border: #ece6f0;
        --text: #2b2b2b;
      }
      html,
      body {
        height: 100%;
      }
      body {
        font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto,
          Arial, sans-serif;
        background: var(--pl-bg);
        color: var(--text);
      }
      /* === NAVBAR (sama seperti klasemen.html) === */
      .pl-navbar {
        background: #fff;
      }
      .brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 800;
        color: var(--pl-purple);
      }
      .brand-badge .lion {
        width: 28px;
        height: 28px;
        display: inline-block;
        background: linear-gradient(135deg, var(--pl-purple), var(--pl-pink));
        border-radius: 6px;
        position: relative;
      }
      .brand-badge .lion::after {
        content: "🦁";
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
      }

      /* Page Title */
      .page-title {
        font-weight: 800;
      }

      /* Reward Cards */
      .reward-card {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.05);
        height: 100%;
      }
      .reward-card .ratio {
        background: #e9ecef;
      }
      .reward-card .card-body {
        padding: 1rem 1rem 1rem;
      }
      .reward-card .card-title {
        font-weight: 700;
        font-size: 1rem;
      }
      .points {
        font-size: 0.86rem;
        color: #6a6570;
      }
      .progress.progress-slim {
        height: 6px;
        background: #f0eef4;
      }
      .progress-bar {
        background: #3d8bfd;
      }

      .coming-soon .ratio {
        filter: grayscale(100%);
        opacity: 0.65;
      }
      .coming-soon .card-body {
        opacity: 0.75;
      }
      .coming-tag {
        font-size: 0.9rem;
        color: #888;
      }

      /* History table */
      .history-wrap {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.05);
      }
      .history-wrap .head {
        border-bottom: 1px solid #eee;
      }
      .table-history th {
        color: #6d6478;
        font-weight: 700;
        white-space: nowrap;
      }
      .table-history td {
        vertical-align: middle;
      }
      .subtext {
        color: #8a8191;
        font-size: 0.9rem;
      }
      .btn-outline-primary {
        border-width: 1.5px;
      }

      /* Sponsors */
      .sponsor-strip {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 12px 22px rgba(0, 0, 0, 0.06);
        padding: 1.5rem 1rem;
        margin: 2.5rem 0 2.5rem;
      }
      .sponsor-logo {
        filter: grayscale(100%);
        opacity: 0.9;
        transition: all 0.2s;
        height: 38px;
        max-width: 140px;
        object-fit: contain;
      }
      .sponsor-logo:hover {
        filter: none;
        opacity: 1;
      }
      .sponsor-role {
        font-size: 0.75rem;
        color: #8b8595;
        margin-top: 0.35rem;
        white-space: nowrap;
      }

      /* Footer */
      footer {
        background: #0c0c12;
        color: #c8c8d0;
      }
      footer a {
        color: #c8c8d0;
        text-decoration: none;
      }
      footer a:hover {
        color: #fff;
      }
      .footer-title {
        font-weight: 800;
        color: #fff;
        font-size: 1.05rem;
        margin-bottom: 1rem;
      }
      .copyright {
        border-top: 1px solid #1e1e28;
        color: #8f90a6;
      }
      .reward-card {
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg pl-navbar border-bottom sticky-top">
      <div class="container">
        <a class="navbar-brand brand-badge d-flex align-items-center" href="../index.php">
          <img src="../assets/image/logo.png" alt="ILeague Logo" width="35" height="35" class="me-2">
          <span>ILeague</span>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navMain"
          aria-controls="navMain"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="klasemen.php">Klasemen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tim.php">Tim</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="reward.php">Reward</a>
            </li>
          </ul>
          <div class="d-flex align-items-center gap-3">
          <?php if (isset($_SESSION['username'])): ?>
           <!-- Profile dropdown (shown after login) -->
            <div class="dropdown" data-auth="profile-wrap">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAxMjggMTI4Jz48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9J2cnIHgxPScwJyB4Mj0nMScgeTE9JzAnIHkyPScxJz48c3RvcCBvZmZzZXQ9JzAnIHN0b3AtY29sb3I9JyNkOWQ5ZDknLz48c3RvcCBvZmZzZXQ9JzEnIHN0b3AtY29sb3I9JyNmMmYyZjInLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48Y2lyY2xlIGN4PSc2NCcgY3k9JzY0JyByPSc2NCcgZmlsbD0ndXJsKCNnKScvPjxjaXJjbGUgY3g9JzY0JyBjeT0nNTAnIHI9JzI2JyBmaWxsPScjYjViNWI1Jy8+PHBhdGggZD0nTTIwLDExNmE0NCw0NCAwIDAgMSA4OCwwJyBmaWxsPScjYjViNWI1Jy8+PC9zdmc+" 
                      alt="avatar" class="rounded-circle" width="32" height="32" style="border:1px solid #ced4da;"/>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li class="px-3 py-2">
                    <div class="small text-muted">Signed in</div>
                    <div class="fw-semibold" data-profile="email">
                      <?= htmlspecialchars($_SESSION['username']); ?>
                    </div>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../php/profile.php"><i class="bi bi-person-gear me-2"></i>Profil</a></li>
                  <li><a class="dropdown-item text-danger" href="../php/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
              </div>
            <?php else: ?>
              <i class="bi bi-search"></i>
              <a class="btn btn-outline-dark rounded-pill px-3" href="signin.php" data-auth="signin-btn">Sign in</a>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

    <main class="container my-4">
      <header class="mb-3">
        <h1 class="page-title">Reward</h1>
        <div class="mb-3">Point Anda: <span id="userPoints">0</span></div>
      </header>

      <!-- Reward grid (4 per row on lg+) -->
      <!-- Reward grid (8 cards) -->
<section class="mb-4">
  <div class="row g-4">
    <!-- Card 1 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="6750">
        <div class="ratio ratio-16x9">
          <img
            src="https://images.unsplash.com/photo-1753036051291-cfc20d052c24?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            class="w-100 h-100 object-fit-cover"
            alt="Roblox"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Roblox Digital Card</h6>
          <div class="points mb-2">0 of 6,750 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="2000">
        <div class="ratio ratio-16x9">
          <img
            src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=1200&auto=format&fit=crop"
            class="w-100 h-100 object-fit-cover"
            alt="Overwatch"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Overwatch Coins Digital Code</h6>
          <div class="points mb-2">0 of 2,000 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 3 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="1700">
        <div class="ratio ratio-16x9">
          <img
            src="https://images.unsplash.com/photo-1642211841112-2beeda7bfc07?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            class="w-100 h-100 object-fit-cover"
            alt="Sea of Thieves"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Sea of Thieves: Ancient Coin Pack</h6>
          <div class="points mb-2">0 of 1,700 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 4 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="7930">
        <div class="ratio ratio-16x9">
          <img
            src="https://media.karousell.com/media/photos/products/2025/6/27/evoucher_alfamart_100k__vouche_1750994831_554ca8ee_progressive"
            class="w-100 h-100 object-fit-cover"
            alt="Alfamart"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Alfamart Indonesia Gift Card</h6>
          <div class="points mb-2">0 of 7,930 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 5 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="2135">
        <div class="ratio ratio-16x9">
          <img
            src="https://img.lazcdn.com/g/p/ac1a3775e2ebf55ee3dbe1f6ac571ff4.jpg_720x720q80.jpg"
            class="w-100 h-100 object-fit-cover"
            alt="Grab"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Grab Indonesia Gift Card</h6>
          <div class="points mb-2">0 of 2,135 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 6 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="7930">
        <div class="ratio ratio-16x9">
          <img
            src="https://dynamic.zacdn.com/-HOjMbmcbXyBzNrXle2ac-T6zzg=/filters:quality(70):format(webp)/https://static-id.zacdn.com/p/zalora-7182-1952632-1.jpg"
            class="w-100 h-100 object-fit-cover"
            alt="Zalora"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-2">Zalora Gift Card</h6>
          <div class="points mb-2">0 of 7,930 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 7 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="1000">
        <div class="ratio ratio-16x9">
          <img
            src="https://yt3.googleusercontent.com/ytc/AIdro_mtaY3vlzfJwJ-vXiEu3K-TJIbSxYZpyi8LryjqiH-_jLI=s900-c-k-c0x00ffffff-no-rj"
            class="w-100 h-100 object-fit-cover"
            alt="UNICEF"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-1">Donate to UNICEF</h6>
          <div class="points mb-2">0 of 1,000 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>

    <!-- Card 8 -->
    <div class="col-12 col-sm-6 col-lg-3">
      <article class="card reward-card h-100" data-needed="1000">
        <div class="ratio ratio-16x9">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPOyUGg6bUH06CWiwb_PenrIpHEALMgkq01g&s"
            class="w-100 h-100 object-fit-cover"
            alt="IRC"
          />
        </div>
        <div class="card-body">
          <h6 class="card-title mb-1">Donate to the International Rescue Committee</h6>
          <div class="points mb-2">0 of 1,000 points</div>
          <div class="progress progress-slim">
            <div class="progress-bar" style="width: 0%"></div>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>


     <!-- Redeem History -->
<section class="history-wrap mb-5">
  <div class="p-3 p-md-4 head d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-1 fw-bold">Redeem history</h5>
      <small class="text-muted">Hadiah akan dikirimkan ke email anda dalam kurun waktu 1 x 24 jam.</small>
    </div>
    <button id="resetBtn" class="btn btn-outline-danger btn-sm">
      <i class="bi bi-arrow-counterclockwise"></i> Reset Poin & History
    </button>
  </div>
  <div class="table-responsive">
    <table class="table table-history align-middle mb-0">
      <thead>
        <tr>
          <th>Status</th>
          <th>Date</th>
          <th style="min-width: 420px">Reward</th>
          <th>Points</th>
          <th>Email Options</th>
          <th>Order Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6" class="text-center text-muted py-3">Belum ada transaksi.</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<script>
const DEFAULT_POINTS = 10000;

// ----------------- Storage & Helper -----------------
if (!localStorage.getItem("points")) {
  localStorage.setItem("points", DEFAULT_POINTS);
}

function getPoints() {
  return parseInt(localStorage.getItem("points") || DEFAULT_POINTS, 10);
}
function setPoints(v) {
  localStorage.setItem("points", String(v));
}
function getHistory() {
  return JSON.parse(localStorage.getItem("redeemHistory") || "[]");
}
function saveHistory(history) {
  localStorage.setItem("redeemHistory", JSON.stringify(history));
}
function generateOrderId() {
  return Math.random().toString(36).substring(2, 8) + "-" + Date.now();
}

// ----------------- Update UI -----------------
function updatePointLabel() {
  const el = document.getElementById("userPoints");
  if (el) el.textContent = getPoints().toLocaleString();
}

function updateProgressBars() {
  const have = getPoints();
  document.querySelectorAll(".reward-card").forEach((card) => {
    const pointsEl = card.querySelector(".points");
    const progressBar = card.querySelector(".progress-bar");
    if (!pointsEl || !progressBar) return;

    const needed = parseInt(
      (pointsEl.textContent.match(/of ([\d,]+)/) || [0, "0"])[1].replace(/,/g, "")
    );

    const percent = Math.min((have / needed) * 100, 100);
    progressBar.style.width = percent + "%";

    const displayPoints = have > needed ? needed : have;
    pointsEl.textContent = `${displayPoints.toLocaleString()} of ${needed.toLocaleString()} points`;
  });
}

function renderHistory() {
  const tbody = document.querySelector(".table-history tbody");
  const history = getHistory();
  tbody.innerHTML = "";
  if (history.length === 0) {
    tbody.innerHTML =
      "<tr><td colspan='6' class='text-center text-muted py-3'>Belum ada transaksi.</td></tr>";
    return;
  }
  history.forEach((item, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>Sent</td>
      <td>${item.date}</td>
      <td><div class="fw-semibold">${item.title}</div>
      <div class="subtext">Order No. ${item.orderId}</div></td>
      <td>${item.points.toLocaleString()}</td>
      <td><button class="btn btn-primary btn-sm btn-resend" data-index="${index}">Resend</button></td>
      <td><button class="btn btn-primary btn-sm btn-getcode" data-index="${index}">Get code</button></td>`;
    tbody.appendChild(tr);
  });

  // Pasang event listener untuk tombol
  document.querySelectorAll(".btn-resend").forEach(btn => {
    btn.addEventListener("click", () => {
      const idx = btn.dataset.index;
      const item = history[idx];
      const toast = new bootstrap.Toast(document.getElementById("infoToast"));
      document.getElementById("toastMsg").textContent =
        `📨 Transaksi "${item.title}" berhasil dikirim ulang. Order No. ${item.orderId}`;
      toast.show();
    });
  });

  document.querySelectorAll(".btn-getcode").forEach(btn => {
    btn.addEventListener("click", () => {
      const idx = btn.dataset.index;
      const item = history[idx];
      const toast = new bootstrap.Toast(document.getElementById("infoToast"));
      document.getElementById("toastMsg").textContent =
        `🔑 Kode transaksi untuk "${item.title}": ${item.orderId}`;
      toast.show();
    });
  });
}

// ----------------- Events -----------------
document.addEventListener("DOMContentLoaded", () => {
  const resetBtn = document.getElementById("resetBtn");
  if (resetBtn) {
    resetBtn.addEventListener("click", () => {
      if (confirm("Yakin ingin mereset poin dan riwayat redeem?")) {
        setPoints(DEFAULT_POINTS);
        saveHistory([]);
        updatePointLabel();
        updateProgressBars();
        renderHistory();
        alert("✅ Poin berhasil direset ke 10.000 dan riwayat dihapus.");
      }
    });
  }

  updatePointLabel();
  updateProgressBars();
  renderHistory();

  document.querySelectorAll(".reward-card").forEach((card) => {
    card.addEventListener("click", () => {
      const title = card.querySelector(".card-title").textContent.trim();
      const pointsText = card.querySelector(".points").textContent;
      const needed = parseInt(
        (pointsText.match(/of ([\d,]+)/) || [0, "0"])[1].replace(/,/g, "")
      );

      const modal = new bootstrap.Modal(document.getElementById("redeemModal"));
      document.getElementById("redeemQuestion").textContent =
        `Yakin ingin menukarkan "${title}" (${needed} poin)?`;
      modal.show();

      document.getElementById("btnRedeemYes").onclick = function () {
        modal.hide();
        const toast = new bootstrap.Toast(document.getElementById("infoToast"));
        const toastMsg = document.getElementById("toastMsg");

        const have = getPoints();
        if (have >= needed) {
          setPoints(have - needed);
          updatePointLabel();
          updateProgressBars();

          const history = getHistory();
          history.unshift({
            title,
            points: needed,
            date: new Date().toLocaleDateString("id-ID"),
            orderId: generateOrderId(),
          });
          saveHistory(history);
          renderHistory();

          toastMsg.textContent = `✅ Berhasil redeem "${title}". Sisa poin: ${(have - needed).toLocaleString()}`;
        } else {
          toastMsg.textContent = `❌ Poin kurang (${have.toLocaleString()} / ${needed.toLocaleString()})`;
        }
        toast.show();
      };
    });
  });
});
</script>


      <!-- SPONSOR STRIP (sama dengan klasemen) -->
      <section id="sponsors" class="sponsor-strip">
        <div class="container">
          <div
            class="d-flex justify-content-center align-items-center flex-wrap gap-4 gap-md-5"
          >
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/ea.com"
                alt="EA Sports"
              />
              <div class="sponsor-role">Lead Partner</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://img.logo.dev/adobe.com?token=live_6a1a28fd-6420-4492-aeb0-b297461d9de2&size=128&retina=false&format=png&theme=dark"
                alt="Adobe"
              />
              <div class="sponsor-role">Official Creativity Partner</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/barclays.com"
                alt="Barclays"
              />
              <div class="sponsor-role">Official Bank</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/coca-cola.com"
                alt="Coca‑Cola"
              />
              <div class="sponsor-role">Official Soft Drink</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/guinness.com"
                alt="Guinness"
              />
              <div class="sponsor-role">Official Beer</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/microsoft.com"
                alt="Microsoft"
              />
              <div class="sponsor-role">Official Cloud &amp; AI Partner</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/puma.com"
                alt="Puma"
              />
              <div class="sponsor-role">Official Ball</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/averydennison.com"
                alt="Avery Dennison"
              />
              <div class="sponsor-role">Official Licensee</div>
            </div>
            <div class="text-center">
              <img
                class="sponsor-logo"
                src="https://logo.clearbit.com/footballmanager.com"
                alt="Football Manager"
              />
              <div class="sponsor-role">Official Licensee</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Redeem Confirm Modal -->
      <div class="modal fade" id="redeemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Konfirmasi Redeem</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <p id="redeemQuestion" class="mb-0">
                Yakin ingin menukarkan point dengan hadiah ini?
              </p>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Tidak
              </button>
              <button type="button" class="btn btn-primary" id="btnRedeemYes">
                Yakin
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Info toast -->
      <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
        <div
          id="infoToast"
          class="toast align-items-center text-bg-primary border-0"
          role="alert"
          aria-live="assertive"
          aria-atomic="true"
        >
          <div class="d-flex">
            <div class="toast-body" id="toastMsg">Permintaan diproses.</div>
            <button
              type="button"
              class="btn-close btn-close-white me-2 m-auto"
              data-bs-dismiss="toast"
              aria-label="Close"
            ></button>
          </div>
        </div>
      </div>
    </main>

    <!-- FOOTER -->
    <footer class="pt-5 mt-5">
      <div class="container pb-4">
        <div class="row g-4">
          <div class="col-6 col-lg-3">
            <div class="footer-title">LIGA INDONESIA</div>
            <ul class="list-unstyled small mb-0">
              <li class="mb-2"><a href="../index.php">Beranda</a></li>
              <li class="mb-2">
                <a href="match.php">Jadwal Dan Hasil Pertandingan</a>
              </li>
              <li class="mb-2"><a href="klasemen.php">Klasemen</a></li>
              <li class="mb-2"><a href="tim.php">Klub</a></li>
            </ul>
          </div>
         
          <div class="col-12 col-lg-3">
            <div class="footer-title">KONTAK KAMI</div>
            <ul class="list-unstyled small">
              <li class="mb-2 fw-semibold">PT Liga Indonesia Baru</li>
              <li class="mb-2">
                Menara Mandiri 2, Lt 19<br />Jl. Jend. Sudirman, Kav 54-55,<br />Jakarta
                12190
              </li>
              <li class="mb-2">
                <i class="bi bi-telephone me-2"></i>+62 21 526 6777
              </li>
              <li class="mb-2">
                <i class="bi bi-telephone me-2"></i>+62 21 526 6747
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="copyright py-3">
        <div
          class="container small d-flex justify-content-between align-items-center"
        >
          <div>© 2025 ILeague. All Rights Reserved</div>
          <a href="#" class="text-decoration-none"
            ><i class="bi bi-arrow-up-circle"></i> Kembali ke atas</a
          >
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
  // === Points demo (offline + history) ===
  const DEFAULT_POINTS = 10000;

  function getPoints() {
    return parseInt(localStorage.getItem("points") || DEFAULT_POINTS, 10);
  }
  function setPoints(v) {
    localStorage.setItem("points", String(v));
  }
  function getHistory() {
    return JSON.parse(localStorage.getItem("redeemHistory") || "[]");
  }
  function saveHistory(history) {
    localStorage.setItem("redeemHistory", JSON.stringify(history));
  }

  function updatePointLabel() {
    const el = document.getElementById("userPoints");
    if (el) el.textContent = getPoints().toLocaleString();
  }

  function updateProgressBars() {
    const have = getPoints();
    document.querySelectorAll(".reward-card").forEach((card) => {
      const pointsEl = card.querySelector(".points");
      const progressBar = card.querySelector(".progress-bar");
      if (!pointsEl || !progressBar) return;

      const needed = parseInt(
        (pointsEl.textContent.match(/of ([\d,]+)/) || [0, "0"])[1].replace(
          /,/g,
          ""
        )
      );
      const percent = Math.min((have / needed) * 100, 100);
      progressBar.style.width = percent + "%";
    });
  }

  function renderHistory() {
    const tbody = document.querySelector(".table-history tbody");
    const history = getHistory();
    if (!tbody) return;

    tbody.innerHTML = "";
    if (history.length === 0) {
      tbody.innerHTML =
        "<tr><td colspan='6' class='text-center text-muted py-3'>Belum ada transaksi.</td></tr>";
      return;
    }

    history.forEach((item) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>Sent</td>
        <td>${item.date}</td>
        <td>
          <div class="fw-semibold">${item.title}</div>
          <div class="subtext">Order No. ${item.orderId}</div>
        </td>
        <td>${item.points.toLocaleString()}</td>
        <td><button class="btn btn-primary btn-sm">Resend</button></td>
        <td><button class="btn btn-primary btn-sm">Get code</button></td>
      `;
      tbody.appendChild(tr);
    });
  }

  function generateOrderId() {
    return Math.random().toString(36).substring(2, 8) + "-" + Date.now();
  }

  document.addEventListener("DOMContentLoaded", function () {
    updatePointLabel();
    updateProgressBars();
    renderHistory();

    document.querySelectorAll(".reward-card").forEach(function (card) {
      card.addEventListener("click", function () {
        const title = card.querySelector(".card-title").textContent.trim();
        const pointsText = card.querySelector(".points").textContent;
        const needed = parseInt(
          (pointsText.match(/of ([\d,]+)/) || [0, "0"])[1].replace(/,/g, "")
        );

        const modal = new bootstrap.Modal(
          document.getElementById("redeemModal")
        );
        document.getElementById(
          "redeemQuestion"
        ).textContent = `Yakin ingin menukarkan point dengan hadiah "${title}" ini (${needed} poin)?`;
        modal.show();

        document.getElementById("btnRedeemYes").onclick = function () {
          modal.hide();
          const toast = new bootstrap.Toast(document.getElementById("infoToast"));
          const toastMsg = document.getElementById("toastMsg");

          const have = getPoints();
          if (have >= needed) {
            // Kurangi poin dan update UI
            setPoints(have - needed);
            updatePointLabel();
            updateProgressBars();

            // Simpan ke history
            const history = getHistory();
            history.unshift({
              title: title,
              points: needed,
              date: new Date().toLocaleDateString("id-ID"),
              orderId: generateOrderId(),
            });
            saveHistory(history);
            renderHistory();

            toastMsg.textContent = `✅ Berhasil menukarkan "${title}". Sisa poin Anda: ${(have - needed).toLocaleString()}`;
          } else {
            toastMsg.textContent = `❌ Poin tidak cukup! Anda punya ${have.toLocaleString()} dari ${needed.toLocaleString()} yang dibutuhkan.`;
          }
          toast.show();
        };
      });
    });
  });
</script>

  </body>
</html>
