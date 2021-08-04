<form action="" method="post" enctype="multipart/form-data" id="file-import">

<p class="gtcdi_desc"><?php _e('1. Select the type of file to import.','language');?></p>

<select name="import-file-type" id="import-file-type">
<option value=""><?php _e('Select Import File','language');?></option>
<option value="xml"><?php _e('XML','language');?></option>
<option value="csv"><?php _e('CSV','language');?></option>
</select>

<input type="text" name="xpath" id="xpath" placeholder="Specify XML XPath">

<div class="gtcdi_divider"></div>

<p class="gtcdi_desc"><?php _e('2. Select your file and click Upload File','language');?>.</p>

<input type="file" name="import-file" id="import-file"><br><br>
<input type="submit" value="Upload File">
</form>

<div class="progress">
    <div class="bar"></div >
    <div class="percent">0%</div >
</div>

<p id="gtcdi_status"></p>

<div class="gtcdi_divider"></div>

<p class="gtcdi_desc"><?php _e('3. Click continue to map your fields.','language');?></p>

<form action="" method="post">
    <input type="hidden" name="file-name" id="file-name" value="">
    <input type="hidden" name="file-type" id="file-type" value="">
    <input type="hidden" name="file-path" id="file-path" value="">
    <input type="hidden" name="step" value="map">
    <input type="submit" class="button button-primary" value="Continue &raquo;">
</form>