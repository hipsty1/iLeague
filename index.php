<?php
include 'php/connect.php';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ileague</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <style>
      :root {
        --pl-purple: #37003c;
        --pl-pink: #ff2882;
        --pl-gray: #f5f5f7;
        --pl-dark: #111118;
      }
      body {
        background-color: var(--pl-gray);
      }
      /* NAVBAR */
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
      .chip {
        border: 1px solid #e9e9ef;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
      }
      /* HERO */
      .hero-card {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
      }
      .hero-card .img-wrap {
        position: relative;
        min-height: 360px;
        background-size: cover;
        background-position: center;
      }
      .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
          180deg,
          rgba(0, 0, 0, 0.05) 0%,
          rgba(0, 0, 0, 0.55) 55%,
          rgba(0, 0, 0, 0.9) 100%
        );
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        color: #fff;
      }
      .hero-title {
        font-weight: 800;
        line-height: 1.05;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.35);
      }
      .section-title {
        font-weight: 800;
        color: var(--pl-dark);
      }
      /* RIGHT SIDEBAR */
      .story-item img {
        width: 88px;
        height: 56px;
        object-fit: cover;
        border-radius: 0.5rem;
      }
      .story-item {
        --bs-list-group-border-color: transparent;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
      }
      .story-item:last-child {
        border-bottom: 0;
      }
      /* SCOREBOARD */
      .board {
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 0 0 1px #eee;
      }
      .board .head {
        background: #fff;
        padding: 0.9rem 1.1rem;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .badge-pill {
        background: #f0f0f4;
        color: #333;
        border-radius: 999px;
        padding: 0.25rem 0.65rem;
        font-size: 0.75rem;
      }
      .fixture {
        padding: 0.85rem 1.1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        border-top: 1px solid #f1f1f1;
      }
      .fixture:first-child {
        border-top: 0;
      }
      .team {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        min-width: 0;
        flex: 1;
      }
      .crest {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #e8e8ef;
        display: inline-block;
      }
      .team span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .score {
        font-weight: 800;
        min-width: 52px;
        text-align: center;
      }
      .status {
        font-size: 0.7rem;
        color: #888;
        min-width: 24px;
        text-align: right;
      }
      /* NEWS GRID */
      .news-card {
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        background: #fff;
        height: 100%;
      }
      .news-card .ratio {
        background: #e9ecef;
      }
      .news-card .card-body {
        min-height: 110px;
      }

      /* SPONSOR STRIP (baru) */
      .sponsor-strip {
        background: #fff;
        box-shadow: 0 0 0 1px #eee;
        border-radius: 1rem;
      }
      .sponsor-logo {
        height: 36px;
        max-width: 140px;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.9;
        transition: all 0.2s;
      }
      .sponsor-logo:hover {
        filter: none;
        opacity: 1;
      }
      .sponsor-role {
        font-size: 0.75rem;
        color: #787b86;
        margin-top: 0.25rem;
        white-space: nowrap;
      }

      /* FOOTER */
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
    </style>
  </head>
  <body>
    <!-- NAVBAR (disederhanakan: Klasemen, Tim, Reward) -->
    <nav class="navbar navbar-expand-lg pl-navbar border-bottom sticky-top">
      <div class="container">
        <a class="navbar-brand brand-badge d-flex align-items-center" href="#">
          <img src="assets/image/logo.png" alt="Premier League Logo" width="35" height="35" class="me-2">
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
              <a class="nav-link active" href="klasemen.html">Klasemen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tim.html">Tim</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reward.html">Reward</a>
            </li>
          </ul>
          <div class="d-flex align-items-center gap-3">
            <!-- Profile dropdown (shown after login) -->
            <div class="dropdown d-none" data-auth="profile-wrap">
              <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAxMjggMTI4Jz48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9J2cnIHgxPScwJyB4Mj0nMScgeTE9JzAnIHkyPScxJz48c3RvcCBvZmZzZXQ9JzAnIHN0b3AtY29sb3I9JyNkOWQ5ZDknLz48c3RvcCBvZmZzZXQ9JzEnIHN0b3AtY29sb3I9JyNmMmYyZjInLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48Y2lyY2xlIGN4PSc2NCcgY3k9JzY0JyByPSc2NCcgZmlsbD0ndXJsKCNnKScvPjxjaXJjbGUgY3g9JzY0JyBjeT0nNTAnIHI9JzI2JyBmaWxsPScjYjViNWI1Jy8+PHBhdGggZD0nTTIwLDExNmE0NCw0NCAwIDAgMSA4OCwwJyBmaWxsPScjYjViNWI1Jy8+PC9zdmc+" alt="avatar" class="rounded-circle" width="32" height="32" style="border:1px solid #ced4da;"/>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li class="px-3 py-2">
                  <div class="small text-muted">Signed in</div>
                  <div class="fw-semibold" data-profile="email">user@example.com</div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="profil.html"><i class="bi bi-person-gear me-2"></i>Profil</a></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
              </ul>
            </div>

            <i class="bi bi-search"></i>
            <a class="btn btn-outline-dark rounded-pill px-3" href="signin.html" data-auth="signin-btn"
              >Sign in</a
            >
          </div>
        </div>
      </div>
    </nav>

    <main class="container my-4">
      <div class="row g-4">
        <!-- LEFT: HERO -->
        <div class="col-lg-8">
          <div class="card hero-card shadow-sm mb-4">
            <div
              class="img-wrap"
              style="
                background-image: url('assets/image/news/topNews.png');
              "
            >
              <div class="hero-overlay">
                <div>
                  <span class="badge text-bg-light text-dark rounded-pill mb-2"
                    >Match report</span
                  >
                  <h1 class="display-6 hero-title mb-2">
                    Jadwal I-League Terlengkap
                  </h1>
                  <p class="mb-0">
                    Kumpulan seluruh jadwal pertandingan I-League.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Latest News grid -->
          <h2 class="section-title mb-3">Latest News</h2>
          <div class="row g-4">
            <div class="col-md-6 col-xl-3">
              <article class="card news-card shadow-sm">
                <div class="ratio ratio-16x9">
                  <img
                    src="https://cdn1-production-images-kly.akamaized.net/Qkzamz1cnI8aeFnOydZ0g2ApC2E=/57x0:1070x1350/1280x1706/filters:quality(75):strip_icc()/kly-media-production/medias/5209994/original/011488500_1746457858-Satu_kemenangan_lagi__satu_langkah_lagi__kita_ubah_Bandung_jadi_lautan_biru.Tetap_di_belakang_kami__Bobotoh..jpg"
                    class="w-100 h-100 object-fit-cover"
                    alt="Persib"
                  />
                </div>
                <div class="card-body">
                  <a href="https://www.bola.com/indonesia/read/6208356/menyadari-suporter-punya-asa-tinggi-untuk-persib-di-level-asia-ini-kata-marc-klok"><h6 class="fw-bold mb-1">Menyadari Suporter Punya Asa...</h6> </a>
                  <small class="text-muted d-block">Indonesia</small>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="card news-card shadow-sm">
                <div class="ratio ratio-16x9">
                  <img
                    src="https://cdn0-production-images-kly.akamaized.net/0lF6aqlu-GdKOYBQCuBH8YFbwTQ=/0x0:3000x1688/1280x720/filters:quality(75):strip_icc():watermark(kly-media-production/assets/images/watermarks/bola/watermark-color-landscape-new.png,1205,20,0)/kly-media-production/medias/5296325/original/012442900_1753573688-Launching_Persijap_Jepara-1.jpg"
                    class="w-100 h-100 object-fit-cover"
                    alt="Persijap"
                  />
                </div>
                <div class="card-body">
                  <a href="https://www.bola.com/indonesia/read/6207842/persijap-jepara-panen-rekor-buruk-hingga-tersungkur-di-zona-degradasi-telan-6-kekalahan-beruntun-kolektor-kartu-merah-terbanyak"><h6 class="fw-bold mb-1">Persijap Jepara Panen Rekor...</h6></a>
                  <small class="text-muted d-block">BRI Super League</small>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="card news-card shadow-sm">
                <div class="ratio ratio-16x9">
                  <img
                    src="https://cdn1-production-images-kly.akamaized.net/bjoNst8gPJWZVDX-fAK3Ee8iP08=/1280x720/smart/filters:quality(75):strip_icc()/kly-media-production/medias/5408100/original/024154800_1762763798-j805kvaj.png"
                    class="w-100 h-100 object-fit-cover"
                    alt="Coach"
                  />
                </div>
                <div class="card-body">
                  <a href="https://www.bola.com/indonesia/read/6208026/patricio-matricardi-dapat-pelajaran-besar-dalam-kemenangan-dramatis-persib-atas-selangor"><h6 class="fw-bold mb-1">Patricio Matricardi Dapat...</h6></a>
                  <small class="text-muted d-block">BRI Super League</small>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="card news-card shadow-sm">
                <div class="ratio ratio-16x9">
                  <img
                    src="https://cdn1-production-images-kly.akamaized.net/3EOlr57oBoVk3oiyNgJS3QKFDsE=/0x42:1599x943/1280x720/filters:quality(75):strip_icc()/kly-media-production/medias/5307862/original/009171400_1754487646-WhatsApp_Image_2025-08-06_at_20.27.15-2.jpeg"
                    class="w-100 h-100 object-fit-cover"
                    alt="Chelsea vs Spurs"
                  />
                </div>
                <div class="card-body">
                  <a href="https://www.bola.com/indonesia/read/6207999/4-fakta-menarik-pekan-ke-12-bri-super-league-20252026-hujan-kartu-merah-lagi-borneo-fc-menang-terus"><h6 class="fw-bold mb-1">4 Fakta Menarik...</h6></a>
                  <small class="text-muted d-block">BRI Super League</small>
                </div>
              </article>
            </div>
          </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <aside class="col-lg-4">
          <div class="card shadow-sm mb-4">
            <div class="card-body">
              <h5 class="fw-bold mb-3">Top stories</h5>
              <div class="list-group list-group-flush">
                <a href="https://www.jawapos.com/sepak-bola-indonesia/016202141/eduardo-perez-genjot-taktik-persebaya-surabaya-filosofi-baru-siap-guncang-liga-1-indonesia-20252026" class="list-group-item story-item">
                  <div class="d-flex gap-3 align-items-center">
                    <img
                      src="https://static.promediateknologi.id/crop/363x118:1197x614/0x0/webp/photo/p2/01/2025/06/27/perez-3062544118.jpg"
                      alt="Taktik"
                      class="flex-shrink-0"
                    />
                    <div class="flex-grow-1">
                      <div class="fw-semibold">
                        Eduardo Perez Genjot Taktik Persebaya
                      </div>
                      <small class="text-muted">Tactics and Analysis</small>
                    </div>
                  </div>
                </a>
                <a href="https://bola.okezone.com/read/2025/11/11/49/3182978/kata-asisten-pelatih-persib-bandung-igor-tolic-soal-bojan-hodak-jadi-juru-taktik-timnas-indonesia" class="list-group-item story-item">
                  <div class="d-flex gap-3 align-items-center">
                    <img
                      src="https://img.okezone.com/content/2025/11/11/49/3182978/asisten_pelatih_persib_bandung_menanggapi_rumor_soal_bojan_hodak_jadi_juru_taktik_timnas_indonesia-rbRo_large.jpg"
                      alt="Taktik"
                      class="flex-shrink-0"
                    />
                    <div class="flex-grow-1">
                      <div class="fw-semibold">
                        Kata Asisten Pelatih Persib Bandung
                      </div>
                      <small class="text-muted">Tactics and Analysis</small>
                    </div>
                  </div>
                </a>
                <a href="https://wow.tribunnews.com/superball/373549/rumor-transfer-pelatih-liga-1-persebaya-persis-dewa-united-berebut-timnas-indonesia-goda-persib#goog_rewarded" class="list-group-item story-item">
                  <div class="d-flex gap-3 align-items-center">
                    <img
                      src="https://asset.tribunnews.com/omSVUuR_DeDeNF0aizAMPVU7U44=/1200x800/filters:upscale():quality(30):format(webp):focal(0.5x0.5:0.5x0.5)/wow/foto/bank/originals/Surabaya-fuad-sule.jpg"
                      alt="Transfer"
                      class="flex-shrink-0"
                    />
                    <div class="flex-grow-1">
                      <div class="fw-semibold">
                        Rumor Transfer Pelatih Liga 1
                      </div>
                      <small class="text-muted">Transfer</small>
                    </div>
                  </div>
                </a>
                <a href="https://www.tribunnews.com/superskor/2025/06/18/aroma-juru-taktik-belanda-di-liga-1-kian-kental-pelatih-psim-bakal-jadi-saingan-baru-bojan-hodak" class="list-group-item story-item">
                  <div class="d-flex gap-3 align-items-center">
                    <img
                      src="https://asset-2.tribunnews.com/tribunnews/foto/bank/images/PSIM-Yogyakarta-Jean-Paul-Van-Gastel.jpg"
                      alt="Taktik
                      class="flex-shrink-0"
                    />
                    <div class="flex-grow-1">
                      <div class="fw-semibold">
                        Aroma Juru Taktik Belanda di Liga 1 Kian Kental
                      </div>
                      <small class="text-muted">Taktik</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <!-- SCOREBOARD -->
          <?php
            $sql = "SELECT * FROM pertandingan ORDER BY id_pertandingan DESC LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="list-group">';
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="list-group-item border-0 mb-2 shadow-sm rounded-3 p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="crest bg-secondary rounded-circle d-inline-block" style="width:30px; height:30px;"></span>
                                <span class="fw-semibold">' . htmlspecialchars($row["home_team"]) . '</span>
                            </div>

                            <div class="text-center flex-grow-1">
                                <span class="fs-5 fw-bold">' . $row["home_score"] . ' - ' . $row["away_score"] . '</span>
                            </div>

                            <div class="d-flex align-items-center gap-2 justify-content-end">
                                <span class="fw-semibold">' . htmlspecialchars($row["away_team"]) . '</span>
                                <span class="crest bg-secondary rounded-circle d-inline-block" style="width:30px; height:30px;"></span>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <span class="badge bg-primary px-3 py-1">' . htmlspecialchars($row["status"]) . '</span>
                        </div>
                    </div>
                    ';
                }
                echo '</div>';
            } else {
                echo "<p class='text-muted text-center'>Tidak ada data pertandingan.</p>";
            }

            $conn->close();
            ?>
          </div>
        </aside>
      </div>
    </main>

    <!-- SPONSOR STRIP (baru, sebelum footer) -->
    <section class="container my-5">
      <div class="sponsor-strip py-4 px-2 px-md-3">
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

    <!-- FOOTER (tanpa 'Unduh' & 'Media Sosial') -->
    <footer class="pt-5 mt-5">
      <div class="container pb-4">
        <div class="row g-4">
          <div class="col-6 col-lg-3">
            <div class="footer-title">LIGA INDONESIA</div>
            <ul class="list-unstyled small mb-0">
              <li class="mb-2"><a href="#">Beranda</a></li>
              <li class="mb-2">
                <a href="pages/match.html">Jadwal Dan Hasil Pertandingan</a>
              </li>
              <li class="mb-2"><a href="pages/klasemen.html">Klasemen</a></li>
              <li class="mb-2"><a href="pages/tim.html">Klub</a></li>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
