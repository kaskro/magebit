<div class="container">
    <div id="vue-container" class="user-page-container">
        <!-- Update form -->
        <div id="updateForm" class="form-container">
            <form action="" method="post">
                <div class="form-header">
                    <div class="d-flex space-between">
                        <h2>User info:
                            <?php echo $user->fullname; ?>
                        </h2>
                        <img src="/public/img/head/logo.png" alt="logo" />
                    </div>
                    <div class="d-flex space-between">
                        <a href="/user/delete" class="red">Delete user</a>
                        <a href="/user/logout">Log out</a>
                    </div>
                    <hr />
                </div>
                <div class="form-content">
                    <ul>
                        <li>
                            <field caption="Fullname" id="fullnamne" name="fullname" type="text" icon="user" error="<?php if (isset($errors["fullname"])) {
                                    echo ucFirst($errors["fullname"]);
                                } ?>" default="<?php if (isset($post["fullname"])) {
                                    echo $post["fullname"];
                                } else {
                                    echo $user->fullname;
                                } ?>">
                            </field>
                        </li>
                        <li>
                            <field caption="Email" id="email" name="email" type="text" icon="email" error="<?php if (isset($errors["email"])) {
                                    echo ucFirst($errors["email"]);
                                } ?>" default="<?php if (isset($post["email"])) {
                                    echo $post["email"];
                                } else {
                                    echo $user->email;
                                } ?>">
                            </field>
                        </li>
                        <li>
                            <div>Attributes</div>
                        </li>
                        <li>
                            <field-list fields="
								<?php echo htmlspecialchars($attributes) ?>">
                            </field-list>
                        </li>
                        <li>
                            <p class="red">Only attributes with name and value will be saved after update! Others will be deleted!</p>
                        </li>
                    </ul>
                </div>
                <div class="form-footer">
                    <input name="update_token_field" type="hidden" value="
						<?php echo $token;  ?>" />
                    <button class="button orange" type="submit">UPDATE</button>
                </div>
            </form>
        </div>
        <!-- Update form end-->
    </div>
    <div class="copyright">All rights reserved "Magebit" 2016.</div>
</div>