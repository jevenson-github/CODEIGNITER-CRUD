<h1 class="mb-5">Login User</h1>

<!-- session message after the adding function  -->
<?php  if($this->session->flashdata('login_failed')) { ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('login_failed'); ?></p>
<?php  } ?>
<?php  if($this->session->flashdata('log_out')) { ?>
            <p class="alert alert-danger"><?= $this->session->flashdata('log_out'); ?></p>
<?php  } ?>

<!-- dito lalabas yung errors   -->
<!-- <?= validation_errors(); ?> -->


<?= form_open('login') ?>
<label for="title">Username : </label>
<!--appending individual error  -->
<?php echo form_error('username'); ?>
<input class="form-control" name="username" id="title" type="text" placeholder=" Username " aria-label="default input example" value="<?= set_value('username'); ?>" autocomplete="off">


<div class="mt-5">
    <label for="password">Password</label>
    <!--appending individual error  -->
    <?php echo form_error('password'); ?>
    <input class="form-control" name="password" id="password" type="password" placeholder="Password " autocomplete="off" aria-label="default input example" value="<?= set_value('password'); ?>" size="50">
</div>

<!-- <div class="mt-5">
    <label for="password">Confirm Password</label>
    <?php //echo form_error('passconf'); ?>
    <input class="form-control" type="password" name="passconf" id="passconf" placeholder="Confirm Password" value="<?php echo set_value('passconf'); ?>" size="50" autocomplete="off" />
</div> -->


<div class="mt-5">
    <button type="submit" class="btn btn-primary">Login</button>
</div>

<?= form_close(); ?>