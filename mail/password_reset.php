<?php

use app\helpers\App;
use app\helpers\Url;
?>

 <div class="container">
    <div class="header">
      <h1>Password Reset</h1>
    </div>
    <div class="content">
      <p>Dear User,</p>
      <p>Your are going to reset your password. Please click the button below to reset your password:</p>
      <a style="display: inline-block; background-color: #007bff; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px;" class="button" href="<?= Url::toRoute(['site/set-new-password', 'prt' => $user->password_reset_token], true) ?>">Reset Password</a>
    </div>
    <div class="footer">
      <p>If you did not take this action, please ignore this email.</p>
      <p>Regards,<br><?= App::appName() ?></p>
    </div>
  </div>