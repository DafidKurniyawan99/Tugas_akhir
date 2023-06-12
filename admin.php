<?php
    session_start();
    
    if ( !isset($_SESSION["signin"])) {
        header("Location: login.php");
        exit;
    }
    include 'db.php';

    if(isset($_POST['adduser']))
    {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['upass'];
        
        //email sudah terdaftar atau belum
        $cekemail = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");
            if(mysqli_fetch_assoc($cekemail)){
                echo"<script>
                        alert('Username Telah Terdaftar!')
                    </script>";
                return false;
                header('location:admin.php');
            }

        // Enskeipsi Password
        $password = password_hash($password, PASSWORD_DEFAULT);
            
        $tambahuser = mysqli_query($conn,"INSERT INTO user values('','$nama','$username','$password')");
        if ($tambahuser){
        echo " <script>
        alert('Admin Berhasil Di tambah');
        document.location.href = 'admin.php';
        </script>";
        } else { 
            echo "<script>
            alert('Admin Gagal Di tambah');
            document.location.href = 'admin.php';
            </script>";
        }
        
    };
    // Hapus User
     // hapus staf
     if(isset($_POST["hapusstaff"])){
        $staffidd1 = $_POST['staffiddel'];
        $currentpassword = mysqli_real_escape_string($conn,$_POST['pwskrg']);
        $queryuser2 = mysqli_query($conn,"SELECT * FROM user WHERE id_user='$staffidd1'");
        $cariuser2 = mysqli_fetch_assoc($queryuser2);

            if(password_verify($currentpassword,$cariuser2['password'])) {
                $hapusin = mysqli_query($conn,"delete from user where id_user='$staffidd1'");
                if($hapusin){
                echo " <script>
                alert('Staff Berhasil Di hapus');
                document.location.href = 'admin.php';
              </script>";
                } else { echo "<script>
                 alert('User Gagal Di hapus');
                 document.location.href = 'admin.php';
               </script>";
                }
                
            } else {
                echo "<script>
                alert('Password Verifikasi salah');
                document.location.href = 'admin.php';
              </script>";
            }
        
        
    };

    // UBAH PASSWORD
        if(isset($_POST["updatepw"])){
            $staffidd2 = $_POST['staffidform'];
            $currentpass = mysqli_real_escape_string($conn,$_POST['currentpw']);
            $newpass = password_hash($_POST['newpw'], PASSWORD_DEFAULT); 
            $queryuser1 = mysqli_query($conn,"SELECT * FROM user WHERE id_user='$staffidd2'");
            $cariuser1 = mysqli_fetch_assoc($queryuser1);

                if(password_verify($currentpass,$cariuser1['password'])) {
                    $updatepassword = mysqli_query($conn,"update user set password='$newpass' where id_user='$staffidd2'");
                    
                    if($updatepassword){
                    echo "<script>
                    alert('Password Berhasil Di Update');
                    document.location.href = 'admin.php';
                    </script>";
            
                    } else {
                    // echo "<script>
                    // alert('Password Gagal Di Update');
                    // document.location.href = 'admin.php';
                    // </script>";
                    echo "gga";
                    }
                    
                } else {
                    echo "<script>
                    alert('Password Verifikasi salah');
                    document.location.href = 'admin.php';
                    </script>";
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
        <title>Admin - SPK Profile Matching</title>
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
                        <h1 class="mt-4">Data User </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body d-flex flex-row-reverse">
                            <button  data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><i class="fa-regular fa-plus "></i>Tambah Admin</button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $admin = mysqli_query($conn, "SELECT*FROM user ");
                                                $no =1;
                                                while ($a = mysqli_fetch_assoc($admin)) {
                                                    $id = $a['id_user'];
                                                    $name = $a['nama_user'];
                                                    $user = $a['username'];
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $name?></td>
                                                <td><?= $user?></td>
                                                <td>
                                                    <form method="post">
                                                        <input type="button" class="btn btn-warning" data-toggle="modal" data-target="#staff<?php echo $a['id_user'];?>" value="Ubah Password" \>
                                                        <input type="hidden" name="staffidd" value="<?php echo $a['id_user'] ?>" \>
                                                        <input data-toggle="modal" data-target="#hapus<?php echo $a['id_user'];?>" type="button" class="btn btn-danger" value="Hapus Staff" \>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- EDIT PASSWORD -->
                                            <div id="staff<?php echo $a['id_user'];?>" class="modal fade">
                                                           <div class="modal-dialog modal-sm">
                                                               <div class="modal-content">
                                                                   <div class="modal-header">
                                                                       <h4 class="modal-title">Ubah Password <strong><?php echo $a['nama_user'] ?></strong></h4>
                                                                   </div>
                                                                   <div class="modal-body">
                                                                       <form method="post">
                                                                           <div class="form-group">
                                                                               <label>Nama</label>
                                                                               <input type="text" name="stname" class="form-control" value="<?php echo $a['nama_user'] ?>" disabled>
                                                                           </div>
                                                                           <div class="form-group">
                                                                               <label>Password <strong><?php echo $a['nama_user'] ?></strong> saat ini</label>
                                                                               <input type="password" class="form-control" name="currentpw">
                                                                           </div>
                                                                           <div class="form-group">
                                                                               <label>Password baru</label>
                                                                               <input type="password" class="form-control" name="newpw">
                                                                           </div>
                                                                           <input type="hidden" value="<?php echo $a['id_user'] ?>" name="staffidform">
                                                                       </div>
                                                                       <div class="modal-footer">
                                                                           <input name="updatepw" type="submit" class="btn btn-info" value="Ubah">
                                                                       </div>
                                                                       </form>
                                                               </div>
                                                           </div>
                                                       </div>
                                            <!-- end EDIT PASSWORD -->
                                            <!-- Hapus user -->
                                            <div id="hapus<?php echo $a['id_user'];?>" class="modal fade">
                                                           <div class="modal-dialog modal-sm">
                                                               <div class="modal-content">
                                                                   <div class="modal-header">
                                                                       <h4 class="modal-title">Apakah Anda yakin ingin menghapus <strong><?php echo $a['nama_user'] ?></strong>?</h4>
                                                                   </div>
                                                                   <div class="modal-body">
                                                                       <form method="post">
                                                                           <div class="form-group">
                                                                               <label>Verifikasi password saat ini (Masukan Sandi dari <strong><?php echo $a['nama_user'] ?></strong>)</label>
                                                                               <input type="password" class="form-control" name="pwskrg">
                                                                           </div>
                                                                           <input type="hidden" value="<?php echo $a['id_user'] ?>" name="staffiddel">
                                                                       </div>
                                                                       <div class="modal-footer">
                                                                           <input name="hapusstaff" type="submit" class="btn btn-danger" value="Hapus">
                                                                       </div>
                                                                       </form>
                                                               </div>
                                                           </div>
                                                       </div>
                                            <!-- End hapus user -->

                                            <?php
                                                }
                                            ?>
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
        <!--  Modal tambah admin !-->   
        <div id="myModal" class="modal fade">
               <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h4 class="modal-title">Tambah Admin Baru</h4>
                       </div>
                       <div class="modal-body">
                           <form method="post">
                               <div class="form-group">
                                   <label>Nama Admin</label>
                                   <input name="nama" type="text" class="form-control" placeholder="Nama Admin" required autofocus>
                               </div>
                               <div class="form-group">
                                   <label>Username</label>
                                   <input name="username" type="text" class="form-control" placeholder="Username" required autofocus>
                               </div>
                               <div class="form-group">
                                   <label>Password</label>
                                   <input name="upass" type="password" class="form-control" placeholder="Password" required autofocus>
                               </div>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                               <input name="adduser" type="submit" class="btn btn-primary" value="Simpan">
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
