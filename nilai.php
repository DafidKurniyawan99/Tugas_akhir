<?php 
    include 'db.php';

    $idkriteria =$_GET['id_kriteria'];
    $liatcust = mysqli_query($conn,"select * from kriteria k, faktor f where id_kriteria='$idkriteria' and k.id_faktor = f.id_faktor");
    $checkdb = mysqli_fetch_assoc($liatcust);

    if(isset($_POST['addnilai'])){
        $nama = $_POST['nm_nilai'];
        $nilai = $_POST['bobot_nilai'];
        $id = $_POST['id'];

        $qu = mysqli_query($conn , "SELECT nilai_standar_bobot FROM bobot where nilai_standar_bobot='$nilai' and id_kriteria='$idkriteria' ");
       
        if(mysqli_fetch_assoc($qu)){
            echo "<script>
                    alert('Nilai Bobot telah digunakan !');
                </script>";
        }else{
            $tambahnilai = mysqli_query($conn ,"INSERT INTO bobot (id_kriteria, nm_nilai, nilai_standar_bobot) VALUES ('$id','$nama','$nilai') ");
            if($tambahnilai){
                echo "<script>
                        alert('Data Berhasil Ditambahkan');
                        document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
                    </script>";
            }else{
                echo "<script>
                        alert('Data Gagal Ditambahkan');
                        document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
                    </script>";
            }
        }
    }

    // Fungsi Edit Sub kriteria
    if ( isset($_POST['updtnilai']) ) {	
		$id_n = $_POST['id_e'];
        $nama_iki = $_POST['nama_e'];
        $bobot = $_POST['bobot_e'];
		$editnilai = mysqli_query($conn, "UPDATE bobot SET  
			        nm_nilai = '$nama_iki', nilai_standar_bobot='$bobot' WHERE id_nilai ='$id_n' AND id_kriteria='$idkriteria'");
        // var_dump($editnilai);
        // exit;
		if ($editnilai) {
                echo "<script>
                alert('Data Berhasil Di ubah');
                document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
                </script>";
			}	
			else {
                echo "<script>
				alert('Data Gagal Di ubah');
				document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
			    </script>";
			}
	}
    // Hapus Nilai
    if(isset($_POST['deletenilai']))
	{
		$idkk = $_POST['idkdel'];
		$idnn = $_POST['idndel'];			  
		$hapusnilai = mysqli_query($conn,"DELETE FROM bobot WHERE id_nilai='$idnn' and id_kriteria='$idkk'");
		if($hapusnilai){
		echo " <script>
                    alert('Berhasil di hapus');
                    document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
                </script>";
		} else { echo "
			<script>
                    alert('Gagal di hapus');
                    document.location.href = 'nilai.php?id_kriteria=".$idkriteria."';
                </script>
		  ";
		 
		}
		
	};
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Nilai - SPK profile matching</title>
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
                        <h1 class="mt-4">Nilai Dari Kriteri</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Nilai Dari Kriteria</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <button data-toggle="modal" data-target="#tambahnilai" type="button" class="btn btn-info mr-2">Tambah Data Nilai</button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <p>Nama Kriteria : <?php echo $checkdb['nm_kriteria']; ?></p>
                                <p>Jenis Faktor : <?php echo $checkdb['nm_faktor']; ?></p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        
                                    
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Penilaian</th>
                                                <th>Jumalah Bobot</th>
                                                <th>Aksi</th> 
                                            </tr>
                                        </thead>
                                        <?php
                                            $tampil = mysqli_query($conn, "SELECT * FROM bobot WHERE id_kriteria = '$idkriteria' ORDER BY nilai_standar_bobot DESC");
                                            $no = 1;
                                            while($row=mysqli_fetch_array($tampil)) {
                                                    $id_k = $row['id_kriteria'];
                                                    $id = $row['id_nilai'];
                                                    $nama_n = $row['nm_nilai'];
                                                    $bobot_n = $row['nilai_standar_bobot'];
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $no++;?></td>
                                                <td><?= $nama_n?></td>
                                                <td><?= $bobot_n?></td>
                                                <td>
                                                    <form method="post">
                                                    <button data-toggle="modal" data-target="#editnilai<?= $id ?>" type="button" class="btn btn-warning mr-2"><i class="fa-solid fa-gear"></i></button>
                                                    <input type='hidden' name='idkdel' value="<?=$id_k;?>" >
                                                    <input type='hidden' name='idndel' value="<?= $id?>">
                                                    <button name='deletenilai' type='submit' class='btn btn-danger' alt='Delete' onclick=" return confirm('Apakah Anda Yakin Untuk Menghapus <?= $nama_n?>?')";><div class='icon'><i class='fa fa-trash'></i></div></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit Nilai -->
                                            <div id="editnilai<?= $id?>" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Sub Nilai Kriteria</h4>
                                                        </div>
                                                        <div class="modal-body ">
                                                            <form method="post">
                                                                <div class="form-group mt-2">
                                                                    <label>Nama Nilai</label>
                                                                    <input name="nama_e" type="text"  class="form-control "  value="<?= $nama_n?>"required>
                                                                    <label>Nilai</label>
                                                                    <input name="bobot_e" type="text"  class="form-control "  min="0" max="5" value="<?= $bobot_n ?>" required>
                                                                    <input type="hidden" name="id_e" value="<?php echo $id ?>" \>                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                                    <input name ="updtnilai" type="submit" class="btn btn-primary" value="Edit">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal edit -->
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
        <!-- Modal tambah Kriteria -->
        <div id="tambahnilai" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Kriteria</h4>
                    </div>
                    <div class="modal-body ">
                        <form method="post">
                            <div class="form-group mt-2">
                                <label>Nama Nilai</label>
                                <input name="nm_nilai" type="text"  class="form-control " placeholder="Nama Nilai" required>
                                <label>Nilai</label>
                                <input name="bobot_nilai" type="text"  class="form-control " placeholder="Ex : 5" min="0" max="5" required>
                                <input type="hidden" name="id" value="<?php echo $idkriteria ?>" \>
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input name ="addnilai" type="submit" class="btn btn-primary" value="Tambah">
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
