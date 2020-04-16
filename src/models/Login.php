<?php
//loadModel('User');

//require_once(realpath(MODEL_PATH . '/user.php'));

class Login extends Model{

  public function validate(){
    $errors = [];

    if (!$this->email) {
      $errors['email'] = 'email é um campo obrigatorio';
    }

    if (!$this->password) {
      $errors['password'] = 'por favor informe a senha!!';
    }

    if (count($errors) > 0) {
      throw new ValidationException($errors);
      
    }
  }


  public function checkLogin(){
    $this->validate();

    $user = User::getOne(['email' => $this->values['email']]);
    if ($user) {
      if ($user->end_date) {
        throw new AppException("usuario esta desligado da empresa.");
      }

       if (password_verify($this->password, $user->password)) {
         return $user;
   }
  }
   throw new AppException('usuario e senha invalidos.');

 }

}


 ?>
