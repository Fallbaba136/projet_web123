

<?php 
class authanLogger {

    public function generateformulaire(string $action): void { ?>

        <div class="d-flex justify-content-center align-items-center vh-100 bg-light pb-3">
            <form method="post" action="<?php echo $action ?>" class="auth-form bg-dark text-white p-4 rounded text-center">

                <label class="form-label mb-3 d-block">Please login</label>

                <input type="text" class="form-control mb-2" id="username" placeholder="username" name="username">
                <input type="password" class="form-control mb-3" id="password" placeholder="password" name="password"> 
                <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            </form>
        </div>

<?php 
    }



 public function log(string $username,string $password): array{
  $username=htmlspecialchars($username);
  $password=htmlspecialchars($password);

  $tableau=array('granted'=>false,'nick'=>null,'error'=>null);

  if($username=='threesn' and $password=='falldiallocisse'){
    $tableau['granted']=true;
  }

  if($tableau['granted']){
    $tableau['nick']="Diambar";
    
  }
  else{
    if(empty($username)){
      $tableau['error']="username is empty";
    }
    else{
      if(empty($password)){
        $tableau['error']="password is empty";
      }
      else{
        $tableau['error']="authantification is failled";
      }
    }
  }
  return $tableau;

 }
}