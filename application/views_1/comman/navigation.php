<nav class="menu-section">
	<div class="container-fuild" style="/*position: fixed;margin-top:110px;*/    width: 100%;    height: 40px;">
		 <nav class="navbar navbar-default navbar-static-top nav-bg-th" role="navigation" style="padding:0px 2%;margin:0;position:unset;" >
            <div class="navbar-header" style="height:40px;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <a class="navbar-brand" href="#"></a>
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse-1" style="font-weight:bold">
                <ul class="nav navbar-nav navigation">
                	<?php foreach($menus as $menu){
                			$f = 0;
                			if($menu['p_id'] == 0){
	                			foreach($menus as $submenu){
	                				if($menu['id'] == $submenu['p_id']){
	                					$f = 1;
	                				}
	                			}
	                			if($f){
	                				echo '<li class="dropdown">';
										if($menu['external_link']==0){
											echo '<a href="'.base_url().$menu['cms_url'].'" class="dropdown-toggle" data-toggle="dropdown" title="'.$menu['menu_name'].'">'.$menu['menu_name'].'<b class="caret"></b></a>';
										}
										else{
											echo '<a href="'.$menu['cms_url'].'" class="dropdown-toggle" data-toggle="dropdown" title="'.$menu['menu_name'].'">'.$menu['menu_name'].'<b class="caret"></b></a>';
										}
	                				echo '<ul class="dropdown-menu">';
	                					foreach($menus as $innermenu){ 
	                						if($innermenu['p_id'] == $menu['id']){
												if($innermenu['external_link']==0){
													echo '<li><a href="'.base_url().$innermenu['cms_url'].'" title="'.$innermenu['menu_name'].'"> '.$innermenu['menu_name'].'</a></li>';
												}
												else{
													echo '<li><a href="'.$innermenu['cms_url'].'" title="'.$innermenu['menu_name'].'" target="_blank"> '.$innermenu['menu_name'].'</a></li>';
												}
	                						}
	                					}
	                				echo '</ul>';
	                				echo '</li>';
	                			}
	                			else{
	                				echo '<li><a class="" title="'.$menu['menu_name'].'" href="'.base_url().$menu['cms_url'].'">'.$menu['menu_name'].'</a></li>';
	                			}
                			}
                	 } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
	</div>
</nav>