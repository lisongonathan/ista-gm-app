$(document).ready(function(){
    //Surbrillance
    $('.itemReleve').addClass("active") 
    
    $('.printBtn').click(function(e){
        e.preventDefault()
        let contenu = $(this).html()
        $(this).empty()
        $('.invoice-body').printThis()
        $(this).html(contenu)
    })
})