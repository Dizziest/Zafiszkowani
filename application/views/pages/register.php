<div id='reg-form'>
<?php echo form_open('page/register'); ?>
    <h1>Rejestracja</h1>
    Login: <input type="text" placeholder="Wpisz swój login(max 20 znaków)" name="login" required=""> <br/>
    Hasło: <input type="password" placeholder="Twoje hasło (min 6 znaków)" name="password" required=""><br/>
    Email: <input type="email" placeholder="Twojemail@email.com" name="email"> <br/>
<input type="submit" name="submit" value="Rejestracja">
<input type='reset' value="Wyczyść">
</form>
<?php echo validation_errors(); ?>
</div>