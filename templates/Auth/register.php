<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Register new user');
?>
<div class="container register">
    <div class="users form content">
        <h1 class="h3 mb-2 text-gray-800">Add New User</h1>
        <?= $this->Form->create($user, ['id' => 'registerForm']) ?>
        <?= $this->Flash->render() ?>
        <?php
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('email');
        echo $this->Form->control('password', [
            'value' => '',
            'id' => 'password'
        ]);
        echo $this->Form->control('password_confirm', [
            'type' => 'password',
            'value' => '',
            'label' => 'Retype Password',
            'id' => 'password_confirm'
        ]);
        echo '<div id="passwordMatchMsg" style="color:red; display:none;">Passwords do not match.</div>';
        ?>
        <?= $this->Form->button(__('Register'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>

        <script>
            const pwd = document.getElementById('password');
            const confirm = document.getElementById('password_confirm');
            const msg = document.getElementById('passwordMatchMsg');

            confirm.addEventListener('blur', function() {
                if (confirm.value !== '' && pwd.value !== confirm.value) {
                    msg.style.display = 'block';
                } else {
                    msg.style.display = 'none';
                }
            });
        </script>

    </div>
</div>
