<?php
require "dbBroker.php";
require "model/utakmica.php"; 
require "model/fakultet.php";

session_start();

$utakmice = Utakmica::get_all_games($conn);
$rezultati = Utakmica::get_score($conn);
$skor = $rezultati->fetch_array();
$statistika = Utakmica::get_stats($conn);
$podaci = $statistika->fetch_array();
$fakulteti = Fakultet::get_all_teams($conn);



if(!$utakmice){
    echo "Greska prilikom upita za sve utakmice";
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kk fon rezultati</title>
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
                 <p><a class="nav-link active" style= "color:black" aria-current="page" href="igraci.php"><b>Igraci</b></a></p>
            </li>
            <ul class="nav justify-content-end">
            <li class="nav-item">
                 <p><a class="nav-link active" style= "color:black" aria-current="page" href="#"><b>Rezultati</b></a></p>
            </li>     
        </ul>
        </div>
</div>

        <br>

        <h2>Trenutni skor</h2>
        <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th scope="col">Broj odigranih utakmica</th>
            <th scope="col">Broj pobeda</th>
            <th scope="col">Broj poraza</th>
            <th scope="col">Broj datih poena</th>
            <th scope="col">Broj primljenih poena</th>
            <th scope="col">Kos razlika</th>
          </tr>
        </thead>
        <tbody>
            
          <tr>
            <td id = "brUtakmica"><?php echo $skor ["broj_utakmica"] ?></td>
            <td id = "brPobeda"><?php echo $skor ["broj_pobeda"]  ?></td>
            <td id = "brPoraza"><?php echo $skor ["broj_poraza"] ?></td>
            <td id = "brDatiPoeni"><?php echo $podaci ["fon_poeni"] ?></td>
            <td id = "brPrimljeniPoeni"><?php echo $podaci ["protivnik_poeni"] ?></td>
            <td id = "kosRazlika"><?php if($podaci["fon_poeni"] > $podaci["protivnik_poeni"]) echo "+".$podaci ["kos_razlika"] ?><?php if($podaci["fon_poeni"] < $podaci["protivnik_poeni"]) echo "-".$podaci ["kos_razlika"] ?><?php if($podaci["fon_poeni"] == $podaci["protivnik_poeni"]) echo  "0"?>
            </td>
          </tr>
          
        </tbody>
        </table>
        
        <br>
        
        <div class="row">
            <div class="col">
                <h2>Rezultati po kolima</h2>
            </div>
            <div class="col-2">
                <button id="btn" class="btn" style="background-color: rgb(160, 215, 255); color: black;" data-bs-toggle="modal" data-bs-target="#dodajUtakmicu">
                    <b>Dodaj utakmicu</b>
                </button>  
            </div>
        </div>
        
       

      <table class="table table-hover table-striped" id ="tabelaUtakmica">
        <thead>
          <tr>
            <th scope="col">Datum odigravanja</th>
            <th scope="col">Vreme odigravanja</th>
            <th scope="col">Domacin</th>
            <th scope="col">Domacin broj poena</th>
            <th scope="col">Gost broj poena</th>
            <th scope="col">Gost</th>
          </tr>
        </thead>
        <tbody>
            <?php
                
                while ($utakmica = $utakmice->fetch_array()):
            ?>
          <tr>
            <td><?php echo $utakmica ["datum_odigravanja"]  ?></td>
            <td><?php echo $utakmica ["vreme_odigravanja"]  ?></td>
            <td><?php echo $utakmica ["domacin"]  ?></td>
            <td><?php echo $utakmica ["domacin_broj_poena"]  ?></td>
            <td><?php echo $utakmica ["gost_broj_poena"]  ?></td>
            <td><?php echo $utakmica ["gost"]  ?></td>
          </tr>
          <?php
                endwhile;           
            ?>
        </tbody>
      </table>


    <!--Modal dodaj utakmicu-->
     <div class="modal fade" id="dodajUtakmicu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">  
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="#" method="post" id="dodajForm">
                            <h3 style="color: black; text-align: center">Dodaj utakmicu</h3>
                            <div class="row">
                            <div class="col-md-11 ">             

                                <div>
                                    <label for="">Domacin</label>
                                    <!-- <input type="text"  name="domacin" class="form-control"/>
                                     -->
                                    <select name="domacin" id="domacin" class ="form-select">
                                        <?php
                                            while ($fakultet = $fakulteti->fetch_array()):
                                        ?>
                                        <option value="<?php echo $fakultet["naziv"]?>"> <?php echo $fakultet["naziv"] ?> </option>
                                        <?php
                                            endwhile;           
                                        ?>
                                    </select>
                                </div>

                                <div >
                                <label for="">Gost</label>
                                    <!-- <input type="text" name="gost" class="form-control"/>
                                     -->
                                     <select name="gost" id="gost" class ="form-select">
                                            <?php
                                                $fakulteti = Fakultet::get_all_teams($conn);
                                                 while ($fakultet = $fakulteti->fetch_array()):
                                            ?>
                                        <option value="<?php echo $fakultet["naziv"]?>"><?php echo $fakultet["naziv"] ?></option>
                                        <?php
                                            endwhile;           
                                        ?>
                                     </select>
                                </div>

                                

                                <div>
                                    <label for="">Domacin broj poena</label>
                                    <input type="text"  name="domacin_broj_poena" class="form-control"/>
                                </div>

                                <div>
                                    <label for="">Gost broj poena</label>
                                    <input type="text"  name="gost_broj_poena" class="form-control"/>
                                </div>

                                <div>
                                    <label for="">Datum odigravanja</label>
                                    <input type="Date"  name="datum_odigravanja" class="form-control"/>
                                </div>

                                <div>
                                    <label for="">Vreme odigravanja</label>
                                    <input type="text"  name="vreme_odigravanja" class="form-control" placeholder="format hh:mm (npr 16:00)"/>
                                </div>
                                
                                <br>

                                <div>
                                    <button id="btnDodaj" type="submit" class="btn btn-block"
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
    <script src="js/dodajUtakmicu.js"></script>
</body>
</html>