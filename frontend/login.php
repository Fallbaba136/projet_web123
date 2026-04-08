<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>


<?php require_once "authan/authanLogger.php" ;?>
<?php require_once "Template.php" ?>
 <?php $objet=new authanLogger(); ?>


<?php ob_start() ?>
<div class="full-width-image">
    <img src="asset/food4.jpeg" alt="Sunugal">
</div>


<div class="login-content">
    <?php $objet->generateformulaire("login.php");  // je vais  generer la formulaire ?>

</div>

<?php $content=ob_get_clean() ?>


<?php Template::render($content) ;?>

<?php if(array_key_exists('login',$_POST)){ //si l'utilisateur a essayer de se connecter 

         $tableau=$objet->log($_POST['username'],$_POST['password']);

        }           
?>

<?php if(!empty($tableau) and $tableau['granted']==true): //si l'authentification est bien reussis ?>
            <?php session_start();
                    $_SESSION['name']=$tableau['nick'];
                     header("Location: create_recette.php");
                    exit();
            ?>
            



 <?php else: ?>
   <script>
       document.addEventListener('DOMContentLoaded',function(){
        let h1=document.createElement('h1')
        h1.innerHTML="<?php echo $tableau['error']; ?>"
        h1.style.color="red"

        div=document.querySelector('.login-content')
        div.insertBefore(h1,div.firstChild)
    })
   </script>
   
 <?php endif; ?>
            
 


 </body>
</html>
        
    