// === Points utility ===
function getPoints(){ return parseInt(localStorage.getItem('points') || '0', 10); }
function setPoints(v){ localStorage.setItem('points', String(v)); }
// Award points with toast
function awardPoints(amount, reason){
  const now = getPoints() + amount;
  setPoints(now);
  // Show toast if host page has a toast container
  let tEl = document.getElementById('pointsToast');
  if(!tEl){
    const wrap = document.createElement('div');
    wrap.className = 'position-fixed bottom-0 end-0 p-3'; wrap.style.zIndex = '1080'; wrap.innerHTML = `
      <div id="pointsToast" class="toast text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" id="pointsToastMsg"></div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>`;
    document.body.appendChild(wrap);
    tEl = document.getElementById('pointsToast');
  }
  document.getElementById('pointsToastMsg').textContent = `+${amount} poin ${reason ? '('+reason+')' : ''}. Total: ${now}`;
  (new bootstrap.Toast(tEl)).show();
}

document.addEventListener('DOMContentLoaded', function(){
  // Clicks on news cards & top stories
  document.querySelectorAll('.news-card a, .story-item, .hero-card .img-wrap').forEach(function(el){
    el.addEventListener('click', function(ev){
      awardPoints(10, 'baca berita');
      // allow navigation; if href="#" prevent to avoid jumping
      if(el.matches('.story-item')) ev.preventDefault();
    });
  });
});

