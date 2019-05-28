<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<div class="w2ui-page page-0">

   <div class="w2ui-field w2ui-span4 "  style="float:left">
      <label><?php echo($formCode) ?>:</label>
      <div>
         <input name="cd_construction_form" id="cd_construction_form" mask='PK' type="text" style="width: 60px;float:left" readonly="readonly" />
      </div>
   </div>

   <div class="w2ui-field w2ui-span4" style="float:left">
      <label><?php echo($formBuild); ?>:</label>
      <div>
         <input name="nr_construction_build_form" id="nr_construction_build_form" mask='I' type="text" style="width: 60px;" readonly="readonly" />
      </div>
   </div>


   <div class="w2ui-field w2ui-span4" style="float:left">
      <label><?php //echo($job);   ?>Description:</label>
      <div>
         <input name="ds_construction_form" id="ds_construction_form" mask='C' type="text" style="width: 354px;" autofocus/>
      </div>
   </div>

   <div class=" w2ui-field w2ui-span4" style="float:left">
      <label for="ds_type_gender_form"><?php echo($formGender); ?>:</label>
      <div>
         <input name="ds_type_gender_form" id="ds_type_gender_form" mask="PL" model = "<?php echo ($gendermodel); ?>" type="text" maxlength="64" style="width: 354px;text-transform: uppercase" autofocus/>
      </div>
   </div>



   <div class="w2ui-field w2ui-span3 " style="float:left">
      <label for="nr_heel_height_form"><?php echo($formHeight); ?>:</label>
      <div>
         <input name="nr_heel_height_form" mask='N;2.2' id="nr_heel_height_form"  type="text" style="width: 50px;float:left;"/>
      </div>
   </div>



   <div class="w2ui-field w2ui-span4 "  style="float:left">
      <label for="ds_comments_form"><?php echo($formComments); ?>:</label>
      <div>
         <input name="ds_comments_form" mask='T' id="ds_comments_form" type="textarea" style="width: 354px"></select>
      </div>
   </div>

   <div class="w2ui-field w2ui-span4 " style="float:left">
      <label><?php echo($formDeactivate); ?>:</label>
      <div>
         <input name="dt_deactivated_form" id="dt_deactivated_form"  type="text" style="width: 100px; text-align:center"></select>
      </div>
   </div>
</div>
</form>