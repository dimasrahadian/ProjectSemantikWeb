<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="index.css">

    <!-- Icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <title>Data Pasar</title>
  </head>
  <body>
     <!-- Connector untuk menghubungkan PHP dan SPARQL -->
     <?php
     require_once("sparqllib.php");
     $searchInput = "" ;
     $filter = "" ;
     
     if (isset($_POST['search'])) {
         $searchInput = $_POST['search'];
         $data = sparql_get(
         "http://localhost:3030/ProfilPasar",
         "
            PREFIX ab: <http://profilpasar.com/> .
            PREFIX d:  <http://profilpasar.com/ns/data#> 
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            
            SELECT ?nama ?alamat ?kecamatan ?kelurahan ?luas ?karakteristik ?komoditi ?bersertifikat
            WHERE
            { 
                ?items
                    item:nama           ?nama ;
                    item:alamat         ?alamat ;
                    item:kecamatan      ?kecamatan ;
                    item:kelurahan      ?kelurahan ;
                    item:luas           ?luas ;
                    item:karakteristik  ?karakteristik ;
                    item:komoditi       ?komoditi ;
                    item:bersertifikat  ?bersertifikat .
                    FILTER 
                    (regex (?Nama, '$searchInput', 'i') 
                    || regex (?alamat, '$searchInput', 'i') 
                    || regex (?kecamatan, '$searchInput', 'i') 
                    || regex (?kelurahan, '$searchInput', 'i') 
                    || regex (?luas, '$searchInput', 'i') 
                    || regex (?karakteristik, '$searchInput', 'i') 
                    || regex (?komoditi, '$searchInput', 'i') 
                    || regex (?bersertifikat, '$searchInput', 'i'))
             }
         "
         );
     } else {
         $data = sparql_get(
         "http://localhost:3030/ProfilPasar",
         "
            PREFIX ab: <http://profilpasar.com/> .
            PREFIX d:  <http://profilpasar.com/ns/data#> 
            PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
            
            SELECT ?nama ?alamat ?kecamatan ?kelurahan ?luas ?karakteristik ?komoditi ?bersertifikat
            WHERE
            { 
                ?items
                    item:nama           ?nama ;
                    item:alamat         ?alamat ;
                    item:kecamatan      ?kecamatan ;
                    item:kelurahan      ?kelurahan ;
                    item:luas           ?luas ;
                    item:karakteristik  ?karakteristik ;
                    item:komoditi       ?komoditi ;
                    item:bersertifikat  ?bersertifikat .
            }
         "
         );
     }

     if (!isset($data)) {
         print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
     }
 ?>

    <!-- Navbar -->
    <nav class="fixed-top">
        <div class="container">
            <p class="logo">Profil Pasar</p>
            <ul class="navLink">
                <li class="navItem">
                    <a class="button" href="home.php">Beranda</a>
                </li>
                <li class="navItem">
                    <a class="button active" href="index.php">Data Pasar</a>
                </li>
                <li class="navItem">
                    <a class="button" href="">Kontak</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
    </nav> -->

    <!-- Jumbotron -->
    <div class="hero">
        <div class="container">
            <div class="heading">
                <h1 class="text-center">
                    Cari Informasi Lengkap Pasar di Kota Bandung
                </h1>
            </div>
            <form class="d-flex" role="search" action="" method="post" id="search" name="search">
                    <input class="form-control me-2" type="search" placeholder="Ketik keyword disini" aria-label="Search" name="search">
                    <button class="btn btn-outline-success text-center" type="submit">Cari</button>
                </form>
        </div>
    </div>
    
    <!-- Body -->
    <div class="container container-fluid my-3">
        <?php
        if ($searchInput != NULL) {
        ?>
            <span style="color: black;">Pencarian pasar : <b>"<?php echo $searchInput; ?>"</b></span>
        <?php
        }
        ?>
        <table class="table table-bordered text-center table-responsive">
            <thead class="align-middle">
                <tr>
                    <th>No.</th>
                    <th>Nama Pasar</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>Luas</th>
                    <th>Karakteristik</th>
                    <th>Komoditi</th>
                    <th>Bersertifikat</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php $i = 0; ?>
                <?php foreach ($data as $data) : ?>
                    <td><?= ++$i ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['alamat'] ?></td>
                    <td><?= $data['kecamatan'] ?></td>
                    <td><?= $data['kelurahan'] ?></td>
                    <td><?= $data['luas'] ?></td>
                    <td><?= $data['karakteristik'] ?></td>
                    <td><?= $data['komoditi'] ?></td>
                    <td><?= $data['bersertifikat'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="contain">
                <p class="logo">Profil Pasar</p>
                <ul class="navLink">
                    <li class="navItem">
                        <a class="button active" href="">Beranda</a>
                    </li>
                    <li class="navItem">
                        <a class="button" href="dataPasar.html">Data Pasar</a>
                    </li>
                    <li class="navItem">
                        <a class="button" href="">Kontak</a>
                    </li>
                </ul>
                <div class="socialMedia">
                    <i data-feather="instagram"></i>
                    <i data-feather="facebook"></i>
                    <i data-feather="twitter"></i>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
  </body>

  <script>
        feather.replace()
    </script>
</html>