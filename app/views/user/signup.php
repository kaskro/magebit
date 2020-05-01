<div class="container">
    <div id="vue-container" class="row">
        <div id="slider" class="left">
            <!-- Sign up form -->
            <div class="back-fold-left">
                <div class="back-fold__top-left"></div>
                <div class="back-fold__middle"></div>
                <div class="back-fold__bottom-left"></div>
            </div>
            <div id="signupForm" class="form-container">
                <form action="signup" method="post">
                    <div class="form-header">
                        <div class="d-flex space-between">
                            <h2>Sign Up</h2>
                            <img src="/public/img/head/logo.png" alt="logo" />
                        </div>
                        <hr />
                    </div>
                    <div class="form-content">
                        <field caption="Name" id="signup-name" name="fullname" type="text" icon="user" error="
							<?php if (isset($errors["fullname"])) {
                                echo ucFirst($errors["fullname"]);
                            } ?>" default="
							<?php if (isset($post["fullname"])) {
                                echo ucFirst($post["fullname"]);
                            } ?>">
                        </field>
                        <field caption="Email" id="signup-email" name="email" type="email" icon="email" error="
							<?php if (isset($errors["email"])) {
                                echo ucFirst($errors["email"]);
                            } ?>" default="
							<?php if (isset($post["email"])) {
                                echo $post["email"];
                            } ?>">
                        </field>
                        <field caption="Password" id="signup-password" name="password" type="password" icon="password" error="
							<?php if (isset($errors["password"])) {
                                echo ucFirst($errors["password"]);
                            } ?>" default="
							<?php if (isset($post["password"])) {
                                echo $post["password"];
                            } ?>">
                        </field>
                    </div>
                    <div class="form-footer">
                        <input name="signup_token_field" type="hidden" value="
							<?php echo $token;  ?>" />
                        <button class="button orange" type="submit">SIGN UP</button>
                    </div>
                </form>
            </div>
            <!-- Sign up form end-->
            <!-- Login form -->
            <div class="back-fold-right hide">
                <div class="back-fold__top-right"></div>
                <div class="back-fold__middle"></div>
                <div class="back-fold__bottom-right"></div>
            </div>
            <div id="loginForm" class="form-container hide">
                <form action="login" method="post">
                    <div class="form-header">
                        <div class="d-flex space-between">
                            <h2>Login</h2>
                            <img src="/public/img/head/logo.png" alt="logo" />
                        </div>
                        <hr />
                    </div>
                    <div class="form-content">
                        <field caption="Email" id="login-email" name="email" type="email" icon="email" error="" default=""></field>
                        <field caption="Password" id="login-password" name="password" type="password" icon="password" error="" default=""></field>
                    </div>
                    <div class="form-footer">
                        <div class="d-flex space-between">
                            <input name="login_token_field" type="hidden" value="
									<?php echo $token ?>" />
                            <button class="button orange" type="submit">LOGIN</button>
                            <button class="button white" type="button">Forgot?</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Login form end -->
        </div>
        <div class="col">
            <div id="signupInfo" class="info hide">
                <h2>Don't have an account?</h2>
                <hr />
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde
                    eligendi, assumenda laboriosam ad repellendus natus nihil adipisci
                    porro non voluptatibus, molestias harum veritatis, modi vero enim!
                    Omnis suscipit ad ullam.
                </p>
                <button id="signupBtn" class="button blue" type="button">SIGN UP</button>
            </div>
        </div>
        <div class="col">
            <div id="loginInfo" class="info">
                <h2>Have an account?</h2>
                <hr />
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde
                    eligendi, assumenda laboriosam ad repellendus natus.
                </p>
                <button id="loginBtn" class="button blue" type="button">LOGIN</button>
            </div>
        </div>
    </div>
    <div class="copyright">All rights reserved "Magebit" 2016.</div>
</div>