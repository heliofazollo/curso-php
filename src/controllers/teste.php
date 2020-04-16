<!DOCTYPE html>
<html ng-app="helloWord">
  <head>
    <meta charset="utf-8">
    <title>Angular</title>
    <script src="lib/angular/angular.js"></script>
    <script>
      angular.module("helloWord", []);
      angular.module("helloWord").controller("helloWordCtrl", function($scope){
        $scope.message = "hello word";
      });
    </script>
  </head>
  <body>
    <div ng-controller="helloWordCtrl">
      {{message}}
    </div>
  </body>
</html>

<!--<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>JS Bin</title>
</head>
<body>
   <form name="CadastroAlunos" type="text" method="post" enctype="multipart/form-data" action="photo_user.php">

  Nome: <input type="text" name="NomeAluno"></br>
  Idade: <input type="text" name="IdadeAluno"></br>
  Foto: <input type="file" name="image" /></br>
    <input type="submit" value="Enviar" name="envia" />
  </form>

</body>
</html>

<?php
//controler temporario



//$wh = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));


//  $i1 = DateInterval::createFromDateString('9 hours');
  //$i2 = DateInterval::createFromDateString('6 hours');

  //$r1 = sumIntervals($i1, $i2);
  //$r2 = subtractItervals($i1, $i2);

  //print_r(getDateFromString($r2));


  //echo " <br>";


  //$workedIntervalString = $wh->getWorkedInterval()->format('%H:%I:%S');
  //print_r($workedIntervalString);
  //echo "<br>";

  //$lunchIntervalString = $wh->getLunchInterval()->format('%H:%I:%S');
  //print_r($lunchIntervalString);
  //echo "<br>";


 ?>