// === Simple session using localStorage ===
function isLoggedIn(){ return localStorage.getItem('isLoggedIn') === 'true'; }
function getEmail(){ return localStorage.getItem('authEmail') || ''; }
function getPassword(){ return localStorage.getItem('authPassword') || ''; }
function isAdmin(){ return localStorage.getItem('isAdmin') === 'true'; }

function renderAuthUI(){
  const signBtn = document.querySelector('[data-auth=signin-btn]');
  const profileWrap = document.querySelector('[data-auth=profile-wrap]');
  if(signBtn && profileWrap){
    if(isLoggedIn()){
      signBtn.classList.add('d-none');
      profileWrap.classList.remove('d-none');
      document.querySelectorAll('[data-profile=email]').forEach(el => el.textContent = getEmail());
    }else{
      profileWrap.classList.add('d-none');
      signBtn.classList.remove('d-none');
    }
  }
  // Inject Admin menu item in navbar if admin
  const nav = document.querySelector('.navbar .navbar-nav');
  if(nav && isAdmin() && !document.getElementById('adminMenuItem')){
    const li = document.createElement('li');
    li.className = 'nav-item';
    li.id = 'adminMenuItem';
    li.innerHTML = '<a class="nav-link text-danger fw-bold" href="admin.html">Edit Klasemen</a>';
    nav.appendChild(li);
  }
}

function logout(){
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('authEmail');
  localStorage.removeItem('authPassword');
  localStorage.removeItem('isAdmin');
  renderAuthUI();
}
document.addEventListener('DOMContentLoaded', renderAuthUI);
</script>
</body>
</html>
