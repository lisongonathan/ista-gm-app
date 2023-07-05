<?php 
    $page = "Erreur";
    ob_start();
?>


<div class="container">
    <div class="row">
      <div class="col-lg-6 col-lg-offset-3 p404 centered">
        <img src="img/404.png" alt="">
        <h1>PAS DE PANIQUE!!</h1>
        <h3><?php echo $msgErreur; ?></h3>
        <br>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <button class="btn btn-theme mt" onclick="rtn()">Retour</button>
          </div>
        </div>
        <h5 class="mt">Peut être voulez vous aller vers la page:</h5>
        <p><a href="index.php">Dashboard</a> | <a href="index.php?deconnexion"> Login</a></p>
      </div>
    </div>
<script>
function rtn() {
   window.history.back();
}
</script>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/error.php"; ?>
