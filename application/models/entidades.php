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
class Entidades extends CI_Model
{  
   // OBTENEMOS LOS DATOS PROCESADOS DEL ESTADO
   function get_estado($entidad)
   {              
     $sql="select *, superficie*100/(select sum(superficie) from dir_municipios) as superficievzla, 
                     poblacion*100/(select sum(poblacion) from dir_municipios) as poblacionvzla
           from dir_estados
           left join (select sum(superficie) as superficie, id_estado 
                 from dir_municipios group by id_estado) s using (id_estado)
           left join (select sum(poblacion) as poblacion, id_estado 
                 from dir_municipios group by id_estado) p using (id_estado) 
           left join (select count(superficie) as municipios, id_estado 
                 from dir_municipios group by id_estado) m using (id_estado)     
           where codigo_onapre='$entidad'";

     $query = $this->db->query($sql);
     return $query->row();     
   }
   
   // OBTENEMOS LOS DATOS PROCESADOS DEL MUNICIPIO  
   function get_municipio($entidad)
   {              
     $sql="select m.*, e.estado, poblacion*100/pob_edo as pob_rel, superficie*100/sup_edo as sup_rel from dir_municipios m
           left join dir_estados e using(id_estado)
           left join (
                      select sum(poblacion) as pob_edo , id_estado from dir_municipios
                      where id_estado=(select id_estado from dir_municipios
                                       where codigo_onapre='$entidad')
                      group by id_estado                 
                      ) p using(id_estado)
           left join (
                      select sum(superficie) as sup_edo , id_estado from dir_municipios
                      where id_estado=(select id_estado from dir_municipios
                                       where codigo_onapre='$entidad')
                      group by id_estado                 
                      ) sup using(id_estado)	   
           where m.codigo_onapre='$entidad'";

     $query = $this->db->query($sql);
     return $query->row();     
   }   
   
   // OBTENEMOS TODAS LAS ENTIDADES SUBORDINADAS A LA ENTIDAD DADA
   function get_entidades($entidad)
   { 
     $sql=($entidad=='E00')?  
           "select * from dir_estados"
           :
           "select m.*, e.estado from dir_municipios m
            join dir_estados e using(id_estado)
            where e.codigo_onapre='$entidad'
            order by m.codigo_onapre" ;
     $query = $this->db->query($sql);
     return $query->result();     
   }   
     
}
?>