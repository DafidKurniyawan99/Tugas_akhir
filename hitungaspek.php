<?php
   session_start();
        
   if ( !isset($_SESSION["signin"])) {
       header("Location: login.php");
       exit;
   }
    include 'db.php';
    $id_kriteria = $_GET['id'];
    $id_siswa = $_GET['id_siswa'];
    if(isset($_POST['submit'])){
        $i = 0;
        for($i;$i<count($_POST['faktor']);$i++){
            $faktor = $_POST['faktor'][$i];
            $nilai = $_POST['nilai'][$i];
            $cek_data = mysqli_query($conn, "select * from pm_nilai where id_faktor = '$faktor' and id_siswa ='$id_siswa'");
            if(mysqli_num_rows($cek_data) > 0){
                $query = "update pm_nilai set bobot_nilai = '$nilai' where id_faktor = '$faktor' and id_siswa ='$id_siswa'";
                $sql = mysqli_query($conn, $query);
            }else{
                $query = "insert into pm_nilai values ('','$id_siswa','$faktor','$nilai')";
                $sql = mysqli_query($conn, $query);
            }
            
        }
        echo "<script>alert('Aspek berhasil diubah');
        document.location.href = 'penilai.php';    
            </script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspek</title>
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
                        <h1 class="mt-4">Kriteria</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="" method="post">
                                    <?php
                                        $get_kriteria= mysqli_query($conn, "SELECT * from pm_kriteria where id_kriteria = '$id_kriteria'");
                                        while($kriteria = mysqli_fetch_assoc($get_kriteria)){
                                            echo "<h3>Aspek $kriteria[kriteria] </h3>";
                                        }
                                        $query="SELECT pm_kriteria.*, pm_faktor.* from pm_kriteria, pm_faktor where pm_kriteria.id_kriteria = pm_faktor.id_kriteria and pm_kriteria.id_kriteria = '$id_kriteria'";
                                        $sql  = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($sql) > 0){
                                            while($data=mysqli_fetch_assoc($sql)){
                                    ?>
                                    <div class="form-group">
                                        <label for="" class="control-label"><?= $data['faktor'] ?></label>
                                        <input type="hidden" name="faktor[]" id="" value="<?= $data['id_faktor'] ?>">
                                        <select name="nilai[]" id="" class="form-control">
                                            <?php
                                                if($id_kriteria == "1"){
                                            ?>
                                                <option value="5" >86 - 100</option>
                                                <option value="4" >80 - 85</option>
                                                <option value="3">70 - 79</option>
                                                <option value="2">60 - 69</option>
                                                <option value="1">< 60 </option>
                                            <?php
                                                }elseif($id_kriteria == "2"){
                                            ?>
                                                <?php if($data['faktor'] == "Tugas"){ ?>
                                                    <option value="4">Sangat Lengkap</option>
                                                    <option value="3">Lengkap</option>
                                                    <option value="2">Kurang Lengkap</option>
                                                    <option value="1">Tidak Lengkap</option>
                                                <?php }else{ ?>
                                                    <option value="4">Sangat Baik</option>
                                                    <option value="3">Baik</option>
                                                    <option value="2">Cukup</option>
                                                    <option value="1">Kurang</option>
                                                <?php } ?>
                                            <?php 
                                                }elseif($id_kriteria == "3"){
                                            ?>
                                                <option value="4">Juara 1</option>
                                                <option value="3">Juara 2</option>
                                                <option value="2">Juara 3</option>
                                                <option value="1">Tidak Pernah</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } } ?>
                                <div class="buttons">
                                    <button class="btn btn-info" name="submit">Submit</button>
                                    <a href="penilai.php" class="btn btn-secondary ml-2">Kembali</a>
                                </div>
                                </form>
                                
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