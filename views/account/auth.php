<div class="auth">
    <section class="auth-head">
        <div class="auth-head-logo">
            <img src="../assets/images/quizz-white.svg" alt="logo quiz, un cercle avec 3 points d'interrogation"/>
        </div>
        <h1>Quiz</h1>
    </section>

    <section class="auth-container">
        <div class="auth-container-menu">
            <div class="auth-container-menu-cursor"></div>
            <div class="auth-container-menu-item active" id="login">
                <p>Se connecter</p>
            </div>

            <div class="auth-container-menu-item" id="register">
                <p>S'inscrire</p>
            </div>
        </div>

        <div class="auth-container-form">
            <form class="auth-container-form-login">
                <div class="auth-container-form-login-input">
                    <label for="name">Pseudo :</label>
                    <input name="name" type="text" id="login-username"/>
                    <span class="error" id="login-pseudo-error"></span>
                </div>

                <div class="auth-container-form-login-input">
                    <label for="password">Mot de passe :</label>
                    <input name="password" type="password" id="login-password"/>
                    <span class="error" id="login-password-error"></span>
                </div>

                <div class="auth-container-form-login-button">
                    <div class="auth-container-form-login-button-content">
                        <span>Se connecter</span>
                    </div>
                </div>
                <span class="error" id="login-error"></span>
            </form>

            <form class="auth-container-form-register hide">
                <div class="auth-container-form-register-select">
                    <div class="auth-container-form-register-select-preview">
                        <img src="../assets/images/personOne.png" />
                    </div>

                    <div class="auth-container-form-register-select-options hide">
                        <div class="auth-container-form-register-select-options-option active">
                            <img src="../assets/images/personOne.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personTwo.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personThree.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personFour.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personFive.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personSix.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personSeven.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personEight.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personNine.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personTen.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personEleven.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personTwelve.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personThirteen.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personFourteen.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personFifteen.png" />
                        </div>

                        <div class="auth-container-form-register-select-options-option">
                            <img src="../assets/images/personSixteen.png" />
                        </div>
                    </div>
                </div>

                <div class="auth-container-form-register-input">
                    <label for="name">Pseudo :</label>
                    <input name="name" type="text" id="register-username"/>
                    <span class="error" id="register-pseudo-error"></span>
                </div>

                <div class="auth-container-form-register-input">
                    <label for="password">Mot de passe :</label>
                    <input name="password" type="password" id="register-password"/>
                    <span class="error" id="register-password-error"></span>
                </div>

                <div class="auth-container-form-register-input">
                    <label for="confirmationPassword" id="conf-password">Confirmation :</label>
                    <input name="confirmationPassword" type="password" id="confirmation-password"/>
                    <span class="error" id="register-conf-password-error"></span>
                </div>

                <div class="auth-container-form-register-button">
                    <div class="auth-container-form-register-button-content">
                        <span>S'inscrire</span>
                    </div>
                </div>
            </form>
        </div>
        
    </section>
</div>

<script type="text/javascript" src="../views/account/js/auth.js"></script>