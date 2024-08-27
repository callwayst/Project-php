<?php
$host   ="localhost";
$user   ="root";
$pass   ="";
$db     ="akademik";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nim      = "";
$nama     = "";
$alamat   = "";
$fakultas = "";
$sukses   = "";
$error    = "";

if (isset($_GET['op'])){
    $op = $_GET['op'];
} else {
    $op ="";
}
if($op == 'delete'){
    $id     = $_GET['id'];
    $sql1   ="delete from mahasiswa where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if($q1){
        $sukses = "Berhasil Hapus Data";
    } else {
        $error  ="Gagal Melakukan Delete Data";
    }
}
if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select * from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $nim        = $r1['nim'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $fakultas   = $r1['fakultas']; 

    if($nim == ''){
        $error = "Data Tidak Ditemukan";
    }
}

if (isset($_POST['simpan'])) { //create
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];

    if($nim && $nama && $alamat && $fakultas){
        if($op  == 'edit'){ // untuk update
            $sql1 = "update mahasiswa set nim = '$nim' ,nama='$nama' ,alamat ='$alamat' ,fakultas='$fakultas' where id ='$id'";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data Berhasil Diupdate";
            }else {
                $error = "Gagal Memasukkan Data";
            }
        }else { //untuk insert
            $sql1 = "insert into mahasiswa(nim,nama,alamat,fakultas) values('$nim','$nama','$alamat','$fakultas')";
            $q1    = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses     ="Berhasil Memasukkan Data Baru";
            } else {
                $error      ="Gagal Memasukkan Data";
            }
        }
    }else {
        $error ="Silahkan Masukkan Semua Data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .mx-auto { width:800px }
        .card { margin-top: 10px }
    </style>
</head>
<body>
    <div class="mx-auto">
        <!-- memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
                <div class="card-body">
                <?php
                if($error){
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>
                    <?php
                    header("refredh:5;url=index.php"); //5 : Detik
                }
                ?>
                <?php
                if($sukses){
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $sukses ?>
                        </div>
                    <?php
                    header("refredh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" placeholder="<?php echo $nim ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="<?php echo $nama ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="nim" name="alamat" placeholder="<?php echo $nim ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="saintek"<?php if($fakultas == "saintek") echo "selected"?>>Saintek</option>
                                <option value="soshum"<?php if($fakultas == "soshum") echo "selected"?>>Soshum</option>
                            </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div> 
        </div>
    <!-- mengeluarkan data -->
    <div class="card">
            <div class="card-header text-white bg-secondary">
               Data Mahasiswa
            </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            <tbody>
                                <?php 
                                    $sql2   ="select * from mahasiswa order by id desc";
                                    $q2     = mysqli_query($koneksi,$sql2);
                                    $urut   = 1;
                                    while($r2 = mysqli_fetch_array($q2)){
                                        $id         = $r2['id'];
                                        $nim        = $r2['nim'];
                                        $nama       = $r2['nama'];
                                        $alamat     = $r2['alamat'];
                                        $fakultas   = $r2['fakultas'];

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $urut++ ?></th>
                                            <td scope="row"><?php echo $nim ?></td>
                                            <td scope="row"><?php echo $nama ?></td>
                                            <td scope="row"><?php echo $alamat ?></td>
                                            <td scope="row"><?php echo $fakultas ?></td>
                                            <td scope="row">
                                                <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                                <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
</body>
</html>