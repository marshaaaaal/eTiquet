
function getRegion(){
    var result;
    var list = document.getElementById("optRegion");
    var optionVal = list.options[list.selectedIndex].id;
    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from refProvince where regCode = '" + optionVal + "'");
    Http.send();
    Http.onreadystatechange = function(){
    if(this.readyState==4 && this.status==200){
    result = JSON.parse(Http.responseText);
    var i=0;
    $('#optProvince')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">Province</option>')
    ;
    $('#optC_Municipality')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">City/Municipality</option>')
    ;
    $('#optBaranggay')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">Baranggay</option>')
    ;  
    for(i=0;i<result.length;i++){
    $('#optProvince')
    .find('option')
    .end()
    .append('<option  id = '+result[i].provCode+'>'+result[i].provDesc+'</option>')
    ;
    }
    }
    
    }
    
    
    }
    
    function getProvince(){
    
    var result;
    var list = document.getElementById("optProvince");
    var optionVal = list.options[list.selectedIndex].id;
    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
    Http.send();
    Http.onreadystatechange = function(){
    if(this.readyState==4 && this.status==200){
    result = JSON.parse(Http.responseText);
    var i=0;
    $('#optC_Municipality')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">City/Municipality</option>')
    ;
    $('#optBaranggay')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">Baranggay</option>')
    ; 
    for(i=0;i<result.length;i++){
    $('#optC_Municipality')
    .find('option')
    .end()
    .append('<option id = '+result[i].citymunCode+'>'+result[i].citymunDesc+'</option>')
    ;
    }
    }
    
    }
    
    
    } 
    function getBProvince(){

        var result;
        var list = document.getElementById("optB_Province");
        var optionVal = list.options[list.selectedIndex].id;
        const Http = new XMLHttpRequest();
        Http.open("GET", "../sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
        Http.send();
        Http.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200){
        result = JSON.parse(Http.responseText);
        var i=0;
        $('#optBC_Municipality')
        .find('option')
        .remove()
        .end()
        .append('<option selected disabled  value="">City/Municipality</option>')
        ;
        for(i=0;i<result.length;i++){
        $('#optBC_Municipality')
        .find('option')
        .end()
        .append('<option id = '+result[i].citymunCode+'>'+result[i].citymunDesc+'</option>')
        ;
        }
        }
        
        }
        
        
        } 
    function getCity(){
    var result;
    var list = document.getElementById("optC_Municipality");
    var optionVal = list.options[list.selectedIndex].id;
    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from refbrgy where citymuncode = '" + optionVal + "'");
    Http.send();
    Http.onreadystatechange = function(){
    if(this.readyState==4 && this.status==200){
    result = JSON.parse(Http.responseText);
    var i=0;
    $('#optBaranggay')
    .find('option')
    .remove()
    .end()
    .append('<option selected disabled  value="">Baranggay</option>')
    ;  
    for(i=0;i<result.length;i++){
    $('#optBaranggay')
    .find('option')
    .end()
    .append('<option id = '+result[i].brgyCode+'>'+result[i].brgyDesc+'</option>')
    ;
    }
    }
    
    }
    
    
    }