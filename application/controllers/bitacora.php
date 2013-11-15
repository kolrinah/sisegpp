<?php if (!defined('BASEPATH')) exit('Sin Acceso Directo al Script');      
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  SISTEMA DE SEGUIMIENTO DE POLÍTICAS PÚBLICAS                     *
 *  DESARROLLADO POR: ING.REIZA GARCÍA                               *
 *                    ING.HÉCTOR MARTÍNEZ                            *
 *  DISEÑO GRÁFICO:   TSU. MARIA GABRIELA MONTERO                    *
 *  PARA:  VICEPRESIDENCIA DE LA REPÚBLICA BOLIVARIANA DE VENEZUELA  *
 *  FECHA: FEBRERO DE 2013                                           *
 *  FRAMEWORK PHP UTILIZADO: CodeIgniter Version 2.1.3               *
 *                           http://ellislab.com/codeigniter         *
 *  TELEFONOS PARA SOPORTE: 0416-9052533 / 0212-5153033              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Bitacora extends CI_Controller {
  function __construct() 
  {
     parent::__construct();
     $this->load->model('Bitacora_mdl');
  }
  
  function index()
  {
    // VERIFICAMOS SI EXISTE SESION ABIERTA    
    if (!$this->session->userdata('aprobado')) {redirect ('acceso', 'refresh'); exit();}
    
    // VERIFICACIÓN DE PERMISOS NECESARIOS PARA ACCESAR EL CONTROLADOR:    
    // * DEBE TENER ROL DE ADMINISTRADOR       
    
    if (!($this->session->userdata('administrador')))exit('Sin Acceso al Script');
          
    $data=array();
    $data['titulo']='Bitácora del Sistema';
    $data['contenido']='bitacora';    
    $data['script']='<!-- Cargamos CSS de DataTables -->'."\n";    
    $data['script'].="\t".'<link rel="stylesheet" type="text/css" media="all" href="'.base_url().'css/dataTables.css"/>'."\n";
    
    $data['script'].='<!--Incluimos Funciones JS de uso común-->'."\n";
    $data['script'].="\t".'<script type="text/javascript" charset="utf-8" src="'.base_url().'js/comunes.js"></script>'."\n";
    
    $data['script'].='<!-- Cargamos JS para DataTables -->'."\n";
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().'js/jquery.dataTables.js"></script>'."\n";
    $data['script'].='<!-- Cargamos Nuestro JS -->'."\n";
    $data['script'].="\t".'<script type="text/javascript" src="'.base_url().'js/bitacora.js"></script>'."\n";
                
               
    $bitacora=$this->Bitacora_mdl->listar_bitacora();  
    
    // CONSTRUIMOS LA TABLA A PARTIR DE LA CONSULTA
    $tabla='<table class="TablaNivel1 display" id="bitacora">';
    $tabla.='<thead><tr><th width="125px">Fecha y Hora</th>';
    $tabla.='<th width="150px">Tabla Afectada</th>';
    $tabla.='<th width="100px">Acción</th>';
    $tabla.='<th>Registro</th>';
    $tabla.='<th width="120px">Dirección IP</th>';
    $tabla.='<th width="30px"></th>';
    $tabla.='</tr></thead>';
    $tabla.='<tfoot><tr>';
    $tabla.='<td>Fecha y Hora</td>';
    $tabla.='<td>Tabla Afectada</td>';
    $tabla.='<td>Acción</th>';
    $tabla.='<td>Registro</td>';
    $tabla.='<td>Dirección IP</td>';
    $tabla.='<td></td>';
    $tabla.='</tr></tfoot>';
    $tabla.='<tbody>';
    
    if (!$bitacora) // SI NO HAY USUARIOS
    {           
      $tabla.='<tr><td colspan="6" title="Sistema Original">';
      $tabla.='<h2><center>No hay Registros en Bitácora</center></h2>';
      $tabla.='</td></tr>';
    }   
    else 
    {    
    foreach ($bitacora as $fila)
    {     
     $fondo='';
     switch ($fila['tipo_accion'])
       {
          case 'DELETE': 
                $fondo='style="color:red!important;font-weight:900;"';
                break;
          case 'INSERT': 
                $fondo='style="color:darkgreen!important;font-weight:900;"';
                break;
       }
     $tabla.='<tr '.$fondo.'>';
     $tabla.='<td>';
     $tabla.=trim($fila['fecha']);
     $tabla.='</td>';
     $tabla.='<td title="Controlador: '.$fila['controlador'].'">';
     $tabla.=trim($fila['tabla_afectada']);
     $tabla.='</td>';
     $tabla.='<td style="text-align:center">';
     $tabla.=trim($fila['tipo_accion']);
     $tabla.='</td>';
     $tabla.='<td title="id_usuario: '.$fila['id_usuario'].'">';
     $tabla.=trim($fila['registro']);
     $tabla.='</td>';
     $tabla.='<td>';
     $tabla.=trim($fila['direccion_ip']);
     $tabla.='</td>';
     $tabla.='<td>';
       
       $imagen='';
       switch ($fila['navegador'])
       {
          case (stristr(strtoupper($fila['navegador']), 'MSIE')!=false): // Internet Explorer
                $imagen='imagenes/msie.png';
                break;
          case (stristr(strtoupper($fila['navegador']), 'FIREFOX')!=false): // Firefox
                $imagen='imagenes/firefox.png';
                break;
          case (stristr(strtoupper($fila['navegador']), 'CHROME')!=false): // Chrome
                $imagen='imagenes/chrome.png';
                break;
          case (stristr(strtoupper($fila['navegador']), 'SAFARI')!=false): // Chrome
                $imagen='imagenes/safari.png';
                break;
          case (stristr(strtoupper($fila['navegador']), 'OPERA')!=false): // Opera
                $imagen='imagenes/opera.png';
                break;
          case (stristr(strtoupper($fila['navegador']), 'ANDROID')!=false): // Android
                $imagen='imagenes/android.png';
                break;
          default:           
                $imagen='imagenes/desconocido.png';
       }
       
     $tabla.='<img src="'.base_url().$imagen.'" title="'.$fila['navegador'].'" />';       
     $tabla.='</td>';
     $tabla.='</tr>';
    }
    }
    $tabla.='</tbody></table>';       
    
   $data['tabla_bitacora']=$tabla;    
    
 // CARGAMOS LA VISTA   
    $this->load->view('plantillas/plantilla_general',$data);  
  }
      
}?>