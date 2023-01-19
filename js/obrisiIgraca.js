function obrisiIgraca(id){
    event.preventDefault();
    console.log('ulazak u obrisi igraca');
    var result = confirm("Da li sigurno zelite da obrisete igraca?");
    if(result == true){

    request = $.ajax({
        url: 'handler/obrisiIgraca.php',
        method: 'post',
        data: {
            igrac_id : id
        },

        success: function () {
            alert('Igrac obrisan iz baze!')
            location.reload();
        }
    })
}

}