<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php"></a>
        </div>

        <ul class="sidebar-menu">

            
            <li class="<?php if($cur_page == 'dashboard.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>dashboard.php"><i class="fas fa-hand-point-right"></i> <span>Dashboard</span></a></li>

            <li class="nav-item dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Property Section</span></a>
                <ul class="dropdown-menu">
                    
                    <li class="<?php if($cur_page == 'location-view.php'||$cur_page == 'location-add.php'||$cur_page == 'location-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>location-view.php"><i class="fas fa-angle-right"></i> Location</a></li>

                    <li class="<?php if($cur_page == 'type-view.php'||$cur_page == 'type-add.php'||$cur_page == 'type-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>type-view.php"><i class="fas fa-angle-right"></i> Type</a></li>

                    <li class="<?php if($cur_page == 'amenity-view.php'||$cur_page == 'amenity-add.php'||$cur_page == 'amenity-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>amenity-view.php"><i class="fas fa-angle-right"></i> Amenity</a></li>

                    <li class="<?php if($cur_page == 'property-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>property-view.php"><i class="fas fa-angle-right"></i> Properties</a></li>
                </ul>
            </li>

            <li class="<?php if($cur_page == 'setting.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>setting.php"><i class="fas fa-hand-point-right"></i> <span>Website Setting</span></a></li>

            <li class="<?php if($cur_page == 'package-view.php'||$cur_page == 'package-add.php'||$cur_page == 'package-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>package-view.php"><i class="fas fa-hand-point-right"></i> <span>Packages</span></a></li>

            <!-- <li class="<?php if($cur_page == 'order-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>order-view.php"><i class="fas fa-hand-point-right"></i> <span>Orders</span></a></li>

            <li class="<?php if($cur_page == 'message-view.php'||$cur_page == 'message-detail.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>message-view.php"><i class="fas fa-hand-point-right"></i> <span>Messages</span></a></li>

            <li class="<?php if($cur_page == 'customer-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>customer-view.php"><i class="fas fa-hand-point-right"></i> <span>Customers</span></a></li>

            <li class="<?php if($cur_page == 'agent-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>agent-view.php"><i class="fas fa-hand-point-right"></i> <span>Agents</span></a></li>

            <li class="<?php if($cur_page == 'why-choose-view.php'||$cur_page == 'why-choose-add.php'||$cur_page == 'why-choose-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>why-choose-view.php"><i class="fas fa-hand-point-right"></i> <span>Why Choose Us</span></a></li>

            <li class="<?php if($cur_page == 'testimonial-view.php'||$cur_page == 'testimonial-add.php'||$cur_page == 'testimonial-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>testimonial-view.php"><i class="fas fa-hand-point-right"></i> <span>Testimonials</span></a></li>

            <li class="<?php if($cur_page == 'post-view.php'||$cur_page == 'post-add.php'||$cur_page == 'post-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>post-view.php"><i class="fas fa-hand-point-right"></i> <span>Blog</span></a></li>

            <li class="<?php if($cur_page == 'faq-view.php'||$cur_page == 'faq-add.php'||$cur_page == 'faq-edit.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>faq-view.php"><i class="fas fa-hand-point-right"></i> <span>FAQ</span></a></li>

            <li class="<?php if($cur_page == 'subscriber-view.php'||$cur_page == 'subscriber-send-email.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>subscriber-view.php"><i class="fas fa-hand-point-right"></i> <span>Subscribers</span></a></li>

            <li class="<?php if($cur_page == 'terms-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>terms-view.php"><i class="fas fa-hand-point-right"></i> <span>Terms</span></a></li>

            <li class="<?php if($cur_page == 'privacy-view.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>privacy-view.php"><i class="fas fa-hand-point-right"></i> <span>Privacy</span></a></li> -->
            

            <!-- <li class="<?php if($cur_page == 'form.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>form.php"><i class="fas fa-hand-point-right"></i> <span>Form</span></a></li>

            <li class="<?php if($cur_page == 'table.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>table.php"><i class="fas fa-hand-point-right"></i> <span>Table</span></a></li>

            <li class="<?php if($cur_page == 'invoice.php') {echo 'active';} ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>invoice.php"><i class="fas fa-hand-point-right"></i> <span>Invoice</span></a></li> -->

        </ul>
    </aside>
</div>