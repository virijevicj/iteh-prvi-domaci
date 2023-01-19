<?php
require "dbBroker.php";
require "model/utakmica.php"; 
require "model/igrac.php";
require "model/fakultet.php";
session_start();

$igraci = Igrac::get_all_players($conn);
$fakulteti = Fakultet::get_all_teams($conn);

if(!$igraci){
    echo "Greska prilikom upita za sve igrace";
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kkfon igraci</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


  </head>

  <body>
    <div class="container">
<!--navbar-->
    <div class="row">
        <div class="col-1 slika"> 
            <a class="navbar-brand" href="/">
                <div class="logo-image" >
                <img src="img/logo.png" class="img-fluid" id ="logo">
                </div>
            </a>
        </div>
        <div class="navigacija col-11">
            <ul class="nav justify-content-end">
            <li class="nav-item">
                 <p><a class="nav-link active" style= "color:black" aria-current="page" href="#"><b>Igraci</b></a></p>
            </li>
            <ul class="nav justify-content-end">
            <li class="nav-item">
                 <p><a class="nav-link active" style= "color:black" aria-current="page" href="rezultati.php"><b>Rezultati</b></a></p>
            </li>     
        </ul>
        </div>
    </div>

        <br>
        <div class="row">
            <div class="col">
                <h2>Tabela aktivnih igraca</h2>
            </div>
            <div class="col-2 pomeri" style="padding-left: 45px;">
            <button id="btn" class="btn" style="background-color: rgb(160, 215, 255); color: black;" data-bs-toggle="modal" data-bs-target="#dodajIgraca">
                <b>Dodaj igraca</b>
            </button> 
            </div>
        </div>

      <table id= "tabelaIgraca" class="table table-hover table-striped">
        <thead>
          <tr>
            <th scope="col">Ime</th>
            <th scope="col">Prezime</th>
            <th scope="col">Datum rodjenja</th>
            <th scope="col">Pozicija</th>
            <th scope="col">Indeks</th>
            <th scope="col">Smer</th>
            <th scope="col">Telefon</th>
            <th scope="col">Email</th>
            <th scope="col">Brisanje igraca</th>

          </tr>
        </thead>
        <tbody>

            <?php
                while ($igrac = $igraci->fetch_array()):
            ?>
          <tr>
            <td><?php echo $igrac["ime"]  ?></td>
            <td><?php echo $igrac["prezime"]  ?></td>
            <td><?php echo $igrac["datum_rodjenja"]  ?></td>
            <td><?php echo $igrac["pozicija"]  ?></td>
            <td><?php echo $igrac["indeks"]  ?></td>
            <td><?php echo $igrac["smer"]  ?></td>
            <td><?php echo $igrac["telefon"]  ?></td>
            <td><?php echo $igrac["email"]  ?></td>
            <td>
            <form action="" method = "post">
                <input type="hidden" name="id" value="<?php echo $igrac["igrac_id"];?>">
                <input type="submit" onclick= "obrisiIgraca(<?php echo $igrac['igrac_id'];?>)" class="btn btn-outline-dark" name="submit" value="Obrisi">
            </form>
            </td>
            
            </tr>
           
          <?php
                endwhile;           
            ?>

        </tbody>
      </table>
    

    <div class="row">
        <div class="col"></div>
        <div class="col-2">
            <!-- <button id="btn" class="btn" style="background-color: rgb(160, 215, 255); color: black; justify-content: end;" data-bs-toggle="modal" data-bs-target="#obrisiIgraca">
                <b>Obrisi igraca</b>
            </button>   -->
        </div>
    </div>

    <!-- Modal dodaj igraca-->
    <div class="modal fade" id="dodajIgraca" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="dodajForm">
                            <h3 style="color: black; text-align: center">Dodaj igraca</h3>
                            <div class="row">
                            <div class="col-md-11 ">
                                <div class="form-group">
                                    <label for="">Ime</label>
                                    <input type="text"  name="ime" class="form-control"/>
                                </div>

                                <div class="form-group">
                                <label for="">Prezime</label>
                                    <input type="text" name="prezime" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Datum rodjenja</label>
                                    <input type="Date"  name="datum_rodjenja" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Pozicija</label>
                                     <select name="pozicija" id="pozija" class ="form-select">
                                        <option value="bek">bek</option>
                                        <option value="krilo">krilo</option>
                                        <option value="centar">centar</option>
                                        
                                     </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Indeks</label>
                                    <input type="text"  name="indeks" class="form-control" placeholder = "format godinaUpisa/brojIndeksa (npr 2021/0564)"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Smer</label>
                                    <!-- <input type="text"  name="smer" class="form-control"/> -->
                                     <select name="smer" id="smer" class ="form-select">
                                        <option value="ISIT">ISIT</option>
                                        <option value="ISIT - DALJINA">ISIT-DALJINA</option>
                                        <option value="OM">OM</option>
                                        <option value="M">M</option>
                                        <option value="MKIS">MKIS</option>
                                     </select>

                                </div>

                                <div class="form-group">
                                    <label for="">Telefon</label>
                                    <input type="text"  name="telefon" class="form-control" placeholder = "npr 0645234323 ili +382 689123324"/>
                                </div>

                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text"  name="email" class="form-control" placeholder = "npr pp5@gmail.com"/>
                                </div>
                                
                                <br>

                                <div class="form-group">
                                    <button id="btnDodaj" type="submit" class="btn  btn-block"
                                    style="background-color: rgb(160, 215, 255); color: black;">Dodaj</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    



    <!-- Modal obrisi igraca-->
    <div class="modal fade" id="obrisiIgraca" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container prijava-form">
                        <form action="#" method="post" id="dodajForm">
                            <h3 style="color: black; text-align: center">Obrisi igraca</h3>
                            <div class="row">
                            <div class="col-md-11 ">
                                <div class="form-group">
                                    <label for="">Selektujte igraca za brisanje</label>
                                    <select name="obrisi" id="obrisi" class ="form-select">
                                            <?php
                                                $igraci = Igrac::get_all_players($conn);
                                                 while ($igrac = $igraci->fetch_array()):
                                            ?>
                                        <option value="<?php echo $igrac["igrac_id"]?>"><?php echo $igrac["ime"]." ".$igrac["prezime"] ?></option>
                                        <?php
                                            endwhile;           
                                        ?>
                                     </select>
                                </div>

                                <br>

                                <div class="form-group">
                                    <input type="submit" onclick= "obrisiIgraca()" class="btn btn-outline-dark"
                                    style="background-color: rgb(160, 215, 255); color: black;" name="submit" value="Obrisi">
                                </div>

                                
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
      crossorigin="anonymous"
    ></script>
    <script src="js/dodajIgraca.js"></script>
    <script src="js/obrisiIgraca.js"></script>
  </body>
</html>

