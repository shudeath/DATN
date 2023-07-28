<div class="container myspin position-absolute top-50 start-50 translate-middle" id="mySpin">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
</div>
<script>
    var navBar = document.getElementById("main-navbar");
    //console.log(navBar.offsetHeight);
    var navSide = String((navBar.offsetHeight)/2) + "px";
    //console.log(navSide);
    document.getElementById("mySpin").style.height = navSide;
</script>