/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  SISTEMA DE SEGUIMIENTO DE POLÍTICAS PÚBLICAS                     *
 *  DESARROLLADO POR: ING.REIZA GARCÍA                               *
 *                    ING.HÉCTOR MARTÍNEZ                            *
 *  PARA:  VICEPRESIDENCIA DE LA REPÚBLICA BOLIVARIANA DE VENEZUELA  *
 *  FECHA: FEBRERO DE 2013                                           *
 *  FRAMEWORK PHP UTILIZADO: CodeIgniter Version 2.1.3               *
 *                           http://ellislab.com/codeigniter         *
 *  TELEFONOS PARA SOPORTE: 0416-9052533 / 0212-5153033              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$(document).ready(function()
{     
    $('#bitacora').dataTable( {
	"sPaginationType": "full_numbers",
        "aaSorting": [[ 0, "desc" ]]
			} );
});   // FINAL DEL DOCUMENT READY

