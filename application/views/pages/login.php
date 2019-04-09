<div id='log-form'>
<?php echo form_open('page/login'); ?>
    <h1>Logowanie</h1>
    Login: <input type="text" placeholder="Wpisz swój login(max 20 znaków)" name="login"> <br/>
    Hasło: <input type="password" placeholder="Twoje hasło (min 6 znaków)" name="password"><br/>
<input type="submit" name="submit" value="Zaloguj">
<input type='reset' value="Wyczyść">
</form>
<?php echo validation_errors(); ?>
</div>
