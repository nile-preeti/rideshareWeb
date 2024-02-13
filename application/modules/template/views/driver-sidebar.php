<div class="content">

    <div class="container">

        <div class="vd_nav-width sidebar-nav vd_navbar-tabs-menu vd_navbar-left">

           <!--  <div class="navbar-tabs-menu clearfix">

            </div> -->

            <div class="navbar-menu clearfix">

               <!-- <div class="vd_panel-menu hidden-xs">

                    <span data-original-title="Expand All" data-toggle="tooltip" data-placement="bottom" data-action="expand-all" class="menu" data-intro="<strong>Expand Button</strong><br/>To expand all menu on left navigation menu." data-step=4 >

                        <i class="fa fa-sort-amount-asc"></i>

                    </span>                   

                </div> -->

                <h3 class="hide-nav-medium hide-nav-small"></h3>

                <div class="vd_menu">



                    <ul>


                       

                        <li class="<?php echo ($this->router->fetch_method()=='getrides')?'active':'';?>">

                            <a href="<?php echo $this->config->base_url() ?>driver/rides">

                                <span class="menu-icon"><i class="fa fa-taxi"></i></span> 

                                <span class="menu-text">Rides</span>  
                            </a>
                        </li>

                      

                         <li class="<?php echo ($this->router->fetch_method()=='payout')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>driver/payout">

                                <span class="menu-icon"><i class="fa fa-money"></i></span> 

                                <span class="menu-text">Payout</span>  
                            </a>

                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='profile')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>driver/profile">

                                <span class="menu-icon"><i class="fa fa-user"></i></span> 

                                <span class="menu-text">Profile</span>  

                            </a>
                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='settings')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>driver/settings">

                                <span class="menu-icon"><i class="fa fa-gears"></i></span> 

                                <span class="menu-text">Settings</span>  

                            </a>
                        </li>

                        


                        

                        <li class="<?php echo ($this->router->fetch_method()=='logout')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>driver/logout">

                                <span class="menu-icon"><i class="fa fa-sign-out"></i></span> 

                                <span class="menu-text">Logout</span>  



                            </a>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="navbar-spacing clearfix">

            </div>

        </div>



