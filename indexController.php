<?php
class indexController {

  private $_view;
  private $_db;

  public function __construct(){
    $this->_view = new viewController;
    $this->_db = new connectDB;
  }

  public function index(){
    $data = array();

    $resultQuery = $this->_db->connect()->query("SELECT * FROM cwiczenie ORDER BY id desc");
    if($resultQuery->num_rows > 0){
      //echo "OK";
      while($row=$resultQuery->fetch_assoc()){
        $data[] = new pytaniaModel ($row);
      }
    }

    $this->_view->renderTemplate('views/pytania/pytania.phtml', $data);
  }

  public function dodaj_pytanie(){
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //debug($data);

    if ($data["action"]==1){
      $query = "INSERT INTO cwiczenie(tresc, answer, kategoria, rok) VALUES ('".$data["tresc"]."','".$data["answer"]."','".$data["kategoria"]."','".$data["rok"]."')";
      $con = $this->_db->connect();
      $test = $con->query($query);

      if ($test == true){
        echo "rekord dodany z numerem id: ".$con->insert_id; //insert_id to wbudowana w mySQLi
      }else{
        echo "rekord nie zostal dodany, błąd: ".$con->error;
      }
    }
    //$resultQuery = $this->_db->connect()->query("INSERT INTO cwiczenie VALUES (NULL, )");

    $this->_view->renderTemplate('views/pytania/dodaj_pytanie.phtml');
  }

public function usun_pytanie( array $params = [] ){
  debug($params);
  $query = "DELETE FROM cwiczenie WHERE id=".$params[0];
  //echo $query;
  $this->_db->connect()->query($query);

  header("location: ". __URL__);
}

  /*public function usun_pytanie(){
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if ($data["action1"]==1){
      $query = "DELETE FROM cwiczenie WHERE id='".$data["id"]."'";
      //echo $query;
      $con = $this->_db->connect();
      $test1 = $con->query($query);

      if ($test1 == true){
        echo "rekord usunięty"; //dodany z numerem id: ".$con->insert_id; //insert_id to wbudowana w mySQLi
      }else{
        echo "rekord nie zostal usunięty, błąd: ".$con->error;
      }
    }
  }*/

  public function edytuj_pytanie(array $params = []){
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //debug($data);

    if ($data["action2"]==1){
      echo $query = "UPDATE cwiczenie SET tresc='".$data["tresc"]."', answer='".$data["answer"]."', kategoria='".$data["kategoria"]."', rok='".$data["rok"]."' WHERE id=".$params[0];
      $con = $this->_db->connect();
      $con->query($query);
      header("location: ". __URL__);
}
    $this->_view->renderTemplate('views/pytania/edytuj_pytanie.phtml');

  }

  public function kontakt(){
        $this->_view->renderTemplate('views/kontakt/kontakt.php');
  }

  public function osoby(){
    $data = array();

    $resultQuery = $this->_db->connect()->query("SELECT * FROM t_osoby");
    if($resultQuery->num_rows > 0){
      //echo "OK";
      while($row=$resultQuery->fetch_assoc()){
        $data[] = new osobyModel ($row);
      }
    }

    $this->_view->renderTemplate('views/osoby/osoby.phtml', $data);
  }


}


 ?>
