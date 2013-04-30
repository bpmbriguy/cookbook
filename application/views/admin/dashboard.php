<div class="indent">
	<div class="wrapper">
    	<article class="col-1">
            <div class="bg">
                <div class="padding">
                    <h3 class="p2">My Cookbook</h3>
                        <div id="myCookbook">
                            <?php $this->load->view('admin/mybook'); ?>
                        </div>
                        <div id="myTools">
                            <ul>
                                <li class="header">&nbsp</li>
                                <li class="add"><?php echo anchor('admin/add', 'Add a new recipe');?></li>
                                <?php if($this->tank_auth->get_user_role() > 2) : ?>
                                <li><?php echo anchor('admin/categories', 'Edit Categories'); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                </div>
            </div>
        </article>
        </div>
</div>
