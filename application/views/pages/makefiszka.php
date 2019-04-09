
<div id='fiszka-form'>
<?php echo form_open('usercontrol/make_fiszka'); ?>
    <h1>Tworzenie fiszki</h1>
    Pytanie: <input type="text" placeholder="Podaj swoje pytanie/słówko w j.polskim." name="question"> <br/>
    Odpowiedz: <input type="text" placeholder="Podaj odpowiedź." name="answer"><br/>
<input type="submit" name="submit" value="Stwórz">
<input type='reset' value="Wyczyść">
</form>
<?php echo validation_errors();
            if(($this->session->userdata('fiszka_flag')) == TRUE){
                echo "Pomyslnie utworzono fiszkę.";
                $this->session->unset_userdata('fiszka_flag');  
            }
            ?>
</div>
