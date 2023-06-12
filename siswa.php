<?php
       session_start();
        
       if ( !isset($_SESSION["signin"])) {
           header("Location: login.php");
           exit;
       }

    include 'db.php';
    //Fungsi Tambah Data Siswa
    if (isset($_POST['addsiswa']))
    {
        $nis_siswa = $_POST['nis_siswa'];
		$nama_siswa = addslashes($_POST['nama_siswa']);
        $kelas = $_POST['kelas_siswa'];

        $addsiswa = mysqli_query($conn, "INSERT INTO siswa (nis_siswa, nama_siswa, kelas, tahun_lulus) 
									VALUES('$nis_siswa','$nama_siswa','$kelas')");
        if($addsiswa){
            echo "<script>
                    alert('Data Berhasil Ditambahkan');
                    document.location.href = 'siswa.php';
                </script>";
        }else{
            echo "<script>
					alert('Data Gagal Ditambahkan');
					document.location.href = 'siswa.php';
				  </script>";
            
        }
    }

    // Ubah Siswa 
    if(isset($_POST['ubahsiswa'])){
        $ide = $_POST['ide'];
        $nis = $_POST['nis'];
        $nama = addslashes($_POST['nama']);
        $kelas = $_POST['kelas'];

        $ubah = mysqli_query($conn, "UPDATE siswa SET nis_siswa= '$nis', nama_siswa='$nama', kelas='$kelas' WHERE id_siswa ='$ide' ");
        
        if($ubah){
            echo "<script>
                alert('Data Berhasil Di ubah');
                document.location.href = 'siswa.php';
                </script>";
        }else{
            // echo "<script>
			// 	alert('Data Gagal Di ubah');
			// 	document.location.href = 'siswa.php';
			//     </script>";
            echo"gagal";
        }
    }

    // Hapus Siswa 
    if(isset($_POST['deletesiswa'])){
        $id_s = $_POST['iddel'];

        $hapus = mysqli_query($conn,"DELETE FROM siswa WHERE id_siswa = '$id_s'");

        if($hapus){
            echo " <script>
                    alert('Berhasil di hapus');
                    document.location.href = 'siswa.php';
                </script>";
        }else{
            echo "
			<script>
                    alert('Gagal di hapus');
                    document.location.href = 'siswa.php';
                </script>
		  ";
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
        <title>Siswa</title>
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
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
                        <h1 class="mt-4">Data Siswa </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Siswa</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body justify-content-right d-flex flex-row-reverse">
                            <button data-toggle="modal" data-target="#tambahsiswa" type="button" class="btn btn-info mr-2">Tambah Data Siswa</button>
                            </div>
                        </div>
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
                                            $data_siswa = mysqli_query($conn, "SELECT * FROM siswa");
                                            $no=1;
                                            while($row=mysqli_fetch_assoc($data_siswa)){
                                                $id_siswa = $row['id_siswa'];
                                                $nis_siswa=$row['nis_siswa'];
                                                $nama_siswa=$row['nama_siswa'];
                                                $kelas=$row['kelas'];
                                                ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?=$nis_siswa;?></td>
                                                <td><?=$nama_siswa;?></td>
                                                <td><?=$kelas;?></td>
                                                <td>
                                                    <form method="post">
                                                        <button data-toggle="modal" data-target="#editfaktor<?= $id_siswa; ?>" type="button" class="btn btn-warning"><i class='fa fa-cog'></i></button>
                                                        <input type='hidden' name='iddel' value="<?= $id_siswa?>">
                                                        <button name='deletesiswa' type='submit' class='btn btn-danger' alt='Delete' onclick=" return confirm('Apakah Anda Yakin Untuk Menghapus <?= $nama_siswa?>?')";><div class='icon'><i class='fa fa-trash'></i></div></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit Siswa-->
                                            <div id="editfaktor<?= $id_siswa; ?>" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Ubah <?= $nama_siswa; ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post">
                                                                        <div class="form-group">
                                                                            <label>NIS</label>
                                                                            <input name="nis" type="number" class="form-control" value="<?= $nis_siswa; ?>" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Nama Siswa</label>
                                                                            <input name="nama" type="text" class="form-control" value="<?= $nama_siswa ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <select name="kelas" id="type" class="form-control" required="true">
                                                                                <option value="9A" <?php if ($kelas == "9A"){ echo "selected"; } ?>>9A</option>
                                                                                <option value="9B" <?php if ($kelas == "9B"){ echo "selected"; } ?>>9B</option>
                                                                                <option value="9C" <?php if ($kelas == "9C"){ echo "selected"; } ?>>9C</option>
                                                                            </select>
                                                                        </div>
                                                                      
                                                                            <input type="hidden" name="ide" value="<?= $id_siswa; ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                        <input name ="ubahsiswa" type="submit" class="btn btn-primary" value="Simpan">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <!-- modal input -->
                                        </tbody>
                                        <?php
                                            }
                                        ?>
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
        <!-- Modal Tambah Siswa -->
                    <div id="tambahsiswa" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    
                                    <h4 class="modal-title">Tambah Data Siswa</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label>NIS (Nomer Induk Siswa)</label>
                                            <input name="nis_siswa" type="number" min="0" class="form-control" placeholder="NIS" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Siswa</label>
                                            <input name="nama_siswa" type="text"  class="form-control" placeholder="Nama Siswa" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <select name="kelas_siswa" id="type" class="form-control" required="true">
                                                <option value="9A">9A</option>
                                                <option value="9B">9B</option>
                                                <option value="9C">9C</option>
                                            </select>
                                        </div>
                                       
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <input name ="addsiswa" type="submit" class="btn btn-primary" value="Tambah">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- Modal Tambah Siswa -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
