<?php
       session_start();
        
       if ( !isset($_SESSION["signin"])) {
           header("Location: login.php");
           exit;
       }
    include 'db.php';
    $id_siswa = $_GET['id_siswa'];

    //Ambil Nilai Target
    $q1 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '1'");
    while($list1 = mysqli_fetch_assoc($q1)){
        $target1 = $list1['nilai_target'];
    }
    $q2 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '2'");
    while($list2 = mysqli_fetch_assoc($q2)){
        $target2 = $list2['nilai_target'];
    }
    $q3 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '8'");
    while($list3 = mysqli_fetch_assoc($q3)){
        $target3 = $list3['nilai_target'];
    }
    $q4 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '7'");
    while($list4 = mysqli_fetch_assoc($q4)){
        $target4 = $list4['nilai_target'];
    }
    $q5 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '9'");
    while($list5 = mysqli_fetch_assoc($q5)){
        $target5 = $list5['nilai_target'];
    }
    $q6 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '10'");
    while($list6 = mysqli_fetch_assoc($q6)){
        $target6 = $list6['nilai_target'];
    }
    $q7 = mysqli_query($conn, "select * from pm_faktor where id_faktor = '11'");
    while($list7 = mysqli_fetch_assoc($q7)){
        $target7 = $list7['nilai_target'];
    }

    //Ambil presentase masing - masing kriteria
    $pr1 = mysqli_query($conn, "select * from pm_kriteria where id_kriteria = '1'");
    while($list1 = mysqli_fetch_assoc($pr1)){
        $presentase1 = $list1['prosentase'];
    }
    $pr2 = mysqli_query($conn, "select * from pm_kriteria where id_kriteria = '2'");
    while($list2 = mysqli_fetch_assoc($pr2)){
        $presentase2 = $list2['prosentase'];
    }
    $pr3 = mysqli_query($conn, "select * from pm_kriteria where id_kriteria = '3'");
    while($list3 = mysqli_fetch_assoc($pr3)){
        $presentase3 = $list3['prosentase'];
    }

    //Fungsi fungsi
    function hitung_N($ncf, $nsf, $id){
        $conn = mysqli_connect("localhost","root","","pm");
        $query = mysqli_query($conn, "select * from pm_kriteria where id_kriteria = '$id'");
        while($item = mysqli_fetch_assoc($query)){
            $bobot_core = (float) $item['bobot_core'] / 100;
            $bobot_secondary = (float) $item['bobot_secondary'] / 100;
        };
        $n = (float) $bobot_core * $ncf +  $bobot_secondary * $nsf;
        return $n;
    }
    function getBobot($param){
        $conn = mysqli_connect("localhost","root","","pm");
        $get_bobot = mysqli_query($conn, "select bobot from pm_bobot where selisih='$param'");
        while($bobot = mysqli_fetch_assoc($get_bobot)){
            $bobot_nilai = $bobot['bobot'];
        }
        return $bobot_nilai;
    }
    function coreFactor($param){
        $conn = mysqli_connect("localhost","root","","pm");
        $get_core = mysqli_query($conn, "select count(id_faktor) as count from pm_faktor where id_kriteria='$param' and jenis_faktor  = 'core'");
        while($get_count = mysqli_fetch_assoc($get_core)){
            $jumlah_core = $get_count['count'];
        }
        return $jumlah_core;
    }
    function secondaryFactor($param){
        $conn = mysqli_connect("localhost","root","","pm");
        $get_core = mysqli_query($conn, "select count(id_faktor) as count from pm_faktor where id_kriteria='$param' and jenis_faktor  = 'secondary'");
        while($get_count = mysqli_fetch_assoc($get_core)){
            $jumlah_core = $get_count['count'];
        }
        return $jumlah_core;
    }
    function ncf($bobot, $kriteria){
        $get_bobot = getBobot($bobot);
        $core = coreFactor($kriteria);
        return $ncf = $get_bobot / $core;

    }
    function nsf($bobot, $kriteria){
        $get_bobot = getBobot($bobot);
        $core = secondaryFactor($kriteria);
        return $nsf = $get_bobot / $core;

    }
    //Simpan perhitungan ke database
    if(isset($_POST['submit'])){
        $cek = mysqli_query($conn, "select * from pm_ranking where id_siswa = '$id_siswa'");
        if(mysqli_num_rows($cek)>0){
            $query = "update pm_ranking set nilai_akhir='$_POST[nilai_akhir]' where id_siswa='$id_siswa'";
            $sql = mysqli_query($conn, $query);
        }else{
            $query = "insert into pm_ranking values ('$id_siswa','$_POST[nilai_akhir]')";
            $sql = mysqli_query($conn, $query);   
        }
        if($sql){
            echo "<script>alert('Berhasil Menyimpan Perhitungan')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Nilai</title>
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
                    <h1 class="mt-4">
                        <?php 
                            $query = mysqli_query($conn, "select * from siswa where id_siswa = '$id_siswa'");
                            while($nama = mysqli_fetch_assoc($query)){
                                echo $nama['nama_siswa'];
                            }
                        ?>
                    </h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h4>Faktor Penilaian</h4>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    
                                    <thead>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>A3</th>
                                        <th>A4</th>
                                        <th>A5</th>
                                        <th>A6</th>
                                        <th>A7</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td><?= $list['A1'] ?></td>
                                                <td><?= $list['A2'] ?></td>
                                                <td><?= $list['A3'] ?></td>
                                                <td><?= $list['A4'] ?></td>
                                                <td><?= $list['A5'] ?></td>
                                                <td><?= $list['A6'] ?></td>
                                                <td><?= $list['A7'] ?></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <h4>Pemetaan GAP :</h4>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>A3</th>
                                        <th>A4</th>
                                        <th>A5</th>
                                        <th>A6</th>
                                        <th>A7</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select f.*, sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");                
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td><?= (int) $list['A1'] - $target1 ?></td>
                                                <td><?= (int) $list['A2'] - $target2 ?></td>
                                                <td><?= (int) $list['A3'] - $target3 ?></td>
                                                <td><?= (int) $list['A4'] - $target4 ?></td>
                                                <td><?= (int) $list['A5'] - $target5 ?></td>
                                                <td><?= (int) $list['A6'] - $target6 ?></td>
                                                <td><?= (int) $list['A7'] - $target7 ?></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <h4>Pembobotan GAP</h4>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>A3</th>
                                        <th>A4</th>
                                        <th>A5</th>
                                        <th>A6</th>
                                        <th>A7</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select f.*, sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");                
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A1'] - $target1;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A2'] - $target2;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A3'] - $target3;
                                                        echo getBobot($bobot);
                                                    ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A4'] - $target4;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A5'] - $target5;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A6'] - $target6;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A7'] - $target7;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <h3>Perhitungan Faktor Aspek Nilai :</h3>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>A1</th>
                                        <th>A2</th>
                                        <th>NCF</th>
                                        <th>NSF</th>
                                        <th>N Aspek Nilai</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select f.*, sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");                
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A1'] - $target1;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A2'] - $target2;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A1'] - $target1;
                                                        echo ncf($bobot, 1);
                                                    ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A1'] - $target1;
                                                        echo nsf($bobot, 1);
                                                    ?>   
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot1= (int) $list['A1'] - $target1;
                                                        $bobot2= (int) $list['A2'] - $target2;
                                                        $ncf = ncf($bobot1, 1);
                                                        $nsf = nsf($bobot2 , 1);
                                                        $n_nilai =  hitung_N($ncf, $nsf, 1);
                                                        echo $n_nilai;
                                                    ?>   
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <h4>Perhitungan Faktor Aspek Kedisiplinan :</h4>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>A3</th>
                                        <th>A4</th>
                                        <th>NCF</th>
                                        <th>NSF</th>
                                        <th>N Aspek Kedisiplinan</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select f.*, sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");                
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A3'] - $target3;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A4'] - $target4;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A3'] - $target3;
                                                        echo ncf($bobot, 2);
                                                    ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot3= (int) $list['A4'] - $target4;
                                                        echo nsf($bobot3, 2);
                                                    ?>   
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot1= (int) $list['A3'] - $target3;
                                                        $bobot2= (int) $list['A4'] - $target4;
                                                        $ncf = ncf($bobot1, 2);
                                                        $nsf = nsf($bobot2 ,2);
                                                        $n_kedisiplinan = hitung_N($ncf, $nsf, 2);
                                                        echo $n_kedisiplinan;
                                                    ?>   
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <h4>Perhitungan Faktor Aspek Prestasi</h4>
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>A5</th>
                                        <th>A6</th>
                                        <th>A7</th>
                                        <th>NCF</th>
                                        <th>NSF</th>
                                        <th>N Aspek Prestasi</th>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql = mysqli_query($conn, 
                                                    "select f.*, sum(case when f.id_faktor = '1' then n.bobot_nilai else 0 end) as A1, sum(case when f.id_faktor = '2' then n.bobot_nilai else 0 end) as A2, sum(case when f.id_faktor = '8' then n.bobot_nilai else 0 end) as A3, sum(case when f.id_faktor = '7' then n.bobot_nilai else 0 end) as A4, sum(case when f.id_faktor = '9' then n.bobot_nilai else 0 end) as A5, sum(case when f.id_faktor = '10' then n.bobot_nilai else 0 end) as A6, sum(case when f.id_faktor = '11' then n.bobot_nilai else 0 end) as A7 from pm_faktor f inner join pm_nilai n on f.id_faktor = n.id_faktor and n.id_siswa = '$id_siswa' group by n.id_siswa");                
                                            while($list = mysqli_fetch_assoc($sql)){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A5'] - $target5;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A6'] - $target6;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A7'] - $target7;
                                                        echo getBobot($bobot);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot= (int) $list['A5'] - $target5;
                                                        echo ncf($bobot, 1);
                                                    ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobotA6= (int) $list['A6'] - $target6;
                                                        $bobotA7= (int) $list['A7'] - $target7;
                                                        $nilaibobot6 = getBobot($bobotA6);
                                                        $nilaibobot7 = getBobot($bobotA7);
                                                        $core = secondaryFactor(3);
                                                        $nsfs = (float) ($nilaibobot6 + $nilaibobot7) / $core;
                                                        echo $nsfs;
                                                    ?>   
                                                </td>
                                                <td>
                                                    <?php
                                                        $bobot5= (int) $list['A5'] - $target5;
                                                        $bobotA6= (int) $list['A6'] - $target6;
                                                        $bobotA7= (int) $list['A7'] - $target7;
                                                        $nilaibobot6 = getBobot($bobotA6);
                                                        $nilaibobot7 = getBobot($bobotA7);
                                                        $core = secondaryFactor(3);
                                                        $nsfs = (float) ($nilaibobot6 + $nilaibobot7) / $core;
                                                        $ncf = ncf($bobot5, 3);
                                                        $n_prestasi = hitung_N($ncf, $nsfs, 3);
                                                        echo $n_prestasi;
                                                    ?>   
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <th>Nilai N Aspek Nilai</th>
                                        <th>Nilai N Aspek Kedisiplinan</th>
                                        <th>Nilai N Aspek Prestasi</th>
                                        <th>Nilai Akhir</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $n_nilai ?></td>
                                            <td><?= $n_kedisiplinan ?></td>
                                            <td><?= $n_prestasi ?></td>
                                            <td>
                                                <?php 
                                                    $nilai_akhir = (float) ($presentase1 * $n_nilai) / 100 + ($presentase2 * $n_kedisiplinan) / 100 + ($presentase3 * $n_prestasi) / 100;
                                                    echo $nilai_akhir;
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="nilai_akhir" id="" value="<?= $nilai_akhir ?>" readonly>
                                <div class="buttons">
                                    <button class="btn btn-info" name="submit">Simpan Perhitungan</button>
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