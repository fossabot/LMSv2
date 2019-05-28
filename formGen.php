<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$models = '';


$formCode = 'Code';
$formBuild = 'Build';
$formSeason = 'Season';
$formDivision = 'Division';
$formBrand = 'Brand';
$formDesc = 'Description';
$formConstruction = 'Construction';
$formLast = 'Last';
$formUpperEdge = 'Upper Edge';
$formOutSole = 'Outsole Design';
$formInsoleBoard = 'Insole Board';
$formInsoleBinding = 'Insole Binding';
$formCounterPocket = 'Counter Pocket';
$formProductType = 'Type Upper';
$formProductTypeL = 'Type Lining';
$formProductTypeS = 'Type Sock L.';
$formFoam = 'Foam';
$formStitch = 'Stitch';
$formSockStitch = 'Sock Stitch';
$formSockLogo   = 'Sock Logo';
$formToePiece   = 'Toe Piece';
$formTopLift = 'Top Lift';
$formOrnamnet = 'Ornament';
$formOrnComment = 'Orn.Comments';
$formTopBox     = 'Toe Box';
$formGenSpec    = 'Generic Spec';
$formDeact      = 'Deactivated';
$formGender     = 'Gender';
$formMidSole    = 'Mid Sole';
$formWelt       = 'Welt';
$formSoleThickness = 'Sole Thickness';
$formSole = 'Sole';
$formSoleEdge = 'Edge Shape';
$formHeel = 'Heel';
$formHeelHeight = 'Height';
?>

<!-- W2UI -->
<link rel="stylesheet" href="third_party/w2ui-1.4.3/w2ui-1.4.3.css"/>
<script type="text/javascript" src="third_party/w2ui-1.4.3/w2ui-1.4.3.js"></script>
<!-- CSS do MAIN -->
<link rel="stylesheet" href="application/css/main.css">
<link rel="stylesheet" href="application/css/filter_styles.css">


