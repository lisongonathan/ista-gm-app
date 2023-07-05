<?php 
    $page = "Login";
    ob_start();
?>

<form class="form-login" method="POST" action="">
    <h2 class="form-login-heading">Se connecter</h2>
    <div class="login-wrap">
        <p><?php echo $msg; ?></p>
        <input type="text" class="form-control" name="matricule" placeholder="Code d'accès" autofocus>
        <br>
        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" autofocus>
        <br>
        <select class="form-control liste-section" name="module">
            <option >Modules</option>
            <option value="1">SECTION</option>
            <option value="2">ADMINISTRATION</option>
            <option value="3">TITULAIRE</option>
            <option value="4">ETUDIANT</option>
            <option value="5">JURY</option>
        </select>
        <br />
        <input class="btn btn-theme btn-block" name="submit" type="submit" value="Connexion" />
        
        <hr>
        <div class="login-social-link centered">
          <div class="registration">
            N'avez vous pas de compte ?<br/>
            <a class="" href="index.php?subscrib">
              Créer un compte
              </a>
          </div>
        </div>
    </div>
</form>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/auth.php"; ?>