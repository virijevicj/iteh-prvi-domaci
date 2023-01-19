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
        url:'handler/dodajIgraca.php',
        type:'post',
        data:serijalizacija
    });

    request.done(function(response, textStatus, jqXHR){
        if(response==="Success"){
            alert("Igrac uspesno dodat!");
            appendRow(red_za_unos);
        }
        else alert("Greska prilikom dodavanja igraca.\nProbajte ponovo!");
    });

});


function appendRow(red){
    $.get("handler/vratiPoslednjegIgraca.php", function(id){
        console.log(id);
        $("#tabelaIgraca tbody").append(
            `
            <tr>
                <td>${red.value}</td>
                <td>${red.prezime}</td>
                <td>${red.datum_rodjenja}</td>
                <td>${red.pozicija}</td>
                <td>${red.indeks}</td>
                <td>${red.smer}</td>
                <td>${red.telefon}</td>
                <td>${red.email}</td>
                <td><input type="submit" onclick= "obrisiIgraca(${id})" class="btn btn-outline-dark" name="submit" value="Obrisi"></td>
            </tr>
            `
        );
    });
};

