<div class="main-container col3-layout">
    <div class="main">
        <div class="page">
            
            <?load_theme_view('inc/tpl-cur-location');?>

            <div class="left-col-border">
                <div class="left-col-border-top">
                    <div class="col-wrapper">
                        <div class="col-main">
                            <?load_theme_view($tpl_page);?>
                        </div>

                        <div class="col-left sidebar">
                            <?load_theme_view('inc/left-sidebar');?>
                        </div>
                        <br class="clear" />
                    </div>

                    <div class="col-right sidebar">
                        <?load_theme_view('inc/right-sidebar');?>
                    </div>
                    <br class="clear" />
                </div>
            </div>
        </div>
    </div>
</div>