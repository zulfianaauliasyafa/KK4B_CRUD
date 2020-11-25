<?php
  $server = "localhost";
  $user = "root";
  $pass = "";
  $database ="dblatihan";

  $koneksi= mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

  //jika tombol simpan diklik
  if(isset($_POST['bsimpan']))
  {
    //pengujian data akan diedit/disimpan baru
    if($_GET['hal'] == "edit")
    {
        //data akan diedit
        $edit = mysqli_query($koneksi, "UPDATE tmhs set 
                                          nim = '$_POST[tnim]',
                                          nama = '$_POST[tnama]',
                                          alamat = '$_POST[talamat]',
                                          prodi = '$_POST[tprodi]'
                                        WHERE id_mhs = '$_GET[id]'
                                        ");
        if($edit) //JIKA EDIT SUKSES
        {
          echo "<script>
                  alert('Edit data SUKSES!');
                  document.location='index.php';
                </script>";
        }
        else
        {
          echo "<script>
                  alert('Edit data GAGAL!');
                  document.location='index.php';
                </script>";
        }
    }
    else
    {
      //data akan disimpan baru
      $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
      VALUES ('$_POST[tnim]', '$_POST[tnama]', '$_POST[talamat]', '$_POST[tprodi]')
      ");
      if($simpan) //JIKA SIMPAN SUKSES
      {
        echo "<script>
                alert('Simpan data SUKSES!');
                document.location='index.php';
              </script>";
      }
      else
      {
        echo "<script>
                alert('Simpan data GAGAL!');
                document.location='index.php';
              </script>";
      }
    }
    
  }


  //pengujian jika tombol edit/hapus diklik
  if(isset($_GET['hal']))
  {
    //pengujian jika edit data
    if($_GET['hal'] == "edit")
    {
      //Tampilkan data yang akan di edit
      $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
      $data = mysqli_fetch_array($tampil);
      if($data)
      {
        //jika data ditemukann , maka data ditampung ke dalam variabel
        $vnim = $data['nim'];
        $vnama = $data['nama'];
        $valamat = $data['alamat'];
        $vprodi = $data['prodi'];
      }
    }
    else if($_GET['hal'] == "hapus")
    {

      //persiapan hapus data
      $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs ='$_GET[id]' ");
      if($hapus){
        echo "<script>
                alert('Hapus data SUKSES!');
                document.location='index.php';
              </script>";
      }

    }
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <h1 class="text-center">CRUD PHP & MySQL dan Bootstrap 4</h1>

        <!-- awal card form -->
        <div class="card mt-4">
        <div class="card-header bg-primary text-white">FORM INPUT DATA MAHASISWA </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <label>NIM</label>
              <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Input NIM Anda disini!" required>
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda disini!" required>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="talamat" placeholder="Input Alamat Anda disini!"><?=@$valamat?></textarea>
            </div>
            <div class="form-group">
              <label>Program Studi </label>
              <select class="form-control" name="tprodi">
                <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                <option value="D3-MI">D3-MI</option>
                <option value="S1-SI">S1-SI</option>
                <option value="S1-TI">S1-TI</option>
              </select>
            </div>   

            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
            <button type="reset" class="btn btn-danger" name="breset">Reset</button>
          </form>
        </div>
        </div>
        <!-- akhir card form -->

        <!-- awal card form -->
        <div class="card mt-4">
          <div class="card-header bg-primary text-white">DAFTAR MAHASISWA</div>
          <div class="card-body">

            <table class="table table-bordered table-striped">
              <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Aksi</th>
              </tr>

              <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs order by id_mhs desc");
                while($data = mysqli_fetch_array($tampil)):

              ?>
              <tr>
                <td><?=$no++?></td> 
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['alamat']?></td>
                <td><?=$data['prodi']?></td>
                <td>
                  <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning">Edit</a>
                  <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" 
                  onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                </td>
              </tr>
                <?php endwhile; //penutup perulangam while ?>
            </table>
         
          </div>
        </div>
        <!-- akhir card form -->

    </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script> 
</body>
</html>