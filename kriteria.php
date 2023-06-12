<?php
    session_start();
    
    if ( !isset($_SESSION["signin"])) {
        header("Location: login.php");
        exit;
    }
    include 'db.php';

    if(isset($_POST['addkriteria']) ){
        $jkfaktor = $_POST['jkfaktor'];
        $nm_kriteria = $_POST['nm_kriteria'];
        $target = $_POST['target'];      
        
        //input data ke database
        $addkriteria = mysqli_query($conn, "INSERT INTO kriteria (id_faktor, nm_kriteria, n_target) 
									VALUES ('$jkfaktor','$nm_kriteria','$target')");
        if($addkriteria){
            echo "<script>
                    alert('Data Berhasil Ditambahkan');
                    document.location.href = 'kriteria.php';
                </script>";
        }else{
            echo "<script>
					alert('Data Gagal Ditambahkan');
					document.location.href = 'kriteria.php';
				  </script>";
        }
    }
    // // edit kriteria 
    if(isset($_POST['updtkriteria'])){
        $ide = $_POST['id_e'];
        $nama = $_POST['nama_e'];
        $persen = $_POST['nilai_e'];
        $bobot_ec = $_POST['bobot_c'];
        $bobot_es = $_POST['bobot_s'];

        //Update data 
        $update = mysqli_query($conn, "UPDATE pm_kriteria SET 
        kriteria = '$nama' , prosentase = '$persen' , bobot_core = '$bobot_ec', bobot_secondary = '$bobot_es' 
        WHERE id_kriteria = '$ide'");

        if($update){
            echo "<script>
                    alert('Data Berhasil Diubah');
                    document.location.href = 'kriteria.php';
                </script>";
        }else{
            echo "<script>
                    alert('Data Gagal Diubah');
                    document.location.href = 'kriteria.php';
                </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kriteria - SPK profile matching</title>
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
                        <h1 class="mt-4">Kriteria</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Kriteria</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kriteria Penilaian</th>
                                                <th>Persentase</th>
                                                <th>Core Factor</th>
                                                <th>Secondary Factor</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $datakriteria = mysqli_query($conn, "SELECT * FROM pm_kriteria");
                                        $no = 1;
                                        while ($c = mysqli_fetch_assoc($datakriteria)) {
                                            $id = $c['id_kriteria'];
                                            $namakriteria = $c['kriteria'];
                                            $prosentase = $c['prosentase'];
                                            $bobot_c = $c['bobot_core'];
                                            $bobot_s = $c['bobot_secondary'];
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $namakriteria?></td>
                                                <td><?= $prosentase?>%</td>
                                                <td><?= $bobot_c?>%</td>
                                                <td><?= $bobot_s?>%</td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#editkriteria<?= $id ?>" type="button" class="btn btn-warning mr-2"><i class="fa-solid fa-gear"></i></button>
                                                </td>

                                            <!-- Modal Edit kriteria -->
                                            <div id="editkriteria<?= $id?>" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Kriteria</h4>
                                                            </div>
                                                            <div class="modal-body ">
                                                                <form method="post">
                                                                    <div class="form-group mt-2">
                                                                        <label for="">Jenis Faktor</label>
                                                                        <label>Nama kriteria</label>
                                                                        <input name="nama_e" type="text"  class="form-control "  value="<?= $namakriteria?>"required>
                                                                        <label>Prosentase</label>
                                                                        <input name="nilai_e" type="number"  class="form-control " min="0" max="100" value="<?= $prosentase?>"required>
                                                                        <label>Bobot Core</label>
                                                                        <input name="bobot_c" type="number"  class="form-control " min="0" max="100" value="<?= $bobot_c?>"required>
                                                                        <label>Bobot Secondary</label>
                                                                        <input name="bobot_s" type="number"  class="form-control " min="0" max="100" value="<?= $bobot_s?>"required>
                                                                        <input type="hidden" name="id_e" value="<?php echo $id ?>" \>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                        <input name ="updtkriteria" type="submit" class="btn btn-primary" value="Edit">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Akhir Modal edit -->
                                                <?php 
                                                }
                                            ?>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                   
                                </div>
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
        <!-- Modal tambah Kriteria -->
        <div id="tambahkriteria" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Kriteria</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post">
                            <label>Jenis Faktor</label>
                            <select name="jkfaktor" class="custom-select form-control mt-2">
                                <option selected>Pilih Faktor</option>
                                <?php
                                    $det=mysqli_query($conn,"SELECT*FROM faktor");
                                    while($d=mysqli_fetch_array($det)){
                                ?>
                                    <option value="<?php echo $d['id_faktor'] ?>"><?php echo $d['nm_faktor'] ?></option>
                                <?php
                                    }
                                ?>		
                            </select>
                            <div class="form-group mt-2">
                                <label>Nama Kriteria</label>
                                <input name="nm_kriteria" type="text"  class="form-control " placeholder="Nama Kriteria" required>
                            </div>
                            <div class="form-group mt-2">
                                <label>Nama Kriteria</label>
                                <input name="target" type="number"  class="form-control " placeholder="ex : 5" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input name ="addkriteria" type="submit" class="btn btn-primary" value="Tambah">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal tambah kriteria -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
