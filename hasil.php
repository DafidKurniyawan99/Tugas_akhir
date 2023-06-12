<?php
    session_start();
    
    if ( !isset($_SESSION["signin"])) {
        header("Location: login.php");
        exit;
    }
    include 'db.php';
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Penilaian - SPK Profile Matching</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/0596d95421.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="image" height="50" width="45" class="mr-2">SMP 3 Selomerto</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <h5 class="mt-2 ml-5 text-white"><strong>Sistem Pendukung Keputusan Menentukan Lulusan Terbaik Menggunakan Metode Profile Matching</strong></h5>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">User</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                User
                            </a>
                            <div class="sb-sidenav-menu-heading">Pengelolaan Data</div>
                            <a class="nav-link" href="siswa.php">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-users"></i></div>
                                Siswa
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Master Data
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="gap.php">Ketentuan Gap</a>
                                    <a class="nav-link" href="kriteria.php">Kriteria</a>
                                    <a class="nav-link" href="core.php">Jenis Faktor</a>
                                    <a class="nav-link" href="penilai.php">Penilaian</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Hasil</div>
                            <a class="nav-link" href="hasil.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Hasil Penilaian
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Data Penilaian</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Penilaian</li>
                        </ol>
                        <!-- <div class="card mb-4">
                            <div class="card-body">
                                <button data-toggle="modal" data-target="#tambahpn" type="button" class="btn btn-info mr-2">Tambah Calon</button>
                            </div>
                        </div> -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nilai Akhir</th>
                                            <th>Ranking</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $b =1; 
                                                $query = mysqli_query($conn, "select pm_ranking.*, siswa.* from pm_ranking, siswa where pm_ranking.id_siswa = siswa.id_siswa order by pm_ranking.nilai_akhir desc");
                                                $i =1 ;
                                                while($row = mysqli_fetch_assoc($query)){
                                            ?>
                                                <tr>
                                                    <td><?= $b++?></td>
                                                    <td><?= $row['nama_siswa'] ?></td>
                                                    <td><?= $row['nilai_akhir'] ?> </td>
                                                    <td><?= $i++ ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; spk profile matching 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
       
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
