<?php
    session_start();
        
    if ( !isset($_SESSION["signin"])) {
        header("Location: login.php");
        exit;
    }

    include 'db.php';

    // Tambah Faktor 
    if(isset($_POST['addfaktor'])){
        $idf = $_POST['id_faktor'];
        $nmf = $_POST['nmf'];
        $trgt = $_POST['trgt'];
        $tip = $_POST['type'];

        $tambah_faktor = mysqli_query($conn, "INSERT INTO pm_faktor (id_kriteria, faktor, nilai_target, jenis_faktor) VALUES ('$idf','$nmf','$trgt','$tip')");

        if($tambah_faktor){
            echo "<script>
            alert('Data Berhasil Di Tambah');
            document.location.href = 'core.php';
            </script>";
        }else{
            // echo "<script>
            // alert('Data Gagal Di Tambah');
            // document.location.href = 'core.php';
            // </script>";
            echo"woyyy";
        }
    }
    //Fungsi Edit Faktor
    if ( isset($_POST['ubahfaktor']) ) {
		$id_faktor = $_POST['id_faktor'];
		$nama_faktor = $_POST['faktor'];
        $target = $_POST['target'];
        $typee = $_POST['type'];
       
		$editfaktor = mysqli_query($conn, "UPDATE pm_faktor SET  
				faktor ='$nama_faktor', nilai_target ='$target', jenis_faktor='$typee' WHERE id_faktor ='$id_faktor'");
                
		if ($editfaktor) {
                echo "<script>
                alert('Data Berhasil Di ubah');
                document.location.href = 'core.php';
                </script>";
			}	
			else {
                echo "<script>
				alert('Data Gagal Di ubah');
				document.location.href = 'core.php';
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
        <title>Jenis Faktor - SPK Profile Matching </title>
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
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Data Faktor Penilaian</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Jenis Faktor</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Kriteia Penilaian</th>
                                                <th>Faktor Penilaian</th>
                                                <th>Target</th>
                                                <th>Type</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn,"SELECT * FROM pm_faktor a LEFT join pm_kriteria b on a.id_kriteria = b.id_kriteria ORDER BY a.id_kriteria ASC");
                                            $no=1;
                                            while($row=mysqli_fetch_assoc($query)){
                                                $id_f = $row['id_faktor'];
                                                $id_a = $row['id_kriteria'];
                                                $nama = $row['kriteria'];
                                                $nm_faktor=$row['faktor'];
                                                $bobot=$row['nilai_target'];
                                                $tipe=$row['jenis_faktor'];

                                                ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?=$nm_faktor;?></td>
                                                <td><?=$bobot?></td>
                                                <td><?= $tipe ?></td>
                                                <td>
                                                <button data-toggle="modal" data-target="#editfaktor<?= $id_f; ?>" type="button" class="btn btn-warning"><i class='fa fa-cog'></i></button>
                                                </td>
                                            </tr>
                                            <div id="editfaktor<?= $id_f; ?>" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Ubah <?= $nm_faktor; ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post">
                                                                        <div class="form-group">
                                                                            <label>Jenis Faktor</label>
                                                                            <input name="nm_faktor" type="text" class="form-control" value="<?= $nama; ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Nama Faktor</label>
                                                                            <input name="faktor" type="text" class="form-control" value="<?= $nm_faktor; ?>" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Target</label>
                                                                            <select name="target" id="target" class="form-control" required="true">
                                                                                <option value="1" <?php if ($bobot == "1"){ echo "selected"; } ?>>1</option>
                                                                                <option value="2" <?php if ($bobot == "2"){ echo "selected"; } ?>>2</option>
                                                                                <option value="3" <?php if ($bobot == "3"){ echo "selected"; } ?>>3</option>
                                                                                <option value="4" <?php if ($bobot == "4"){ echo "selected"; } ?>>4</option>
                                                                                <option value="5" <?php if ($bobot == "5"){ echo "selected"; } ?>>5</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <select name="type" id="type" class="form-control" required="true">
                                                                                <option value="core" <?php if ($tipe == "core"){ echo "selected"; } ?>>Core Factor</option>
                                                                                <option value="secondary" <?php if ($tipe == "secondary"){ echo "selected"; } ?>>Secondary Factor</option>
                                                                            </select>
                                                                        </div>
                                                                            <input type="hidden" name="id_faktor" value="<?= $id_f; ?>">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                        <input name ="ubahfaktor" type="submit" class="btn btn-primary" value="Simpan">
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
        <!-- Modal tambah Faktor -->
        <div id="tambahnilai" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Faktor Penilaian</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post">
                            <div class="form-group mt-2">
                                <div class="form-group">
                                    <label>Kriteria Penilaian</label>
                                    <select name="id_faktor" id="id_aspek" class="form-control" required="true">
                                        <option selected>--Pilih Kriteria--</option>
                                        <?php
                                            $det=mysqli_query($conn,"SELECT*FROM pm_kriteria ");
                                            while($d=mysqli_fetch_array($det)){
                                        ?>
                                            <option value="<?php echo $d['id_kriteria'] ?>"> <?php echo $d['kriteria'] ?></option>
                                        <?php
                                            }
                                        ?>		
                                    </select>
                                </div>

                                <label>Nama Faktor</label>
                                <input name="nmf" type="text"  class="form-control " placeholder="Nama Faktor" required>
                                <div class="form-group">
                                    <label>Target</label>
                                    <select name="trgt" id="target" class="form-control" required="true">
                                        <option value="">-- Pilih Target--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" id="type" class="form-control" required="true">
                                        <option value="core">Core Factor</option>
                                        <option value="secondary">Secondary Factor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input name ="addfaktor" type="submit" class="btn btn-primary" value="Tambah">
                        </div>
                    </form>
                </div>
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
