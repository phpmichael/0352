<?if($errors = $this->session->flashdata('errors')):?>
    <?foreach($errors as $error):?>
        <p class="label btn-danger"><?=$error?></p>
    <?endforeach;?>
<?endif?>