jQuery(document).ready(function($)
	{


		$(document).on('click', '.registration-control-admin .add-field', function()
			{	
			
				var option_id = $(this).attr('option-id');
				
				var id = $.now();

				var html = '<div class="single"><input type="text" name="'+option_id+'['+id+']" value="" /><input class="remove-field button" type="button" value="Remove"></div>';
				//alert(html);
					$(this).prev('.repatble').append(html);
					
					
				})

		$(document).on('click', '.registration-control-admin .remove-field', function()
			{	
				if(confirm("Do you really want to remove ?")){
					$(this).prev().remove();
					$(this).remove();
					}

				
					
					
				})






		$(document).on('click', '.registration-control-admin .tab-nav li', function()
			{
				$(".active").removeClass("active");
				$(this).addClass("active");
				
				var nav = $(this).attr("nav");
				
				$(".box li.tab-box").css("display","none");
				$(".box"+nav).css("display","block");
		
			})




	});	







