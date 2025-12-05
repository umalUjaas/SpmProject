<?php
// contact.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate empty fields
    $errors = [];
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Check for empty fields
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, simulate success and redirect
    if (empty($errors)) {
        // In a real application, you would:
        // - Send an email
        // - Save to database
        // - etc.
        
        // Simulate processing delay
        sleep(1);
        
        // Redirect to thank you page
        header("Location: thank-you.html");
        exit();
    } else {
        // If there are errors, you might want to display them
        // For now, we'll just redirect to thank-you page as per requirements
        // In a real app, you'd pass errors back to the form
        header("Location: thank-you.html");
        exit();
    }
} else {
    // If not POST request, redirect to home
    header("Location: index.php");
    exit();
}
?>
