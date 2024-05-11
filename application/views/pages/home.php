<h1 class="mb-5"> <?= $title;  ?> </h1>

<?php echo $this->pagination->create_links(); ?>
<!-- session message after the adding function  -->
<?php if ($this->session->flashdata('user_loggedin')) { ?>

     <p class="alert alert-success"><?= $this->session->flashdata('user_loggedin'); ?></p>

<?php  } ?>
<!-- session message for adding data  -->
<?php if ($this->session->flashdata('post_added')) { ?>
     <p class="alert alert-success"><?= $this->session->flashdata('post_added'); ?></p>
<?php  } ?>

<!-- session message after the adding function  -->
<?php if ($this->session->flashdata('post_deleted')) { ?>
     <p class="alert alert-success"><?= $this->session->flashdata('post_deleted'); ?></p>
<?php  } ?>

<!-- Looping data coming from the stored procedure  -->
<ul class="list-group">
     <?php
     foreach ($posts as $row) { ?>
          <!-- if the result type in the model is in the form of 'result()' -->
          <!-- <a class="list-group-item list-group-item-action" href="<?= base_url(); ?> <?= $row->slug; ?>" > <?= $row->title ;?> </a> -->

          <!-- if the result type in the  model is in the form of 'result_array()'-->
          <a class="list-group-item list-group-item-action" href="<?= base_url(); ?> <?= $row['slug']; ?>" > <?= $row['title'];?> </a>
     <?php } ?>
</ul>

<p class="mt-5">Total Posts : <?= $total; ?> </p>