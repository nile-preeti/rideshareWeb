<header id="header" class="">
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 d-flex align-items-center justify-content-between">
           <a href="index.html" class="logo"><img src="<?php echo base_url('assets/modules/web/img/share-logo.png')?>" alt="" class="img-fluid"></a>

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <!--li class="<-?php echo ($this->router->fetch_method()=='index')?'active':''?>"><a href="<-?php echo base_url();?>">Home</a></li-->
              <!--li class="<-?php echo ($this->router->fetch_method()=='riders')?'active':''?>"><a href="<-?php echo base_url('riders');?>">Riders</a></li>
              <li class="<-?php echo ($this->router->fetch_method()=='drivers')?'active':''?>"><a href="<-?php echo base_url('drivers');?>">Drivers</a></li-->
              <li class="<?php echo ($this->router->fetch_method()=='about_us')?'active':''?>"><a href="<?php echo base_url('about-us');?>">About Us</a></li>
              <!--li class="<?php echo ($this->router->fetch_method()=='faq')?'active':''?>"><a href="<?php echo base_url('faq');?>">FAQ</a></li-->
              <li class="<?php echo ($this->router->fetch_method()=='contact_us')?'active':''?>"><a href="<?php echo base_url('contact-us');?>">Contact Us</a></li>
            </ul>
          </nav>
          <!-- <button class="btn btn-primary btn-contact">Contact Us</button> -->
        </div>

      </div>

    </div>
  </header><!-- End Header -->