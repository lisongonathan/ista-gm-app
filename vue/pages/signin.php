<?php 
    $page = "Signin";
    ob_start();
?>

<form class="form-login" method="POST" action="">
    <h2 class="form-login-heading">S'Inscrire</h2>
    <div class="login-wrap">
        <p><?php echo $msg; ?></p>
        <input type="text" class="form-control" name="matricule" placeholder="Code d'accès" autofocus>
        <br>
        <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" autofocus>
        <br>
        <input type="password" class="form-control" name="c_mdp" placeholder="Confirmer le mot de passe" autofocus>
        <br>
        <select class="form-control liste-section" name="module">
            <option >Utilisateurs</option>
            <option value="1">ENSEIGNANT</option>
            <option value="2">ETUDIANT</option>
            <option value="3">ADMINISTRATIF</option>
        </select>
        <br />
        <input class="btn btn-theme btn-block" name="submit" type="submit" value="Inscription" />
        
        <br />
        <div class="login-social-link centered">
          <div class="registration">
            J'ai déjà un compte<br/>
            <a class="" href="index.php">
              Se connecter
              </a>
          </div>
        </div>
    </div>
</form>

<?php $contenu = ob_get_clean(); ?>
<?php require "vue/gabarit/auth.php"; ?>