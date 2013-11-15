<?php if ( ! defined('BASEPATH')) exit('Sin Acceso Directo al Script');?>
<div class="container_16 CuerpoPpal">
  <div class="grid_16 AjusteTop">
      <h1 id="nombreEntidad">República Bolivariana de Venezuela</h1>
  </div>
  <div class="clear"></div>  
  <div class="grid_9 suffix_7" style="position: relative;">
   <div class="MarcoMapa"></div>
   <img id="entidad" src="<?php echo base_url();?>imagenes/mapas/blank.png" width="482" height="364" usemap="#Map"
        style="position: absolute; top:0px; left:0; z-index:4;"/>
   <map name="Map" id="Map">
   </map>  
   <img id="entidadClic" src="<?php echo base_url();?>imagenes/mapas/blank.png" width="482" height="364"
        style="position: absolute; top:0px; left:0;z-index:3;"/>  
   <div style="position: absolute; width:482px; height: 364px;">
   <img id="entidadFondo" src="<?php echo base_url();?>imagenes/mapas/E00.png" width="482" height="364" alt="Mapa de Venezuela" 
        style="position: absolute; top:0px; left:0px; z-index:2;"/>
   <img id="venBoton" src="<?php echo base_url();?>imagenes/venezuela_gris.png" title="Volver al Mapa"
        style="position: absolute; bottom:3px; left:3px; z-index:6;" class="BotonIco"/>
   </div>
  </div>  
  <div class="clear"></div>
  <div class="prefix_9 grid_7" style="height: 32px;">  
      <table width="100%">
          <tr>
              <td width="40px">
                  <?php echo $boton1;?>
              </td>
              <td style="width:240px; vertical-align: middle; height: 32px;">
                   <?php echo $spanb1;?>
              </td>              
              <td>
                  <?php echo $boton2;?>
              </td>
          </tr>
      </table>      
      <br/>      
  </div> 
  <div class="clear"></div>
  <div class="prefix_9 grid_7" style="height: 350px " id="Informacion"></div> 
  <div class="clear"></div>
  <div class="grid_9 suffix_7" id="datosINE" ></div>
  <div class="clear"></div>
  <div class="grid_16 AjusteBottom"></div>
  <div class="clear"></div>
</div>