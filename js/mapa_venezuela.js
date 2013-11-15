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

$(document).ready(function()
{     
    $("#venBoton").hide();
    $("#venBoton").mouseover(function(){
        $(this).attr("src",$("#base_url").val()+"imagenes/venezuela_roja.png");
    });
    
    $("#venBoton").mouseleave(function(){
        $(this).attr("src",$("#base_url").val()+"imagenes/venezuela_gris.png");
    });
    
    cargarMapeo("E00");
    
    // AL PULSAR EL BOTON VENEZUELA
    $("#venBoton").click(function(){
        $(this).effect("puff",{}, 1000);
                
        $("#entidadClic").effect("pulsate",{}, 50,
          function(){
            $("#entidadClic").attr("src", $("#base_url").val()+"imagenes/mapas/blank.png");
            $("#entidadClic").removeAttr("entidad");
            $("#entidadClic").show();
        });
        
        $("#entidadFondo").effect("pulsate",{}, 50,
          function(){
            $("#entidadFondo").attr("src", $("#base_url").val()+"imagenes/mapas/E00.png");
            $("#entidadFondo").hide().fadeIn('slow');    
        });
        
        $("#Informacion").effect("puff",{}, 500,
          function(){
            $(this).html("");
            $(this).show();
        });  
        
        $("#datosINE").effect("puff",{}, 500,
          function(){
            $(this).html("");
            $(this).show();    
        });
        
        cargarMapeo("E00");
        $("#nombreEntidad").hide();
        $("#nombreEntidad").html("República Bolivariana de Venezuela").fadeIn('slow');        
    });
    programarArea();
    
});   // FINAL DEL DOCUMENT READY

// FUNCIONES ESPECIALES
$(function () { 
	// Inicialización del Stack
	var openspeed = 300;
	var closespeed = 300;
	$('.stack>img').toggle(function(){
                $('.stack>img').attr("src", $("#base_url").val()+"imagenes/menu00a.png");
		var vertical = 0;
		var horizontal = 0;
		var $el=$(this);
                $("#Informacion").addClass('MarcAgua');
		$el.next().children().each(function(){
			$(this).animate({top: vertical + 'px', left: horizontal + 'px'}, openspeed);
			vertical = vertical + 30;
			horizontal = (horizontal+.10)*2;
		});
		$el.next().animate({top: '40px', left: '7px'}, openspeed).addClass('openStack')
		   .find('li a>img').animate({width: '24px', marginLeft: '9px'}, openspeed);
		$el.animate({paddingBottom: '0'});
	}, function(){
		//Subida de Reversa
		$("#Informacion").removeClass('MarcAgua');
                var $el=$(this);
		$('.stack>img').attr("src", $("#base_url").val()+"imagenes/menu00.png");
                $el.next().removeClass('openStack').children('li').animate({top: '-33px', left: '-10px'}, closespeed);
		$el.next().find('li a>img').animate({width: '0px', marginLeft: '0'}, closespeed);
		//$el.animate({paddingBottom: '35px'});
	});
	
	// Animación Adicional del Stacks
	$('.stack li a').hover(function(){
		$("img",this).animate({width: '32px'}, 100);
		$("span",this).animate({marginRight: '15px'});
                $("span",this).addClass('Resaltar');
	},function(){
		$("img",this).animate({width: '24px'}, 100);
		$("span",this).animate({marginRight: '0'});
                $("span",this).removeClass('Resaltar');
	});
        // Selección del Menu
        $('.stack li a').click(function(){
                $("#spanB1").html($("span",this).html());
				$("#spanB1").attr("menu",$(this).attr("menu"));                  
                //Subida de Reversa
		$('.stack>img').trigger("click");
                $('.stack>img').attr("src", $("img",this).attr("src"));
                Actualizar();
                });
});

