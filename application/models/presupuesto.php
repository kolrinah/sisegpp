<?php
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
class Presupuesto extends CI_Model
{  
   function ingresos_x_year($entidad, $year)
   {   
     $sql= (strlen($entidad)<4)?
           "select * from (select * from p_ingresos_estados
                          join dir_estados using (id_estado)
		          where codigo_onapre='$entidad' and year=$year) p
           right join p_tipos_ingresos using (id_tipo_ingreso)
           order by id_tipo_ingreso":
           "select * from (select * from p_ingresos_municipios
                          join dir_municipios using (id_municipio)
		          where codigo_onapre='$entidad' and year=$year) p
           right join p_tipos_ingresos using (id_tipo_ingreso)
           order by id_tipo_ingreso";

     $query = $this->db->query($sql);
     return $query;     
   }
   
   function total_ingreso_x_year($entidad, $year)
   {              
     $sql=(strlen($entidad)<4)?
          "select sum(monto) as total from p_ingresos_estados
           join dir_estados using (id_estado)
           where codigo_onapre='$entidad' and year=$year
           group by id_estado":
          "select sum(monto) as total from p_ingresos_municipios
           join dir_municipios using (id_municipio)
           where codigo_onapre='$entidad' and year=$year
           group by id_municipio";

     $query = $this->db->query($sql);
     return $query->row();
   }
   
   function rrhh_x_year($entidad, $year)
   {              
     $sql=(strlen($entidad)<4)?
          "select * from (select * from p_rrhh_estados
                          join dir_estados using (id_estado)
		          where codigo_onapre='$entidad' and year=$year) p
           right join p_tipos_rrhh using (id_tipo_rrhh)
           order by id_tipo_rrhh":
          "select * from (select * from p_rrhh_municipios
                          join dir_municipios using (id_municipio)
		          where codigo_onapre='$entidad' and year=$year) p
           right join p_tipos_rrhh using (id_tipo_rrhh)
           order by id_tipo_rrhh";            

     $query = $this->db->query($sql);
     return $query;     
   }
   
   function total_rrhh_x_year($entidad, $year)
   {              
     $sql=(strlen($entidad)<4)?
          "select sum(monto) as total from p_rrhh_estados
           join dir_estados using (id_estado)
           where codigo_onapre='$entidad' and year=$year
           group by id_estado":
          "select sum(monto) as total from p_rrhh_municipios
           join dir_municipios using (id_municipio)
           where codigo_onapre='$entidad' and year=$year
           group by id_municipio";             

     $query = $this->db->query($sql);
     return $query->row();
   }   
}
?>