<div>
   <div style="width:800px; display: inline-block;">

      <div style="width:800px;display: inline-block">

         <div class="w2ui-field w2ui-span4 cgbSmallForm"  style="float:left">
            <label><?php echo($formCode) ?>:</label>
            <div>
               <input name="cd_shoe_specification_form" id="cd_shoe_specification_form" mask='PK' type="text" style="width: 60px;float:left" readonly="readonly" />
            </div>
         </div>

         <div class="w2ui-field w2ui-span4 cgbSmallForm"  style="float:left">
            <label><?php echo($formBuild) ?>:</label>
            <div>
               <input name="nr_shoe_specification_build_form" id="nr_shoe_specification_build_form" mask='I' type="text" style="width: 60px;float:left" readonly="readonly" />
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_season_form"><?php echo($formSeason); ?>:</label>
            <div>
               <input name="ds_season_form" id="ds_season_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="16" style="width: 80px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="dt_deactivated_form"><?php echo($formDeact); ?>:</label>
            <div>
               <input name="dt_deactivated_form" id="dt_deactivated_form" mask="D" model = "<?php echo ($models); ?>" type="text" maxlength="16" style="width: 80px;text-transform: uppercase" autofocus/>
            </div>
         </div>

      </div>

      <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
         <label for="ds_division_form"><?php echo($formDivision); ?>:</label>
         <div>
            <input name="ds_division_form" id="ds_division_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="32" style="width: 200px;text-transform: uppercase" autofocus/>
         </div>
      </div>

      <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
         <label for="ds_division_brand_form"><?php echo($formBrand); ?>:</label>
         <div>
            <input name="ds_division_brand_form" id="ds_division_brand_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="32" style="width: 200px;text-transform: uppercase" autofocus/>
         </div>
      </div>

      <div class="w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
         <label><?php echo($formDesc); ?>:</label>
         <div>
            <input name="ds_shoe_specification_form" id="ds_division_brand_form" mask='C' type="text" style="width: 495px;;text-transform: uppercase;" autofocus/>
         </div>
      </div>

      <div style="width:800px;display: inline-block">
         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left" >
            <label for="ds_construction_form" style="background-color: beige;"><?php echo($formConstruction); ?>:</label>
            <div>
               <input name="ds_construction_form" id="ds_construction_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_last_form"><?php echo($formLast); ?>:</label>
            <div>
               <input name="ds_last_form" id="ds_last_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

      </div>

      <div style="width:800px;display: inline-block;background-color: beige; border: #000 dashed thin" id="constr_area">


         <div style="width:800px;display: inline-block" id="constr_area_1">

            <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
               <label for="ds_gender_form"><?php echo($formGender); ?>:</label>
               <div>
                  <input name="ds_gender_form" id="ds_gender_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>


            <div class=" w2ui-field w2ui-span3 cgbSmallForm" style="float:left">
               <label for="ds_product_mid_sole_form"><?php echo($formMidSole); ?>:</label>
               <div>
                  <input name="ds_product_mid_sole_form" id="ds_product_mid_sole_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>

            <div class=" w2ui-field w2ui-span3 cgbSmallForm" style="float:left">
               <label for="ds_product_welt_form"><?php echo($formWelt); ?>:</label>
               <div>
                  <input name="ds_product_welt_form" id="ds_product_welt_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>


            <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
               <label for="ds_sole_thickness_form"><?php echo($formSoleThickness); ?>:</label>
               <div>
                  <input name="ds_sole_thickness_form" id="ds_sole_thickness_form" mask="RO" type="text" style="width: 90px" autofocus/>
               </div>
            </div>

         </div>



         <div style="width:800px;display: inline-block" id="constr_area_2">

            <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
               <label for="ds_product_sole_material_form"><?php echo($formSole); ?>:</label>
               <div>
                  <input name="ds_product_sole_material_form" id="ds_product_sole_material_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>


            <div class=" w2ui-field w2ui-span3 cgbSmallForm" style="float:left">
               <label for="ds_sole_edge_shape_form"><?php echo($formSoleEdge); ?>:</label>
               <div>
                  <input name="ds_sole_edge_shape_form" id="ds_sole_edge_shape_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>

            <div class=" w2ui-field w2ui-span3 cgbSmallForm" style="float:left">
               <label for="ds_product_heel_form"><?php echo($formHeel); ?>:</label>
               <div>
                  <input name="ds_product_heel_form" id="ds_product_heel_form" mask="RO" type="text" style="width: 120px" autofocus/>
               </div>
            </div>


            <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
               <label for="nr_heel_height_form"><?php echo($formHeelHeight); ?>:</label>
               <div>
                  <input name="nr_heel_height_form" id="nr_heel_height_form" mask='N;2.2' type="text" style="width: 90px" autofocus/>
               </div>
            </div>



         </div>     
      </div>
      
      
      <div style="width:800px;display: inline-block">
         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_upper_edge_form"><?php echo($formUpperEdge); ?>:</label>
            <div>
               <input name="ds_upper_edge_form" id="ds_upper_edge_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_outsole_design_form"><?php echo($formOutSole); ?>:</label>
            <div>
               <input name="ds_outsole_design_form" id="ds_outsole_design_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

      </div>


      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_insole_board_form"><?php echo($formInsoleBoard); ?>:</label>
            <div>
               <input name="ds_product_insole_board_form" id="ds_product_insole_board_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>


         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_insole_binding_form"><?php echo($formInsoleBinding); ?>:</label>
            <div>
               <input name="ds_product_insole_binding_form" id="ds_product_insole_binding_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>
      </div>

      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_counter_pocket_form"><?php echo($formCounterPocket); ?>:</label>
            <div>
               <input name="ds_product_counter_pocket_form" id="ds_product_counter_pocket_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_foam_form"><?php echo($formFoam); ?>:</label>
            <div>
               <input name="ds_product_foam_form" id="ds_product_foam_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>
         
         
      </div>
      
      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_toe_piece_form"><?php echo($formToePiece); ?>:</label>
            <div>
               <input name="ds_product_toe_piece_form" id="ds_product_toe_piece_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>
         
         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_toe_box_form"><?php echo($formTopBox); ?>:</label>
            <div>
               <input name="ds_product_toe_box_form" id="ds_product_toe_box_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>
      </div>
      
      
      
      <div style="width:800px;display: inline-block">
         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_top_lift_form"><?php echo($formTopLift); ?>:</label>
            <div>
               <input name="ds_product_top_lift_form" id="ds_product_top_lift_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_generic_shoe_specification_form"><?php echo($formGenSpec); ?>:</label>
            <div>
               <input name="ds_generic_shoe_specification_form" mask='T' id="ds_generic_shoe_specification_form" type="textarea" style="width: 300px"></select>
            </div>
         </div>

         
      </div>
      
      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_ornament"><?php echo($formOrnamnet); ?>:</label>
            <div>
               <input name="ds_product_ornament" id="ds_product_ornament" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 300px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_ornament_comment"><?php echo($formOrnComment); ?>:</label>
            <div>
               <input name="ds_product_ornament_comment" mask='T' id="ds_product_ornament_comment" type="textarea" style="width: 300px"></select>
            </div>
         </div>
         
         
         
      </div>

      
      
      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_type_upper_form"><?php echo($formProductType); ?>:</label>
            <div>
               <input name="ds_product_type_upper_form" id="ds_product_type_upper_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 168px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_type_lining_material_form"><?php echo($formProductTypeL); ?>:</label>
            <div>
               <input name="ds_product_type_lining_material_form" id="ds_product_type_lining_material_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 168px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_product_type_sock_lining_form"><?php echo($formProductTypeS); ?>:</label>
            <div>
               <input name="ds_product_type_sock_lining_form" id="ds_product_type_sock_lining_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 170px;text-transform: uppercase" autofocus/>
            </div>
         </div>


      </div>

      <div style="width:800px;display: inline-block">

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_stitch_form"><?php echo($formStitch); ?>:</label>
            <div>
               <input name="ds_stitch_form" id="ds_stitch_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 168px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_stitch_sock_form"><?php echo($formSockStitch); ?>:</label>
            <div>
               <input name="ds_stitch_sock_form" id="ds_stitch_sock_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 168px;text-transform: uppercase" autofocus/>
            </div>
         </div>

         <div class=" w2ui-field w2ui-span4 cgbSmallForm" style="float:left">
            <label for="ds_sock_logo_form"><?php echo($formSockLogo); ?>:</label>
            <div>
               <input name="ds_sock_logo_form" id="ds_sock_logo_form" mask="PL" model = "<?php echo ($models); ?>" type="text" maxlength="64" style="width: 170px;text-transform: uppercase" autofocus/>
            </div>
         </div>


      </div>
      
   </div>


</div>

