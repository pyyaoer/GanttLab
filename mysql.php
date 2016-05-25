<?php

class MySQL{

  var $mysql;

  function connect_mysql(){
    $this->mysql = new mysqli("localhost", "xiaoyang", "password", "gantt");
    if ($mysqli->connect_errno) {
       echo "<script>alert('Cannot connect to database gantt!');</script>";
       exit();
    }
  }

  function close_mysql(){
    $this->mysql->close();
  }

  /********************/
  /* Person Functions */
  /********************/
  function new_person($name, $email, $info, $passwd){

    if ($email == NULL)
      $email = "";
    if ($info == NULL)
      $info = "";

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return false;
    }
    $res->close();

    $sql = sprintf("INSERT INTO person (name, email, info, passwd) VALUES ('%s', '%s', '%s', '%s')", $name, $email, $info, $passwd);

    $this->mysql->query($sql);
    return true;
  }

  function info_person($name, &$email, &$info, &$passwd){

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $email = $row['email'];
    $info = $row['info'];
    $passwd = $row['passwd'];

    $res->close();
  }

  function update_person($name, $new_name, $email, $info, $passwd){

    if ($email == NULL)
      $email = "";
    if ($info == NULL)
      $info = "";

    if (strcmp($name, $new_name) != 0){
      $sql = sprintf("SELECT * FROM person WHERE name='%s'", $new_name);
      $res = $this->mysql->query($sql);
      if ($res->num_rows != 0){
        $res->close();
        return;
      }
      $res->close();
    }

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("UPDATE person SET name='%s', email='%s', info='%s', passwd='%s' WHERE id=%d", $new_name, $email, $info, $passwd, $id);

    $this->mysql->query($sql);
  }

  function has_person($name, $passwd){

    $sql = sprintf("SELECT * FROM person WHERE name='%s' AND passwd='%s'", $name, $passwd);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $res->close();
    return true;

  }


  /*********************/
  /* Project Functions */
  /*********************/
  function new_project($name, $info){

    if ($name == NULL || $name == "")
      return false;

    if ($info == NULL)
      $info = "";

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return true;
    }
    $res->close();

    if ($info != ""){
      $sql = sprintf("INSERT INTO project (name, info) VALUES ('%s', '%s')", $name, $info);
    } else{
      $sql = sprintf("INSERT INTO project (name) VALUES ('%s')", $name);
    }

    $this->mysql->query($sql);
    return true;
  }

  function info_project($id, &$name, &$info){

    $sql = sprintf("SELECT * FROM project WHERE id='%d'", $id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $name = $row['name'];
    $info = $row['info'];

    $res->close();
  }

  function update_project($name, $new_name, $info){

    if ($info == NULL)
      $info = "";

    if (strcmp($name, $new_name) != 0){
      $sql = sprintf("SELECT * FROM project WHERE name='%s'", $new_name);
      $res = $this->mysql->query($sql);
      if ($res->num_rows != 0){
        $res->close();
        return;
      }
      $res->close();
    }

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("UPDATE project SET name='%s', info='%s' WHERE id=%d", $new_name, $info, $id);

    $this->mysql->query($sql);
  }

  function flush_project($name){

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE project=%d ORDER BY start", $id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    while($row = $res->fetch_array(MYSQLI_ASSOC)){
      self::flush_event($row['id'], "");
    }
    $res->close();

  }

  function show_events($name){

    $data = array();

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return $data;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE project=%d ORDER BY start", $id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return $data;
    }
    while($row = $res->fetch_array(MYSQLI_ASSOC)){
      $data[]=array(
        'label' => $row['name'],
        'start' => $row['start'],
        'end' => $row['end'],
        'class' => $row['status'],
      );
    }
    $res->close();

    return $data;
  }


  /****************************/
  /* Person_Project Functions */
  /****************************/
  function new_pp($person, $project){

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $person);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $person_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM person_project WHERE person_id=%d AND project_id=%d", $person_id, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return true;
    }
    $res->close();

    $sql = sprintf("INSERT INTO person_project (person_id, project_id) VALUES (%d, %d)", $person_id, $project_id);

    $this->mysql->query($sql);
    return true;
  }

  function show_projects($name){

    $data = array();

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $name);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return $data;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM person_project WHERE person_id=%d", $id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return $data;
    }
    while($row = $res->fetch_array(MYSQLI_ASSOC)){
      $data[]=$row['project_id'];
    }
    $res->close();

    return $data;
  }


  /*******************/
  /* Event Functions */
  /*******************/
  function new_event($name, $start, $end, $project, $status, $info){

    if ($name == NULL || name == "")
      return false;

    if ($status == "" || $status == NULL)
      $status = "will";
    if ($info == NULL)
      $info = "";

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $name, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return true;
    }

    if ($start == NULL || $end == NULL || $start == "" || $end == ""){
      return false;
    }

    $sql = sprintf("INSERT INTO event (name, start, end, project, status, info) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $name, $start, $end, $project_id, $status, $info);

    $this->mysql->query($sql);
    return true;
  }

  function info_event($name, &$start, &$end, $project, &$status, &$info){

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $name, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $start = $row['start'];
    $end = $row['end'];
    $status = $row['status'];
    $info = $row['info'];

    $res->close();
  }

  function update_event($name, $new_name, $start, $end, $project, $status, $info){

    if ($info == NULL)
      $info = "";

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    if (strcmp($name, $new_name) != 0){
      $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $new_name, $project_id);
      $res = $this->mysql->query($sql);
      if ($res->num_rows != 0){
        $res->close();
        return;
      }
      $res->close();
    }

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $name, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $id = $row['id'];
    $res->close();

    $sql = sprintf("UPDATE event SET name='%s', start='%s', end='%s', status='%s', info='%s' WHERE id=%d", $new_name, $start, $end, $status, $info, $id);

    $this->mysql->query($sql);
  }

  function flush_event($event_id, $status){

    $sql = sprintf("SELECT * FROM event WHERE id=%d", $event_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $e_status = $row['status'];
    $e_end = $row['end'];
    $res->close();

    if ($e_status == "done"){
      return true;
    }

    $today_t = date("y-m-d");
    if (strtotime($today_t) > strtotime($e_end)){
      $sql = sprintf("UPDATE event SET status='%s' WHERE id=%d", "delayed", $event_id);
      $this->mysql->query($sql);
    }

    if ($e_status == "will"){
      $sql = sprintf("SELECT * FROM event_event WHERE master_id=%d", $event_id);
      $res = $this->mysql->query($sql);
      if ($res->num_rows == 0){
        $res->close();
        $sql = sprintf("UPDATE event SET status='%s' WHERE id=%d", "ready", $event_id);
        $this->mysql->query($sql);
      }
    }
    else if ($e_status == "ready"){
      $sql = sprintf("SELECT * FROM event_event WHERE master_id=%d", $event_id);
      $res = $this->mysql->query($sql);
      if ($res->num_rows != 0){
        $res->close();
        $sql = sprintf("UPDATE event SET status='%s' WHERE id=%d", "will", $event_id);
        $this->mysql->query($sql);
      }
    }

    if ($status == ""){
      return true;
    }
    else if ($status == "done"){
      $sql = sprintf("UPDATE event SET status='%s' WHERE id=%d", $status, $event_id);
      $this->mysql->query($sql);
      $sql = sprintf("DELETE FROM event_event WHERE slave_id=%d", $event_id);
      $this->mysql->query($sql);
    }
    else if ($status == "doing" || $status == "delayed"){
      $sql = sprintf("UPDATE event SET status='%s' WHERE id=%d", $status, $event_id);
      $this->mysql->query($sql);
    }

    return true;
  }


  /**************************/
  /* Person_Event Functions */
  /**************************/
  function new_pe($person, $event, $project){

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $event, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $event_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM person WHERE name='%s'", $person);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $person_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM person_project WHERE person_id=%d AND project_id=%d", $person_id, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $res->close();

    $sql = sprintf("SELECT * FROM person_event WHERE person_id=%d AND event_id=%d", $person_id, $event_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return true;
    }
    $res->close();

    $sql = sprintf("INSERT INTO person_event (person_id, event_id) VALUES (%d, %d)", $person_id, $event_id);

    $this->mysql->query($sql);
    return true;
  }

  /*************************/
  /* Event_Event Functions */
  /*************************/
  function new_ee($slave, $master, $project){

    $sql = sprintf("SELECT * FROM project WHERE name='%s'", $project);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $project_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $slave, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $slave_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event WHERE name='%s' AND project=%d", $master, $project_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows == 0){
      $res->close();
      return false;
    }
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $master_id = $row['id'];
    $res->close();

    $sql = sprintf("SELECT * FROM event_event WHERE slave_id=%d AND master_id=%d", $slave_id, $master_id);
    $res = $this->mysql->query($sql);
    if ($res->num_rows != 0){
      $res->close();
      return true;
    }
    $res->close();

    $sql = sprintf("INSERT INTO event_event (slave_id, master_id) VALUES (%d, %d)", $slave_id, $master_id);

    $this->mysql->query($sql);
    return true;
  }

}
?>
