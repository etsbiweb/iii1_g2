emel radi

#include"..
session_start();
if(isset($_POST['submit'])) {
  
        $name=$_POST['name'],
        $email= $_POST['email'],
        $phone= $_POST['phone'],
        $message= => $_POST['message']
    ;

    // Slanje emaila
    sendEmail($formData);
$stmt->("INSERT INTO contact_form (name, email, phone, message) VALUES (?, ?, ?, ?)");
    // Redirekcija na stranicu sa uspješnom porukom
    header("Location: success.php");
    exit();
} else {
    echo "Molimo popunite formu.";
}