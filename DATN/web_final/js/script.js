/*Main*/
    view_spin = "<div id='mySpin'><div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'></div></div></div>";
    main_spin = "<div class='container myspin position-absolute top-50 start-50 translate-middle' id='mySpin'\><div class='d-flex justify-content-center'><div class='spinner-border text-primary' role='status'></div></div></div><script>var navBar = document.getElementById('main-navbar');var navSide = String((navBar.offsetHeight)/2) + 'px';document.getElementById('mySpin').style.height = navSide;</script>";
    card_spin = "<div class='container position-absolute top-50 start-50 translate-middle' id='cardSpin'\><div class='d-flex justify-content-center'><div class='spinner-border text-primary text-center' role='status'></div></div></div><script>var navBar = document.getElementById('main-navbar');var navSide = String((navBar.offsetHeight)/2) + 'px';document.getElementById('cardSpin').style.height = navSide;</script>";
/*Main*/

/*Bang cham cong*/
    function dateSelect(){
        var y = document.getElementById("curyear");
        var x = document.getElementById("curmonth");
        var i = x.selectedIndex + 1;
        const url = "view/cong.php?m=" + i + "&y=" + y.value ;
        //$("#myTable").load(url);
        loadPage(url,"myTable","GET");
    }
    function defaultTable(){
        var today = new Date();
        y = today.getFullYear();
        m = today.getMonth() + 1;
        const url = "view/cong.php?m=" + m + "&y=" + y ;
        //$("#myTable").load(url);
        loadPage(url,"myTable","GET");
    }
    function defaultTime(){
        var today = new Date();
        var y = document.getElementById("curyear");
        y.value = today.getFullYear();
        var x = document.getElementById("curmonth");
        
        for (var i=0; i<x.options.length; i++) {
            option = x.options[i];
            if (option.value == today.getMonth() + 1) {
                    option.setAttribute('selected', true);
                return; 
            }
        } 
    }
    function loadPage(page,ID,method){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById(ID).innerHTML = this.responseText;
        }
        xhttp.open(method, page);
        xhttp.send();
    }
    function spinner(){
        var main=document.getElementById("maincontent");
        main.innerHTML = main_spin;
    } 
/*Bang cham cong*/