<?php
function connect() {
    return new mysqli("localhost", "root", "", "utenti_db");
}

function login() {
    $conn = connect();
    if($conn->connect_error) die ("errore di connessione " . $conn->connect_error);
    $email = $_REQUEST["email"];
    $password = $_REQUEST["password"];
    $sql = "SELECT password FROM utenti WHERE email LIKE '$email'";
    $result = $conn->query($sql);
    if($result->num_rows != 1) {
        echo "Errore di login.";
        $conn->close();
        return;
    } 
    $hash_password = $result->fetch_assoc()["password"];
    if(password_verify($password, $hash_password)) {
        echo "Login effettuato!";
    } else {
        echo "Errore di login.";
    }
    $conn->close();
}

function registrati() {
    $conn = connect();
    if($conn->connect_error) die ("errore di connessione " . $conn->connect_error);
    $email = $_REQUEST["email"];
    $password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
    $sql = "INSERT INTO utenti (email, password) VALUES ('$email', '$password');";
    if($conn->query($sql) === true) {
        echo "registrato con successo";
    } 
    $conn->close();
}

if(isset($_REQUEST["login"])) {
    login();
}

if(isset($_REQUEST["registrati"])) {
    registrati();
}
?>