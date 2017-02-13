<?if($errors = $this->session->flashdata('errors')):?>
    <?foreach($errors as $error):?>
        <p class="error"><?=$error?></p>
    <?endforeach;?>
<?endif?>