function cargarMapeo(entidad)
{
 // CARGAMOS EL MAPEO DE LOS ESTADOS
         $.ajax({
             type:'POST',
             url:'mapa_venezuela/cargar_mapeo',
             data:{
                   'entidad':entidad
                  },
           /* beforeSend:function(){
                         $("#entidadClic").attr("src", $("#base_url").val()+"imagenes/cargando.gif");},
             complete: function(){
                         $("#entidadClic").attr("src", $("#base_url").val()+"imagenes/mapas/blank.png");},*/
             error: function(){
                         var Mensaje='Ha Ocurrido un Error al Intentar Cargar el Mapa.';
                         CajaDialogo('Error', Mensaje);},
             success: function(data){
                                   $("#Map").html(data);
                                   programarArea();
                                    },
             dataType:'html'});            
}

function programarArea()
{
    $("area").mouseover(function() {
	$("#entidad").attr("src", $("#base_url").val()+"imagenes/mapas/"+$(this).attr("id")+".png");
			});
    $("area").mouseleave(function() {
	$("#entidad").attr("src", $("#base_url").val()+"imagenes/mapas/blank.png");
			});
    // AL SELECCIONAR UNA ENTIDAD
    $("area").click(function() {
        if ($(this).attr("id").length<4) // SI LA ENTIDAD ES UN ESTADO
        {
           var ruta=$("#base_url").val()+"imagenes/mapas/"+$(this).attr("id")+"m.png";
	   $("#entidadFondo").effect("puff",{}, "slow",
               function(){
           $("#entidadFondo").attr("src", ruta);
           $("#entidadFondo").hide().fadeIn('slow');                 
               });
           $("#Map").html('');
           cargarMapeo($(this).attr("id"));               
        }
        else  // SI LA ENTIDAD ES UN MUNICIPIO
        {
           var ruta=$("#base_url").val()+"imagenes/mapas/"+$(this).attr("id")+".png";
           $("#entidadClic").attr("src", ruta);
        }
            
        $("#entidadClic").attr("entidad", $(this).attr("id"));
        $("#nombreEntidad").hide();
        $("#nombreEntidad").html($(this).attr("title")).fadeIn('slow');
        
        $("#Informacion").hide(); 
        $("#datosINE").hide();

        $("#venBoton").show();
        $("#venBoton").effect("shake",{},100);

        $("#entidad").attr("src",$("#base_url").val()+"imagenes/mapas/blank.png");
        
    // CARGAMOS LA INFORMACION PRESUPUESTARIA DE LA ENTIDAD
    Actualizar();
    
    // CARGAMOS LOS DATOS DE LA ENTIDAD 
    $.ajax({
        type:'POST',
        url:'mapa_venezuela/cargar_wiki',
        data:{
              'entidad':$(this).attr("id")
             },
        beforeSend:function(){$("#cargandoModal").show();},
        complete: function(){
                    $("#cargandoModal").hide();},
        error: function(){
                    var Mensaje='Ha Ocurrido un Error al Intentar Cargar la Información.';
                    CajaDialogo('Error', Mensaje);},
        success: function(data){
                              $("#datosINE").html(data);
                              $("#datosINE").fadeIn('slow');
                               },
        dataType:'html'});
      
            });    
}

function Actualizar()
{
   $.ajax({
   type:'POST',
   url:'mapa_venezuela/cargar_info',
   data:{
         'entidad':$("#entidadClic").attr("entidad"),
         'menu':trim($("#spanB1").attr("menu")),
         'forma':$("#hideB2").val()
        },
   beforeSend:function(){$("#cargandoModal").show();},
   complete: function(){
               $("#cargandoModal").hide();},               
   error: function(){
               var Mensaje='Ha Ocurrido un Error al Intentar Cargar la Información.';
               CajaDialogo('Error', Mensaje);},
   success: function(data){                                
                         $("#Informacion").html(data);
                         $("#Informacion").effect("slide",{}, 1000);
                         //$("#Informacion").fadeIn('slow');
                          },
   dataType:'html'});     
}

function ToggleBotonB2()
{
   if ($("#hideB2").val()==='t')
   {
     $("#hideB2").val('f');      
     $("#imgB2").attr('src', $('#base_url').val()+'imagenes/grafico.png');
     $("#spanB2").html('&nbsp;&nbsp;Gráfico');
   }
   else
   {
     $("#hideB2").val('t');      
     $("#imgB2").attr('src', $('#base_url').val()+'imagenes/tabla.png');
     $("#spanB2").html('&nbsp;&nbsp;Tabla');
   }
   
   Actualizar();
}