<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	
	//var_dump($meta_fields);



	

	?>





<div class="wrap registration-control-admin front-form settings">

	<div id="icon-tools" class="icon32"><br></div>
    
	<h2><?php _e(sprintf('%s - History',registration_control_plugin_name), registration_control_textdomain); ?></h2>

<?php


					global $wpdb;
					 
					$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
					$limit = 20;

					$offset = ( $pagenum - 1 ) * $limit;
					$entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}registration_control ORDER BY id DESC LIMIT $offset, $limit" );
					 
					if( $entries )
						{ 
			
							$html = '';
							$html.= '<table class="widefat"><thead><tr>';
							$html.= '<th scope="col" class="manage-column column-name" style=""><strong>Date & Time</strong></th>';
							$html.= '<th scope="col" class="manage-column column-name" style=""><strong>Username</strong></th>';							
							$html.= '<th scope="col" class="manage-column column-name" style=""><strong>Email</strong></th>';	
							$html.= '<th scope="col" class="manage-column column-name" style=""><strong>Action</strong></th>';							
					
							
																					
							$html.= '</tr></thead>';							
							
							$html.= '<tbody>';			
							$count = 1;
							$class = '';
							foreach( $entries as $entry )
								{
									$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';	
									
									$html.= '<tr '.$class.'>';
									
									$html.= '<td>'.$entry->datetime.'</td>';										
									$html.= '<td>'.$entry->username.'</td>';									
									$html.= '<td> '.$entry->email.'</td>';
									$html.= '<td> '.$entry->action.'</td>';									
																	
									
									$html.= '</tr>';									
									$count++;
								}
								
							$html.= '</tbody></table>';	
							
							$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}registration_control" );
							$num_of_pages = ceil( $total / $limit );
							$page_links = paginate_links( array(
								'base' => add_query_arg( 'pagenum', '%#%' ),
								'format' => '',
								'prev_text' => __( '&laquo;', 'aag' ),
								'next_text' => __( '&raquo;', 'aag' ),
								'total' => $num_of_pages,
								'current' => $pagenum
							) );
							 
							if ( $page_links ) {
								$html.= '<div class="tablenav"><div class="tablenav-pages" style=" text-align:left;margin: 1em 0;width: 100%;">' . $page_links . '</div></div><br/>';
							}
						}
					else
						{
						 	$html.= 'No activity yet.';
						}
					
								
						 							
								
								
								
								
								
					echo $html;

?>
</div>
