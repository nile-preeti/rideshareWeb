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

                        <li class="<?php echo ($this->router->fetch_method()=='map')?'active':'';?>"  >

                            <a href="<?php echo $this->config->base_url() ?>admin/map">

                                <span class="menu-icon"><i class="fa fa-map-marker"></i></span> 

                                <span class="menu-text" >Map</span>  



                            </a>

                        </li>

                       <!--  <li>

                            <a style="color:black" href="<?php echo base_url('admin/add_driver') ?>">

                                <span class="menu-icon"><i class="fa fa-map-marker"></i></span> 

                                <span class="menu-text" >Add Driver</span>  



                            </a>

                        </li> -->

                        <li class="<?php echo ($this->router->fetch_method()=='riders')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/riders">

                                <span class="menu-icon"><i class="fa fa-user"></i></span> 

                                <span class="menu-text">Riders</span>  



                            </a>

                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='drivers')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/drivers">

                                <span class="menu-icon"><i class="fa fa-user-secret"></i></span> 

                                <span class="menu-text">Drivers</span>  



                            </a>

                        </li>
                    <!--  
                        <li class="<?php //echo ($this->router->fetch_method()=='brand_list')?'active':'';?>">

                            <a href="<?php //echo $this->config->base_url() ?>admin/brand_list">

                                <span class="menu-icon"><i class="fa fa-bus"></i></span> 

                                <span class="menu-text">Make</span>  



                            </a>

                        </li>

                        <li class="<?php// echo ($this->router->fetch_method()=='brand_model_list')?'active':'';?>">

                            <a  href="<?php //echo $this->config->base_url() ?>admin/brand_model_list">

                                <span class="menu-icon"><i class="fa fa-registered"></i></span> 

                                <span class="menu-text">Model Make</span>  



                            </a>

                        </li>
                    -->

                        <li class="<?php echo ($this->router->fetch_method()=='getrides')?'active':'';?>">

                            <a href="<?php echo $this->config->base_url() ?>admin/getrides">

                                <span class="menu-icon"><i class="fa fa-taxi"></i></span> 

                                <span class="menu-text">Rides</span>  
                            </a>
                        </li>

                    

                        <li class="<?php echo ($this->router->fetch_method()=='getPayments')?'active':'';?>">

                            <a href="<?php echo $this->config->base_url() ?>admin/getPayments">

                                <span class="menu-icon"><i class="fa fa-credit-card"></i></span> 

                                <span class="menu-text">Payments</span>  



                            </a>

                        </li>

                         <li class="<?php echo ($this->router->fetch_method()=='payout_driver')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/payout_driver">

                                <span class="menu-icon"><i class="fa fa-money"></i></span> 

                                <span class="menu-text">Driver Payout</span>  



                            </a>

                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='vehicle_type_list')?'active':'';?>"> 

                            <a  href="<?php echo $this->config->base_url() ?>admin/vehicle_type_list">

                                <span class="menu-icon"><i class="fa fa-car"></i></span> 

                                <span class="menu-text">Vehicle type</span>  



                            </a>

                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='version')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/version">

                                <span class="menu-icon"><i class="fa fa-gears"></i></span> 

                                <span class="menu-text">Version</span>  



                            </a>

                        </li>

                        <li class="<?php echo ($this->router->fetch_method()=='settings')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/settings">

                                <span class="menu-icon"><i class="fa fa-gears"></i></span> 

                                <span class="menu-text">Settings</span>  



                            </a>

                        </li>

                        

                        <!-- <li>

                            <a  style="color:white" href="<?php echo $this->config->base_url() ?>admin/rate_chart">

                                <span class="menu-icon"><i class="fa fa-gears"></i></span> 

                                <span class="menu-text">Rate Chart</span>  



                            </a>

                        </li> -->

                        

                        <li class="<?php echo ($this->router->fetch_method()=='logout')?'active':'';?>">

                            <a  href="<?php echo $this->config->base_url() ?>admin/logout">

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



