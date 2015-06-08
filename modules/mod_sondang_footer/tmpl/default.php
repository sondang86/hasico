<?php 
// No direct access
defined('_JEXEC') or die; ?>

<div class="mx_wrapper_bottom">
    <div class="container">
        <div class="row">
            <!--Footer 1-->
            <div class="col-md-3 mx_block">
                <div class="module ">
                    <div class="mod-wrapper">
                        <h3 class="header">Help</h3>
                        <div class="mod-content clearfix">
                            <ul class="nav menu">
                                <li class="item-437"><a href="index.php?option=com_content&amp;view=article&amp;id=4&amp;Itemid=124"><i class="fa fa-angle-right">   </i>About Us</a></li>
                                <li class="item-280 parent"><a href="index.php?option=com_contact&amp;view=contact&amp;id=1&amp;Itemid=137"><i class="fa fa-angle-right">   </i>Copyright</a></li>
                                <li class="item-278"><a href="index.php?option=com_content&amp;view=article&amp;id=10&amp;Itemid=139"><i class="fa fa-angle-right">   </i>Terms &amp; Conditions</a></li>
                                <li class="item-279"><a href="../index.php/the-joomla-community"><i class="fa fa-angle-right">   </i>Privacy</a></li>
                                <li class="item-512"><a href="index.php?option=com_sondang&view=helloworld&layout=contactus&Itemid=149"><i class="fa fa-angle-right">   </i>Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div style="clear: both;"> </div>
            </div>
            <!--End Footer 1-->

            <!--Footer 2-->
            <div class="col-md-5 separator_bottommx_block">
                <div class="module ">
                    <div class="mod-wrapper">
                        <h3 class="header">About us</h3>
                        <div class="mod-content clearfix">
                            <div class="custom">
                                <p>Sannam Building-9 Floor-Dich Vong Hau-Cau Giay<br /> Tel: 555 555 555 <br /> Email: <span id="cloak58829"><a href="mailto:contact@hasico.vn">contact@hasico.vn</a></span></p>

                                <!--Google Map-->

                                <div id="tc_simple_map_canvas" style="height: 160px; position: relative; overflow: hidden; transform: translateZ(0px); background-color: #e5e3df;">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1862.0251385784497!2d105.78232847906962!3d21.03067419663887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0xafc5258733c2f19e!2zVMOyYSBuaMOgIFNhbm5hbQ!5e0!3m2!1svi!2s!4v1432792574873" width="460" height="200" frameborder="0" style="border:0"></iframe>
                                </div> 
                                <!--End Google Map-->
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"> </div>
            </div>
            <!--End Footer 2-->


            <!--Footer 3-->
            <div class="col-md-4 separator_bottommx_block">
                <div class="module ">
                    <div class="mod-wrapper">
                        <h3 class="header">Popular Posts</h3>
                        <div class="mod-content clearfix">
                            <div class="custom">
                                <?php foreach ($list as $key => $article):?>
                                <p><img style="float: left; border: 0; margin-left: 5px; margin-right: 5px;" title="show" src="http://demo4.mixwebtemplates.com/images/icons/icon1.png" alt="show" align="left" border="0" /><a href="#"><i class="fa fa-angle-right">   </i><?php echo $article->title?></a></p>
                                <p> </p>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"> </div>
            </div>
        </div>
    </div>
</div>