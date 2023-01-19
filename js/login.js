function login(){
    console.log('pokusaj prijave');
    var aemail = document.getElementById('email').value;
    var alozinka = document.getElementById('lozinka').value;
    var login = false;

    request = $.ajax({
        url: 'handler/login.php',
        method: 'post',
        data: {
            email : aemail,
            lozinka: alozinka
        },
        
    }); 

    request.done(function(response, textStatus, jqXHR){
        if(response==="Success"){
            location.replace('rezultati.php');
        }
        else{
            console.log("Neuspesan login "+ response);
            alert("Neuspesno logovanje!\nProbajte ponovo.");
        } 
    });

}