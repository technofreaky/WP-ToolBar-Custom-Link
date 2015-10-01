<form novalidate="novalidate" method="post">

<?php
$options = get_option('wptbcl_links');
$options[] = array();
$i = 1;

foreach($options as $option){
        if(empty($option)){
$option['name'] = ''; $option['link'] = ''; $option['slug'] = ''; $option['class'] = ''; $option['parentid'] = ''; $option['title']  = '';
        }
?>

    <h3 id="tblinkh_<?php echo $i; ?>"><u> Link <?php echo $i; ?></u> </h3>
    <table class="form-table" id="tblink_<?php echo $i; ?>">
        <tbody>
            <tr>
                <th scope="row"> <label for="blogname">Name</label> </th>
                <td> <input type="text" class="regular-text create_slug" value="<?php echo $option['name']; ?>" data-id="<?php echo $i; ?>" id="" name="wptbcl[<?php echo $i; ?>][name]"/> </td>
                <th scope="row"> <label for="blogname">Link [URL]</label> </th>
                <td> <input type="text" class="regular-text" value="<?php echo $option['link']; ?>" id="" name="wptbcl[<?php echo $i; ?>][link]"/> </td>
            </tr>
            <tr>
                <th scope="row"> <label for="blogname">Slug</label> </th>
                <td> <input type="text" class="" value="<?php echo $option['slug']; ?>" id="slug_<?php echo $i; ?>" name="wptbcl[<?php echo $i; ?>][slug]"/> </td>
                <th scope="row"> <label for="blogname">Elemnt HTML Class</label> </th>
                <td> <input type="text" class="" value="<?php echo $option['class']; ?>" id="" name="wptbcl[<?php echo $i; ?>][class]"/> </td>
            </tr>
            <tr>
                <th scope="row"> <label for="blogname">Parent ID</label> </th>
                <td> <input type="text" class="" value="<?php echo @$option['parentid']; ?>" id="" name="wptbcl[<?php echo $i; ?>][parentid]"/> </td>
                <th scope="row"> <label for="blogname">Title Attribute</label> </th>
                <td> <input type="text" class="regular-text" value="<?php echo $option['title']; ?>" id="" name="wptbcl[<?php echo $i; ?>][title]"/> </td>
            </tr>
            <tr>
                <th scope="row"> </th>
                <td>  </td>
                <th scope="row"> </th>
                <td>  <input type="button" data-id="<?php echo $i; ?>" id="delete_<?php echo $i; ?>" value="Delete" class="button  delete_link"/> </td>
            </tr>
        </tbody>
    </table>
    <hr id="tblinkhr_<?php echo $i; ?>">
<?php
    $i++;
    }
?>
    

    <p class="submit"> <input type="submit" value="Save Changes" class="button button-primary" id="wptbcl_save" name="wptbcl_save"> </p>
</form>

<script>
    jQuery(document).ready(function(){
        jQuery('.delete_link').click(function(){
            var id = jQuery(this).attr('data-id');
            jQuery('#tblink_'+id).fadeOut(function(){
                jQuery(this).remove();
            });
            jQuery('#tblinkh_'+id).fadeOut(function(){
                jQuery(this).remove();
            });
            jQuery('#tblinkhr_'+id).fadeOut(function(){
                jQuery(this).remove();
            });
        });
        jQuery('.create_slug').keyup(function(){
            var value = jQuery(this).val();
            var id = jQuery(this).attr('data-id');
            create_slug(id,value); 
        });
        
        jQuery('.create_slug').keydown(function(){
            var value = jQuery(this).val();
            var id = jQuery(this).attr('data-id');
            create_slug(id,value); 
        });
        
    });
    
    function create_slug(id,value){
        var val = value;
        val = val.replace(/ /g,'');
        val = val.replace(/[^a-zA-Z0-9 ]/g, "");
        val = val.toLowerCase();        
        jQuery('#slug_'+id).val('');
        jQuery('#slug_'+id).val(val);
    }
</script>