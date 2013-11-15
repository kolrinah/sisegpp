<?php if (!defined('BASEPATH')) exit('Sin Acceso Directo al Script');      
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  SISTEMA DE SEGUIMIENTO DE POLÍTICAS PÚBLICAS                     *
 *  DESARROLLADO POR: ING. REIZA GARCÍA                              *
 *                    ING. HÉCTOR MARTÍNEZ                           *
 *  DISEÑO GRÁFICO:   TSU. MARIA GABRIELA MONTERO                    *
 *  PARA:  VICEPRESIDENCIA DE LA REPÚBLICA BOLIVARIANA DE VENEZUELA  *
 *  FECHA: FEBRERO DE 2013                                           *
 *  FRAMEWORK PHP UTILIZADO: CodeIgniter Version 2.1.3               *
 *                           http://ellislab.com/codeigniter         *
 *  TELEFONOS PARA SOPORTE: 0416-9052533 / 0212-5153033              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Mapa_venezuela extends CI_Controller {
  function __construct() 
  {
     parent::__construct();
     $this->load->model('Presupuesto');
     $this->load->model('Entidades');
  }
  
  function index()
  {
    // VERIFICAMOS SI EXISTE SESION ABIERTA    
    if (!$this->session->userdata('aprobado')) {redirect ('acceso', 'refresh'); exit();}
        
    $data=array();
    $data['titulo']='Estados de Venezuela';
    $data['contenido']='mapa_venezuela';    
    
    $data['script']='<!--Incluimos Funciones JS de uso común-->'."\n";
    $data['script'].="\t".'<script type="text/javascript" charset="utf-8" src="'.base_url().'js/comunes.js"></script>'."\n";

    $data['script'].='<!-- Cargamos JS RGraph -->'."\n";
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().
                          'js/RGraph/libraries/RGraph.common.core.js"></script>'."\n";
    
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().
                          'js/RGraph/libraries/RGraph.common.key.js"></script>'."\n";
    
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().
                          'js/RGraph/libraries/RGraph.bar.js"></script>'."\n";     
    
    $data['script'].='<!-- Cargamos Nuestro JS -->'."\n";
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().'js/mapa_venezuela.js"></script>'."\n";
 
    $data['boton1'] ='<div class="stack">';
    $data['boton1'].='<img src="'.base_url().'imagenes/menu00.png" alt="Menú" title="Menú">';    
    $data['boton1'].='<ul id="stack">';
    $data['boton1'].='<li><a menu="01"><span style="background-color:hsl(0, 100%, 50%);">
                                             Ingresos de la Entidad</span>
                          <img src="'.base_url().'imagenes/menu01.png" alt="Ingresos"></a></li>';
    $data['boton1'].='<li><a menu="02"><span style="background-color:hsl(40, 100%, 50%);">
                                             Transferencias de Recursos</span>
                          <img src="'.base_url().'imagenes/menu02.png" alt="Transferencias"></a></li>';
    $data['boton1'].='<li><a menu="03"><span style="background-color:hsl(60, 100%, 50%);" >
                                             Presupuesto de Gastos</span>
                          <img src="'.base_url().'imagenes/menu03.png" alt="Presupuesto de Gastos"></a></li>';
    $data['boton1'].='<li><a menu="04"><span style="background-color:hsl(80, 100%, 50%);">
                                             Presupuesto de Personal</span>
                          <img src="'.base_url().'imagenes/menu04.png" alt="Presupuesto de Personal"></a></li>';
    $data['boton1'].='<li><a menu="05"><span style="background-color:hsl(200, 100%, 50%);">
                                             Contratos Colectivos</span>
                          <img src="'.base_url().'imagenes/menu05.png" alt="Contratos Colectivos"></a></li>';
    $data['boton1'].='<li><a menu="06"><span style="background-color:hsl(250, 100%, 50%);">
                                             Prestaciones Sociales</span>
                          <img src="'.base_url().'imagenes/menu06.png" alt="Prestaciones Sociales"></a></li>';
    $data['boton1'].='<li><a menu="07"><span style="background-color:hsl(300, 100%, 50%);">
                                             Otros Pasivos Laborales</span>
                          <img src="'.base_url().'imagenes/menu07.png" alt="Otros Pasivos Laborales"></a></li>';
    $data['boton1'].='<li><a menu="08"><span style="background-color:hsl(320, 100%, 50%);">
                                             Ejecución Presupuestaria</span>
                          <img src="'.base_url().'imagenes/menu08.png" alt="Ejecución Presupuestaria"></a></li>';
    $data['boton1'].='<li><a menu="09"><span style="background-color:hsl(350, 100%, 50%);">
                                             Inversión Social</span>
                          <img src="'.base_url().'imagenes/menu09.png" alt="Inversión Social"></a></li>';    
    $data['boton1'].='</ul>';
    $data['boton1'].='</div>';
    
    $data['spanb1']='<span id="spanB1" menu="00">Menú</span>';
    
    $data['boton2'] ='<div class="ToggleBoton" onclick="javascript:ToggleBotonB2()" title="Haga clic para cambiar">';
    $data['boton2'].='<img id="imgB2" src="'.base_url().'imagenes/tabla.png"/>';
    $data['boton2'].='</div>';
    $data['boton2'].='<span id="spanB2">&nbsp;&nbsp;Tabla</span>';
    $data['boton2'].='<input type="hidden" id="hideB2" value="t" />';   
    
    $data['datosine']='';
    
    // CARGAMOS LA VISTA   
    $this->load->view('plantillas/plantilla_general',$data);  
  }
  
  function cargar_info()
  {
    if (!$this->input->is_ajax_request()) die('Acceso Denegado');
    
    $entidad= $this->input->post('entidad');
    $menu= trim($this->input->post('menu'));
    $forma= $this->input->post('forma');
    
    switch($menu)
    {
      case '00':
            die();
            break;
      case '01':
            $query2011=$this->Presupuesto->ingresos_x_year($entidad, 2011);
            $query2012=$this->Presupuesto->ingresos_x_year($entidad, 2012);  
            if($forma=='t') // SE MUESTRA LA INFORMACION DE INGRESOS EN TABLA
            {              
              $total2011=$this->Presupuesto->total_ingreso_x_year($entidad, 2011);                
              $total2012=$this->Presupuesto->total_ingreso_x_year($entidad, 2012); 
              die ($this->_tabla_ingresos($query2011, $total2011, $query2012, $total2012));            
            }
            else // SE MUESTRA LA INFORMACION DE INGRESOS EN GRAFICO
            {
              die ($this->_grafico_ingresos($query2011->result(), $query2012->result()));                
            }
            break;
      case '04': 
            $query2011=$this->Presupuesto->rrhh_x_year($entidad, 2011);
            $query2012=$this->Presupuesto->rrhh_x_year($entidad, 2012); 
            if($forma=='t') // SE MUESTRA LA INFORMACION DE RRHH EN TABLA
            {              
              $total2011=$this->Presupuesto->total_rrhh_x_year($entidad, 2011);                 
              $total2012=$this->Presupuesto->total_rrhh_x_year($entidad, 2012); 
              die ($this->_tabla_rrhh($query2011, $total2011, $query2012, $total2012));                        
            }
            else  // SE MUESTRA LA INFORMACION DE RRHH EN GRAFICO
            {
              die ($this->_grafico_rrhh($query2011->result(), $query2012->result()));                
            }
            break;
       default:
            $data='<br/><br/><img src="'.base_url().'imagenes/construccion.gif"/>';
            die($data);
    }    
  }

  function cargar_wiki()
  {
    if (!$this->input->is_ajax_request()) die('Acceso Denegado');
    $entidad= $this->input->post('entidad');
    
    if(strlen($entidad)<4)
    {
        $data=$this->_informacionEstado($entidad);
    }
    else
    {
        $data=$this->_informacionMunicipio($entidad);
    }
    die($data);
  }
  
  function cargar_mapeo()
  {
    if (!$this->input->is_ajax_request()) die('Acceso Denegado');
    $entidad= $this->input->post('entidad');

    $entidades=$this->Entidades->get_entidades($entidad);
    
    $html='';
    if ($entidad=='E00')
    {
       foreach ($entidades as $e)
       {         
         $html.='<area id="'.$e->codigo_onapre.'" href="#" title="'.$e->gobernacion.'" '.
                             $e->map_area.' />'; 
       }        
    }
    else
    {
       foreach ($entidades as $e)
       {         
         $html.='<area id="'.$e->codigo_onapre.'" href="#" title="'.$e->municipio.'" '.
                             $e->map_area.' />'; 
       }          
    }    
    die($html);
  }
  
  function _informacionEstado($entidad)
  {
    $estado=$this->Entidades->get_estado($entidad);
    $data= '<table class="Formulario">';
    $data.='<tr>';
    $data.='<th colspan="2" style="font-size:1.5em; font-weight: bold;">';
    $data.=mb_convert_case($estado->estado, MB_CASE_TITLE);
    $data.='</th>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td style="width:100px;">';    
    $data.='<strong>Capital:</strong>';
    $data.='</td>';    
    $data.='<td style="text-align:left">';
    $data.=$estado->capital_estado;
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td>';
    $data.='<strong>Superficie:</strong>';
    $data.='</td>';
    $data.='<td>';
    $data.=isset($estado->superficie)?number_format($estado->superficie,0,',','.').' km<sup>2</sup>'.
            ' ('.number_format($estado->superficievzla,1,',','.').'% del Territorio Nacional)':'';
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td>';
    $data.='<strong>Población<sup>(1)</sup>:</strong>';
    $data.='</td>';
    $data.='<td>';
    $data.=isset($estado->poblacion)?number_format($estado->poblacion,0,',','.').' Habitantes'.
           ' ('.number_format($estado->poblacionvzla,1,',','.').'% de la Población Nacional)':'';
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td>';
    $data.='<strong>Municipios:</strong>';
    $data.='</td>';
    $data.='<td>';
    $data.=isset($estado->municipios)?$estado->municipios:'';
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td colspan="2">'; 
    $data.='<strong><sup>(1)</sup></strong><i> Proyección Estimada del INE para el año 2012</i>'; 
    $data.='</td>'; 
    $data.='</tr>'; 
    $data.='</table>';
    return $data;
  }
  
  function _informacionMunicipio($entidad)
  {
    $municipio=$this->Entidades->get_municipio($entidad);
    $data= '<table class="Formulario">';
    $data.='<tr>';
    $data.='<th colspan="2" style="font-size:1.5em; font-weight: bold;">';
    $data.=mb_convert_case($municipio->municipio, MB_CASE_TITLE);
    $data.='</th>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td style="width:100px;">';    
    $data.='<strong>Capital:</strong>';
    $data.='</td>';    
    $data.='<td style="text-align:left">';
    $data.=$municipio->capital_municipio;
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td>';
    $data.='<strong>Superficie:</strong>';
    $data.='</td>';
    $data.='<td>';
    $data.=isset($municipio->superficie)?number_format($municipio->superficie,0,',','.').' km<sup>2</sup>'.
            ' ('.number_format($municipio->sup_rel,1,',','.').'% del '.
               mb_convert_case($municipio->estado,MB_CASE_TITLE).')':'';
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td>';
    $data.='<strong>Población<sup>(1)</sup>:</strong>';
    $data.='</td>';
    $data.='<td>';
    $data.=isset($municipio->poblacion)?number_format($municipio->poblacion,0,',','.').' Habitantes'.
           ' ('.number_format($municipio->pob_rel,1,',','.').'% del '.
              mb_convert_case($municipio->estado,MB_CASE_TITLE).')':'';
    $data.='</td>';
    $data.='</tr>';
    $data.='<tr>';
    $data.='<td style="width:100px;">';    
    $data.='<strong>ICA<sup>(2)</sup>, 2004:</strong>';
    $data.='</td>';    
    $data.='<td style="text-align:left">';
    $data.=$municipio->ica;
    $data.='</td>';
    $data.='</tr>';
    
    $data.='<tr>';
    $data.='<td colspan="2">'; 
    $data.='<strong><sup>(1)</sup></strong><i> Proyección Estimada del INE para el año 2012</i><br/>'; 
    $data.='<strong><sup>(2)</sup></strong><i> Índice de Calidad Ambiental para el año 2004</i>'; $data.='</td>'; 
    $data.='</tr>'; 
    $data.='</table>';
    return $data;
  }
  
  function _tabla_ingresos($query2011, $total2011, $query2012, $total2012)
  {
    $data= '<br/><table class="TablaNivel1 Zebrado">';
    $data.='<thead>';
    $data.='<tr>';
    $data.='<th style="width:170px;">';
    $data.='Tipo de Ingreso';
    $data.='</th>';
    $data.='<th style="width:60px;" title="Millones de Bs.">';
    $data.='2011<br/>(MM Bs.)';
    $data.='</th>';
    $data.='<th style="width:60px;" title="Millones de Bs.">';
    $data.='2012<br/>(MM Bs.)';
    $data.='</th>';  
    $data.='<th style="width:60px;">';
    $data.='&Delta;<br/>(%)';
    $data.='</th>'; 
    $data.='</tr>';
    $data.='</thead>';
    $data.='<tbody>';
    
    $q2011=$query2011->result();
    $q2012=$query2012->result();
    
    for ($i=0; $i<$query2011->num_rows();$i++)
    {
      $data.='<tr>';
      $data.='<td style="text-align:left;">';
      $data.=$q2011[$i]->tipo_ingreso;
      $data.='</td>';    
      $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
      $data.=number_format($q2011[$i]->monto,0,',','.');
      $data.='</td>';    
      $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
      $data.=number_format($q2012[$i]->monto,0,',','.');
      $data.='</td>';
      $data.='<td style="color:'.(($q2012[$i]->monto<$q2011[$i]->monto)?'red':'black').'">';
        $var=$q2012[$i]->monto-$q2011[$i]->monto;
        $var*=100/((isset($q2011[$i]->monto)&&($q2011[$i]->monto!=0))?$q2011[$i]->monto:1);
      $data.=number_format($var,0,',','.');
      $data.='</td>';
      $data.='</tr>';        
    }       
    $data.='</tbody>';
    $data.='<tfoot>';
    $data.='<tr>';
    $data.='<td>';
    $data.='TOTALES (MM Bs.)';
    $data.='</td>';
    $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
    $data.= (isset($total2011->total))?number_format($total2011->total,0,',','.'):0;
    $data.='</td>';
    $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
    $data.=(isset($total2012->total))?number_format($total2012->total,0,',','.'):0;
    $data.='</td>';  
    $data.='<td>';  
      $var=((isset($total2012->total))?$total2012->total:0)-((isset($total2011->total))?$total2011->total:0);
      $var*=100/((isset($total2011->total)&&($total2011->total!=0))?$total2011->total:1);
    $data.=number_format($var,0,',','.');      
    $data.='</td>';
    $data.='</tr>';
    $data.='</tfoot>';
    $data.='</table>';
    return $data;
  }
  
  function _tabla_rrhh($query2011, $total2011, $query2012, $total2012)
  {
    $data= '<br/><table class="TablaNivel1 Zebrado">';
    $data.='<thead>';
    $data.='<tr>';
    $data.='<th style="width:170px;">';
    $data.='Nivel del Personal';
    $data.='</th>';
    $data.='<th style="width:60px;" title="Millones de Bs.">';
    $data.='2011<br/>(MM Bs.)';
    $data.='</th>';
    $data.='<th style="width:60px;" title="Millones de Bs.">';
    $data.='2012<br/>(MM Bs.)';
    $data.='</th>';  
    $data.='<th style="width:60px;">';
    $data.='&Delta;<br/>(%)';
    $data.='</th>'; 
    $data.='</tr>';
    $data.='</thead>';
    $data.='<tbody>';
    
    $q2011=$query2011->result();
    $q2012=$query2012->result();
    
    for ($i=0; $i<$query2011->num_rows();$i++)
    {
      $data.='<tr>';
      $data.='<td style="text-align:left;">';
      $data.=$q2011[$i]->tipo_rrhh;
      $data.='</td>';    
      $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
      $data.=number_format($q2011[$i]->monto,0,',','.');
      $data.='</td>';    
      $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
      $data.=number_format($q2012[$i]->monto,0,',','.');
      $data.='</td>';
      $data.='<td style="color:'.(($q2012[$i]->monto<$q2011[$i]->monto)?'red':'black').'">';
        $var=$q2012[$i]->monto-$q2011[$i]->monto;
        $var*=100/((isset($q2011[$i]->monto)&&($q2011[$i]->monto!=0))?$q2011[$i]->monto:1);
      $data.=number_format($var,0,',','.');
      $data.='</td>';
      $data.='</tr>';        
    }       
    $data.='</tbody>';
    $data.='<tfoot>';
    $data.='<tr>';
    $data.='<td>';
    $data.='TOTALES (Millones Bs.)';
    $data.='</td>';
    $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
    $data.= (isset($total2011->total))?number_format($total2011->total,0,',','.'):0;
    $data.='</td>';
    $data.='<td style="text-align:right; padding-right:10px;" title="Millones de Bs.">';
    $data.=(isset($total2012->total))?number_format($total2012->total,0,',','.'):0;
    $data.='</td>';  
    $data.='<td>';  
      $var=((isset($total2012->total))?$total2012->total:0)-((isset($total2011->total))?$total2011->total:0);
      $var*=100/((isset($total2011->total)&&($total2011->total!=0))?$total2011->total:1);
    $data.=number_format($var,0,',','.');      
    $data.='</td>';
    $data.='</tr>';
    $data.='</tfoot>';
    $data.='</table>';
    $data.='<br/><strong>(Otros)</strong><i> Niveles: Universitario, Técnico, Contratado, Bombero etc.</i>';
    return $data;
  }
  
  function _grafico_ingresos($q2011, $q2012)
  {
    $q2011[0]->monto=isset($q2011[0]->monto)?$q2011[0]->monto:0;
    $q2012[0]->monto=isset($q2012[0]->monto)?$q2012[0]->monto:0;
    $q2011[1]->monto=isset($q2011[1]->monto)?$q2011[1]->monto:0;
    $q2012[1]->monto=isset($q2012[1]->monto)?$q2012[1]->monto:0;
    $q2011[2]->monto=isset($q2011[2]->monto)?$q2011[2]->monto:0;
    $q2012[2]->monto=isset($q2012[2]->monto)?$q2012[2]->monto:0;
    
    $data= '<br/><canvas id="cvs" width="400" height="350">[No Soporta canvas]</canvas>';
    $data.="<script>
            var bar4 = new RGraph.Bar('cvs', [[".$q2011[0]->monto.",".$q2012[0]->monto."],
                                              [".$q2011[1]->monto.",".$q2012[1]->monto."],
                                              [".$q2011[2]->monto.",".$q2012[2]->monto."]]);
            bar4.Set('colors', ['#2A17B1', '#98ED00']); 
            bar4.Set('key', ['2011', '2012']);
            bar4.Set('labels.above', true);
            bar4.Set('labels', ['".$q2011[0]->tipo_ingreso."', '".$q2011[1]->tipo_ingreso."',
                                '".$q2011[2]->tipo_ingreso."']);
            bar4.Set('title', 'Ingresos en Millones de Bs.');  
            bar4.Set('scale.thousand', '.');
            bar4.Set('gutter.top', 30);            
            bar4.Set('hmargin', 10);
            bar4.Set('numyticks', 5);
            bar4.Set('ylabels.count', 5);
            bar4.Set('gutter.left', 35);
            bar4.Set('variant', '3d');
            bar4.Set('strokestyle', 'transparent');
            bar4.Set('hmargin.grouped', 0);
            bar4.Draw();      
            </script>";

    return $data;
  }  
  
  function _grafico_rrhh($q2011, $q2012)
  {
    $q2011[0]->monto=isset($q2011[0]->monto)?$q2011[0]->monto:0;
    $q2012[0]->monto=isset($q2012[0]->monto)?$q2012[0]->monto:0;
    $q2011[1]->monto=isset($q2011[1]->monto)?$q2011[1]->monto:0;
    $q2012[1]->monto=isset($q2012[1]->monto)?$q2012[1]->monto:0;
    $q2011[2]->monto=isset($q2011[2]->monto)?$q2011[2]->monto:0;
    $q2012[2]->monto=isset($q2012[2]->monto)?$q2012[2]->monto:0;
    $q2011[3]->monto=isset($q2011[3]->monto)?$q2011[3]->monto:0;
    $q2012[3]->monto=isset($q2012[3]->monto)?$q2012[3]->monto:0;    
    $q2011[4]->monto=isset($q2011[4]->monto)?$q2011[4]->monto:0;
    $q2012[4]->monto=isset($q2012[4]->monto)?$q2012[4]->monto:0;    
    $q2011[5]->monto=isset($q2011[5]->monto)?$q2011[5]->monto:0;
    $q2012[5]->monto=isset($q2012[5]->monto)?$q2012[5]->monto:0;    
    $q2011[6]->monto=isset($q2011[6]->monto)?$q2011[6]->monto:0;
    $q2012[6]->monto=isset($q2012[6]->monto)?$q2012[6]->monto:0;    
    
    $data= '<br/><canvas id="cvs" width="400" height="350">[No Soporta canvas]</canvas>';
    $data.="<script>
            var bar4 = new RGraph.Bar('cvs', [[".$q2011[0]->monto.",".$q2012[0]->monto."],
                                              [".$q2011[1]->monto.",".$q2012[1]->monto."],
                                              [".$q2011[2]->monto.",".$q2012[2]->monto."],
                                              [".$q2011[3]->monto.",".$q2012[3]->monto."],
                                              [".$q2011[4]->monto.",".$q2012[4]->monto."],
                                              [".$q2011[5]->monto.",".$q2012[5]->monto."],                                                  
                                              [".$q2011[6]->monto.",".$q2012[6]->monto."]]);
            bar4.Set('colors', ['#2A17B1', '#98ED00']); 
            bar4.Set('key', ['2011', '2012']);
            bar4.Set('labels.above', true);
            bar4.Set('labels', ['".$q2011[0]->tipo_rrhh."', '".$q2011[1]->tipo_rrhh."',
                                '".$q2011[2]->tipo_rrhh."', '".$q2011[3]->tipo_rrhh."',
                                '".$q2011[4]->tipo_rrhh."', '".$q2011[5]->tipo_rrhh."',
                                '".$q2011[6]->tipo_rrhh."'                                    
                                    ]);            
            bar4.Set('text.angle',30);
            bar4.Set('title', 'Presupuesto RRHH en Millones de Bs.');  
            bar4.Set('scale.thousand', '.');
            bar4.Set('gutter.top', 40); 
            bar4.Set('gutter.bottom', 100); 
            bar4.Set('hmargin', 10);
            bar4.Set('numyticks', 5);
            bar4.Set('ylabels.count', 5);
            bar4.Set('gutter.left', 35);
            bar4.Set('variant', '3d');
            bar4.Set('strokestyle', 'transparent');
            bar4.Set('hmargin.grouped', 0);
            bar4.Draw();      
            </script>";
    $data.='<br/><strong>(Otros)</strong><i> Niveles: Universitario, Técnico, Contratado, Bombero etc.</i>';
    return $data;
  }  
  
}?>