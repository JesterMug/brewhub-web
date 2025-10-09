<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->layout = 'login';
$this->assign('title', 'Register');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-6 col-md-9">


            <!-- Card Begins -->



            <div class="card o-hidden border-0 shadow-lg my-5" style="min-height: 400px">
                <div class="card-body p-0">
            <div class="row h-100">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <div class="p-5 w-100 text-center">


                        <!-- Form Beings -->


                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4" style="font-size: 30px">Join Now</h1>
                        </div>

                        <?= $this->Form->create($user) ?>

                        <div class="form-group">
                            <?= $this->Form->control('first_name', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'First Name',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('last_name', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Last Name',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Email Address',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('password', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Password',
                                'type' => 'password',
                                'required' => true,
                                'id' => 'passwordInput'
                            ]) ?>

                            <small id="passwordFeedback" class="form-text text-muted"></small>

                            <div class="progress mt-2" style="height:8px; background:#333;">
                                <div id="passwordStrengthBar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                            </div>
                        </div>

                        <!-- Load zxcvbn -->
                        <script src="https://unpkg.com/zxcvbn@4.4.2/dist/zxcvbn.js" defer></script>

                        <!-- Password strength logic -->
                        <script defer>
                            (function(){
                                function scoreWithFallback(val){
                                    if (typeof zxcvbn === 'function') {
                                        return Math.max(0, Math.min(4, zxcvbn(val).score));
                                    }
                                    // fallback heuristic if zxcvbn fails to load
                                    if (!val) return 0;
                                    let s = 0;
                                    if (val.length >= 12) s++;
                                    if (/[A-Z]/.test(val)) s++;
                                    if (/[0-9]/.test(val)) s++;
                                    if (/[^A-Za-z0-9]/.test(val)) s++;
                                    return Math.max(0, Math.min(4, s));
                                }

                                function update(){
                                    const pw = document.getElementById('passwordInput');
                                    const bar = document.getElementById('passwordStrengthBar');
                                    const fb  = document.getElementById('passwordFeedback');
                                    if (!pw || !bar || !fb) return;

                                    const score = scoreWithFallback(pw.value || '');
                                    const colors = ['bg-danger','bg-warning','bg-info','bg-primary','bg-success'];
                                    const msgs = [
                                        'Very weak — add more words.',
                                        'Weak — try a longer passphrase.',
                                        'Fair — could be stronger.',
                                        'Strong — nice!',
                                        'Very strong!'
                                    ];

                                    bar.className = 'progress-bar ' + colors[score];
                                    bar.style.width = ((score + 1) * 20) + '%';
                                    bar.setAttribute('aria-valuenow', (score + 1) * 20);
                                    fb.textContent = msgs[score];
                                }

                                document.addEventListener('DOMContentLoaded', () => {
                                    const pw = document.getElementById('passwordInput');
                                    if (!pw) return;
                                    pw.addEventListener('input', update);
                                    update();
                                });
                            })();
                        </script>


                        <div class="d-grid">
                            <button class="btn btn-primary btn-user btn-block">Register</button>
                        </div>

                        <?= $this->Form->end() ?>

                        <hr>
                        <div class="text-center">
                            <?= $this->Html->link('Already have an account? Login!', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'small']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
