<?php 
require './utils/credential.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_user']) && isset($_POST['login_password'])) {
  $submittedUser = $_POST['login_user'];
  $submittedPassword = $_POST['login_password'];

  if (isset($credentials['username'], $credentials['password'])) {
    if ($credentials['username'] == $submittedUser && $credentials['password'] == $submittedPassword) {
      $_SESSION['username'] = $submittedUser;
      $_SESSION['auth_timestamp'] = date("Y-m-d H:i:s");
      header('Location: /products');
      exit;
    } else {
      $_SESSION['login_form_error'] = 'Невірне ім’я користувача або пароль.';
    }
  } else {
    $_SESSION['login_form_error'] = 'Помилка зчитування облікових даних.';
  }
}

$loginFormError = $_SESSION['login_form_error'] ?? '';
unset($_SESSION['login_form_error']);
?>

<div class="login-box">
    <h2>🔐 Вхід</h2>

    <?php if ($loginFormError): ?>
    <div class="login-error"><?php echo htmlspecialchars($loginFormError); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="login_user" placeholder="Ім’я користувача" required>
        <input type="password" name="login_password" placeholder="Пароль" required>
        <button type="submit">Увійти</button>
    </form>
</div>
