$('#dodajForm').submit(function(){
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija = $form.serialize();
    let red_za_unos = $form.serializeArray().reduce(function(json, {name, value}){
        json[name]=value;
        return json;
    });

    request = $.ajax({
        url:'handler/dodajUtakmicu.php',
        type:'post',
        data:serijalizacija
    });

    request.done(function(response, textStatus, jqXHR){
        if(response==="Success"){
            alert("Utakmica uspesno dodata!");
            dodajUtakmicu(red_za_unos);
            azurirajSkor(red_za_unos);
        }
        else alert("Utakmica nije uspesno dodata. \nProbajte ponovo!");
    });
});

function dodajUtakmicu(red){

    $("#tabelaUtakmica tbody").append(
        `
        <tr>
            <td>${red.datum_odigravanja}</td>
            <td>${red.vreme_odigravanja}</td>
            <td>${red.value}</td>
            <td>${red.domacin_broj_poena}</td>
            <td>${red.gost_broj_poena}</td>
            <td>${red.gost}</td>
        </tr>
        `
    ); 
}

function azurirajSkor(red){
    var broj_odigranih_utakmica = document.getElementById('brUtakmica').textContent.trim();
    var broj_pobeda = document.getElementById('brPobeda').textContent.trim();
    var broj_poraza = document.getElementById('brPoraza').textContent.trim();
    var broj_datih_poena = document.getElementById('brDatiPoeni').textContent.trim();
    var broj_primljenih_poena = document.getElementById('brPrimljeniPoeni').textContent.trim();
    var kos_razlika_string = document.getElementById('kosRazlika').textContent.trim();
    var kos_razlika;
    if(kos_razlika_string.startsWith('+') || kos_razlika_string.startsWith('-')){
        kos_razlika = kos_razlika_string.substring(1, kos_razlika_string.length).trim();
    }else{
        kos_razlika = 0;
    }
    console.log(broj_odigranih_utakmica + " / " + broj_pobeda + " / " + broj_poraza + " / " + broj_datih_poena + " / " + broj_primljenih_poena + " / " + kos_razlika);

    broj_odigranih_utakmica = parseInt(broj_odigranih_utakmica) + 1;
    if(red.value == "Fakultet organizacionih nauka"){//fon je domacin
        if(red.domacin_broj_poena > red.gost_broj_poena){
            broj_pobeda = parseInt(broj_pobeda) + 1;
        }else{
            broj_poraza = parseInt(broj_poraza) + 1;
        }
        broj_datih_poena = parseInt(broj_datih_poena) + parseInt(red.domacin_broj_poena);
        broj_primljenih_poena = parseInt(broj_primljenih_poena) + parseInt(red.gost_broj_poena);
    }else{//fon je gost
        if(red.gost_broj_poena > red.domacin_broj_poena){
            broj_pobeda = parseInt(broj_pobeda) + 1;
        }else{
            broj_poraza = parseInt(broj_poraza) + 1;
        }
        broj_datih_poena = parseInt(broj_datih_poena) + parseInt(red.gost_broj_poena);
        broj_primljenih_poena = parseInt(broj_primljenih_poena) + parseInt(red.domacin_broj_poena);
    }
    kos_razlika = broj_datih_poena - broj_primljenih_poena;
    if(kos_razlika > 0){
        kos_razlika_string = "+" + kos_razlika;
    }else if(kos_razlika < 0){
        kos_razlika_string = "-" + kos_razlika;
    }else{
        kos_razlika_string = 0;
    }
    console.log("************************************************************")
    console.log(broj_odigranih_utakmica + " / " + broj_pobeda + " / " + broj_poraza + " / " + broj_datih_poena + " / " + broj_primljenih_poena + " / " + kos_razlika_string);
    

    document.getElementById('brUtakmica').innerText = broj_odigranih_utakmica;
    document.getElementById('brPobeda').innerText = broj_pobeda;
    document.getElementById('brPoraza').innerText = broj_poraza;
    document.getElementById('brDatiPoeni').innerText = broj_datih_poena;
    document.getElementById('brPrimljeniPoeni').innerText = broj_primljenih_poena;
    document.getElementById('kosRazlika').innerText = kos_razlika_string;

}
