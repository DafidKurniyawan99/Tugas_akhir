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
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
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
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql = "select * from siswa";
                                                $query = mysqli_query($conn,$sql);
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($query)){
                                            ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['nis_siswa'] ?></td>
                                                <td><?= $row['nama_siswa'] ?></td>
                                                <td><?= $row['kelas'] ?></td>
                                                <td>
                                                    <a href="hitungaspek.php?id=1&id_siswa=<?=$row['id_siswa']?>" class="btn btn-info">Aspek Nilai</a>
                                                    <a href="hitungaspek.php?id=2&id_siswa=<?=$row['id_siswa']?>" class="btn btn-info">Aspek Kedisiplinan</a>
                                                    <a href="hitungaspek.php?id=3&id_siswa=<?=$row['id_siswa']?>" class="btn btn-info">Aspek Prestasi</a>
                                                    <a href="hitungnilai.php?id_siswa=<?=$row['id_siswa']?>" class="btn btn-primary">Hitung Keputusan</a>
                                                </td>
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
        <!-- Tambah Calon -->
        <div id="tambahpn" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Kriteria</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post">
                            <label>Siswa</label>
                            <select name="id_siswa" class="custom-select form-control mt-2">
                                <option selected>Pilih Siswa</option>
                                <?php
                                    $det=mysqli_query($conn,"SELECT*FROM siswa WHERE id_siswa NOT IN (select id_siswa from penilaian)");
                                    while($d=mysqli_fetch_array($det)){
                                ?>
                                    <option value="<?php echo $d['id_siswa'] ?>"> <?php echo $d['nis_siswa'] ?> | <?php echo $d['nama_siswa'] ?> | <?php echo $d['kelas_siswa'] ?></option>
                                <?php
                                    }
                                ?>		
                            </select>
                            <div class="form-group mt-2">
                            <?php
                                $query="SELECT * FROM kriteria";
                                $execute=$conn->query($query);
                                if ($execute->num_rows > 0){
                                    while($data=$execute->fetch_array(MYSQLI_ASSOC)){
                                        echo "<div class=\"form-control mb-1\">";
                                        echo "<label for=\"nilai\">$data[nm_kriteria] :</label>";
                                        echo "<input type='hidden' value=$data[id_kriteria] name='kriteria[]'>";
                                        echo "<select class=\"form-costum ml-2\" required name=\"nilai[]\" id=\"nilai\">";
                                        echo "<option selected>-- Pilih $data[nm_kriteria] --</option>";
                                        $query2="SELECT id_nilai,nm_nilai,nilai_standar_bobot FROM bobot WHERE id_kriteria='$data[id_kriteria]' ORDER BY nilai_standar_bobot ASC";
                                        $execute2=$conn->query($query2);
                                            if ($execute2->num_rows > 0){
                                                while ($data2=$execute2->fetch_array(MYSQLI_ASSOC)){
                                                    echo "<option value=\"$data2[nilai_standar_bobot] \">$data2[nm_nilai]</option>";
                                                }
                                            }else{
                                                echo "<option disabled value=\"\">Belum ada Nilai Kriteria</option>";
                                            };
                                        echo "</select></div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input name ="addpen" type="submit" class="btn btn-primary" value="Tambah">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Calon -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
