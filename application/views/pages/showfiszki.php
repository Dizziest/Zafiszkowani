<div class="container">
    <div class="table-title">
        <h3>Twoje fiszki</h3>
    </div>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-left">Pytanie</th>
                <th class="text-left">Odpowiedź</th>
                <th class="text-left"></th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <?php foreach ($fiszka_item as $fiszka): ?>
            <tr>
                <td class="text-left">
                    <?php echo $fiszka->question; ?>
                </td>
                <td class="text-left">
                    <?php echo $fiszka->answer; ?>
                </td>
                <td class="text-left">
                    <a class="edit" href="<?php echo site_url('usercontrol/edit_fiszka/'.$fiszka->id); ?>">Edytuj</a>
                </td>
                <td class="text-left">
                    <a href="<?php echo site_url('usercontrol/delete_fiszka/'.$fiszka->id); ?>">Usuń</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    if($this->session->userdata('delete_flag') == TRUE){?>
    <div id="deleted-message" style=" text-align: center; font-size: 30px; color: white; font-family: "Roboto", helvetica, arial, sans-serif;">
        Pomyślnie usunięto.<br/>
    </div>
    <?php
        $this->session->unset_userdata('delete_flag');     
    }
    ?>
</div>