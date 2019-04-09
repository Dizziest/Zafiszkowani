<div id='fiszka-form'>
<?php echo form_open('usercontrol/edit_fiszka/'.$id); ?>
    <h1>Edytowanie fiszki</h1>
    Pytanie: <input type="text" value="<?php print($this->session->userdata('question')); ?>" name="question"> <br/>
    Odpowiedz: <input type="text" value="<?php print ($this->session->userdata('answer')); ?>" name="answer"><br/>
<input type="submit" name="submit" value="Edytuj">
<input type='reset' value="Wyczyść">
</form>
<?php echo validation_errors();
            ?>
</div>