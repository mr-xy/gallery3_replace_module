<?php defined("SYSPATH") or die("No direct script access.") ?>
<style type="text/css">
#g-dialog, .ui-dialog {
    width:500px !important;
}
#validateLink {
    visibility: hidden;
}
</style>
<script type="text/javascript">
  var IPTC_TITLE =
    <?= t('Edit IPTC-data of "%item_title"', array("item_title" => "__TITLE__"))->for_js() ?>;
  var set_title = function(title) {
    $("#g-dialog").dialog("option", "title", IPTC_TITLE.replace("__TITLE__", title));
  }
  set_title("<?= $item->title ?>");

</script>
<div class="g-iptcedit-dialog">
  
<body>
    <form action="<?= url::site("iptcedit/dialog/{$item->id}") ?>" method="post" id="iptcedit"> 
     <?php 
     if(empty($iptcTags)){
         echo "<div class='g-warning'>" . t('No IPTC-Tags are activated. Go to admin->settings->IPTC edit to activate and label.') . "</div>";
         $type = "hidden";
     }else{
         $type = "submit";
        foreach($iptcTags as $key => $value) {
            $label = $iptcLabels[$key];
            if($key == 'IPTC_CAPTION') {
                $inputs .= '<label for="' . $key . '"><span style="color:#656565;">' . $label . '</span></label>';
                $inputs .= '<textarea id="' . $key  . '" type="text" name="iptcdata[' . $key .']">'. $i->get($iptcTags[$key]).'</textarea><br />';                
            }else{ 
            $inputs .= '<label for="' . $key . '"><span style="color:#656565;">' . $label . '</span></label>';
             $inputs .= '<input id="' . $key  . '" type="text" name="iptcdata[' . $key .']" value="' . $i->get($iptcTags[$key]). '" size="100" /><br />';
            }
        }
        echo $inputs;
     }
    ?> 
        <input type="hidden" name="file" value="<?php print $file;?>" />
        <input type="hidden" name="submitted" value="1" />
        <input type="<?php echo $type ?>" value="<?= t("Save") ?>" id="iptcsubmit" onclick="reload()"/>
    </form>
    <!--<a href="#" id="validateLink" onclick="validate()"><?= t("Validate IPTC-data") ?></a>-->
    <!-- datepicker -->
    <iframe id="dp_target" name="dp_target" src="<?php echo url::abs_file('modules/iptcedit/helpers/datepicker_frame.php'); ?>" style="display: none; width:100%;height: 100%;min-width:310px;min-height:300px;border:0px solid #fff;margin: 0;padding: 0;"></iframe>
    <!-- /datepicker -->
    
<script type="text/javascript">
    $(document).ready(function(){
        $('#iptcsubmit').removeAttr('onclick').unbind('click');
    });

    $('#iptcsubmit').bind('click', function(event) {
        var ready = 0;
        ready = validate();
        if(ready == 0) {
           $('#iptcedit').submit();
           event.preventDefault();
           $.post("<?= url::site("iptcedit/dialog/{$item->id}") ?>", $("#iptcedit").serialize());
           $.post("<?php echo $purgeIPTCcache?>");
           //$('.ui-dialog-content').html('<div style="border-bottom:1px solid green; padding-bottom: 5px; margin-bottom: 10px; color:green;"><?= t('IPTC-data have been updated.'); ?></div>');
           $('html, body').animate({scrollTop: $(".ui-dialog-titlebar").offset().top}, 1000);
           reload();
        }else{
           event.preventDefault();
        }
    });
    
    function reload(){
        setTimeout("location.reload()", 800);
    }
    
    function setDate(e){
        $('#IPTC_CREATED_DATE').val(e);
        $('#dp_target').dialog('close');
    }
    $('#IPTC_CREATED_DATE').focus(function(e){
        $('#dp_target').dialog({
            height: 300,
            width: 300
        });
        $('#dp_target').dialog('open');
    });
    
    //form validation
    function validate(){
        var invalid = 0;
        $('input').css('background-color', 'white');
        $('textarea').css('background-color', 'white');
        <?php
        foreach($iptcTags as $key => $value) {
            if(module::get_var("iptcedit", $key."_required") && module::get_var("iptcedit", $key)) {
                echo "if ($('#$key').val().length == 0) {invalid += 1; $('#$key').css('background-color','#FFF9A0');} ";
            }
        }
        ?>
        if(invalid == 0) {
            //$('#iptcsubmit').css('visibility', 'visible');
            //$('#validateLink').css('visibility', 'hidden');
        }else{
            //$('#iptcsubmit').css('visibility', 'hidden');
            //$('#validateLink').css('visibility', 'visible');
            alert("<?= t("Please fill all required (colored) fields.")?>");
        }
        return invalid;
    }
    
</script>
</body>  
  
</div>
